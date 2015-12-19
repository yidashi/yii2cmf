/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : 127.0.0.1:3306
Source Database       : yii

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-12-02 18:22:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pop_article
-- ----------------------------
DROP TABLE IF EXISTS `pop_article`;
CREATE TABLE `pop_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `category` varchar(50) NOT NULL COMMENT '分类',
  `category_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL COMMENT '作者',
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2875 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for pop_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_assignment`;
CREATE TABLE `pop_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `pop_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_assignment
-- ----------------------------
INSERT INTO `pop_auth_assignment` VALUES ('author', '2', '1443080982');
INSERT INTO `pop_auth_assignment` VALUES ('superAdmin', '1', '1443080982');

-- ----------------------------
-- Table structure for pop_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_item`;
CREATE TABLE `pop_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `pop_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `pop_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- ----------------------------
-- Table structure for pop_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_item_child`;
CREATE TABLE `pop_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `pop_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pop_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_item_child
-- ----------------------------
INSERT INTO `pop_auth_item_child` VALUES ('superAdmin', '/*');

-- ----------------------------
-- Table structure for pop_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `pop_auth_rule`;
CREATE TABLE `pop_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for pop_category
-- ----------------------------
DROP TABLE IF EXISTS `pop_category`;
CREATE TABLE `pop_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '名字',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_category
-- ----------------------------
INSERT INTO `pop_category` VALUES ('1', '励志', '0', '1449050838', '1449050838');
INSERT INTO `pop_category` VALUES ('2', '美文', '0', '1449050838', '1449050838');
INSERT INTO `pop_category` VALUES ('3', '健康', '0', '1449050838', '1449050838');

-- ----------------------------
-- Table structure for pop_gather
-- ----------------------------
DROP TABLE IF EXISTS `pop_gather`;
CREATE TABLE `pop_gather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_org` varchar(255) NOT NULL,
  `res` tinyint(1) NOT NULL DEFAULT '1',
  `result` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5805 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for pop_menu
-- ----------------------------
DROP TABLE IF EXISTS `pop_menu`;
CREATE TABLE `pop_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `pop_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pop_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_menu
-- ----------------------------
INSERT INTO `pop_menu` VALUES ('1', '系统管理', null, null, '1', null);
INSERT INTO `pop_menu` VALUES ('2', '菜单管理', '1', '/admin/menu/index', null, null);
INSERT INTO `pop_menu` VALUES ('15', '用户管理', '1', '/admin/assignment/index', null, null);
INSERT INTO `pop_menu` VALUES ('16', '路由管理', '1', '/admin/route/index', null, null);
INSERT INTO `pop_menu` VALUES ('17', '角色管理', '1', '/admin/role/index', null, null);
INSERT INTO `pop_menu` VALUES ('20', '控制面板', null, '/site/index', '1', null);

-- ----------------------------
-- Table structure for pop_nav
-- ----------------------------
DROP TABLE IF EXISTS `pop_nav`;
CREATE TABLE `pop_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '名称',
  `route` varchar(255) NOT NULL COMMENT '路由',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_nav
-- ----------------------------
INSERT INTO `pop_nav` VALUES ('1', '励志', 'article/1');
INSERT INTO `pop_nav` VALUES ('2', '美文', 'article/2');

-- ----------------------------
-- Table structure for pop_spider
-- ----------------------------
DROP TABLE IF EXISTS `pop_spider`;
CREATE TABLE `pop_spider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标识',
  `title` varchar(100) NOT NULL COMMENT '名称',
  `domain` varchar(255) NOT NULL COMMENT '域名',
  `page_dom` varchar(255) NOT NULL COMMENT '分页链接元素',
  `list_dom` varchar(255) NOT NULL COMMENT '列表链接元素',
  `time_dom` varchar(255) DEFAULT NULL COMMENT '内容页时间元素',
  `content_dom` varchar(255) NOT NULL COMMENT '内容页内容元素',
  `title_dom` varchar(255) NOT NULL COMMENT '内容页标题元素',
  `target_category` varchar(255) NOT NULL COMMENT '目标分类',
  `target_category_url` varchar(255) NOT NULL COMMENT '目标分类地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pop_spider
-- ----------------------------
INSERT INTO `pop_spider` VALUES ('1', 'chncomic', '中国国际动漫网', 'http://www.chncomic.com/', '.page_div ul li a', '.info_list h1 a', '.time span', '.article_con', '.w_640 h1.article_title', '影视', 'http://www.chncomic.com/info/yingshi/');
INSERT INTO `pop_spider` VALUES ('2', 'neihan', '内涵段子', 'http://neihanshequ.com/', '', '.share_url', null, '.content-wrapper .upload-txt', '.name-time-wrapper .name', '段子', 'http://neihanshequ.com/');
INSERT INTO `pop_spider` VALUES ('3', 'tiejiong', '微信热文', 'http://www.tiejiong.com', '.page li a', '.mainnews li .testimg a', '.listltitle .spanimg3', '.wzbody', '.listltitle center h3', '励志,美文,健康,野史,段子', 'http://www.tiejiong.com/lizhi/,http://www.tiejiong.com/meiwen/,http://www.tiejiong.com/jiankang/,http://www.tiejiong.com/lishi/,http://www.tiejiong.com/duanzi/');

-- ----------------------------
-- Table structure for pop_user
-- ----------------------------
DROP TABLE IF EXISTS `pop_user`;
CREATE TABLE `pop_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pop_user
-- ----------------------------
INSERT INTO `pop_user` VALUES ('1', 'hehe', '1lQl4TG6sYlyWRqXZEWL0ZhQkPATVnMs', '$2y$13$8n0PJFk7ZDea4YdMYho2XeFHbrBWADKM9NYdmnm8R0qBov969sTY.', null, 'liujuntaor@qq.com', '10', '1441766741', '1446535118');
