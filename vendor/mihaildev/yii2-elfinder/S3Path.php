<?php
/**
 * Date: 12.05.15
 * Time: 17:29
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
 * Class S3Path
 *
 */
class S3Path extends BasePath{
	public $driver = 'S3';
	public $accessKey = '';
	public $secretKey = '';
	public $bucket = '';
	public $region = '';
	public $path = '';

	public function getRoot(){
		$options = parent::getRoot();
		$options['separator'] = '/';

		$options['s3']= [
			'key' => $this->accessKey,
			'secret' => $this->secretKey,
			'region' => $this->region,
			'scheme' => 'http',
			'ssl.certificate_authority' => false
		];

		$options['bucket'] = $this->bucket;

		if(empty($this->path)) {
			$options['path'] = './';
			$options['URL'] = 'http://' . $this->bucket . '.s3-website-' . $this->region . '.amazonaws.com/';
		}else{
			$this->path = trim($this->path, '/');
			$options['path'] = $this->path;
			$options['URL'] = 'http://' . $this->bucket . '.s3-website-' . $this->region . '.amazonaws.com/'.$this->path;
		}

		$options['acl'] = 'public';

		if($options['defaults']['read'])
			$options['acl'] .= '-read';

		if($options['defaults']['write'])
			$options['acl'] .= '-write';
		return $options;
	}
}