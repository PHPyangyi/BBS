/*
 Navicat MySQL Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : bbs

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 01/06/2018 08:28:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tg_article
-- ----------------------------
DROP TABLE IF EXISTS `tg_article`;
CREATE TABLE `tg_article`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//id',
  `tg_reid` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//主题ID',
  `tg_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//发帖人',
  `tg_type` tinyint(2) UNSIGNED NOT NULL COMMENT '//发帖类型',
  `tg_title` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//帖子标题',
  `tg_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//帖子内容',
  `tg_readcount` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//阅读量',
  `tg_commendcount` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//评论量',
  `tg_last_modify_date` datetime NOT NULL COMMENT '//最后修改时间',
  `tg_date` datetime NOT NULL COMMENT '//发帖时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 68 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_article
-- ----------------------------
INSERT INTO `tg_article` VALUES (52, 0, 'yang', 1, '测试发帖', '<p>测试发帖。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/><img src=\"http://img.baidu.com/hi/bobo/B_0016.gif\"/><img src=\"/ueditor/php/upload/image/20180528/1527477548964127.jpg\" title=\"1527477548964127.jpg\" alt=\"319481_300.jpg\"/><img src=\"http://img.baidu.com/hi/jx2/j_0026.gif\"/></p>', 8, 0, '2018-05-28 16:34:51', '2018-05-28 11:19:13');
INSERT INTO `tg_article` VALUES (53, 0, 'yang', 1, '测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0003.gif\"/>测试发帖。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/><img src=\"http://img.baidu.com/hi/bobo/B_0016.gif\"/><img src=\"/ueditor/php/upload/image/20180528/1527477548964127.jpg\" title=\"1527477548964127.jpg\" alt=\"319481_300.jpg\"/></p>', 135, 0, '2018-05-28 16:35:33', '2018-05-28 11:20:20');
INSERT INTO `tg_article` VALUES (56, 53, 'yangyi', 1, 'RE:测试发帖11', '<p>回复测试。。。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/jx2/j_0016.gif\"/><img src=\"http://img.baidu.com/hi/jx2/j_0062.gif\"/><img src=\"http://img.baidu.com/hi/youa/y_0016.gif\"/><img src=\"http://img.baidu.com/hi/youa/y_0038.gif\"/><img src=\"/ueditor/php/upload/image/20180528/1527490407140537.jpg\" title=\"1527490407140537.jpg\" alt=\"319409_300.jpg\"/></p>', 1, 0, '0000-00-00 00:00:00', '2018-05-28 14:55:12');
INSERT INTO `tg_article` VALUES (57, 53, 'admin', 1, 'RE:测试发帖11', '<p>继续测试。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/youa/y_0038.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 14:56:36');
INSERT INTO `tg_article` VALUES (58, 53, 'yang', 1, 'RE:测试发帖11', '<p>继续测试。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/youa/y_0038.gif\"/><img src=\"http://img.baidu.com/hi/jx2/j_0027.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 14:57:20');
INSERT INTO `tg_article` VALUES (59, 53, 'yang', 1, 'RE:测试发帖11', '<p>继续测试。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/youa/y_0038.gif\"/><img src=\"http://img.baidu.com/hi/jx2/j_0027.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 14:57:43');
INSERT INTO `tg_article` VALUES (60, 53, 'yang', 1, 'RE:测试发帖11', '<p>钱钱钱钱钱钱钱钱钱<br/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 14:58:01');
INSERT INTO `tg_article` VALUES (61, 53, 'yang', 1, 'RE:测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0024.gif\"/><img src=\"http://img.baidu.com/hi/jx2/j_0039.gif\"/>测试。。。。。。。。。。。。。。。。。。</p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 14:58:46');
INSERT INTO `tg_article` VALUES (62, 53, 'yang', 1, 'RE:测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/>测试中。。。。。。。。。。。。。</p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:00:14');
INSERT INTO `tg_article` VALUES (63, 53, 'yang', 1, 'RE:测试发帖11', '<p>应该ok了。。。。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/jx2/j_0035.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:01:07');
INSERT INTO `tg_article` VALUES (64, 53, 'yang', 1, 'RE:测试发帖11', '<p>还要测试。。。。。。。。。。。。。。。。<img src=\"http://img.baidu.com/hi/jx2/j_0024.gif\"/><img src=\"/ueditor/php/upload/image/20180528/1527490908886239.jpg\" title=\"1527490908886239.jpg\" alt=\"319794_300.jpg\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:01:51');
INSERT INTO `tg_article` VALUES (65, 53, 'yang', 1, 'RE:测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:04:18');
INSERT INTO `tg_article` VALUES (66, 53, 'yang', 1, 'RE:测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:05:15');
INSERT INTO `tg_article` VALUES (67, 53, 'yang', 1, 'RE:测试发帖11', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0025.gif\"/></p>', 0, 0, '0000-00-00 00:00:00', '2018-05-28 15:09:39');

-- ----------------------------
-- Table structure for tg_dir
-- ----------------------------
DROP TABLE IF EXISTS `tg_dir`;
CREATE TABLE `tg_dir`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//相册目录名',
  `tg_type` tinyint(1) UNSIGNED NOT NULL COMMENT '//相册的类型',
  `tg_password` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//相册的密码',
  `tg_content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//相册的描述',
  `tg_face` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//相册目录封面',
  `tg_dir` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//相册的物理地址',
  `tg_date` datetime NOT NULL COMMENT '//相册创建的时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_dir
-- ----------------------------
INSERT INTO `tg_dir` VALUES (9, 'test_photo', 0, NULL, '测试相册添加', NULL, 'photo/1527727938', '2018-05-31 08:52:18');
INSERT INTO `tg_dir` VALUES (10, 'test_photo_yang', 1, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '测试加密的相册public', 'photo/1527728006/1527732677.jpg', 'photo/1527728006', '2018-05-31 08:53:26');

-- ----------------------------
-- Table structure for tg_flower
-- ----------------------------
DROP TABLE IF EXISTS `tg_flower`;
CREATE TABLE `tg_flower`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//收花者',
  `tg_fromuser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//送花着',
  `tg_flower` mediumint(8) UNSIGNED NOT NULL COMMENT '//花朵个数',
  `tg_content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//感言',
  `tg_date` datetime NOT NULL COMMENT '//时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_flower
-- ----------------------------
INSERT INTO `tg_flower` VALUES (3, 'yang', '炎日', 14, '灰常欣赏你，送你花啦~~~', '2018-05-27 21:04:14');
INSERT INTO `tg_flower` VALUES (4, 'yang', 'yangyi', 8, '灰常欣赏你，送你花啦~~~', '2018-05-27 22:07:51');

-- ----------------------------
-- Table structure for tg_friend
-- ----------------------------
DROP TABLE IF EXISTS `tg_friend`;
CREATE TABLE `tg_friend`  (
  `tg_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//被添加的好友',
  `tg_fromuser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//添加的人',
  `tg_content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//请求内容',
  `tg_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '//验证',
  `tg_date` datetime NOT NULL COMMENT '//添加时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_friend
-- ----------------------------
INSERT INTO `tg_friend` VALUES (1, 'yang', 'admin', '我非常想和你交朋友！真的非常想！', 1, '2018-05-27 19:58:41');
INSERT INTO `tg_friend` VALUES (3, 'yang', 'yangyi', '我非常想和你交朋友！', 0, '2018-05-27 11:29:10');
INSERT INTO `tg_friend` VALUES (7, '妮可罗宾', 'yang', '我非常想和你交朋友！', 0, '2018-05-27 20:28:18');

-- ----------------------------
-- Table structure for tg_message
-- ----------------------------
DROP TABLE IF EXISTS `tg_message`;
CREATE TABLE `tg_message`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//收信人',
  `tg_fromuser` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//发信人',
  `tg_content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//发信内容',
  `tg_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '//短信状态',
  `tg_date` datetime NOT NULL COMMENT '//发送时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_message
-- ----------------------------
INSERT INTO `tg_message` VALUES (21, 'admin', 'yang', '测试发送。。。。。。。。。。。。。。。', 0, '2018-05-27 15:16:39');
INSERT INTO `tg_message` VALUES (22, 'yang', 'admin', '测试发送。。。。', 0, '2018-05-27 15:18:30');
INSERT INTO `tg_message` VALUES (23, 'yang', 'yangyi', 'yangyi测试发送。。。。', 0, '2018-05-26 15:19:09');
INSERT INTO `tg_message` VALUES (24, 'yang', '娜美', '娜美测试方式。。。。。', 0, '2018-05-26 15:19:41');
INSERT INTO `tg_message` VALUES (25, 'yang', '妮可罗宾', '妮可罗宾测试发送。。。。。', 1, '2018-05-27 15:20:13');
INSERT INTO `tg_message` VALUES (36, '', '', '', 0, '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for tg_photo
-- ----------------------------
DROP TABLE IF EXISTS `tg_photo`;
CREATE TABLE `tg_photo`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//图片名',
  `tg_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//图片路径',
  `tg_content` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//图片简介',
  `tg_sid` mediumint(8) UNSIGNED NOT NULL COMMENT '//图片所在的目录',
  `tg_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//上传者',
  `tg_readcount` smallint(5) NOT NULL DEFAULT 0 COMMENT '//浏览量',
  `tg_commendcount` smallint(5) NOT NULL DEFAULT 0 COMMENT '//评论量',
  `tg_date` datetime NOT NULL,
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_photo
-- ----------------------------
INSERT INTO `tg_photo` VALUES (34, 'test_images', 'photo/1527728006/1527732677.jpg', '测试', 10, 'yang', 78, 5, '2018-05-31 10:11:53');
INSERT INTO `tg_photo` VALUES (35, '111111111111', 'photo/1527728006/1527735063.jpg', '11111111111', 10, 'yang', 16, 0, '2018-05-31 10:51:09');
INSERT INTO `tg_photo` VALUES (36, '测试02号', 'photo/1527727938/1527758163.jpg', '测试02号', 9, 'yang', 1, 0, '2018-05-31 17:16:09');

-- ----------------------------
-- Table structure for tg_photo_commend
-- ----------------------------
DROP TABLE IF EXISTS `tg_photo_commend`;
CREATE TABLE `tg_photo_commend`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//评论标题',
  `tg_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//评论内容',
  `tg_sid` mediumint(8) UNSIGNED NOT NULL COMMENT '//图片的ID',
  `tg_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//评论者',
  `tg_date` datetime NOT NULL COMMENT '//评论时间',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_photo_commend
-- ----------------------------
INSERT INTO `tg_photo_commend` VALUES (10, '', '<p>test photo....................<br/></p>', 34, 'yang', '2018-05-31 15:49:20');
INSERT INTO `tg_photo_commend` VALUES (11, '', '<p>1111111111111111111111111<br/></p>', 34, 'yang', '2018-05-31 15:51:05');
INSERT INTO `tg_photo_commend` VALUES (12, '', '<p>222222222222222222222<br/></p>', 34, 'yang', '2018-05-31 16:08:08');

-- ----------------------------
-- Table structure for tg_system
-- ----------------------------
DROP TABLE IF EXISTS `tg_system`;
CREATE TABLE `tg_system`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_webname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//网站名称',
  `tg_article` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//文章分页数',
  `tg_blog` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//博友分页数',
  `tg_photo` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//相册分页数',
  `tg_skin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//网站皮肤',
  `tg_string` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//网站敏感字符串',
  `tg_post` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//发帖限制',
  `tg_re` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//回帖限制',
  `tg_code` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//是否启用验证码',
  `tg_register` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//是否开放会员',
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_system
-- ----------------------------
INSERT INTO `tg_system` VALUES (1, 'YangWeb俱乐部(YangWeb.C', 10, 15, 12, 1, '他妈的|NND|草|操|垃圾|淫荡|贱货|SB|sb|jb|JB|法轮功|小泉', 60, 15, 1, 1);

-- ----------------------------
-- Table structure for tg_user
-- ----------------------------
DROP TABLE IF EXISTS `tg_user`;
CREATE TABLE `tg_user`  (
  `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '//用户自动编号',
  `tg_uniqid` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//验证身份的唯一标识符',
  `tg_active` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//激活登录用户',
  `tg_username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//用户名',
  `tg_password` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//密码',
  `tg_question` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//密码提示',
  `tg_answer` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//密码回答',
  `tg_email` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//邮件',
  `tg_qq` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//QQ',
  `tg_url` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '//网址',
  `tg_sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//性别',
  `tg_face` char(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//头像',
  `tg_level` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '//会员等级',
  `tg_reg_time` datetime NOT NULL COMMENT '//注册时间',
  `tg_last_time` datetime NOT NULL COMMENT '//最后登录的时间',
  `tg_last_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '//最后登录的IP',
  `tg_login_count` smallint(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000 COMMENT '//登录次数',
  `tg_switch` tinyint(1) UNSIGNED NOT NULL,
  `tg_autograph` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`tg_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tg_user
-- ----------------------------
INSERT INTO `tg_user` VALUES (43, 'a9f7954aa85653df480a9b2bb7520ccf7ec87d8e', '', 'yang', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '123', '2121', '1151832036@qq.com', '1151832036', 'http://www.baidu.com', '男', 'face/m13.gif', 1, '2018-05-26 18:44:47', '2018-05-31 18:36:29', '127.0.0.1', 0028, 1, '测试个性签名........');
INSERT INTO `tg_user` VALUES (42, '7904a20f1dfed22c7a97b8b957cf975219065dd5', '', 'yangyi', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '123', '321', '1151832035@qq.com', '1151832035', 'http://www.baidu.com', '男', 'face/m02.gif', 1, '2018-05-26 18:30:46', '2018-05-27 09:31:45', '127.0.0.1', 0012, 0, NULL);
INSERT INTO `tg_user` VALUES (44, 'b589021b35920dacaa4a5bd2e546c0ae40ed8c18', '', 'admin', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '123', '12121', '1151832035@qq.com', '1151832035', 'http://www.baidu.com', '男', 'face/m06.gif', 1, '0000-00-00 00:00:00', '2018-05-31 18:46:26', '::1', 0003, 0, NULL);
INSERT INTO `tg_user` VALUES (5, '9bf40be3f04307790fc2e63996363dd40f446edd', '', '炎日', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我家的狗狗', '4d5cf6a96cf8a438e3ae210bf7b2dac02b6fa1a4', 'yc60.com@gmail.com', '24234234', 'http://www.yc60.com', '男', 'face/m07.gif', 1, '2010-08-18 22:26:31', '2010-09-15 20:54:05', '127.0.0.1', 0032, 0, NULL);
INSERT INTO `tg_user` VALUES (6, 'fce4b3004724c08ba283f1af4bc382b009bb3829', 'fe33b6f30b30ddf90c14c8747f010b169a3d5155', '蜡笔小新', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的是', '34bb28945fd223b49e67f9b4bf6d2c12cb73f8f9', 'labixiaoxin@163.com', '234234234', 'http://www.yc60.com', '男', 'face/m29.gif', 0, '2010-08-18 22:30:30', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (9, '6528afa27002db3281185c926d273db15e5b70b0', 'bbcc5d47ec78538240e10538299d386230fea512', '樱桃小丸子', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我有个姐姐', '0693b23e03efc840446c716dad880193c1cebe93', 'yintao@sina.com.cn', '23478234', 'http://www.yc60.com', '女', 'face/m34.gif', 0, '2010-08-19 08:58:41', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (10, 'a0a9003ebd0a20d72ae92b131fe984c0149dd667', 'f9203a499bdbe661cde5ef18634b953c57812f74', '奥特曼', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是奥特曼', '2694e30d5dca7d243b831aeea8cf03e0511e2fce', 'aoteman@sina.com.cn', '12323423', 'http://www.aoteman.com', '女', 'face/m25.gif', 0, '2010-08-21 15:17:48', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (11, '1acc0c777cd4c9490843c168a15bd89a9076b321', '642d05bcedef0bc318b108457e8abc41176310b4', '奥特', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是奥特曼', '2694e30d5dca7d243b831aeea8cf03e0511e2fce', 'bnbbs@163.com', '234234234', 'http://www.aoteman.com', '女', 'face/m43.gif', 0, '2010-08-21 18:48:12', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (12, '9666e60c620264b53522f84fed6dc48bf5574e14', 'a9db682808415330181bf77a50e0803711993469', '小丸子', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是小丸子', 'bb18a82d08e1391ff3c575c48a1712c4e980bf39', 'xiaowanzi@sina.com.cn', '234234234', 'http://www.sina.com.cn', '女', 'face/m30.gif', 0, '2010-08-21 19:11:05', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (13, '4c629f3a5e62c5bfa7bf16d3f9a00bd330eff235', '283d8f1649facf7b8b0f5b9b42e4478e72b378b4', '好人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是好人', '320b5da92489bdb993e7108e35954b5102b7171e', 'haoren@sina.com.cn', '2342342', 'http://www.sina.com.cn', '女', 'face/m40.gif', 0, '2010-08-21 19:20:57', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (14, '2638e2d7255e32edb5481b53e47bd4a86ad655af', '', '坏人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是坏人', '67415ef1e4bda2dd233ac3e9d38c607256bf1ff1', 'huairen@163.com', '423432423', 'http://www.163.com', '男', 'face/m47.gif', 0, '2010-08-21 19:22:31', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (15, '641eabc04bb6bd32d90d05c0bab2fc2c6d741c41', '', '好人和坏人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是好人和坏人', '76c27d4fc01e7f9cbf31fb2c2ced77942c9f6cf6', 'haohuai@sina.com.cn', '23423423', 'http://www.sina.com.cn', '男', 'face/m22.gif', 0, '2010-08-21 19:40:02', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (16, 'a678b77efb52a387c5dbb05d7c14008dc2987eba', '', '孙悟空', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟空', 'deaed6c927227f47387781299458118e9cdec5b3', 'sunwukong@sina.com.cn', '23423489', 'http://www.sunwukong.com', '男', 'face/m02.gif', 1, '2010-08-24 10:57:02', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (17, '231bff478710803c3126327fd96d6d3158120d17', '', '孙悟饭', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟饭', 'aaa589902087dcad6ab2a6af5643c0fc69e4484c', 'sunwufan@sina.com.cn', '23489734', 'http://www.sunwufan.com', '男', 'face/m03.gif', 0, '2010-08-24 10:58:01', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (18, 'b5a4d74d5dc01372083c173c869bf60e729ffbf2', '', '孙悟天', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟天', 'deaed6c927227f47387781299458118e9cdec5b3', 'sunwutian@sina.com.cn', '23423984', 'http://www.sunwutian.com', '男', 'face/m04.gif', 0, '2010-08-24 10:59:34', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (19, '8b4bb3130c8d390013434a704bdaa3be2d614676', '', '克林', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是克林', 'deaed6c927227f47387781299458118e9cdec5b3', 'kelin@sina.com.cn', '234234283', 'http://www.kelin.com.cn', '男', 'face/m05.gif', 0, '2010-08-24 11:02:51', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (20, '60bff63cf3e484ec0a8b4daa46dec6baebff989b', '', '龟仙人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是龟仙人', 'deaed6c927227f47387781299458118e9cdec5b3', 'guixianren@sina.com.cn', '234234999', 'http://www.guixianren.com', '男', 'face/m06.gif', 0, '2010-08-24 11:06:32', '2010-09-12 10:10:31', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (21, 'f31e4adcb6fa592bf718ca73de485ed266220d70', '', '贝吉塔', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是贝吉塔', 'deaed6c927227f47387781299458118e9cdec5b3', 'beijita@sina.com.cn', '23423498', 'http://www.beijita.com', '男', 'face/m07.gif', 0, '2010-08-24 11:07:52', '2010-09-12 10:10:05', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (22, 'a15429e7a5c61d1225d2618b993b1c386565cbd8', '', '天津饭', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是天津饭', 'deaed6c927227f47387781299458118e9cdec5b3', 'tianjf@sina.com.cn', '234234989', 'http://www.tianfjf.com', '男', 'face/m08.gif', 0, '2010-08-24 11:08:39', '2010-09-12 10:09:29', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (23, 'df72455b70f2908ecbdb7fd9ce7947063193fdbd', '', '乐平', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是乐平', 'deaed6c927227f47387781299458118e9cdec5b3', 'leping@sina.com.cn', '234234980', 'http://www.leping.com', '男', 'face/m09.gif', 0, '2010-08-24 11:09:13', '2010-09-12 10:08:58', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (24, '590d5606bfb9a9f5ce755f0059bba31cfa78e927', '', '短笛', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是短笛', 'deaed6c927227f47387781299458118e9cdec5b3', 'duandi@sina.com.cn', '2349854534', 'http://www.duandi.com', '男', 'face/m10.gif', 0, '2010-08-24 11:10:02', '2010-09-14 11:29:43', '127.0.0.1', 0003, 0, NULL);
INSERT INTO `tg_user` VALUES (25, 'c75fd7135784a2bd2fe5937e3787445c3e3a6c79', '', '星矢', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是星矢', '2d668504f97a0f9d1798298b84288980c7b388ea', 'xinshi@sina.com.cn', '234234900', 'http://www.xinshi.com', '男', 'face/m12.gif', 0, '2010-08-24 11:13:33', '2010-09-14 11:30:05', '127.0.0.1', 0003, 0, NULL);
INSERT INTO `tg_user` VALUES (26, '4075ba67f8a2d056f51479b019bf1969e3280189', '', '紫龙', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是紫龙', 'deaed6c927227f47387781299458118e9cdec5b3', 'zilong@sina.com.cn', '23423498', 'http://www.zilong.com.cn', '男', 'face/m13.gif', 0, '2010-08-24 11:17:51', '2010-09-12 10:02:52', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (27, '03135e0fddcfb1b3303a82e9d7aa77aaae1ed20b', '', '一辉', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是一辉', 'deaed6c927227f47387781299458118e9cdec5b3', 'yihui@sina.com.cn', '234234234', 'http://www.yihui.com', '男', 'face/m15.gif', 0, '2010-08-24 11:26:56', '2010-09-06 18:22:57', '127.0.0.1', 0001, 0, NULL);
INSERT INTO `tg_user` VALUES (31, '73c003e0d282f3221884ede5106724d5400131c4', '', '佐助', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是佐助', 'deaed6c927227f47387781299458118e9cdec5b3', 'zuozhu@sina.com.cn', '23489234', 'http://www.zuozhu.com', '男', 'face/m20.gif', 0, '2010-08-24 11:36:06', '2010-09-12 09:55:36', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (32, '98b7bd390dd629f53d53f81f389fc3ff2ba8a7ff', '', '小樱', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是小樱', 'deaed6c927227f47387781299458118e9cdec5b3', 'xiaoying@sima.com.cn', '23427834', 'http://www.xiaoying.com', '女', 'face/m21.gif', 0, '2010-08-24 11:36:43', '2010-09-12 09:55:00', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (33, '1adc7152087dec00eb0ccb290ddc6dc83de0c358', '', '路飞', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是路飞', 'deaed6c927227f47387781299458118e9cdec5b3', 'lufei@sina.com.cn', '2343247', 'http://www.lufei.com', '男', 'face/m22.gif', 0, '2010-08-24 11:38:14', '2010-09-12 09:54:30', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (34, '8e3d876dd74a586a6d7dc8d9cb3c598ab6802f83', '', '娜美', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是娜美', 'deaed6c927227f47387781299458118e9cdec5b3', 'namei@sina.com.cn', '23423489', 'http://www.namei.com.cn', '女', 'face/m24.gif', 0, '2010-08-24 11:40:27', '2010-09-15 21:04:37', '127.0.0.1', 0003, 0, NULL);
INSERT INTO `tg_user` VALUES (35, '3d38a55cd8e81cb529c1a0cdfe0e5e9a68ec4053', '', '索罗', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是索罗', 'aaa589902087dcad6ab2a6af5643c0fc69e4484c', 'suoluo@sina.com.cn', '234234234', 'http://www.suoluo.com', '男', 'face/m25.gif', 0, '2010-08-24 11:54:44', '2010-09-14 20:30:14', '127.0.0.1', 0003, 0, NULL);
INSERT INTO `tg_user` VALUES (36, 'e26f7eef584adb0c92ae7c865f82590085c9b2ed', '', '香吉士', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是香吉士', '2d668504f97a0f9d1798298b84288980c7b388ea', 'xiangjishi@sina.com.cn', '2134234324', 'http://www.xiangjishi.com', '男', 'face/m26.gif', 0, '2010-08-24 11:55:36', '2010-09-12 09:51:44', '127.0.0.1', 0002, 0, NULL);
INSERT INTO `tg_user` VALUES (37, '0e048e76e12785ea317d31da9e3dab9a85b05fbf', '', '妮可罗宾', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是妮可罗宾', 'aaa589902087dcad6ab2a6af5643c0fc69e4484c', 'nikeluobing@sina.com.cn', '123123123', 'http://www.nike.com', '男', 'face/m44.gif', 0, '2010-08-24 14:15:28', '2010-09-12 09:50:48', '127.0.0.1', 0002, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
