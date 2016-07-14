--
-- Dumping data for table {{%user}}
--

LOCK TABLES {{%user}} WRITE;
/*!40000 ALTER TABLE {{%user}} DISABLE KEYS */;
INSERT INTO {{%user}} VALUES (1,'hehe','1lQl4TG6sYlyWRqXZEWL0ZhQkPATVnMs','$2y$13$lYlhIcBcs6jBr7yTd6YrWueckcs.Cvx70juIHs6wEfjtUwnA318VW',NULL,'hehe@qq.com',10,1,1441766741,1441766741,1458640427);
/*!40000 ALTER TABLE {{%user}} ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES {{%profile}} WRITE;
INSERT INTO {{%profile}} (id,locale) VALUES(1, 'zh-CN');
UNLOCK TABLES;


--
-- Dumping data for table {{%auth_item}}
--

LOCK TABLES {{%auth_item}} WRITE;
/*!40000 ALTER TABLE {{%auth_item}} DISABLE KEYS */;
INSERT INTO {{%auth_item}} VALUES ('superAdmin',1,'超级管理员',NULL,NULL,1443080982,1443408507),('/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin-log/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin-log/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin-log/view',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/assignment/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/assignment/assign',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/assignment/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/assignment/search',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/assignment/view',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/default/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/default/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/create',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/update',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/menu/view',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/assign',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/create',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/search',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/update',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/permission/view',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/assign',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/create',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/search',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/update',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/role/view',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/route/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/route/assign',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/route/create',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/route/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/route/search',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/*',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/create',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/index',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/update',2,NULL,NULL,NULL,1458640575,1458640575),('/admin/rule/view',2,NULL,NULL,NULL,1458640575,1458640575),('/article/*',2,NULL,NULL,NULL,1458640575,1458640575),('/article/change-status',2,NULL,NULL,NULL,1467619833,1467619833),('/article/clear',2,NULL,NULL,NULL,1467619833,1467619833),('/article/create',2,NULL,NULL,NULL,1458640575,1458640575),('/article/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/article/hard-delete',2,NULL,NULL,NULL,1458640575,1458640575),('/article/index',2,NULL,NULL,NULL,1458640575,1458640575),('/article/reduction',2,NULL,NULL,NULL,1458640575,1458640575),('/article/trash',2,NULL,NULL,NULL,1458640575,1458640575),('/article/update',2,NULL,NULL,NULL,1458640575,1458640575),('/article/upload',2,NULL,NULL,NULL,1458640575,1458640575),('/article/view',2,NULL,NULL,NULL,1458640575,1458640575),('/article/webupload',2,NULL,NULL,NULL,1458640575,1458640575),('/category/*',2,NULL,NULL,NULL,1458640575,1458640575),('/category/create',2,NULL,NULL,NULL,1458640575,1458640575),('/category/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/category/index',2,NULL,NULL,NULL,1458640575,1458640575),('/category/update',2,NULL,NULL,NULL,1458640575,1458640575),('/category/view',2,NULL,NULL,NULL,1458640575,1458640575),('/comment/*',2,NULL,NULL,NULL,1467619833,1467619833),('/comment/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/comment/index',2,NULL,NULL,NULL,1467619833,1467619833),('/comment/view',2,NULL,NULL,NULL,1467619833,1467619833),('/config/*',2,NULL,NULL,NULL,1458640575,1458640575),('/config/create',2,NULL,NULL,NULL,1458640575,1458640575),('/config/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/config/index',2,NULL,NULL,NULL,1458640575,1458640575),('/config/update',2,NULL,NULL,NULL,1458640575,1458640575),('/config/view',2,NULL,NULL,NULL,1458640575,1458640575),('/console/*',2,NULL,NULL,NULL,1467619833,1467619833),('/database/*',2,NULL,NULL,NULL,1458640575,1458640575),('/database/export/*',2,NULL,NULL,NULL,1458640575,1458640575),('/database/export/index',2,NULL,NULL,NULL,1458640575,1458640575),('/database/export/init',2,NULL,NULL,NULL,1458640575,1458640575),('/database/export/optimize',2,NULL,NULL,NULL,1458640575,1458640575),('/database/export/repair',2,NULL,NULL,NULL,1467619833,1467619833),('/database/export/start',2,NULL,NULL,NULL,1458640575,1458640575),('/database/import/*',2,NULL,NULL,NULL,1458640575,1458640575),('/database/import/del',2,NULL,NULL,NULL,1458640575,1458640575),('/database/import/index',2,NULL,NULL,NULL,1458640575,1458640575),('/database/import/init',2,NULL,NULL,NULL,1458640575,1458640575),('/database/import/start',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/*',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/*',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/db-explain',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/download-mail',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/index',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/toolbar',2,NULL,NULL,NULL,1458640575,1458640575),('/debug/default/view',2,NULL,NULL,NULL,1458640575,1458640575),('/donation/*',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/*',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/create',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/index',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/update',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/admin/view',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/default/*',2,NULL,NULL,NULL,1467619833,1467619833),('/donation/default/index',2,NULL,NULL,NULL,1467619833,1467619833),('/file-manager-elfinder/*',2,NULL,NULL,NULL,1467619833,1467619833),('/file-manager-elfinder/connect',2,NULL,NULL,NULL,1467619833,1467619833),('/file-manager-elfinder/manager',2,NULL,NULL,NULL,1467619833,1467619833),('/file-manager/*',2,NULL,NULL,NULL,1467619833,1467619833),('/file-manager/index',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/*',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/create',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/index',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/update',2,NULL,NULL,NULL,1467619833,1467619833),('/gather/view',2,NULL,NULL,NULL,1467619833,1467619833),('/gii/*',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/*',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/action',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/diff',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/index',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/preview',2,NULL,NULL,NULL,1458640575,1458640575),('/gii/default/view',2,NULL,NULL,NULL,1458640575,1458640575),('/gridview/*',2,NULL,NULL,NULL,1458640575,1458640575),('/gridview/export/*',2,NULL,NULL,NULL,1458640575,1458640575),('/gridview/export/download',2,NULL,NULL,NULL,1458640575,1458640575),('/log/*',2,NULL,NULL,NULL,1467619833,1467619833),('/log/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/log/index',2,NULL,NULL,NULL,1467619833,1467619833),('/log/view',2,NULL,NULL,NULL,1467619833,1467619833),('/page/*',2,NULL,NULL,NULL,1458640575,1458640575),('/page/create',2,NULL,NULL,NULL,1458640575,1458640575),('/page/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/page/index',2,NULL,NULL,NULL,1458640575,1458640575),('/page/update',2,NULL,NULL,NULL,1458640575,1458640575),('/page/upload',2,NULL,NULL,NULL,1467619833,1467619833),('/page/view',2,NULL,NULL,NULL,1458640575,1458640575),('/plugins/*',2,NULL,NULL,NULL,1467619833,1467619833),('/plugins/close',2,NULL,NULL,NULL,1467619833,1467619833),('/plugins/index',2,NULL,NULL,NULL,1467619833,1467619833),('/plugins/install',2,NULL,NULL,NULL,1467619833,1467619833),('/plugins/open',2,NULL,NULL,NULL,1467619833,1467619833),('/plugins/uninstall',2,NULL,NULL,NULL,1467619833,1467619833),('/site/*',2,NULL,NULL,NULL,1458640575,1458640575),('/site/demo',2,NULL,NULL,NULL,1458640575,1458640575),('/site/error',2,NULL,NULL,NULL,1458640575,1458640575),('/site/index',2,NULL,NULL,NULL,1458640575,1458640575),('/site/login',2,NULL,NULL,NULL,1458640575,1458640575),('/site/logout',2,NULL,NULL,NULL,1458640575,1458640575),('/site/webupload',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/*',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/create',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/index',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/update',2,NULL,NULL,NULL,1467619833,1467619833),('/spider/view',2,NULL,NULL,NULL,1467619833,1467619833),('/suggest/*',2,NULL,NULL,NULL,1467619833,1467619833),('/suggest/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/suggest/index',2,NULL,NULL,NULL,1467619833,1467619833),('/suggest/view',2,NULL,NULL,NULL,1467619833,1467619833),('/system/*',2,NULL,NULL,NULL,1458640575,1458640575),('/system/config',2,NULL,NULL,NULL,1458640575,1458640575),('/system/webupload',2,NULL,NULL,NULL,1458640575,1458640575),('/tag/*',2,NULL,NULL,NULL,1467619833,1467619833),('/tag/create',2,NULL,NULL,NULL,1467619833,1467619833),('/tag/delete',2,NULL,NULL,NULL,1467619833,1467619833),('/tag/index',2,NULL,NULL,NULL,1467619833,1467619833),('/tag/update',2,NULL,NULL,NULL,1467619833,1467619833),('/tag/view',2,NULL,NULL,NULL,1467619833,1467619833),('/user/*',2,NULL,NULL,NULL,1458640575,1458640575),('/user/ban',2,NULL,NULL,NULL,1467619833,1467619833),('/user/create',2,NULL,NULL,NULL,1458640575,1458640575),('/user/delete',2,NULL,NULL,NULL,1458640575,1458640575),('/user/index',2,NULL,NULL,NULL,1458640575,1458640575),('/user/reset-password',2,NULL,NULL,NULL,1458640575,1458640575),('/user/update',2,NULL,NULL,NULL,1458640575,1458640575),('/user/view',2,NULL,NULL,NULL,1458640575,1458640575);
/*!40000 ALTER TABLE {{%auth_item}} ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `pop_auth_assignment`
--

LOCK TABLES `pop_auth_assignment` WRITE;
/*!40000 ALTER TABLE `pop_auth_assignment` DISABLE KEYS */;
INSERT INTO `pop_auth_assignment` VALUES ('superAdmin','1',1443080982);
/*!40000 ALTER TABLE `pop_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table {{%auth_item_child}}
--

LOCK TABLES {{%auth_item_child}} WRITE;
/*!40000 ALTER TABLE {{%auth_item_child}} DISABLE KEYS */;
INSERT INTO {{%auth_item_child}} VALUES ('superAdmin','/*');
/*!40000 ALTER TABLE {{%auth_item_child}} ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table {{%config}}
--

LOCK TABLES `pop_config` WRITE;
/*!40000 ALTER TABLE `pop_config` DISABLE KEYS */;
INSERT INTO `pop_config` VALUES (1,'CONFIG_TYPE_LIST','text=>字符\r\narray=>数组\r\npassword=>密码\r\nimage=>图片\r\ntextarea=>多行字符\r\nselect=>下拉框\r\nradio=>单选框\r\ncheckbox=>多选框\r\neditor=>富文本编辑器','','配置类型列表','array',0,1461937892,'system'),(3,'SEO_SITE_DESCRIPTION','yiicmf2','','meta description','text',0,1468403120,'system'),(4,'SEO_SITE_KEYWORDS','yiicmf','','meta keywords','text',0,1461937892,'system'),(5,'SITE_ICP','','','域名备案号','text',0,1461937892,'system'),(6,'SITE_NAME','饮水思源','','网站名称','text',0,1461937892,'system'),(7,'SITE_LOGO','logo.png','','网站LOGO','image',0,1461937892,'system'),(8,'FOOTER','','','底部','textarea',0,1461937892,'system'),(9,'THEME_NAME','chncomic','basic=>basic\r\nchncomic=>chncomic','主题名','select',0,1467882452,'system'),(10,'BACKEND_SKIN','skin-blue','skin-black=>skin-black\r\nskin-blue=>skin-blue\r\nskin-green=>skin-green\r\nskin-purple=>skin-purple\r\nskin-red=>skin-red\r\nskin-yellow=>skin-yellow','后台皮肤','select',1461931367,1461937892,'system'),(11,'FRIENDLY_LINK','Yii2CMF=>http://www.51siyuan.cn','','友情链接','array',0,1468406411,'email'),(12,'CONFIG_GROUP','system=>系统2\r\nwechat=>微信\r\nemail=>邮箱','','配置分组','array',1468405444,1468421137,'system');
/*!40000 ALTER TABLE `pop_config` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table {{%menu}}
--

LOCK TABLES {{%menu}} WRITE;
/*!40000 ALTER TABLE {{%menu}} DISABLE KEYS */;
INSERT INTO {{%menu}} VALUES (1,'权限管理',NULL,NULL,1,NULL,'users'),
(5,'用户管理',1,'/user/index',NULL,NULL,''),
(6,'路由管理',1,'/admin/route/index',NULL,NULL,''),
(7,'角色管理',1,'/admin/role/index',NULL,NULL,''),
(8,'菜单管理',1,'/admin/menu/index',NULL,NULL,''),
(2,'系统管理',NULL,NULL,2,NULL,'cog'),
(9,'网站设置',2,'/system/config',1,NULL,''),
(10,'配置管理',2,'/config/index',2,NULL,''),
(11,'操作记录',2,'/admin-log/index',NULL,NULL,''),
(3,'内容管理',NULL,NULL,3,NULL,'edit'),
(12,'文章列表',3,'/article/index',1,NULL,''),
(13,'发布文章',3,'/article/create',2,NULL,''),
(14,'回收站',3,'/article/trash',3,NULL,''),
(15,'单页管理',3,'/page/index',40,NULL,''),
(16,'分类管理',3,'/category/index',4,NULL,''),
(17,'评论管理',3,'/comment/index',6,NULL,''),
(4,'插件管理',NULL,NULL,4,NULL,'book'),
(18,'模块',4,'/plugins/index',NULL,NULL,''),
(19,'数据库备份',NULL,NULL,4,NULL,'book'),
(20,'备份',19,'/database/export/index',NULL,NULL,''),
(21,'还原',19,'/database/import/index',NULL,NULL,'');
/*!40000 ALTER TABLE {{%menu}} ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES {{%page}} WRITE;
/*!40000 ALTER TABLE {{%page}} DISABLE KEYS */;
INSERT INTO {{%page}} VALUES (1,1,'<p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; box-sizing: border-box; color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, Arial, &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei&#39;, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(255, 255, 255);\">本网站所收集的部分公开资料来源于互联网，转载的目的在于传递更多信息及用于网络分享，并不代表本站赞同其观点和对其真实性负责，也不构成任何其他建议。本站部分作品是由网友自主投稿和发布、编辑整理上传，对此类作品本站仅提供交流平台，不为其版权负责。如果您发现网站上有侵犯您的知识产权的作品，请与我们取得联系，我们会及时修改或删除。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; box-sizing: border-box; color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, Arial, &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei&#39;, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(255, 255, 255);\">本网站所提供的信息，只供参考之用。本网站不保证信息的准确性、有效性、及时性和完整性。本网站及其雇员一概毋须以任何方式就任何信息传递或传送的失误、不准确或错误，对用户或任何其他人士负任何直接或间接责任。在法律允许的范围内，本网站在此声明，不承担用户或任何人士就使用或未能使用本网站所提供的信息或任何链接所引致的任何直接、间接、附带、从属、特殊、惩罚性或惩戒性的损害赔偿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; box-sizing: border-box; color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, Arial, &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei&#39;, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(255, 255, 255);\">电子邮件：332672087#qq.com（发邮件时，请将“#”替换为“@”）</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; box-sizing: border-box; color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, Arial, &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei&#39;, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(255, 255, 255);\">联系电话：18045665692</p><p><br/></p>','免责声明','mianze',1441766741,1441766741),(2,1,'<p><span style=\"color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, Arial, &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei&#39;, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(255, 255, 255);\">本站基于YII2开发，仅用作学习交流。如需源码请点击站点最下边的获取源码。</span></p>','关于我们','aboutus',1441766741,1441766741);
/*!40000 ALTER TABLE {{%page}} ENABLE KEYS */;
UNLOCK TABLES;

