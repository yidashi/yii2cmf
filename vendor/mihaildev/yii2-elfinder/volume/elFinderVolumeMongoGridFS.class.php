<?php

/**
 * MongoDB GridFS driver for elFinder
 *
 * Supply your own MongoGridFS instance to 'db' option
 *
 * @author Manatsawin Hanmongkolchai
 * @license Apache license 2.0
 * This driver is developed under Kyou project.
 * Kyou project's development is sponsored by NECTEC under NSC2013 program.
 * NECTEC does not provides support for this driver
 */
class elFinderVolumeMongoGridFS extends elFinderVolumeDriver {
	/**
	 * @var string
	 */
	protected $driverId = 'm';
	/**
	* @var MongoGridFS
	*/
	protected $db;

	/**
	 * File used to hold a directory metadata
	 * Should not be changed
	 */
	const PLACEHOLDER = "__placeholder";

	public function __construct(){
		// Actually MongoClient only exists in v1.3.0 so you will get class not found anyway
		// \m/
		if(version_compare(MongoClient::VERSION, '1.3.0', '<')){
			throw new RuntimeException("elFinderVolumeMongoGridFS only supports MongoClient version 1.3.0 and above");
		}
		$this->options['mimeDetect'] = 'internal';
	}

	/**
	 * Check for connection
	 * @return bool
	 */
	protected function init(){
		if($this->options['db'] instanceof MongoDB){
			$this->options['db'] = $this->options['db']->getGridFS();
		}else if(!$this->options['db'] instanceof MongoGridFS){
			throw new InvalidArgumentException("db option is not instance of MongoDB or MongoGridFS");
		}
		$this->db = $this->options['db'];
		return true;
	}

	protected function format_stat(MongoGridFSFile $file){
		return array(
			"name" => $file->getFilename(),
			"size" => $file->getSize(),
			"ts" => $file->file['uploadDate']->sec,
			"mime" => $file->file['metadata']['mime'],
			"read" => true,
			"write" => true,
			"width" => $file->file['metadata']['width'],
			"height" => $file->file['metadata']['height'],
		);
	}

	protected function subdirs($path){
		$subdirs = $this->db->find(array(
			"metadata.path" => new MongoRegex('/^'.preg_quote($path, '/').'\/[^\/]+$/')
		), array("metadata.path" => true));
		$subdirsName = array();
		foreach($subdirs as $item){
			$subdirsName[] = $item->file['metadata']['path'];
		}
		return array_unique($subdirsName);
	}

	/**
	 * Scan directory
	 */
	protected function cacheDir($path) {
		$this->dirsCache[$path] = array();
		$path = preg_replace('~/$~', '', $path);
		// subdirs in the directory
		foreach($this->subdirs($path) as $subdir){
			$data = array(
				//"id" => $subdir,
				"name" => $subdir,
				"size" => 0,
				"mime" => "directory",
				"read" => true,
				"write" => true,
				"parent_id" => $path,
			);
			if ($stat = $this->updateCache($this->_joinPath($path, $data['name']), $data)) {
				$this->dirsCache[$path][] = $data['name'];
			}
		}

		// files in the directory
		$files = $this->db->find(array(
			"metadata.path" => $path
		));
		foreach($files as $file){
			if($file->getFilename() == $this::PLACEHOLDER){ // for mkdir()
				continue;
			}
			$data = $this->format_stat($file);
			$fullpath = $this->_joinPath($path, $data['name']);
			if ($stat = $this->updateCache($fullpath, $data)) {
				$this->dirsCache[$path][] = $fullpath;
			}
		}
		
		return $this->dirsCache[$path];
	}

	protected function make($path, $name, $mime){
		if($mime == "directory"){
			$path = $this->_joinPath($path, $name);
			$name = $this::PLACEHOLDER;
		}
		return $this->db->storeBytes("", array(
			"filename" => $name,
			"metadata" => array(
				"path" => $path,
				"mime" => $mime,
			)
		));
	}

	protected function getFile($path){
		$file = $this->db->findOne(array(
			"filename" => $this->_basename($path),
			"metadata.path" => $this->_dirname($path)
		));
		return $file;
	}

	/**
	 * Join dir name and file name
	 */
	protected function _joinPath($path, $name) {
		$path = preg_replace('~/$~', '', $path);
		return $path.$this->separator.$name;
	}

	/**
	 * Return stat for given path.
	 * Stat contains following fields:
	 * - (int)    size    file size in b. required
	 * - (string) name    file name. required
	 * - (int)    ts      file modification time in unix time. required
	 * - (string) mime    mimetype. required for folders, others - optionally
	 * - (bool)   read    read permissions. required
	 * - (bool)   write   write permissions. required
	 * - (bool)   locked  is object locked. optionally
	 * - (bool)   hidden  is object hidden. optionally
	 * - (string) alias   for symlinks - link target path relative to root path. optionally
	 * - (string) target  for symlinks - link target path. optionally
	 *
	 * If file does not exists - returns empty array or false.
	 *
	 * @param  string  $path    file path 
	 * @return array|false
	 **/
	protected function _stat($path) {
		$file = $this->getFile($path);
		if(!$file){
			// It could be a directory...
			$path = preg_replace('~/$~', '', $path);
			$file = $this->db->find(array(
				"metadata.path" => $path
			));
			$file->sort(array(
				"uploadDate" => -1
			));
			if($file->count() == 0 && $path != $this->root){
				return false;
			}
			$parent_dir = preg_replace('~[/]{0,1}[^\/]+$~', '', $path);
			$subdir = count($this->subdirs($path));
			$out = array(
				//"id" => $this->_basename($path),
				"name" => $this->_basename($path),
				"size" => 0,
				"ts" => $file->current()->file['uploadDate']->sec,
				"mime" => "directory",
				"dirs" => $subdir,
				"read" => true,
				"write" => true,
				"parent_id" => $parent_dir,
			);
			if($path == $this->root){
				unset($out['parent_id']);
			}
			return $out;
		}
		return $this->format_stat($file);
	}

	/**
	 * Open file and return file pointer (read only)
	 *
	 * @param  string  $path  file path
	 * @param  string  $mode  open file mode (ignored in this driver)
	 * @return resource|false
	 **/
	protected function _fopen($path, $mode='rb'){
		$file = $this->getFile($path);
		if(!$file){
			return false;
		}
		return $file->getResource();
	}

	/**
	 * Close opened file
	 **/
	protected function _fclose($fp, $path='') {
		@fclose($fp);
	}

	/**
	 * Copy file into another file
	 * WARNING: This function loads the entire file into memory
	 *
	 * @param  string  $source     source file path
	 * @param  string  $targetDir  target directory path
	 * @param  string  $name       new file name
	 * @return string
	 **/
	protected function _copy($source, $targetDir, $name) {
		$this->clearcache();
		$src = $this->getFile($source);
		$targetDir = preg_replace('~/$~', '', $targetDir);
		return $this->db->storeBytes($src->getBytes(), array(
			"filename" => $name,
			"metadata" => array(
				"path" => $targetDir,
				"mime" => $src->file['metadata']['mime'],
			)
		));
	}

	/**
	 * Move file into another parent dir.
	 * Return new file path or false.
	 *
	 * @param  string  $source  source file path
	 * @param  string  $target  target dir path
	 * @param  string  $name    file name
	 * @return string
	 **/
	protected function _move($source, $targetDir, $name) {
		$targetDir = preg_replace('~/$~', '', $targetDir);
		$this->db->update(array(
			'filename' => $this->_basename($source),
			'metadata.path' => $this->_dirname($source),
		), array(
			'$set' => array(
				'filename' => (string) $name,
				'metadata.path' => $targetDir
			)
		));
		return $targetDir;
	}

	/**
	 * Remove file
	 *
	 * @param  string  $path  file path
	 * @return bool
	 **/
	protected function _unlink($path) {
		$file = $this->getFile($path);
		if(!$file){
			return false;
		}
		return $this->db->delete($file->file['_id']);
	}

	/**
	 * Remove dir. Will fail if the directory is not empty
	 *
	 * @param  string  $path  dir path
	 * @return bool
	 **/
	protected function _rmdir($path) {
		if(count($this->_scandir($path)) > 0){
			return false;
		}
		return $this->_unlink($this->_joinPath($path, $this::PLACEHOLDER));
	}

	/**
	 * Create new file and write into it from file pointer.
	 * Return new file path or false on error.
	 *
	 * @param  resource  $fp   file pointer
	 * @param  string    $dir  target dir path
	 * @param  string    $name file name
	 * @return bool|string
	 **/
	protected function _save($fp, $dir, $name, $mime, $w, $h) {
		$dir = preg_replace('~/$~', '', $dir);
		$content = '';
		while (!feof($fp)) {
			$content .= fread($fp, 8192);
		}
		$this->db->storeBytes($content, array(
			"filename" => $name,
			"metadata" => array(
				"path" => $dir,
				"mime" => $mime,
				"width" => $w,
				"height" => $h
			)
		));
		return $this->_joinPath($dir, $name);
	}

	/**
	 * Get file contents
	 *
	 * @param  string  $path  file path
	 * @return string|false
	 **/
	protected function _getContents($path) {
		$file = $this->getFile($path);
		if(!$file){
			return false;
		}
		return $file->getBytes();
	}
	
	/**
	 * Write a string to a file
	 *
	 * @param  string  $path     file path
	 * @param  string  $content  new file content
	 * @return bool
	 **/
	protected function _filePutContents($path, $content) {
		$oldFile = $this->getFile($path);
		if(!$oldFile){
			return false;
		}
		return $this->db->storeBytes($content, array(
			"filename" => $oldFile->file['filename'],
			"metadata" => $oldFile->file['metadata']
		));
	}


	// ************ copy pasted methods *********

	/**
	 * Return array of parents paths (ids)
	 *
	 * @param  int   $path  file path (id)
	 * @return array
	 * @author Dmitry (dio) Levashov
	 **/
	protected function getParents($path) {
		$parents = array();

		while ($path) {
			if ($file = $this->stat($path)) {
				array_unshift($parents, $path);
				$path = isset($file['phash']) ? $this->decode($file['phash']) : false;
			}
		}
		
		if (count($parents)) {
			array_pop($parents);
		}
		return $parents;
	}

	/**
	 * Return parent directory path
	 */
	protected function _dirname($path){
		return dirname($path);
	}

	/**
	 * Return file name
	 */
	protected function _basename($path) {
		return basename($path);
	}

	/**
	 * Return normalized path, this works the same as os.path.normpath() in Python
	 **/
	protected function _normpath($path) {
		if (empty($path)) {
			return '.';
		}

		if (strpos($path, '/') === 0) {
			$initial_slashes = true;
		} else {
			$initial_slashes = false;
		}
			
		if (($initial_slashes) 
		&& (strpos($path, '//') === 0) 
		&& (strpos($path, '///') === false)) {
			$initial_slashes = 2;
		}
			
		$initial_slashes = (int) $initial_slashes;

		$comps = explode('/', $path);
		$new_comps = array();
		foreach ($comps as $comp) {
			if (in_array($comp, array('', '.'))) {
				continue;
			}
				
			if (($comp != '..') 
			|| (!$initial_slashes && !$new_comps) 
			|| ($new_comps && (end($new_comps) == '..'))) {
				array_push($new_comps, $comp);
			} elseif ($new_comps) {
				array_pop($new_comps);
			}
		}
		$comps = $new_comps;
		$path = implode('/', $comps);
		if ($initial_slashes) {
			$path = str_repeat('/', $initial_slashes) . $path;
		}
		
		return $path ? $path : '.';
	}
	/**
	 * Return file path related to root dir
	 *
	 * @param  string  $path  file path
	 * @return string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _relpath($path) {
		return $path == $this->root ? '' : substr($path, strlen($this->root)+1);
	}
	
	/**
	 * Convert path related to root dir into real path
	 *
	 * @param  string  $path  file path
	 * @return string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _abspath($path) {
		return $path == DIRECTORY_SEPARATOR ? $this->root : $this->root.DIRECTORY_SEPARATOR.$path;
	}
	
	/**
	 * Return fake path started from root dir
	 *
	 * @param  string  $path  file path
	 * @return string
	 * @author Dmitry (dio) Levashov
	 **/
	protected function _path($path) {
		return $this->rootName.($path == $this->root ? '' : $this->separator.$this->_relpath($path));
	}
	/**
	 * Return true if $path is children of $parent
	 **/
	protected function _inpath($path, $parent) {
		return $path == $parent
			? true
			: in_array($parent, $this->getParents($path));
	}
	/**
	 * Return true if path is dir and has at least one childs directory
	 **/
	protected function _subdirs($path) {
		return ($stat = $this->stat($path)) && isset($stat['dirs']) ? $stat['dirs'] : false;
	}
	/**
	 * Return object width and height
	 **/
	protected function _dimensions($path, $mime) {
		return ($stat = $this->stat($path)) && isset($stat['width']) && isset($stat['height']) ? $stat['width'].'x'.$stat['height'] : '';
	}
	/**
	 * Actually implemented by cacheDir
	 **/
	protected function _scandir($path) {
		$path = preg_replace('~/$~', '', $path);
		return isset($this->dirsCache[$path])
			? $this->dirsCache[$path]
			: $this->cacheDir($path);
	}
	/**
	 * Create dir and return path
	 */
	protected function _mkdir($path, $name) {
		return $this->make($path, $name, 'directory') ? $this->_joinPath($path, $name) : false;
	}
	/**
	 * Create file and return path
	 **/
	protected function _mkfile($path, $name) {
		return $this->make($path, $name, 'text/plain') ? $this->_joinPath($path, $name) : false;
	}
	protected function _symlink($target, $path, $name) {
		return false;
	}
	protected function _checkArchivers() {
		return;
	}
	protected function _unpack($path, $arc) {
		return;
	}
	protected function _findSymlinks($path) {
		return false;
	}
	protected function _extract($path, $arc) {
		return false;
	}
	protected function _archive($dir, $files, $name, $arc) {
		return false;
	}
}