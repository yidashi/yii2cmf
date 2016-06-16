<?php
/**
 * @var array $options
 */

define('ELFINDER_IMG_PARENT_URL', \mihaildev\elfinder\Assets::getPathUrl());

// run elFinder
$connector = new elFinderConnector(new elFinder($options));
$connector->run();