
--
-- Dumping data for table {{%auth_item}}
--

LOCK TABLES {{%auth_item}} WRITE;
/*!40000 ALTER TABLE {{%auth_item}} DISABLE KEYS */;
INSERT INTO {{%auth_item}} VALUES ('superAdmin',1,'超级管理员',NULL,NULL,1443080982,1443408507),('/*',2,NULL,NULL,NULL,1458640575,1458640575);
/*!40000 ALTER TABLE {{%auth_item}} ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table {{%auth_assignment}}
--

LOCK TABLES {{%auth_assignment}} WRITE;
/*!40000 ALTER TABLE {{%auth_assignment}} DISABLE KEYS */;
INSERT INTO {{%auth_assignment}} VALUES ('superAdmin','1',1443080982);
/*!40000 ALTER TABLE {{%auth_assignment}} ENABLE KEYS */;
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
-- Dumping data for table {{%menu}}
--

LOCK TABLES {{%menu}} WRITE;
/*!40000 ALTER TABLE {{%menu}} DISABLE KEYS */;
INSERT INTO {{%menu}} (`id`, `name`, `parent`, `route`, `order`, `data`, `icon`)
VALUES
	(24, '系统管理', NULL, NULL, 2, NULL, 'cog'),
	(30, '数据库备份', NULL, NULL, 5, NULL, 'book'),
	(33, '权限管理', NULL, NULL, 1, NULL, 'users'),
	(39, '内容管理', NULL, NULL, 3, NULL, 'edit'),
	(44, '插件管理', NULL, NULL, 4, NULL, 'plug'),
	(46, '外观', NULL, NULL, 6, NULL, 'tv'),
	(25, '网站设置', 24, '/system/config', 1, NULL, ''),
	(26, '配置管理', 24, '/config/index', 2, NULL, ''),
	(37, '操作记录', 24, '/admin-log/index', 3, NULL, ''),
	(31, '备份', 30, '/backup/export/index', NULL, NULL, ''),
	(32, '还原', 30, '/backup/import/index', NULL, NULL, ''),
	(15, '用户管理', 33, '/user/admin/index', NULL, NULL, ''),
	(16, '路由管理', 33, '/rbac/route/index', NULL, NULL, ''),
	(17, '角色管理', 33, '/rbac/role/index', NULL, NULL, ''),
	(34, '菜单管理', 33, '/rbac/menu/index', NULL, NULL, ''),
	(22, '文章列表', 39, '/article/index', 1, NULL, ''),
	(27, '单页管理', 39, '/page/index', 40, NULL, ''),
	(29, '分类管理', 39, '/category/index', 4, NULL, ''),
	(40, '发布文章', 39, '/article/create', 2, NULL, ''),
	(41, '回收站', 39, '/article/trash', 3, NULL, ''),
	(42, '评论管理', 39, '/comment/index', 6, NULL, ''),
	(43, '留言板', 39, '/suggest/index', 7, NULL, ''),
	(45, '插件', 44, '/plugins/index', NULL, NULL, ''),
	(47, '主题', 46, '/theme/index', 4, NULL, ''),
	(48, '幻灯片', 46, '/carousel/index', 3, NULL, ''),
	(49, '导航', 46, '/nav/index', 5, NULL, ''),
	(50, '区域', 46, '/area/index', 1, NULL, ''),
	(51, '区块', 46, '/block/index', 2, NULL, ''),
	(52, '群发站内信', 24, '/message/admin/create', 4, NULL, '');
/*!40000 ALTER TABLE {{%menu}} ENABLE KEYS */;
UNLOCK TABLES;
