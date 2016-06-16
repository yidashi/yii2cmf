<?php
/**
 * Date: 23.01.14
 * Time: 22:47
 */

namespace mihaildev\elfinder\volume;

use Yii;

class Local extends Base{
	public $path;

	public $baseUrl = '@web';

	public $basePath = '@webroot';

	public function getUrl(){
		return Yii::getAlias($this->baseUrl.'/'.trim($this->path,'/'));
	}

	public function getRealPath(){
		$path = Yii::getAlias($this->basePath.'/'.trim($this->path,'/'));

		if(!is_dir($path))
			mkdir($path, 0777, true);

		return $path;
	}

	protected function optionsModifier($options){

		$options['path'] = $this->getRealPath();
		$options['URL'] = $this->getUrl();

		return $options;
	}
} 