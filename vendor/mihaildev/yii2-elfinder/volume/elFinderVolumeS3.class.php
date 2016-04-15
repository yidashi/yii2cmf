<?php
/**
 * Amazon S3 driver for elFinder
 *
 * Use your own aws.phar or use the one supplied
 *
 * @author Manatsawin Hanmongkolchai
 * @license Apache license 2.0
 * This driver is developed under Kyou project.
 * Kyou project's development is sponsored by NECTEC under NSC2013 program.
 * NECTEC does not provides support for this driver
 */

/*
make
_fopen
_fclose
_copy
_move
_unlink
_save
_getContents
_filePutContents
*/

require_once "aws.phar";

class elFinderVolumeS3 extends elFinderVolumeDriver {
	protected function pathToKey($path){
		//return $path;
		if($path == '.' || $path == './')
			return '/';

		if(substr($path, 0, 2) == './'){
			return substr($path, 2);
		}

		return $path;
	}

	/**
	 * @var string
	 */
	protected $driverId = 's';
	/** @var  \Aws\S3\S3Client */
	protected $s3;

	public function __construct(){
		$this->options['mimeDetect'] = 'internal';
		if(!isset($this->options['s3'])){
			$this->options['s3'] = array();
		}
		if(!isset($this->options['acl'])){
			$this->options['acl'] = 'private';
		}
	}

	/**
	 * Create S3Client
	 * All options to S3Client is supplied in the s3 option
	 * See http://docs.amazonwebservices.com/aws-sdk-php-2/latest/class-Aws.S3.S3Client.html for list of S3Client options
	 * See http://docs.amazonwebservices.com/general/latest/gr/rande.html#s3_region for list of region names
	 * @return bool
	 */
	protected function init(){
		$this->s3 = Aws\S3\S3Client::factory($this->options['s3']);
		$this->bucket = $this->options['bucket'];
		return true;
	}

	protected function format_stat($file){
		$dt = DateTime::createFromFormat(Aws\Common\Enum\DateFormat::RFC1123, $file['LastModified']);
		$meta = $file['Metadata'];
		return array(
			"name" => $file['filename'],
			"size" => $file['ContentLength'],
			"ts" => $dt->getTimestamp(),
			"mime" => $file['ContentType'],
			"read" => true,
			"write" => true,
			"width" => $meta['width'],
			"height" => $meta['height'],
		);
	}

	/**
	 * Scan directory
	 */
	protected function cacheDir($path) {
		$rpath = rtrim($this->pathToKey($path) , '/'). "/";

		$this->dirsCache[$path] = array();
		if($rpath == '/'){
			$scan = $this->s3->listObjects(array(
				"Bucket" => $this->bucket,
				"Key" => '/',
				"Delimiter" => "/"
			));
		}else{
			$scan = $this->s3->listObjects(array(
				"Bucket" => $this->bucket,
				"Prefix" => $rpath,
				"Delimiter" => "/"
			));
		}

		if(isset($scan['CommonPrefixes'])){
			foreach($scan['CommonPrefixes'] as $prefix){
				if($prefix['Prefix'] == $rpath){
					continue;
				}
				//preg_match('~/([^/]+)/$~', $prefix['Prefix'], $m);
				if($rpath !== '/')
					$name = substr($prefix['Prefix'], strlen($rpath));
				else
					$name = $prefix['Prefix'];
				$name = trim($name, '/');
				$data = array(
					"name" => $name,
					"size" => 0,
					"mime" => "directory",
					"read" => true,
					"write" => true,
					"parent_id" => $path,
				);
				$fullpath = $this->_joinPath($path, $data['name']);
				//print $fullpath."\n";
				if ($stat = $this->updateCache($fullpath, $data)) {
					$this->dirsCache[$path][] = $fullpath;
				}
			}
		}

		if(isset($scan['Contents'])){
			foreach($scan['Contents'] as $file){
				if(preg_match('~/$~', $file['Key'])){
					continue;
				}
				$data = $this->format_stat($this->getFile($file['Key']));
				$fullpath = $this->_joinPath($path, $data['name']);
				if ($stat = $this->updateCache($fullpath, $data)) {
					$this->dirsCache[$path][] = $fullpath;
				}
			}
		}
		
		return $this->dirsCache[$path];
	}

	protected function make($path, $name, $mime){
		if($mime == "directory"){
			$name .= "/";
		}
		$path = $this->_joinPath($path, $name);
		return $this->s3->putObject(array(
			"Bucket" => $this->bucket,
			"Key" => $this->pathToKey($path),
			"ContentType" => $mime,
			"ACL" => $this->options['acl']
		));
	}

	protected function getFile($path, $method="headObject"){
		try{
			$fileData = $this->s3->$method(array(
				"Bucket" => $this->bucket,
				"Key" => $this->pathToKey($path)
			));
		}catch(Aws\S3\Exception\NoSuchKeyException $e){
			return false;
		}
		$fileData['filename'] = $this->_basename($path);
		$fileData['path'] = $path;

		return $fileData;
	}

	/**
	 * Join dir name and file name
	 */
	protected function _joinPath($path, $name) {
		$path = rtrim($path, '/');
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
		if(!$file || $path == '.'|| $path == './'){
			$qpath = $path;
			if(!preg_match('~/$~', $path)){
				$qpath .= '/';
			}else{
				return false;
			}
			// _subdirs need to know is there any subdir
			$dirList = $this->getScandir($qpath);
			$dirs = 0;
			if(count($dirList) > 0){
				foreach($dirList as $dir){
					if($dir['mime'] == "directory"){
						$dirs++;
					}
				}
			}else if($path != $this->root){
				// sometimes this is an empty directory
				// but we need special case for root, root always exists
				if(!$this->getFile($qpath)){
					return false;
				}
			}
			$parent_dir = preg_replace('~/(.*?)[/]{0,1}$~', '', $path);
			$data = array(
				"name" => basename($path),
				"size" => 0,
				"mime" => "directory",
				"read" => true,
				"write" => true,
				"dirs" => $dirs,
				"parent_id" => $parent_dir,
			);
			return $data;
		}
		return $this->format_stat($file);
	}

	protected function getTmpName($path){
		$exp = pathinfo($path, PATHINFO_EXTENSION);
		if(empty($exp))
			$exp = 'tmp';

		return 'tmp_'.$this->id()."_".md5(serialize($this->options['s3']).$path).'.'.$exp;
	}

	protected function getTmpFilePath($path){
		return $this->tmbPath.DIRECTORY_SEPARATOR.$this->getTmpName($path);
	}

	/**
	 * Open file and return file pointer (read only)
	 *
	 * @param  string  $path  file path
	 * @param  string  $mode  open file mode (ignored in this driver)
	 * @return resource|false
	 **/
	protected function _fopen($path, $mode='rb'){

		$file = $this->getFile($path, 'getObject');
		if(!$file){
			return false;
		}

		$tmpPath = $this->getTmpFilePath($path);

		$dir = dirname($tmpPath);
		if(!is_dir($dir)){
			mkdir($dir, $this->options['tmbPathMode'], true);
			chmod($dir, $this->options['tmbPathMode']);
		}

		file_put_contents($tmpPath, (string) $file['Body']);

		return fopen($tmpPath, $mode);
	}

	/**
	 * Close opened file
	 **/
	protected function _fclose($fp, $path='') {
		@fclose($fp);
		$tmpPath = $this->getTmpFilePath($path);
		if(file_exists($tmpPath)){
			unlink($tmpPath);
		}

	}

	/**
	 * Copy file into another file
	 * S3 does not preserve ACL for a file
	 * also can be used only for file smaller than 5GB
	 *
	 * @param  string  $source     source file path
	 * @param  string  $targetDir  target directory path
	 * @param  string  $name       new file name
	 * @return Guzzle\Service\Resource\Model
	 **/
	protected function _copy($source, $targetDir, $name) {
		$stat = $this->stat($source);
		if($stat['mime'] == 'directory'){
			$newDir = $this->_mkdir($targetDir, $name);

			$items = $this->_scandir($source);

			foreach($items as $item){
				$this->_copy($item, $newDir, basename($item));
			}

			$this->clearcache();
			return $newDir;
		}
		$this->clearcache();
		return $this->s3->copyObject(array(
			"Bucket" => $this->bucket,
			"Key" => $this->pathToKey($this->_joinPath($targetDir, $name)),
			"CopySource" => $this->bucket . "/" . $this->pathToKey($source),
			"ACL" => $this->options['acl']
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
		$this->_copy($source, $targetDir, $name);
		$this->_unlink($source);
		return $targetDir;
	}

	/**
	 * Remove file
	 *
	 * @param  string  $path  file path
	 * @return Guzzle\Service\Resource\Model
	 **/
	protected function _unlink($path) {

		$clear = new \Aws\S3\Model\ClearBucket($this->s3, $this->bucket);
		$iterator = $this->s3->getIterator('ListObjects', array('Bucket' => $this->bucket, 'Prefix' => $this->pathToKey($path)));

		$clear->setIterator($iterator);
		$clear->clear();

		return $this->s3->deleteObject(array(
			"Bucket" => $this->bucket,
			"Key" => $this->pathToKey($path)
		));
	}

	/**
	 * Remove dir. Will fail if the directory is not empty
	 *
	 * @param  string  $path  dir path
	 * @return bool
	 **/
	protected function _rmdir($path) {
		if(!preg_match('~/$~', $path)){
			$path .= '/';
		}

		return $this->_unlink($path);
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
	protected function _save($fp, $dir, $name, $stat) {
		$path = $this->_joinPath($dir, $name);

		if(strpos($path, './')){
			$path = substr($path, 2);
		}
		
		$mime = $stat['mime'];
		$w = !empty($stat['width'])  ? $stat['width']  : 0;
		$h = !empty($stat['height']) ? $stat['height'] : 0;
		$this->s3->putObject(array(
			"Bucket" => $this->bucket,
			"Key" => $this->pathToKey($path),
			"ContentType" => $mime,
			"ACL" => $this->options['acl'],
			"Metadata" => array(
				'width' => $w,
				'height' => $h
			),
			"Body" => $fp
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
		$file = $this->getFile($path, 'getObject');
		if(!$file){
			return false;
		}
		return (string) $file['Body'];
	}
	
	/**
	 * Write a string to a file
	 *
	 * @param  string  $path     file path
	 * @param  string  $content  new file content
	 * @return bool
	 **/
	protected function _filePutContents($path, $content) {
		$oldSettings = $this->getFile($path);

		$settings = array(
			"Bucket" => $this->bucket,
			"Key" => $this->pathToKey($path),
			"ACL" => $this->options['acl'],
			"Body" => $content
		);
		if($oldSettings){
			$settings['Metadata'] = $oldSettings['Metadata'];
			$settings['ContentType'] = $oldSettings['ContentType'];
			$settings['ACP'] = Aws\S3\Model\Acp::fromArray($this->s3->getObjectAcl(array(
				'Bucket' => $this->bucket,
				'Key' => $this->pathToKey($path)
			))->toArray());
			unset($settings['ACL']);
		}
		return $this->s3->putObject($settings);
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

		$path = str_replace('\\', '/', $path);
		$patr = ltrim($path, '/');

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
		return $path == DIRECTORY_SEPARATOR ? $this->root : str_replace('\\', '/', $this->root.DIRECTORY_SEPARATOR.$path);
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