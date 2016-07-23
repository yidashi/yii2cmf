<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/19
 * Time: 上午12:08
 */

namespace frontend\themes;


use common\components\PackageInfo;
use common\components\ThemeManager;

abstract class Theme extends PackageInfo
{
    public $manager;
    public function __construct(ThemeManager $manager, array $config = [])
    {
        $this->manager = $manager;
        parent::__construct($config);
    }

    public function isActive()
    {
        return $this->getPackage() == $this->manager->getDefaultTheme();
    }
}