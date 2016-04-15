<?php
/**
 * Date: 30.03.15
 * Time: 13:48
 *
 * This file is part of the MihailDev project.
 *
 * (c) MihailDev project <http://github.com/mihaildev/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace mihaildev\elfinder;

/**
 * Class FtpPath
 *
 * @package mihaildev\elfinder
 */
class FtpPath extends BasePath{
	public $driver = 'FTP';

	public $baseUrl = '';

	public $basePath = '';

	public $host = 'localhost';
	public $port = 21;

	public $user = '';
	public $pass = '';

	public $path = '/';
	public $mode = 'passive';

	public $iss = false;

	public function getUrl(){
		return rtrim($this->baseUrl,'/').'/'.trim($this->path,'/');
	}

	public function getRealPath(){
		return rtrim($this->basePath,'/').'/'.trim($this->path,'/');
	}

	public function getRoot(){
		if($this->iss)
			$this->driver = 'FTPIIS';

		$options = parent::getRoot();

		$options['host'] = $this->host;
		$options['port'] = $this->port;
		$options['user'] = $this->user;
		$options['pass'] = $this->pass;
		$options['mode'] = $this->mode;
		$options['path'] = $this->getRealPath();
		$options['URL'] = $this->getUrl();

		return $options;
	}
}