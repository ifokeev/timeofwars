/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost
 Source Database       : tow

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : utf-8

 Date: 06/13/2014 06:15:39 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `timeofwars_2battle`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_2battle`;
CREATE TABLE `timeofwars_2battle` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `team1` text NOT NULL,
  `team2` text NOT NULL,
  `start_time` int(10) NOT NULL,
  `step` smallint(4) unsigned NOT NULL DEFAULT '1',
  `status` set('completed','wait','during') NOT NULL DEFAULT 'during',
  `win_team` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_2battle_action`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_2battle_action`;
CREATE TABLE `timeofwars_2battle_action` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `battle_id` mediumint(8) unsigned NOT NULL,
  `Username` char(20) NOT NULL,
  `Enemy` char(20) NOT NULL,
  `hited` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_dead` enum('0','1') NOT NULL DEFAULT '0',
  `team` enum('2','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `battle_id` (`battle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_2battle_kicks`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_2battle_kicks`;
CREATE TABLE `timeofwars_2battle_kicks` (
  `user_id` smallint(5) unsigned NOT NULL,
  `target_id` smallint(5) unsigned NOT NULL,
  `battle_id` mediumint(8) unsigned NOT NULL,
  `kick1` tinyint(1) unsigned NOT NULL,
  `kick2` tinyint(1) unsigned NOT NULL,
  `block1` tinyint(1) NOT NULL,
  `block2` tinyint(1) NOT NULL,
  `hit_time` int(10) NOT NULL,
  `step` smallint(4) unsigned NOT NULL DEFAULT '1',
  KEY `battle_id` (`battle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_access_keepers`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_access_keepers`;
CREATE TABLE `timeofwars_access_keepers` (
  `Username` char(30) NOT NULL DEFAULT '',
  `access` set('brak_OnOff','battle_off','status','addrow_ld','look_LD','addclan','blok_off','blok','chaos_off','chaos','molch_off','molch') NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_access_keepers`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_access_keepers` VALUES ('Admin', 'brak_OnOff,battle_off,status,addrow_ld,look_LD,addclan,blok_off,blok,chaos_off,chaos,molch_off,molch');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_admin_referal`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_admin_referal`;
CREATE TABLE `timeofwars_admin_referal` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `from_userid` mediumint(8) NOT NULL,
  `referal_id` mediumint(8) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_admin_referal_log`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_admin_referal_log`;
CREATE TABLE `timeofwars_admin_referal_log` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `add_time` int(11) NOT NULL,
  `refer_id` mediumint(8) NOT NULL,
  `referal_id` mediumint(8) NOT NULL,
  `money` double(5,2) NOT NULL,
  `value` set('bad','good') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_as_notes`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_as_notes`;
CREATE TABLE `timeofwars_as_notes` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Status` varchar(10) DEFAULT NULL,
  `link` varchar(80) NOT NULL,
  `Text` varchar(100) NOT NULL DEFAULT '',
  `hranitel` varchar(30) NOT NULL DEFAULT '',
  `Time` varchar(20) NOT NULL DEFAULT '',
  `On_time` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_bank_acc`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_bank_acc`;
CREATE TABLE `timeofwars_bank_acc` (
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Euro` double(20,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_bank_acc`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_bank_acc` VALUES ('Admin', '9999.00');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_banned`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_banned`;
CREATE TABLE `timeofwars_banned` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `Ip` varchar(30) NOT NULL DEFAULT '',
  `Time` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_battle_abils`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_battle_abils`;
CREATE TABLE `timeofwars_battle_abils` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `OwnerType` enum('clan','name') NOT NULL DEFAULT 'clan',
  `Owner` varchar(20) NOT NULL DEFAULT '',
  `AbilsType` enum('critplus','crit2','uvplus','damageplus','damagemnog','vamp','otrag') NOT NULL DEFAULT 'critplus',
  `AbilsCount` float NOT NULL DEFAULT '0',
  `AbilsPresent` smallint(6) NOT NULL DEFAULT '0',
  `AbilsStr` varchar(100) NOT NULL DEFAULT '',
  `Type` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_battle_action`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_battle_action`;
CREATE TABLE `timeofwars_battle_action` (
  `Player` char(20) NOT NULL DEFAULT '',
  `Action` char(20) DEFAULT NULL,
  `Enemy` char(20) DEFAULT NULL,
  `What` char(20) DEFAULT NULL,
  `Time` char(20) DEFAULT NULL,
  `Id` bigint(20) NOT NULL DEFAULT '0',
  KEY `id_ind` (`Id`),
  KEY `pla_ind` (`Player`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_battle_exp`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_battle_exp`;
CREATE TABLE `timeofwars_battle_exp` (
  `id_battle_exp` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `levelMin` int(11) DEFAULT NULL,
  `levelMax` int(11) DEFAULT NULL,
  `percents` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_battle_exp`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_battle_exp`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_battle_exp` VALUES ('1', '-1', '1', '50'), ('2', '2', '2', '55'), ('3', '3', '3', '60'), ('4', '-2', '-2', '40'), ('5', '-3', '-3', '35'), ('6', '-4', '-4', '30'), ('7', '-7', '-5', '25'), ('8', '-255', '-8', '20'), ('9', '4', '255', '65');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_battle_id`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_battle_id`;
CREATE TABLE `timeofwars_battle_id` (
  `Id` bigint(20) NOT NULL DEFAULT '0',
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_battle_id`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_battle_id` VALUES ('5554');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_battle_list`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_battle_list`;
CREATE TABLE `timeofwars_battle_list` (
  `Player` char(20) NOT NULL DEFAULT '',
  `Team` tinyint(4) DEFAULT NULL,
  `Damage` bigint(20) DEFAULT NULL,
  `Dead` enum('0','1') NOT NULL DEFAULT '0',
  `Id` bigint(20) NOT NULL DEFAULT '0',
  `is_finished` enum('0','1') NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_ind` (`Id`),
  KEY `pla_ind` (`Player`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_blocked`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_blocked`;
CREATE TABLE `timeofwars_blocked` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Why` text NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '',
  `Time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_casino`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_casino`;
CREATE TABLE `timeofwars_casino` (
  `Username` char(30) NOT NULL,
  `Price` double(15,2) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_castles`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_castles`;
CREATE TABLE `timeofwars_castles` (
  `zamok` char(30) NOT NULL DEFAULT 'zamok_1',
  `own_locations` char(30) NOT NULL DEFAULT '0;0;0;0',
  `title` char(50) NOT NULL,
  `coords` char(20) NOT NULL DEFAULT '0;0',
  `balance` double(11,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`zamok`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_castles`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_castles` VALUES ('zamok_255', '0;1;1;1', 'Темная обитель', '300;150', '76898');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_castles_logs`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_castles_logs`;
CREATE TABLE `timeofwars_castles_logs` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `zamok` char(30) NOT NULL DEFAULT 'zamok_1',
  `Username` char(20) NOT NULL,
  `howmuch` double(11,0) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_chaos`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_chaos`;
CREATE TABLE `timeofwars_chaos` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Comment` varchar(255) NOT NULL DEFAULT '',
  `FreeTime` int(11) unsigned NOT NULL DEFAULT '0',
  `wasclan` int(8) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_clan`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan`;
CREATE TABLE `timeofwars_clan` (
  `id_clan` int(8) NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL DEFAULT '',
  `title` varchar(64) NOT NULL DEFAULT '',
  `type` enum('ASTRAL','CLAN') NOT NULL DEFAULT 'CLAN',
  `join_price` int(8) NOT NULL DEFAULT '0',
  `left_price` int(8) NOT NULL DEFAULT '0',
  `slogan` text NOT NULL,
  `advert` text NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '',
  `kazna` double(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_clan`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_clan`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_clan` VALUES ('50', 'Дилер', 'Дилеры', 'ASTRAL', '20', '0', 'продажа ресурсов игры', 'дилеры мира', '', '0.00'), ('99', 'ЛамоБот', 'Официальные боты игры', 'ASTRAL', '20', '0', '', '', '', '0.00'), ('255', 'Admin', 'Администрация', 'ASTRAL', '20', '0', 'фывфывфыв,фывфы', 'ыфвыфв', 'http://timeofwars.ru', '450.00'), ('1', '', 'Хранители Небес', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('53', '', 'Хранители Поднебесья', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('2', '', 'Хранители Огня', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('3', '', 'Хранители Земли', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('4', '', 'Хранители Ветра', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('55', '', 'Ученики Хранителей', 'ASTRAL', '20', '5', '', '', '', '0.00'), ('19', '', 'Журналисты', 'CLAN', '20', '5', '', '', '', '0.00');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_clan_demands`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_demands`;
CREATE TABLE `timeofwars_clan_demands` (
  `Username` varchar(255) NOT NULL DEFAULT '',
  `id_clan` int(8) NOT NULL DEFAULT '0',
  `text` char(50) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_clan_demands_m`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_demands_m`;
CREATE TABLE `timeofwars_clan_demands_m` (
  `Username` char(20) NOT NULL,
  `id_clan` mediumint(4) NOT NULL,
  `addtime` char(20) NOT NULL,
  `howmuch` mediumint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_clan_goout`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_goout`;
CREATE TABLE `timeofwars_clan_goout` (
  `Username` char(20) NOT NULL,
  `addtime` char(20) NOT NULL,
  `id_clan` smallint(4) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_clan_history`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_history`;
CREATE TABLE `timeofwars_clan_history` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `id_clan` tinyint(3) unsigned NOT NULL,
  `time` char(20) NOT NULL,
  `type` set('kazna','relations','weapons','members') NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_clan_ranks`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_ranks`;
CREATE TABLE `timeofwars_clan_ranks` (
  `id_rank` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_clan` int(8) unsigned NOT NULL DEFAULT '0',
  `rank_name` varchar(20) NOT NULL DEFAULT '',
  `perms` set('setup','members','rank','align','weapon','kazna','request') NOT NULL DEFAULT '',
  `icon` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_rank`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_clan_ranks`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_clan_ranks` VALUES ('1', '255', 'test', 'kazna,request', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_clan_relations`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_relations`;
CREATE TABLE `timeofwars_clan_relations` (
  `id_clan_from` int(8) unsigned NOT NULL DEFAULT '0',
  `id_clan_to` int(8) unsigned NOT NULL DEFAULT '0',
  `relation_type` enum('WAR','PEACE','ALLIANCE','NEUTRAL') NOT NULL DEFAULT 'NEUTRAL',
  `reason` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_clan_from`,`id_clan_to`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_clan_relations`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_clan_relations` VALUES ('255', '50', 'NEUTRAL', ''), ('255', '99', 'NEUTRAL', ''), ('99', '255', 'WAR', ''), ('255', '2', 'PEACE', ''), ('255', '3', 'ALLIANCE', '');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_clan_user`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_user`;
CREATE TABLE `timeofwars_clan_user` (
  `id_clan` int(8) unsigned NOT NULL DEFAULT '0',
  `Username` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `id_rank` smallint(4) unsigned NOT NULL DEFAULT '0',
  `tax` enum('0','10','20','30','40','50') NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_clan_user`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_clan_user` VALUES ('255', 'Admin', '1', '1', '30'), ('99', 'Ламобот', '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_clan_weapon_demands`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_weapon_demands`;
CREATE TABLE `timeofwars_clan_weapon_demands` (
  `id_item` int(10) unsigned NOT NULL DEFAULT '0',
  `Username` char(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `addTime` int(11) unsigned NOT NULL DEFAULT '0',
  `status` set('ACCEPT','REJECT') CHARACTER SET cp1251 COLLATE cp1251_bin DEFAULT NULL,
  PRIMARY KEY (`id_item`,`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_clan_weapon_items`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_clan_weapon_items`;
CREATE TABLE `timeofwars_clan_weapon_items` (
  `id_item` int(10) unsigned NOT NULL DEFAULT '0',
  `id_clan` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `location` set('STORE','INUSE') CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT 'STORE',
  `cost` double(5,2) NOT NULL DEFAULT '1.00',
  `Owner` char(20) NOT NULL,
  `timeINuse` char(20) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_comission`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_comission`;
CREATE TABLE `timeofwars_comission` (
  `Owner` char(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `Un_Id` bigint(20) unsigned DEFAULT NULL,
  `Id` char(16) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Cost` float(8,0) unsigned DEFAULT NULL,
  `Level_need` tinyint(3) unsigned DEFAULT NULL,
  `Stre_need` smallint(5) unsigned DEFAULT NULL,
  `Agil_need` smallint(5) unsigned DEFAULT NULL,
  `Intu_need` smallint(5) unsigned DEFAULT NULL,
  `Endu_need` smallint(5) unsigned DEFAULT NULL,
  `Clan_need` tinyint(3) unsigned DEFAULT NULL,
  `Level_add` smallint(6) DEFAULT NULL,
  `Stre_add` smallint(6) DEFAULT NULL,
  `Agil_add` smallint(6) DEFAULT NULL,
  `Intu_add` smallint(6) DEFAULT NULL,
  `Endu_add` smallint(6) DEFAULT NULL,
  `MINdamage` smallint(5) unsigned DEFAULT NULL,
  `MAXdamage` smallint(5) unsigned DEFAULT NULL,
  `Crit` smallint(6) DEFAULT NULL,
  `AntiCrit` smallint(6) DEFAULT NULL,
  `Uv` smallint(6) DEFAULT NULL,
  `AntiUv` smallint(6) DEFAULT NULL,
  `Armor1` smallint(6) DEFAULT NULL,
  `Armor2` smallint(6) DEFAULT NULL,
  `Armor3` smallint(6) DEFAULT NULL,
  `Armor4` smallint(6) DEFAULT NULL,
  `MagicID` char(16) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT NULL,
  `MAXwear` char(6) DEFAULT NULL,
  `Wear_ON` enum('0','1') NOT NULL DEFAULT '0',
  `Srab` int(11) NOT NULL DEFAULT '0',
  `Shop_Price` float(8,0) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_damage_strength`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_damage_strength`;
CREATE TABLE `timeofwars_damage_strength` (
  `Stringth` int(11) NOT NULL DEFAULT '0',
  `MINdamage` int(11) NOT NULL DEFAULT '0',
  `MAXdamage` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_damage_strength`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_damage_strength` VALUES ('1', '1', '2'), ('2', '1', '3'), ('3', '1', '4'), ('4', '2', '4'), ('5', '2', '5'), ('6', '3', '5'), ('7', '3', '6'), ('8', '3', '7'), ('9', '3', '8'), ('10', '4', '8'), ('11', '4', '9'), ('12', '5', '9'), ('13', '6', '9'), ('14', '6', '10'), ('15', '7', '10'), ('16', '8', '10'), ('17', '8', '11'), ('18', '9', '11'), ('19', '10', '11'), ('20', '10', '12'), ('21', '10', '12'), ('22', '11', '12'), ('23', '11', '13'), ('24', '11', '14'), ('25', '11', '15'), ('26', '12', '15'), ('27', '13', '15'), ('28', '14', '16'), ('29', '14', '17'), ('30', '14', '18'), ('31', '14', '19'), ('32', '15', '20'), ('33', '15', '22'), ('34', '16', '24'), ('35', '17', '26'), ('36', '18', '27'), ('37', '18', '28'), ('38', '19', '29'), ('39', '19', '30'), ('40', '20', '30'), ('41', '21', '31'), ('42', '22', '31'), ('43', '22', '32'), ('44', '23', '32'), ('45', '24', '32'), ('46', '24', '33'), ('47', '24', '34'), ('48', '24', '36'), ('49', '24', '37'), ('50', '24', '38'), ('51', '24', '40'), ('52', '25', '41'), ('53', '25', '42'), ('54', '26', '43'), ('55', '26', '44'), ('56', '26', '45'), ('57', '27', '45'), ('58', '28', '45'), ('59', '29', '46'), ('60', '30', '46'), ('61', '31', '47'), ('62', '32', '47'), ('63', '33', '48'), ('64', '34', '48'), ('65', '35', '49'), ('66', '36', '49'), ('67', '37', '50'), ('68', '38', '50'), ('69', '39', '50'), ('70', '40', '50'), ('71', '41', '50'), ('72', '42', '51'), ('73', '43', '52'), ('74', '43', '53'), ('75', '44', '55'), ('76', '45', '55'), ('77', '46', '56'), ('78', '47', '58'), ('79', '48', '60'), ('80', '49', '62'), ('81', '50', '64'), ('82', '51', '66'), ('83', '52', '68'), ('84', '53', '70'), ('85', '54', '72'), ('86', '55', '74'), ('87', '56', '76'), ('88', '57', '78'), ('89', '58', '80'), ('90', '59', '82'), ('91', '60', '84'), ('92', '61', '86'), ('93', '62', '88'), ('94', '63', '90'), ('95', '64', '92'), ('96', '65', '94'), ('97', '66', '96'), ('98', '67', '98'), ('99', '68', '100'), ('100', '69', '100'), ('101', '70', '101'), ('102', '70', '102'), ('103', '71', '103'), ('104', '72', '104'), ('105', '73', '104'), ('106', '73', '105'), ('107', '74', '106'), ('108', '75', '106'), ('109', '75', '107'), ('110', '76', '108'), ('111', '76', '109'), ('112', '77', '109'), ('113', '77', '110'), ('114', '78', '110'), ('115', '79', '111'), ('116', '80', '112'), ('117', '81', '113'), ('118', '82', '114'), ('119', '83', '115'), ('120', '84', '116'), ('121', '85', '117'), ('122', '86', '118'), ('123', '87', '119'), ('124', '88', '120'), ('125', '89', '121'), ('126', '90', '122'), ('127', '91', '123'), ('128', '92', '124'), ('129', '93', '125'), ('130', '94', '126'), ('131', '95', '127'), ('132', '96', '128'), ('133', '97', '129'), ('134', '98', '130'), ('135', '99', '131'), ('136', '100', '132'), ('137', '101', '133'), ('138', '102', '134'), ('139', '103', '135'), ('140', '104', '136'), ('141', '105', '137'), ('142', '106', '138'), ('143', '107', '139'), ('144', '108', '140'), ('145', '109', '141'), ('146', '110', '142'), ('147', '111', '143'), ('148', '112', '144'), ('149', '113', '145'), ('150', '114', '146'), ('151', '115', '147'), ('152', '116', '148'), ('153', '117', '149'), ('154', '118', '150'), ('155', '119', '151'), ('156', '120', '152'), ('157', '121', '153'), ('158', '122', '154'), ('159', '123', '155'), ('160', '124', '156'), ('161', '125', '157'), ('162', '126', '158'), ('163', '127', '159'), ('164', '128', '160'), ('165', '129', '161'), ('166', '130', '162'), ('167', '131', '163'), ('168', '132', '164'), ('169', '133', '165'), ('170', '134', '166'), ('171', '135', '167'), ('172', '136', '168'), ('173', '137', '169'), ('174', '138', '170'), ('175', '139', '171'), ('176', '140', '172'), ('177', '141', '173'), ('178', '142', '174'), ('179', '143', '175'), ('180', '144', '176'), ('181', '145', '177'), ('182', '146', '178'), ('183', '147', '179'), ('184', '148', '180'), ('185', '149', '181'), ('186', '150', '182'), ('187', '151', '183'), ('188', '152', '184'), ('189', '153', '185'), ('190', '154', '186'), ('191', '155', '187'), ('192', '156', '188'), ('193', '157', '189'), ('194', '158', '190'), ('195', '159', '191'), ('196', '160', '192'), ('197', '161', '193'), ('198', '162', '194'), ('199', '163', '195'), ('200', '164', '196'), ('201', '165', '197'), ('202', '166', '198'), ('203', '167', '199'), ('204', '168', '200'), ('205', '169', '201'), ('206', '170', '202'), ('207', '171', '203'), ('208', '172', '204'), ('209', '173', '205'), ('210', '174', '206'), ('211', '175', '207'), ('212', '176', '208'), ('213', '177', '209'), ('214', '178', '210'), ('215', '179', '211'), ('216', '180', '212'), ('217', '181', '213'), ('218', '182', '214'), ('219', '183', '215'), ('220', '184', '216'), ('221', '185', '217'), ('222', '186', '218'), ('223', '187', '219'), ('224', '188', '220'), ('225', '189', '221'), ('226', '190', '222'), ('227', '191', '223'), ('228', '192', '224'), ('229', '193', '225'), ('230', '194', '226'), ('231', '195', '227'), ('232', '196', '228'), ('233', '197', '229'), ('234', '198', '230'), ('235', '199', '231'), ('236', '200', '232'), ('237', '201', '233'), ('238', '202', '234'), ('239', '203', '235'), ('240', '204', '236'), ('241', '205', '237'), ('242', '206', '238'), ('243', '207', '239'), ('244', '208', '240'), ('245', '209', '241'), ('246', '210', '242'), ('247', '211', '243'), ('248', '212', '244'), ('249', '213', '245'), ('250', '214', '246'), ('251', '215', '247'), ('252', '216', '248'), ('253', '217', '249'), ('254', '218', '250'), ('255', '219', '251'), ('256', '220', '252'), ('257', '221', '253'), ('258', '222', '254'), ('259', '223', '255'), ('260', '224', '256'), ('261', '225', '257'), ('262', '226', '258'), ('263', '227', '259'), ('264', '228', '260'), ('265', '229', '261'), ('266', '230', '262'), ('267', '231', '263'), ('268', '232', '264'), ('269', '233', '265'), ('270', '234', '266'), ('271', '235', '267'), ('272', '236', '268'), ('273', '237', '269'), ('274', '238', '270'), ('275', '239', '271'), ('276', '240', '272'), ('277', '241', '273'), ('278', '242', '274'), ('279', '243', '275'), ('280', '244', '276'), ('281', '245', '277'), ('282', '246', '278'), ('283', '247', '279'), ('284', '248', '280'), ('285', '249', '281'), ('286', '250', '282'), ('287', '251', '283'), ('288', '252', '284'), ('289', '253', '285'), ('290', '254', '286'), ('291', '255', '287'), ('292', '256', '288'), ('293', '257', '289'), ('294', '258', '290'), ('295', '259', '291'), ('296', '260', '292'), ('297', '261', '293'), ('298', '262', '294'), ('299', '263', '295'), ('300', '264', '296'), ('301', '265', '297'), ('302', '266', '298'), ('303', '267', '299'), ('304', '268', '300'), ('305', '269', '301'), ('306', '270', '302'), ('307', '271', '303'), ('308', '272', '304'), ('309', '273', '305'), ('310', '274', '306'), ('311', '275', '307'), ('312', '276', '308'), ('313', '277', '309'), ('314', '278', '310'), ('315', '279', '311'), ('316', '280', '312'), ('317', '281', '313'), ('318', '282', '314'), ('319', '283', '315'), ('320', '284', '316'), ('321', '285', '317'), ('322', '286', '318'), ('323', '287', '319'), ('324', '288', '320'), ('325', '289', '321'), ('326', '290', '322'), ('327', '291', '323'), ('328', '292', '324'), ('329', '293', '325'), ('330', '294', '326'), ('331', '295', '327'), ('332', '296', '328'), ('333', '297', '329'), ('334', '298', '330'), ('335', '299', '331'), ('336', '300', '332'), ('337', '301', '333'), ('338', '302', '334'), ('339', '303', '335'), ('340', '304', '336'), ('341', '305', '337'), ('342', '306', '338'), ('343', '307', '339'), ('344', '308', '340'), ('345', '309', '341'), ('346', '310', '342'), ('347', '311', '343'), ('348', '312', '344'), ('349', '313', '345'), ('350', '314', '346'), ('351', '315', '347'), ('352', '316', '348'), ('353', '317', '349'), ('354', '318', '350'), ('355', '319', '351'), ('356', '320', '352'), ('357', '321', '353'), ('358', '322', '354'), ('359', '323', '355'), ('360', '324', '356'), ('361', '325', '357'), ('362', '326', '358'), ('363', '327', '359'), ('364', '328', '360'), ('365', '329', '361'), ('366', '330', '362'), ('367', '331', '363'), ('368', '332', '364'), ('369', '333', '365'), ('370', '334', '366'), ('371', '335', '367'), ('372', '336', '368'), ('373', '337', '369'), ('374', '338', '370'), ('375', '339', '371'), ('376', '340', '372'), ('377', '341', '373'), ('378', '342', '374'), ('379', '343', '375'), ('380', '344', '376'), ('381', '345', '377'), ('382', '346', '378'), ('383', '347', '379'), ('384', '348', '380'), ('385', '349', '381'), ('386', '350', '382'), ('387', '351', '383'), ('388', '352', '384'), ('389', '353', '385'), ('390', '354', '386'), ('391', '355', '387'), ('392', '356', '388'), ('393', '357', '389'), ('394', '358', '390'), ('395', '359', '391'), ('396', '360', '392'), ('397', '361', '393'), ('398', '362', '394'), ('399', '363', '395'), ('400', '364', '396'), ('401', '365', '397'), ('402', '366', '398'), ('403', '367', '399'), ('404', '368', '400'), ('405', '369', '401'), ('406', '370', '402'), ('407', '371', '403'), ('408', '372', '404'), ('409', '373', '405'), ('410', '374', '406'), ('411', '375', '407'), ('412', '376', '408'), ('413', '377', '409'), ('414', '378', '410'), ('415', '379', '411'), ('416', '380', '412'), ('417', '381', '413'), ('418', '382', '414'), ('419', '383', '415'), ('420', '384', '416'), ('421', '385', '417'), ('422', '386', '418'), ('423', '387', '419'), ('424', '388', '420'), ('425', '389', '421'), ('426', '390', '422'), ('427', '391', '423'), ('428', '392', '424'), ('429', '393', '425'), ('430', '394', '426'), ('431', '395', '427'), ('432', '396', '428'), ('433', '397', '429'), ('434', '398', '430'), ('435', '399', '431'), ('436', '400', '432'), ('437', '401', '433'), ('438', '402', '434'), ('439', '403', '435'), ('440', '404', '436'), ('441', '405', '437'), ('442', '406', '438'), ('443', '407', '439'), ('444', '408', '440'), ('445', '409', '441'), ('446', '410', '442'), ('447', '411', '443'), ('448', '412', '444'), ('449', '413', '445'), ('450', '414', '446'), ('451', '415', '447'), ('452', '416', '448'), ('453', '417', '449'), ('454', '418', '450'), ('455', '419', '451'), ('456', '420', '452'), ('457', '421', '453'), ('458', '422', '454'), ('459', '423', '455'), ('460', '424', '456'), ('461', '425', '457'), ('462', '426', '458'), ('463', '427', '459'), ('464', '428', '460'), ('465', '429', '461'), ('466', '430', '462'), ('467', '431', '463'), ('468', '432', '464'), ('469', '433', '465'), ('470', '434', '466'), ('471', '435', '467'), ('472', '436', '468'), ('473', '437', '469'), ('474', '438', '470'), ('475', '439', '471'), ('476', '440', '472'), ('477', '441', '473'), ('478', '442', '474'), ('479', '443', '475'), ('480', '444', '476'), ('481', '445', '477'), ('482', '446', '478'), ('483', '447', '479'), ('484', '448', '480'), ('485', '449', '481'), ('486', '450', '482'), ('487', '451', '483'), ('488', '452', '484'), ('489', '453', '485'), ('490', '454', '486'), ('491', '455', '487'), ('492', '456', '488'), ('493', '457', '489'), ('494', '458', '490'), ('495', '459', '491'), ('496', '460', '492'), ('497', '461', '493'), ('498', '462', '494'), ('499', '463', '495'), ('500', '464', '496'), ('5000', '4964', '4996'), ('4999', '4963', '4995'), ('4998', '4962', '4994'), ('4997', '4961', '4993'), ('4996', '4960', '4992'), ('4995', '4959', '4991'), ('4994', '4958', '4990'), ('4993', '4957', '4989'), ('4992', '4956', '4988'), ('4991', '4955', '4987'), ('4990', '4954', '4986'), ('4989', '4953', '4985'), ('4988', '4952', '4984'), ('4987', '4951', '4983'), ('4986', '4950', '4982'), ('4985', '4949', '4981'), ('4984', '4948', '4980'), ('4983', '4947', '4979'), ('4982', '4946', '4978'), ('4981', '4945', '4977'), ('4980', '4944', '4976'), ('4979', '4943', '4975'), ('4978', '4942', '4974'), ('4977', '4941', '4973'), ('4976', '4940', '4972'), ('4975', '4939', '4971'), ('4974', '4938', '4970'), ('4973', '4937', '4969'), ('4972', '4936', '4968'), ('4971', '4935', '4967'), ('4970', '4934', '4966'), ('4969', '4933', '4965'), ('4968', '4932', '4964'), ('4967', '4931', '4963'), ('4966', '4930', '4962'), ('4965', '4929', '4961'), ('4964', '4928', '4960'), ('4963', '4927', '4959'), ('4962', '4926', '4958'), ('4961', '4925', '4957'), ('4960', '4924', '4956'), ('4959', '4923', '4955'), ('4958', '4922', '4954'), ('4957', '4921', '4953'), ('4956', '4920', '4952'), ('4955', '4919', '4951'), ('4954', '4918', '4950'), ('4953', '4917', '4949'), ('4952', '4916', '4948'), ('4951', '4915', '4947'), ('4950', '4914', '4946'), ('4949', '4913', '4945'), ('4948', '4912', '4944'), ('4947', '4911', '4943'), ('4946', '4910', '4942'), ('4945', '4909', '4941'), ('4944', '4908', '4940'), ('4943', '4907', '4939'), ('4942', '4906', '4938'), ('4941', '4905', '4937'), ('4940', '4904', '4936'), ('4939', '4903', '4935'), ('4938', '4902', '4934'), ('4937', '4901', '4933'), ('4936', '4900', '4932'), ('4935', '4899', '4931'), ('4934', '4898', '4930'), ('4933', '4897', '4929'), ('4932', '4896', '4928'), ('4931', '4895', '4927'), ('4930', '4894', '4926'), ('4929', '4893', '4925'), ('4928', '4892', '4924'), ('4927', '4891', '4923'), ('4926', '4890', '4922'), ('4925', '4889', '4921'), ('4924', '4888', '4920'), ('4923', '4887', '4919'), ('4922', '4886', '4918'), ('4921', '4885', '4917'), ('4920', '4884', '4916'), ('4919', '4883', '4915'), ('4918', '4882', '4914'), ('4917', '4881', '4913'), ('4916', '4880', '4912'), ('4915', '4879', '4911'), ('4914', '4878', '4910'), ('4913', '4877', '4909'), ('4912', '4876', '4908'), ('4911', '4875', '4907'), ('4910', '4874', '4906'), ('4909', '4873', '4905'), ('4908', '4872', '4904'), ('4907', '4871', '4903'), ('4906', '4870', '4902'), ('4905', '4869', '4901'), ('4904', '4868', '4900'), ('4903', '4867', '4899'), ('4902', '4866', '4898'), ('4901', '4865', '4897'), ('4900', '4864', '4896'), ('4899', '4863', '4895'), ('4898', '4862', '4894'), ('4897', '4861', '4893'), ('4896', '4860', '4892'), ('4895', '4859', '4891'), ('4894', '4858', '4890'), ('4893', '4857', '4889'), ('4892', '4856', '4888'), ('4891', '4855', '4887'), ('4890', '4854', '4886'), ('4889', '4853', '4885'), ('4888', '4852', '4884'), ('4887', '4851', '4883'), ('4886', '4850', '4882'), ('4885', '4849', '4881'), ('4884', '4848', '4880'), ('4883', '4847', '4879'), ('4882', '4846', '4878'), ('4881', '4845', '4877'), ('4880', '4844', '4876'), ('4879', '4843', '4875'), ('4878', '4842', '4874'), ('4877', '4841', '4873'), ('4876', '4840', '4872'), ('4875', '4839', '4871'), ('4874', '4838', '4870'), ('4873', '4837', '4869'), ('4872', '4836', '4868'), ('4871', '4835', '4867'), ('4870', '4834', '4866'), ('4869', '4833', '4865'), ('4868', '4832', '4864'), ('4867', '4831', '4863'), ('4866', '4830', '4862'), ('4865', '4829', '4861'), ('4864', '4828', '4860'), ('4863', '4827', '4859'), ('4862', '4826', '4858'), ('4861', '4825', '4857'), ('4860', '4824', '4856'), ('4859', '4823', '4855'), ('4858', '4822', '4854'), ('4857', '4821', '4853'), ('4856', '4820', '4852'), ('4855', '4819', '4851'), ('4854', '4818', '4850'), ('4853', '4817', '4849'), ('4852', '4816', '4848'), ('4851', '4815', '4847'), ('4850', '4814', '4846'), ('4849', '4813', '4845'), ('4848', '4812', '4844'), ('4847', '4811', '4843'), ('4846', '4810', '4842'), ('4845', '4809', '4841'), ('4844', '4808', '4840'), ('4843', '4807', '4839'), ('4842', '4806', '4838'), ('4841', '4805', '4837'), ('4840', '4804', '4836'), ('4839', '4803', '4835'), ('4838', '4802', '4834'), ('4837', '4801', '4833'), ('4836', '4800', '4832'), ('4835', '4799', '4831'), ('4834', '4798', '4830'), ('4833', '4797', '4829'), ('4832', '4796', '4828'), ('4831', '4795', '4827'), ('4830', '4794', '4826'), ('4829', '4793', '4825'), ('4828', '4792', '4824'), ('4827', '4791', '4823'), ('4826', '4790', '4822'), ('4825', '4789', '4821'), ('4824', '4788', '4820'), ('4823', '4787', '4819'), ('4822', '4786', '4818'), ('4821', '4785', '4817'), ('4820', '4784', '4816'), ('4819', '4783', '4815'), ('4818', '4782', '4814'), ('4817', '4781', '4813'), ('4816', '4780', '4812'), ('4815', '4779', '4811'), ('4814', '4778', '4810'), ('4813', '4777', '4809'), ('4812', '4776', '4808'), ('4811', '4775', '4807'), ('4810', '4774', '4806'), ('4809', '4773', '4805'), ('4808', '4772', '4804'), ('4807', '4771', '4803'), ('4806', '4770', '4802'), ('4805', '4769', '4801'), ('4804', '4768', '4800'), ('4803', '4767', '4799'), ('4802', '4766', '4798'), ('4801', '4765', '4797'), ('4800', '4764', '4796'), ('4799', '4763', '4795'), ('4798', '4762', '4794'), ('4797', '4761', '4793'), ('4796', '4760', '4792'), ('4795', '4759', '4791'), ('4794', '4758', '4790'), ('4793', '4757', '4789'), ('4792', '4756', '4788'), ('4791', '4755', '4787'), ('4790', '4754', '4786'), ('4789', '4753', '4785'), ('4788', '4752', '4784'), ('4787', '4751', '4783'), ('4786', '4750', '4782'), ('4785', '4749', '4781'), ('4784', '4748', '4780'), ('4783', '4747', '4779'), ('4782', '4746', '4778'), ('4781', '4745', '4777'), ('4780', '4744', '4776'), ('4779', '4743', '4775'), ('4778', '4742', '4774'), ('4777', '4741', '4773'), ('4776', '4740', '4772'), ('4775', '4739', '4771'), ('4774', '4738', '4770'), ('4773', '4737', '4769'), ('4772', '4736', '4768'), ('4771', '4735', '4767'), ('4770', '4734', '4766'), ('4769', '4733', '4765'), ('4768', '4732', '4764'), ('4767', '4731', '4763'), ('4766', '4730', '4762'), ('4765', '4729', '4761'), ('4764', '4728', '4760'), ('4763', '4727', '4759'), ('4762', '4726', '4758'), ('4761', '4725', '4757'), ('4760', '4724', '4756'), ('4759', '4723', '4755'), ('4758', '4722', '4754'), ('4757', '4721', '4753'), ('4756', '4720', '4752'), ('4755', '4719', '4751'), ('4754', '4718', '4750'), ('4753', '4717', '4749'), ('4752', '4716', '4748'), ('4751', '4715', '4747'), ('4750', '4714', '4746'), ('4749', '4713', '4745'), ('4748', '4712', '4744'), ('4747', '4711', '4743'), ('4746', '4710', '4742'), ('4745', '4709', '4741'), ('4744', '4708', '4740'), ('4743', '4707', '4739'), ('4742', '4706', '4738'), ('4741', '4705', '4737'), ('4740', '4704', '4736'), ('4739', '4703', '4735'), ('4738', '4702', '4734'), ('4737', '4701', '4733'), ('4736', '4700', '4732'), ('4735', '4699', '4731'), ('4734', '4698', '4730'), ('4733', '4697', '4729'), ('4732', '4696', '4728'), ('4731', '4695', '4727'), ('4730', '4694', '4726'), ('4729', '4693', '4725'), ('4728', '4692', '4724'), ('4727', '4691', '4723'), ('4726', '4690', '4722'), ('4725', '4689', '4721'), ('4724', '4688', '4720'), ('4723', '4687', '4719'), ('4722', '4686', '4718'), ('4721', '4685', '4717'), ('4720', '4684', '4716'), ('4719', '4683', '4715'), ('4718', '4682', '4714'), ('4717', '4681', '4713'), ('4716', '4680', '4712'), ('4715', '4679', '4711'), ('4714', '4678', '4710'), ('4713', '4677', '4709'), ('4712', '4676', '4708'), ('4711', '4675', '4707'), ('4710', '4674', '4706'), ('4709', '4673', '4705'), ('4708', '4672', '4704'), ('4707', '4671', '4703'), ('4706', '4670', '4702'), ('4705', '4669', '4701'), ('4704', '4668', '4700'), ('4703', '4667', '4699'), ('4702', '4666', '4698'), ('4701', '4665', '4697'), ('4700', '4664', '4696'), ('4699', '4663', '4695'), ('4698', '4662', '4694'), ('4697', '4661', '4693'), ('4696', '4660', '4692'), ('4695', '4659', '4691'), ('4694', '4658', '4690'), ('4693', '4657', '4689'), ('4692', '4656', '4688'), ('4691', '4655', '4687'), ('4690', '4654', '4686'), ('4689', '4653', '4685'), ('4688', '4652', '4684'), ('4687', '4651', '4683'), ('4686', '4650', '4682'), ('4685', '4649', '4681'), ('4684', '4648', '4680'), ('4683', '4647', '4679'), ('4682', '4646', '4678'), ('4681', '4645', '4677'), ('4680', '4644', '4676'), ('4679', '4643', '4675'), ('4678', '4642', '4674'), ('4677', '4641', '4673'), ('4676', '4640', '4672'), ('4675', '4639', '4671'), ('4674', '4638', '4670'), ('4673', '4637', '4669'), ('4672', '4636', '4668'), ('4671', '4635', '4667'), ('4670', '4634', '4666'), ('4669', '4633', '4665'), ('4668', '4632', '4664'), ('4667', '4631', '4663'), ('4666', '4630', '4662'), ('4665', '4629', '4661'), ('4664', '4628', '4660'), ('4663', '4627', '4659'), ('4662', '4626', '4658'), ('4661', '4625', '4657'), ('4660', '4624', '4656'), ('4659', '4623', '4655'), ('4658', '4622', '4654'), ('4657', '4621', '4653'), ('4656', '4620', '4652'), ('4655', '4619', '4651'), ('4654', '4618', '4650'), ('4653', '4617', '4649'), ('4652', '4616', '4648'), ('4651', '4615', '4647'), ('4650', '4614', '4646'), ('4649', '4613', '4645'), ('4648', '4612', '4644'), ('4647', '4611', '4643'), ('4646', '4610', '4642'), ('4645', '4609', '4641'), ('4644', '4608', '4640'), ('4643', '4607', '4639'), ('4642', '4606', '4638'), ('4641', '4605', '4637'), ('4640', '4604', '4636'), ('4639', '4603', '4635'), ('4638', '4602', '4634'), ('4637', '4601', '4633'), ('4636', '4600', '4632'), ('4635', '4599', '4631'), ('4634', '4598', '4630'), ('4633', '4597', '4629'), ('4632', '4596', '4628'), ('4631', '4595', '4627'), ('4630', '4594', '4626'), ('4629', '4593', '4625'), ('4628', '4592', '4624'), ('4627', '4591', '4623'), ('4626', '4590', '4622'), ('4625', '4589', '4621'), ('4624', '4588', '4620'), ('4623', '4587', '4619'), ('4622', '4586', '4618'), ('4621', '4585', '4617'), ('4620', '4584', '4616'), ('4619', '4583', '4615'), ('4618', '4582', '4614'), ('4617', '4581', '4613'), ('4616', '4580', '4612'), ('4615', '4579', '4611'), ('4614', '4578', '4610'), ('4613', '4577', '4609'), ('4612', '4576', '4608'), ('4611', '4575', '4607'), ('4610', '4574', '4606'), ('4609', '4573', '4605'), ('4608', '4572', '4604'), ('4607', '4571', '4603'), ('4606', '4570', '4602'), ('4605', '4569', '4601'), ('4604', '4568', '4600'), ('4603', '4567', '4599'), ('4602', '4566', '4598'), ('4601', '4565', '4597'), ('4600', '4564', '4596'), ('4599', '4563', '4595'), ('4598', '4562', '4594'), ('4597', '4561', '4593'), ('4596', '4560', '4592'), ('4595', '4559', '4591'), ('4594', '4558', '4590'), ('4593', '4557', '4589'), ('4592', '4556', '4588'), ('4591', '4555', '4587'), ('4590', '4554', '4586'), ('4589', '4553', '4585'), ('4588', '4552', '4584'), ('4587', '4551', '4583'), ('4586', '4550', '4582'), ('4585', '4549', '4581'), ('4584', '4548', '4580'), ('4583', '4547', '4579'), ('4582', '4546', '4578'), ('4581', '4545', '4577'), ('4580', '4544', '4576'), ('4579', '4543', '4575'), ('4578', '4542', '4574'), ('4577', '4541', '4573'), ('4576', '4540', '4572'), ('4575', '4539', '4571'), ('4574', '4538', '4570'), ('4573', '4537', '4569'), ('4572', '4536', '4568'), ('4571', '4535', '4567'), ('4570', '4534', '4566'), ('4569', '4533', '4565'), ('4568', '4532', '4564'), ('4567', '4531', '4563'), ('4566', '4530', '4562'), ('4565', '4529', '4561'), ('4564', '4528', '4560'), ('4563', '4527', '4559'), ('4562', '4526', '4558'), ('4561', '4525', '4557'), ('4560', '4524', '4556'), ('4559', '4523', '4555'), ('4558', '4522', '4554'), ('4557', '4521', '4553'), ('4556', '4520', '4552'), ('4555', '4519', '4551'), ('4554', '4518', '4550'), ('4553', '4517', '4549'), ('4552', '4516', '4548'), ('4551', '4515', '4547'), ('4550', '4514', '4546'), ('4549', '4513', '4545'), ('4548', '4512', '4544'), ('4547', '4511', '4543'), ('4546', '4510', '4542'), ('4545', '4509', '4541'), ('4544', '4508', '4540'), ('4543', '4507', '4539'), ('4542', '4506', '4538'), ('4541', '4505', '4537'), ('4540', '4504', '4536'), ('4539', '4503', '4535'), ('4538', '4502', '4534'), ('4537', '4501', '4533'), ('4536', '4500', '4532'), ('4535', '4499', '4531'), ('4534', '4498', '4530'), ('4533', '4497', '4529'), ('4532', '4496', '4528'), ('4531', '4495', '4527'), ('4530', '4494', '4526'), ('4529', '4493', '4525'), ('4528', '4492', '4524'), ('4527', '4491', '4523'), ('4526', '4490', '4522'), ('4525', '4489', '4521'), ('4524', '4488', '4520'), ('4523', '4487', '4519'), ('4522', '4486', '4518'), ('4521', '4485', '4517'), ('4520', '4484', '4516'), ('4519', '4483', '4515'), ('4518', '4482', '4514'), ('4517', '4481', '4513'), ('4516', '4480', '4512'), ('4515', '4479', '4511'), ('4514', '4478', '4510'), ('4513', '4477', '4509'), ('4512', '4476', '4508'), ('4511', '4475', '4507'), ('4510', '4474', '4506'), ('4509', '4473', '4505'), ('4508', '4472', '4504'), ('4507', '4471', '4503'), ('4506', '4470', '4502'), ('4505', '4469', '4501'), ('4504', '4468', '4500'), ('4503', '4467', '4499'), ('4502', '4466', '4498'), ('4501', '4465', '4497'), ('4500', '4464', '4496'), ('4499', '4463', '4495'), ('4498', '4462', '4494'), ('4497', '4461', '4493'), ('4496', '4460', '4492'), ('4495', '4459', '4491'), ('4494', '4458', '4490'), ('4493', '4457', '4489'), ('4492', '4456', '4488'), ('4491', '4455', '4487'), ('4490', '4454', '4486'), ('4489', '4453', '4485'), ('4488', '4452', '4484'), ('4487', '4451', '4483'), ('4486', '4450', '4482'), ('4485', '4449', '4481'), ('4484', '4448', '4480'), ('4483', '4447', '4479'), ('4482', '4446', '4478'), ('4481', '4445', '4477'), ('4480', '4444', '4476'), ('4479', '4443', '4475'), ('4478', '4442', '4474'), ('4477', '4441', '4473'), ('4476', '4440', '4472'), ('4475', '4439', '4471'), ('4474', '4438', '4470'), ('4473', '4437', '4469'), ('4472', '4436', '4468'), ('4471', '4435', '4467'), ('4470', '4434', '4466'), ('4469', '4433', '4465'), ('4468', '4432', '4464'), ('4467', '4431', '4463'), ('4466', '4430', '4462'), ('4465', '4429', '4461'), ('4464', '4428', '4460'), ('4463', '4427', '4459'), ('4462', '4426', '4458'), ('4461', '4425', '4457'), ('4460', '4424', '4456'), ('4459', '4423', '4455'), ('4458', '4422', '4454'), ('4457', '4421', '4453'), ('4456', '4420', '4452'), ('4455', '4419', '4451'), ('4454', '4418', '4450'), ('4453', '4417', '4449'), ('4452', '4416', '4448'), ('4451', '4415', '4447'), ('4450', '4414', '4446'), ('4449', '4413', '4445'), ('4448', '4412', '4444'), ('4447', '4411', '4443'), ('4446', '4410', '4442'), ('4445', '4409', '4441'), ('4444', '4408', '4440'), ('4443', '4407', '4439'), ('4442', '4406', '4438'), ('4441', '4405', '4437'), ('4440', '4404', '4436'), ('4439', '4403', '4435'), ('4438', '4402', '4434'), ('4437', '4401', '4433'), ('4436', '4400', '4432'), ('4435', '4399', '4431'), ('4434', '4398', '4430'), ('4433', '4397', '4429'), ('4432', '4396', '4428'), ('4431', '4395', '4427'), ('4430', '4394', '4426'), ('4429', '4393', '4425'), ('4428', '4392', '4424'), ('4427', '4391', '4423'), ('4426', '4390', '4422'), ('4425', '4389', '4421'), ('4424', '4388', '4420'), ('4423', '4387', '4419'), ('4422', '4386', '4418'), ('4421', '4385', '4417'), ('4420', '4384', '4416'), ('4419', '4383', '4415'), ('4418', '4382', '4414'), ('4417', '4381', '4413'), ('4416', '4380', '4412'), ('4415', '4379', '4411'), ('4414', '4378', '4410'), ('4413', '4377', '4409'), ('4412', '4376', '4408'), ('4411', '4375', '4407'), ('4410', '4374', '4406'), ('4409', '4373', '4405'), ('4408', '4372', '4404'), ('4407', '4371', '4403'), ('4406', '4370', '4402'), ('4405', '4369', '4401'), ('4404', '4368', '4400'), ('4403', '4367', '4399'), ('4402', '4366', '4398'), ('4401', '4365', '4397'), ('4400', '4364', '4396'), ('4399', '4363', '4395'), ('4398', '4362', '4394'), ('4397', '4361', '4393'), ('4396', '4360', '4392'), ('4395', '4359', '4391'), ('4394', '4358', '4390'), ('4393', '4357', '4389'), ('4392', '4356', '4388'), ('4391', '4355', '4387'), ('4390', '4354', '4386'), ('4389', '4353', '4385'), ('4388', '4352', '4384'), ('4387', '4351', '4383'), ('4386', '4350', '4382'), ('4385', '4349', '4381'), ('4384', '4348', '4380'), ('4383', '4347', '4379'), ('4382', '4346', '4378'), ('4381', '4345', '4377'), ('4380', '4344', '4376'), ('4379', '4343', '4375'), ('4378', '4342', '4374'), ('4377', '4341', '4373'), ('4376', '4340', '4372'), ('4375', '4339', '4371'), ('4374', '4338', '4370'), ('4373', '4337', '4369'), ('4372', '4336', '4368'), ('4371', '4335', '4367'), ('4370', '4334', '4366'), ('4369', '4333', '4365'), ('4368', '4332', '4364'), ('4367', '4331', '4363'), ('4366', '4330', '4362'), ('4365', '4329', '4361'), ('4364', '4328', '4360'), ('4363', '4327', '4359'), ('4362', '4326', '4358'), ('4361', '4325', '4357'), ('4360', '4324', '4356'), ('4359', '4323', '4355'), ('4358', '4322', '4354'), ('4357', '4321', '4353'), ('4356', '4320', '4352'), ('4355', '4319', '4351'), ('4354', '4318', '4350'), ('4353', '4317', '4349'), ('4352', '4316', '4348'), ('4351', '4315', '4347'), ('4350', '4314', '4346'), ('4349', '4313', '4345'), ('4348', '4312', '4344'), ('4347', '4311', '4343'), ('4346', '4310', '4342'), ('4345', '4309', '4341'), ('4344', '4308', '4340'), ('4343', '4307', '4339'), ('4342', '4306', '4338'), ('4341', '4305', '4337'), ('4340', '4304', '4336'), ('4339', '4303', '4335'), ('4338', '4302', '4334'), ('4337', '4301', '4333'), ('4336', '4300', '4332'), ('4335', '4299', '4331'), ('4334', '4298', '4330'), ('4333', '4297', '4329'), ('4332', '4296', '4328'), ('4331', '4295', '4327'), ('4330', '4294', '4326'), ('4329', '4293', '4325'), ('4328', '4292', '4324'), ('4327', '4291', '4323'), ('4326', '4290', '4322'), ('4325', '4289', '4321'), ('4324', '4288', '4320'), ('4323', '4287', '4319'), ('4322', '4286', '4318'), ('4321', '4285', '4317'), ('4320', '4284', '4316'), ('4319', '4283', '4315'), ('4318', '4282', '4314'), ('4317', '4281', '4313'), ('4316', '4280', '4312'), ('4315', '4279', '4311'), ('4314', '4278', '4310'), ('4313', '4277', '4309'), ('4312', '4276', '4308'), ('4311', '4275', '4307'), ('4310', '4274', '4306'), ('4309', '4273', '4305'), ('4308', '4272', '4304'), ('4307', '4271', '4303'), ('4306', '4270', '4302'), ('4305', '4269', '4301'), ('4304', '4268', '4300'), ('4303', '4267', '4299'), ('4302', '4266', '4298'), ('4301', '4265', '4297'), ('4300', '4264', '4296'), ('4299', '4263', '4295'), ('4298', '4262', '4294'), ('4297', '4261', '4293'), ('4296', '4260', '4292'), ('4295', '4259', '4291'), ('4294', '4258', '4290'), ('4293', '4257', '4289'), ('4292', '4256', '4288'), ('4291', '4255', '4287'), ('4290', '4254', '4286'), ('4289', '4253', '4285'), ('4288', '4252', '4284'), ('4287', '4251', '4283'), ('4286', '4250', '4282'), ('4285', '4249', '4281'), ('4284', '4248', '4280'), ('4283', '4247', '4279'), ('4282', '4246', '4278'), ('4281', '4245', '4277'), ('4280', '4244', '4276'), ('4279', '4243', '4275'), ('4278', '4242', '4274'), ('4277', '4241', '4273'), ('4276', '4240', '4272'), ('4275', '4239', '4271'), ('4274', '4238', '4270'), ('4273', '4237', '4269'), ('4272', '4236', '4268'), ('4271', '4235', '4267'), ('4270', '4234', '4266'), ('4269', '4233', '4265'), ('4268', '4232', '4264'), ('4267', '4231', '4263'), ('4266', '4230', '4262'), ('4265', '4229', '4261'), ('4264', '4228', '4260'), ('4263', '4227', '4259'), ('4262', '4226', '4258'), ('4261', '4225', '4257'), ('4260', '4224', '4256'), ('4259', '4223', '4255'), ('4258', '4222', '4254'), ('4257', '4221', '4253'), ('4256', '4220', '4252'), ('4255', '4219', '4251'), ('4254', '4218', '4250'), ('4253', '4217', '4249'), ('4252', '4216', '4248'), ('4251', '4215', '4247'), ('4250', '4214', '4246'), ('4249', '4213', '4245'), ('4248', '4212', '4244'), ('4247', '4211', '4243'), ('4246', '4210', '4242'), ('4245', '4209', '4241'), ('4244', '4208', '4240'), ('4243', '4207', '4239'), ('4242', '4206', '4238'), ('4241', '4205', '4237'), ('4240', '4204', '4236'), ('4239', '4203', '4235'), ('4238', '4202', '4234'), ('4237', '4201', '4233'), ('4236', '4200', '4232'), ('4235', '4199', '4231'), ('4234', '4198', '4230'), ('4233', '4197', '4229'), ('4232', '4196', '4228'), ('4231', '4195', '4227'), ('4230', '4194', '4226'), ('4229', '4193', '4225'), ('4228', '4192', '4224'), ('4227', '4191', '4223'), ('4226', '4190', '4222'), ('4225', '4189', '4221'), ('4224', '4188', '4220'), ('4223', '4187', '4219'), ('4222', '4186', '4218'), ('4221', '4185', '4217'), ('4220', '4184', '4216'), ('4219', '4183', '4215'), ('4218', '4182', '4214'), ('4217', '4181', '4213'), ('4216', '4180', '4212'), ('4215', '4179', '4211'), ('4214', '4178', '4210'), ('4213', '4177', '4209'), ('4212', '4176', '4208'), ('4211', '4175', '4207'), ('4210', '4174', '4206'), ('4209', '4173', '4205'), ('4208', '4172', '4204'), ('4207', '4171', '4203'), ('4206', '4170', '4202'), ('4205', '4169', '4201'), ('4204', '4168', '4200'), ('4203', '4167', '4199'), ('4202', '4166', '4198'), ('4201', '4165', '4197'), ('4200', '4164', '4196'), ('4199', '4163', '4195'), ('4198', '4162', '4194'), ('4197', '4161', '4193'), ('4196', '4160', '4192'), ('4195', '4159', '4191'), ('4194', '4158', '4190'), ('4193', '4157', '4189'), ('4192', '4156', '4188'), ('4191', '4155', '4187'), ('4190', '4154', '4186'), ('4189', '4153', '4185'), ('4188', '4152', '4184'), ('4187', '4151', '4183'), ('4186', '4150', '4182'), ('4185', '4149', '4181'), ('4184', '4148', '4180'), ('4183', '4147', '4179'), ('4182', '4146', '4178'), ('4181', '4145', '4177'), ('4180', '4144', '4176'), ('4179', '4143', '4175'), ('4178', '4142', '4174'), ('4177', '4141', '4173'), ('4176', '4140', '4172'), ('4175', '4139', '4171'), ('4174', '4138', '4170'), ('4173', '4137', '4169'), ('4172', '4136', '4168'), ('4171', '4135', '4167'), ('4170', '4134', '4166'), ('4169', '4133', '4165'), ('4168', '4132', '4164'), ('4167', '4131', '4163'), ('4166', '4130', '4162'), ('4165', '4129', '4161'), ('4164', '4128', '4160'), ('4163', '4127', '4159'), ('4162', '4126', '4158'), ('4161', '4125', '4157'), ('4160', '4124', '4156'), ('4159', '4123', '4155'), ('4158', '4122', '4154'), ('4157', '4121', '4153'), ('4156', '4120', '4152'), ('4155', '4119', '4151'), ('4154', '4118', '4150'), ('4153', '4117', '4149'), ('4152', '4116', '4148'), ('4151', '4115', '4147'), ('4150', '4114', '4146'), ('4149', '4113', '4145'), ('4148', '4112', '4144'), ('4147', '4111', '4143'), ('4146', '4110', '4142'), ('4145', '4109', '4141'), ('4144', '4108', '4140'), ('4143', '4107', '4139'), ('4142', '4106', '4138'), ('4141', '4105', '4137'), ('4140', '4104', '4136'), ('4139', '4103', '4135'), ('4138', '4102', '4134'), ('4137', '4101', '4133'), ('4136', '4100', '4132'), ('4135', '4099', '4131'), ('4134', '4098', '4130'), ('4133', '4097', '4129'), ('4132', '4096', '4128'), ('4131', '4095', '4127'), ('4130', '4094', '4126'), ('4129', '4093', '4125'), ('4128', '4092', '4124'), ('4127', '4091', '4123'), ('4126', '4090', '4122'), ('4125', '4089', '4121'), ('4124', '4088', '4120'), ('4123', '4087', '4119'), ('4122', '4086', '4118'), ('4121', '4085', '4117'), ('4120', '4084', '4116'), ('4119', '4083', '4115'), ('4118', '4082', '4114'), ('4117', '4081', '4113'), ('4116', '4080', '4112'), ('4115', '4079', '4111'), ('4114', '4078', '4110'), ('4113', '4077', '4109'), ('4112', '4076', '4108'), ('4111', '4075', '4107'), ('4110', '4074', '4106'), ('4109', '4073', '4105'), ('4108', '4072', '4104'), ('4107', '4071', '4103'), ('4106', '4070', '4102'), ('4105', '4069', '4101'), ('4104', '4068', '4100'), ('4103', '4067', '4099'), ('4102', '4066', '4098'), ('4101', '4065', '4097'), ('4100', '4064', '4096'), ('4099', '4063', '4095'), ('4098', '4062', '4094'), ('4097', '4061', '4093'), ('4096', '4060', '4092'), ('4095', '4059', '4091'), ('4094', '4058', '4090'), ('4093', '4057', '4089'), ('4092', '4056', '4088'), ('4091', '4055', '4087'), ('4090', '4054', '4086'), ('4089', '4053', '4085'), ('4088', '4052', '4084'), ('4087', '4051', '4083'), ('4086', '4050', '4082'), ('4085', '4049', '4081'), ('4084', '4048', '4080'), ('4083', '4047', '4079'), ('4082', '4046', '4078'), ('4081', '4045', '4077'), ('4080', '4044', '4076'), ('4079', '4043', '4075'), ('4078', '4042', '4074'), ('4077', '4041', '4073'), ('4076', '4040', '4072'), ('4075', '4039', '4071'), ('4074', '4038', '4070'), ('4073', '4037', '4069'), ('4072', '4036', '4068'), ('4071', '4035', '4067'), ('4070', '4034', '4066'), ('4069', '4033', '4065'), ('4068', '4032', '4064'), ('4067', '4031', '4063'), ('4066', '4030', '4062'), ('4065', '4029', '4061'), ('4064', '4028', '4060'), ('4063', '4027', '4059'), ('4062', '4026', '4058'), ('4061', '4025', '4057'), ('4060', '4024', '4056'), ('4059', '4023', '4055'), ('4058', '4022', '4054'), ('4057', '4021', '4053'), ('4056', '4020', '4052'), ('4055', '4019', '4051'), ('4054', '4018', '4050'), ('4053', '4017', '4049'), ('4052', '4016', '4048'), ('4051', '4015', '4047'), ('4050', '4014', '4046'), ('4049', '4013', '4045'), ('4048', '4012', '4044'), ('4047', '4011', '4043'), ('4046', '4010', '4042'), ('4045', '4009', '4041'), ('4044', '4008', '4040'), ('4043', '4007', '4039'), ('4042', '4006', '4038'), ('4041', '4005', '4037'), ('4040', '4004', '4036'), ('4039', '4003', '4035'), ('4038', '4002', '4034'), ('4037', '4001', '4033'), ('4036', '4000', '4032'), ('4035', '3999', '4031'), ('4034', '3998', '4030'), ('4033', '3997', '4029'), ('4032', '3996', '4028'), ('4031', '3995', '4027'), ('4030', '3994', '4026'), ('4029', '3993', '4025'), ('4028', '3992', '4024'), ('4027', '3991', '4023'), ('4026', '3990', '4022'), ('4025', '3989', '4021'), ('4024', '3988', '4020'), ('4023', '3987', '4019'), ('4022', '3986', '4018'), ('4021', '3985', '4017'), ('4020', '3984', '4016'), ('4019', '3983', '4015'), ('4018', '3982', '4014'), ('4017', '3981', '4013'), ('4016', '3980', '4012'), ('4015', '3979', '4011'), ('4014', '3978', '4010'), ('4013', '3977', '4009'), ('4012', '3976', '4008'), ('4011', '3975', '4007'), ('4010', '3974', '4006'), ('4009', '3973', '4005'), ('4008', '3972', '4004'), ('4007', '3971', '4003'), ('4006', '3970', '4002'), ('4005', '3969', '4001'), ('4004', '3968', '4000'), ('4003', '3967', '3999'), ('4002', '3966', '3998'), ('4001', '3965', '3997'), ('4000', '3964', '3996'), ('3999', '3963', '3995'), ('3998', '3962', '3994'), ('3997', '3961', '3993'), ('3996', '3960', '3992'), ('3995', '3959', '3991'), ('3994', '3958', '3990'), ('3993', '3957', '3989'), ('3992', '3956', '3988'), ('3991', '3955', '3987'), ('3990', '3954', '3986'), ('3989', '3953', '3985'), ('3988', '3952', '3984'), ('3987', '3951', '3983'), ('3986', '3950', '3982'), ('3985', '3949', '3981'), ('3984', '3948', '3980'), ('3983', '3947', '3979'), ('3982', '3946', '3978'), ('3981', '3945', '3977'), ('3980', '3944', '3976'), ('3979', '3943', '3975'), ('3978', '3942', '3974'), ('3977', '3941', '3973'), ('3976', '3940', '3972'), ('3975', '3939', '3971'), ('3974', '3938', '3970'), ('3973', '3937', '3969'), ('3972', '3936', '3968'), ('3971', '3935', '3967'), ('3970', '3934', '3966'), ('3969', '3933', '3965'), ('3968', '3932', '3964'), ('3967', '3931', '3963'), ('3966', '3930', '3962'), ('3965', '3929', '3961'), ('3964', '3928', '3960'), ('3963', '3927', '3959'), ('3962', '3926', '3958'), ('3961', '3925', '3957'), ('3960', '3924', '3956'), ('3959', '3923', '3955'), ('3958', '3922', '3954'), ('3957', '3921', '3953'), ('3956', '3920', '3952'), ('3955', '3919', '3951'), ('3954', '3918', '3950'), ('3953', '3917', '3949'), ('3952', '3916', '3948'), ('3951', '3915', '3947'), ('3950', '3914', '3946'), ('3949', '3913', '3945'), ('3948', '3912', '3944'), ('3947', '3911', '3943'), ('3946', '3910', '3942'), ('3945', '3909', '3941'), ('3944', '3908', '3940'), ('3943', '3907', '3939'), ('3942', '3906', '3938'), ('3941', '3905', '3937'), ('3940', '3904', '3936'), ('3939', '3903', '3935'), ('3938', '3902', '3934'), ('3937', '3901', '3933'), ('3936', '3900', '3932'), ('3935', '3899', '3931'), ('3934', '3898', '3930'), ('3933', '3897', '3929'), ('3932', '3896', '3928'), ('3931', '3895', '3927'), ('3930', '3894', '3926'), ('3929', '3893', '3925'), ('3928', '3892', '3924'), ('3927', '3891', '3923'), ('3926', '3890', '3922'), ('3925', '3889', '3921'), ('3924', '3888', '3920'), ('3923', '3887', '3919'), ('3922', '3886', '3918'), ('3921', '3885', '3917'), ('3920', '3884', '3916'), ('3919', '3883', '3915'), ('3918', '3882', '3914'), ('3917', '3881', '3913'), ('3916', '3880', '3912'), ('3915', '3879', '3911'), ('3914', '3878', '3910'), ('3913', '3877', '3909'), ('3912', '3876', '3908'), ('3911', '3875', '3907'), ('3910', '3874', '3906'), ('3909', '3873', '3905'), ('3908', '3872', '3904'), ('3907', '3871', '3903'), ('3906', '3870', '3902'), ('3905', '3869', '3901'), ('3904', '3868', '3900'), ('3903', '3867', '3899'), ('3902', '3866', '3898'), ('3901', '3865', '3897'), ('3900', '3864', '3896'), ('3899', '3863', '3895'), ('3898', '3862', '3894'), ('3897', '3861', '3893'), ('3896', '3860', '3892'), ('3895', '3859', '3891'), ('3894', '3858', '3890'), ('3893', '3857', '3889'), ('3892', '3856', '3888'), ('3891', '3855', '3887'), ('3890', '3854', '3886'), ('3889', '3853', '3885'), ('3888', '3852', '3884'), ('3887', '3851', '3883'), ('3886', '3850', '3882'), ('3885', '3849', '3881'), ('3884', '3848', '3880'), ('3883', '3847', '3879'), ('3882', '3846', '3878'), ('3881', '3845', '3877'), ('3880', '3844', '3876'), ('3879', '3843', '3875'), ('3878', '3842', '3874'), ('3877', '3841', '3873'), ('3876', '3840', '3872'), ('3875', '3839', '3871'), ('3874', '3838', '3870'), ('3873', '3837', '3869'), ('3872', '3836', '3868'), ('3871', '3835', '3867'), ('3870', '3834', '3866'), ('3869', '3833', '3865'), ('3868', '3832', '3864'), ('3867', '3831', '3863'), ('3866', '3830', '3862'), ('3865', '3829', '3861'), ('3864', '3828', '3860'), ('3863', '3827', '3859'), ('3862', '3826', '3858'), ('3861', '3825', '3857'), ('3860', '3824', '3856'), ('3859', '3823', '3855'), ('3858', '3822', '3854'), ('3857', '3821', '3853'), ('3856', '3820', '3852'), ('3855', '3819', '3851'), ('3854', '3818', '3850'), ('3853', '3817', '3849'), ('3852', '3816', '3848'), ('3851', '3815', '3847'), ('3850', '3814', '3846'), ('3849', '3813', '3845'), ('3848', '3812', '3844'), ('3847', '3811', '3843'), ('3846', '3810', '3842'), ('3845', '3809', '3841'), ('3844', '3808', '3840'), ('3843', '3807', '3839'), ('3842', '3806', '3838'), ('3841', '3805', '3837'), ('3840', '3804', '3836'), ('3839', '3803', '3835'), ('3838', '3802', '3834'), ('3837', '3801', '3833'), ('3836', '3800', '3832'), ('3835', '3799', '3831'), ('3834', '3798', '3830'), ('3833', '3797', '3829'), ('3832', '3796', '3828'), ('3831', '3795', '3827'), ('3830', '3794', '3826'), ('3829', '3793', '3825'), ('3828', '3792', '3824'), ('3827', '3791', '3823'), ('3826', '3790', '3822'), ('3825', '3789', '3821'), ('3824', '3788', '3820'), ('3823', '3787', '3819'), ('3822', '3786', '3818'), ('3821', '3785', '3817'), ('3820', '3784', '3816'), ('3819', '3783', '3815'), ('3818', '3782', '3814'), ('3817', '3781', '3813'), ('3816', '3780', '3812'), ('3815', '3779', '3811'), ('3814', '3778', '3810'), ('3813', '3777', '3809'), ('3812', '3776', '3808'), ('3811', '3775', '3807'), ('3810', '3774', '3806'), ('3809', '3773', '3805'), ('3808', '3772', '3804'), ('3807', '3771', '3803'), ('3806', '3770', '3802'), ('3805', '3769', '3801'), ('3804', '3768', '3800'), ('3803', '3767', '3799'), ('3802', '3766', '3798'), ('3801', '3765', '3797'), ('3800', '3764', '3796'), ('3799', '3763', '3795'), ('3798', '3762', '3794'), ('3797', '3761', '3793'), ('3796', '3760', '3792'), ('3795', '3759', '3791'), ('3794', '3758', '3790'), ('3793', '3757', '3789'), ('3792', '3756', '3788'), ('3791', '3755', '3787'), ('3790', '3754', '3786'), ('3789', '3753', '3785'), ('3788', '3752', '3784'), ('3787', '3751', '3783'), ('3786', '3750', '3782'), ('3785', '3749', '3781'), ('3784', '3748', '3780'), ('3783', '3747', '3779'), ('3782', '3746', '3778'), ('3781', '3745', '3777'), ('3780', '3744', '3776'), ('3779', '3743', '3775'), ('3778', '3742', '3774'), ('3777', '3741', '3773'), ('3776', '3740', '3772'), ('3775', '3739', '3771'), ('3774', '3738', '3770'), ('3773', '3737', '3769'), ('3772', '3736', '3768'), ('3771', '3735', '3767'), ('3770', '3734', '3766'), ('3769', '3733', '3765'), ('3768', '3732', '3764'), ('3767', '3731', '3763'), ('3766', '3730', '3762'), ('3765', '3729', '3761'), ('3764', '3728', '3760'), ('3763', '3727', '3759'), ('3762', '3726', '3758'), ('3761', '3725', '3757'), ('3760', '3724', '3756'), ('3759', '3723', '3755'), ('3758', '3722', '3754'), ('3757', '3721', '3753'), ('3756', '3720', '3752'), ('3755', '3719', '3751'), ('3754', '3718', '3750'), ('3753', '3717', '3749'), ('3752', '3716', '3748'), ('3751', '3715', '3747'), ('3750', '3714', '3746'), ('3749', '3713', '3745'), ('3748', '3712', '3744'), ('3747', '3711', '3743'), ('3746', '3710', '3742'), ('3745', '3709', '3741'), ('3744', '3708', '3740'), ('3743', '3707', '3739'), ('3742', '3706', '3738'), ('3741', '3705', '3737'), ('3740', '3704', '3736'), ('3739', '3703', '3735'), ('3738', '3702', '3734'), ('3737', '3701', '3733'), ('3736', '3700', '3732'), ('3735', '3699', '3731'), ('3734', '3698', '3730'), ('3733', '3697', '3729'), ('3732', '3696', '3728'), ('3731', '3695', '3727'), ('3730', '3694', '3726'), ('3729', '3693', '3725'), ('3728', '3692', '3724'), ('3727', '3691', '3723'), ('3726', '3690', '3722'), ('3725', '3689', '3721'), ('3724', '3688', '3720'), ('3723', '3687', '3719'), ('3722', '3686', '3718'), ('3721', '3685', '3717'), ('3720', '3684', '3716'), ('3719', '3683', '3715'), ('3718', '3682', '3714'), ('3717', '3681', '3713'), ('3716', '3680', '3712'), ('3715', '3679', '3711'), ('3714', '3678', '3710'), ('3713', '3677', '3709'), ('3712', '3676', '3708'), ('3711', '3675', '3707'), ('3710', '3674', '3706'), ('3709', '3673', '3705'), ('3708', '3672', '3704'), ('3707', '3671', '3703'), ('3706', '3670', '3702'), ('3705', '3669', '3701'), ('3704', '3668', '3700'), ('3703', '3667', '3699'), ('3702', '3666', '3698'), ('3701', '3665', '3697'), ('3700', '3664', '3696'), ('3699', '3663', '3695'), ('3698', '3662', '3694'), ('3697', '3661', '3693'), ('3696', '3660', '3692'), ('3695', '3659', '3691'), ('3694', '3658', '3690'), ('3693', '3657', '3689'), ('3692', '3656', '3688'), ('3691', '3655', '3687'), ('3690', '3654', '3686'), ('3689', '3653', '3685'), ('3688', '3652', '3684'), ('3687', '3651', '3683'), ('3686', '3650', '3682'), ('3685', '3649', '3681'), ('3684', '3648', '3680'), ('3683', '3647', '3679'), ('3682', '3646', '3678'), ('3681', '3645', '3677'), ('3680', '3644', '3676'), ('3679', '3643', '3675'), ('3678', '3642', '3674'), ('3677', '3641', '3673'), ('3676', '3640', '3672'), ('3675', '3639', '3671'), ('3674', '3638', '3670'), ('3673', '3637', '3669'), ('3672', '3636', '3668'), ('3671', '3635', '3667'), ('3670', '3634', '3666'), ('3669', '3633', '3665'), ('3668', '3632', '3664'), ('3667', '3631', '3663'), ('3666', '3630', '3662'), ('3665', '3629', '3661'), ('3664', '3628', '3660'), ('3663', '3627', '3659'), ('3662', '3626', '3658'), ('3661', '3625', '3657'), ('3660', '3624', '3656'), ('3659', '3623', '3655'), ('3658', '3622', '3654'), ('3657', '3621', '3653'), ('3656', '3620', '3652'), ('3655', '3619', '3651'), ('3654', '3618', '3650'), ('3653', '3617', '3649'), ('3652', '3616', '3648'), ('3651', '3615', '3647'), ('3650', '3614', '3646'), ('3649', '3613', '3645'), ('3648', '3612', '3644'), ('3647', '3611', '3643'), ('3646', '3610', '3642'), ('3645', '3609', '3641'), ('3644', '3608', '3640'), ('3643', '3607', '3639'), ('3642', '3606', '3638'), ('3641', '3605', '3637'), ('3640', '3604', '3636'), ('3639', '3603', '3635'), ('3638', '3602', '3634'), ('3637', '3601', '3633'), ('3636', '3600', '3632'), ('3635', '3599', '3631'), ('3634', '3598', '3630'), ('3633', '3597', '3629'), ('3632', '3596', '3628'), ('3631', '3595', '3627'), ('3630', '3594', '3626'), ('3629', '3593', '3625'), ('3628', '3592', '3624'), ('3627', '3591', '3623'), ('3626', '3590', '3622'), ('3625', '3589', '3621'), ('3624', '3588', '3620'), ('3623', '3587', '3619'), ('3622', '3586', '3618'), ('3621', '3585', '3617'), ('3620', '3584', '3616'), ('3619', '3583', '3615'), ('3618', '3582', '3614'), ('3617', '3581', '3613'), ('3616', '3580', '3612'), ('3615', '3579', '3611'), ('3614', '3578', '3610'), ('3613', '3577', '3609'), ('3612', '3576', '3608'), ('3611', '3575', '3607'), ('3610', '3574', '3606'), ('3609', '3573', '3605'), ('3608', '3572', '3604'), ('3607', '3571', '3603'), ('3606', '3570', '3602'), ('3605', '3569', '3601'), ('3604', '3568', '3600'), ('3603', '3567', '3599'), ('3602', '3566', '3598'), ('3601', '3565', '3597'), ('3600', '3564', '3596'), ('3599', '3563', '3595'), ('3598', '3562', '3594'), ('3597', '3561', '3593'), ('3596', '3560', '3592'), ('3595', '3559', '3591'), ('3594', '3558', '3590'), ('3593', '3557', '3589'), ('3592', '3556', '3588'), ('3591', '3555', '3587'), ('3590', '3554', '3586'), ('3589', '3553', '3585'), ('3588', '3552', '3584'), ('3587', '3551', '3583'), ('3586', '3550', '3582'), ('3585', '3549', '3581'), ('3584', '3548', '3580'), ('3583', '3547', '3579'), ('3582', '3546', '3578'), ('3581', '3545', '3577'), ('3580', '3544', '3576'), ('3579', '3543', '3575'), ('3578', '3542', '3574'), ('3577', '3541', '3573'), ('3576', '3540', '3572'), ('3575', '3539', '3571'), ('3574', '3538', '3570'), ('3573', '3537', '3569'), ('3572', '3536', '3568'), ('3571', '3535', '3567'), ('3570', '3534', '3566'), ('3569', '3533', '3565'), ('3568', '3532', '3564'), ('3567', '3531', '3563'), ('3566', '3530', '3562'), ('3565', '3529', '3561'), ('3564', '3528', '3560'), ('3563', '3527', '3559'), ('3562', '3526', '3558'), ('3561', '3525', '3557'), ('3560', '3524', '3556'), ('3559', '3523', '3555'), ('3558', '3522', '3554'), ('3557', '3521', '3553'), ('3556', '3520', '3552'), ('3555', '3519', '3551'), ('3554', '3518', '3550'), ('3553', '3517', '3549'), ('3552', '3516', '3548'), ('3551', '3515', '3547'), ('3550', '3514', '3546'), ('3549', '3513', '3545'), ('3548', '3512', '3544'), ('3547', '3511', '3543'), ('3546', '3510', '3542'), ('3545', '3509', '3541'), ('3544', '3508', '3540'), ('3543', '3507', '3539'), ('3542', '3506', '3538'), ('3541', '3505', '3537'), ('3540', '3504', '3536'), ('3539', '3503', '3535'), ('3538', '3502', '3534'), ('3537', '3501', '3533'), ('3536', '3500', '3532'), ('3535', '3499', '3531'), ('3534', '3498', '3530'), ('3533', '3497', '3529'), ('3532', '3496', '3528'), ('3531', '3495', '3527'), ('3530', '3494', '3526'), ('3529', '3493', '3525'), ('3528', '3492', '3524'), ('3527', '3491', '3523'), ('3526', '3490', '3522'), ('3525', '3489', '3521'), ('3524', '3488', '3520'), ('3523', '3487', '3519'), ('3522', '3486', '3518'), ('3521', '3485', '3517'), ('3520', '3484', '3516'), ('3519', '3483', '3515'), ('3518', '3482', '3514'), ('3517', '3481', '3513'), ('3516', '3480', '3512'), ('3515', '3479', '3511'), ('3514', '3478', '3510'), ('3513', '3477', '3509'), ('3512', '3476', '3508'), ('3511', '3475', '3507'), ('3510', '3474', '3506'), ('3509', '3473', '3505'), ('3508', '3472', '3504'), ('3507', '3471', '3503'), ('3506', '3470', '3502'), ('3505', '3469', '3501'), ('3504', '3468', '3500'), ('3503', '3467', '3499'), ('3502', '3466', '3498'), ('3501', '3465', '3497'), ('3500', '3464', '3496'), ('3499', '3463', '3495'), ('3498', '3462', '3494'), ('3497', '3461', '3493'), ('3496', '3460', '3492'), ('3495', '3459', '3491'), ('3494', '3458', '3490'), ('3493', '3457', '3489'), ('3492', '3456', '3488'), ('3491', '3455', '3487'), ('3490', '3454', '3486'), ('3489', '3453', '3485'), ('3488', '3452', '3484'), ('3487', '3451', '3483'), ('3486', '3450', '3482'), ('3485', '3449', '3481'), ('3484', '3448', '3480'), ('3483', '3447', '3479'), ('3482', '3446', '3478'), ('3481', '3445', '3477'), ('3480', '3444', '3476'), ('3479', '3443', '3475'), ('3478', '3442', '3474'), ('3477', '3441', '3473'), ('3476', '3440', '3472'), ('3475', '3439', '3471'), ('3474', '3438', '3470'), ('3473', '3437', '3469'), ('3472', '3436', '3468'), ('3471', '3435', '3467'), ('3470', '3434', '3466'), ('3469', '3433', '3465'), ('3468', '3432', '3464'), ('3467', '3431', '3463'), ('3466', '3430', '3462'), ('3465', '3429', '3461'), ('3464', '3428', '3460'), ('3463', '3427', '3459'), ('3462', '3426', '3458'), ('3461', '3425', '3457'), ('3460', '3424', '3456'), ('3459', '3423', '3455'), ('3458', '3422', '3454'), ('3457', '3421', '3453'), ('3456', '3420', '3452'), ('3455', '3419', '3451'), ('3454', '3418', '3450'), ('3453', '3417', '3449'), ('3452', '3416', '3448'), ('3451', '3415', '3447'), ('3450', '3414', '3446'), ('3449', '3413', '3445'), ('3448', '3412', '3444'), ('3447', '3411', '3443'), ('3446', '3410', '3442'), ('3445', '3409', '3441'), ('3444', '3408', '3440'), ('3443', '3407', '3439'), ('3442', '3406', '3438'), ('3441', '3405', '3437'), ('3440', '3404', '3436'), ('3439', '3403', '3435'), ('3438', '3402', '3434'), ('3437', '3401', '3433'), ('3436', '3400', '3432'), ('3435', '3399', '3431'), ('3434', '3398', '3430'), ('3433', '3397', '3429'), ('3432', '3396', '3428'), ('3431', '3395', '3427'), ('3430', '3394', '3426'), ('3429', '3393', '3425'), ('3428', '3392', '3424'), ('3427', '3391', '3423'), ('3426', '3390', '3422'), ('3425', '3389', '3421'), ('3424', '3388', '3420'), ('3423', '3387', '3419'), ('3422', '3386', '3418'), ('3421', '3385', '3417'), ('3420', '3384', '3416'), ('3419', '3383', '3415'), ('3418', '3382', '3414'), ('3417', '3381', '3413'), ('3416', '3380', '3412'), ('3415', '3379', '3411'), ('3414', '3378', '3410'), ('3413', '3377', '3409'), ('3412', '3376', '3408'), ('3411', '3375', '3407'), ('3410', '3374', '3406'), ('3409', '3373', '3405'), ('3408', '3372', '3404'), ('3407', '3371', '3403'), ('3406', '3370', '3402'), ('3405', '3369', '3401'), ('3404', '3368', '3400'), ('3403', '3367', '3399'), ('3402', '3366', '3398'), ('3401', '3365', '3397'), ('3400', '3364', '3396'), ('3399', '3363', '3395'), ('3398', '3362', '3394'), ('3397', '3361', '3393'), ('3396', '3360', '3392'), ('3395', '3359', '3391'), ('3394', '3358', '3390'), ('3393', '3357', '3389'), ('3392', '3356', '3388'), ('3391', '3355', '3387'), ('3390', '3354', '3386'), ('3389', '3353', '3385'), ('3388', '3352', '3384'), ('3387', '3351', '3383'), ('3386', '3350', '3382'), ('3385', '3349', '3381'), ('3384', '3348', '3380'), ('3383', '3347', '3379'), ('3382', '3346', '3378'), ('3381', '3345', '3377'), ('3380', '3344', '3376'), ('3379', '3343', '3375'), ('3378', '3342', '3374'), ('3377', '3341', '3373'), ('3376', '3340', '3372'), ('3375', '3339', '3371'), ('3374', '3338', '3370'), ('3373', '3337', '3369'), ('3372', '3336', '3368'), ('3371', '3335', '3367'), ('3370', '3334', '3366'), ('3369', '3333', '3365'), ('3368', '3332', '3364'), ('3367', '3331', '3363'), ('3366', '3330', '3362'), ('3365', '3329', '3361'), ('3364', '3328', '3360'), ('3363', '3327', '3359'), ('3362', '3326', '3358'), ('3361', '3325', '3357'), ('3360', '3324', '3356'), ('3359', '3323', '3355'), ('3358', '3322', '3354'), ('3357', '3321', '3353'), ('3356', '3320', '3352'), ('3355', '3319', '3351'), ('3354', '3318', '3350'), ('3353', '3317', '3349'), ('3352', '3316', '3348'), ('3351', '3315', '3347'), ('3350', '3314', '3346'), ('3349', '3313', '3345'), ('3348', '3312', '3344'), ('3347', '3311', '3343'), ('3346', '3310', '3342'), ('3345', '3309', '3341'), ('3344', '3308', '3340'), ('3343', '3307', '3339'), ('3342', '3306', '3338'), ('3341', '3305', '3337'), ('3340', '3304', '3336'), ('3339', '3303', '3335'), ('3338', '3302', '3334'), ('3337', '3301', '3333'), ('3336', '3300', '3332'), ('3335', '3299', '3331'), ('3334', '3298', '3330'), ('3333', '3297', '3329'), ('3332', '3296', '3328'), ('3331', '3295', '3327'), ('3330', '3294', '3326'), ('3329', '3293', '3325'), ('3328', '3292', '3324'), ('3327', '3291', '3323'), ('3326', '3290', '3322'), ('3325', '3289', '3321'), ('3324', '3288', '3320'), ('3323', '3287', '3319'), ('3322', '3286', '3318'), ('3321', '3285', '3317'), ('3320', '3284', '3316'), ('3319', '3283', '3315'), ('3318', '3282', '3314'), ('3317', '3281', '3313'), ('3316', '3280', '3312'), ('3315', '3279', '3311'), ('3314', '3278', '3310'), ('3313', '3277', '3309'), ('3312', '3276', '3308'), ('3311', '3275', '3307'), ('3310', '3274', '3306'), ('3309', '3273', '3305'), ('3308', '3272', '3304'), ('3307', '3271', '3303'), ('3306', '3270', '3302'), ('3305', '3269', '3301'), ('3304', '3268', '3300'), ('3303', '3267', '3299'), ('3302', '3266', '3298'), ('3301', '3265', '3297'), ('3300', '3264', '3296'), ('3299', '3263', '3295'), ('3298', '3262', '3294'), ('3297', '3261', '3293'), ('3296', '3260', '3292'), ('3295', '3259', '3291'), ('3294', '3258', '3290'), ('3293', '3257', '3289'), ('3292', '3256', '3288'), ('3291', '3255', '3287'), ('3290', '3254', '3286'), ('3289', '3253', '3285'), ('3288', '3252', '3284'), ('3287', '3251', '3283'), ('3286', '3250', '3282'), ('3285', '3249', '3281'), ('3284', '3248', '3280'), ('3283', '3247', '3279'), ('3282', '3246', '3278'), ('3281', '3245', '3277'), ('3280', '3244', '3276'), ('3279', '3243', '3275'), ('3278', '3242', '3274'), ('3277', '3241', '3273'), ('3276', '3240', '3272'), ('3275', '3239', '3271'), ('3274', '3238', '3270'), ('3273', '3237', '3269'), ('3272', '3236', '3268'), ('3271', '3235', '3267'), ('3270', '3234', '3266'), ('3269', '3233', '3265'), ('3268', '3232', '3264'), ('3267', '3231', '3263'), ('3266', '3230', '3262'), ('3265', '3229', '3261'), ('3264', '3228', '3260'), ('3263', '3227', '3259'), ('3262', '3226', '3258'), ('3261', '3225', '3257'), ('3260', '3224', '3256'), ('3259', '3223', '3255'), ('3258', '3222', '3254'), ('3257', '3221', '3253'), ('3256', '3220', '3252'), ('3255', '3219', '3251'), ('3254', '3218', '3250'), ('3253', '3217', '3249'), ('3252', '3216', '3248'), ('3251', '3215', '3247'), ('3250', '3214', '3246'), ('3249', '3213', '3245'), ('3248', '3212', '3244'), ('3247', '3211', '3243'), ('3246', '3210', '3242'), ('3245', '3209', '3241'), ('3244', '3208', '3240'), ('3243', '3207', '3239'), ('3242', '3206', '3238'), ('3241', '3205', '3237'), ('3240', '3204', '3236'), ('3239', '3203', '3235'), ('3238', '3202', '3234'), ('3237', '3201', '3233'), ('3236', '3200', '3232'), ('3235', '3199', '3231'), ('3234', '3198', '3230'), ('3233', '3197', '3229'), ('3232', '3196', '3228'), ('3231', '3195', '3227'), ('3230', '3194', '3226'), ('3229', '3193', '3225'), ('3228', '3192', '3224'), ('3227', '3191', '3223'), ('3226', '3190', '3222'), ('3225', '3189', '3221'), ('3224', '3188', '3220'), ('3223', '3187', '3219'), ('3222', '3186', '3218'), ('3221', '3185', '3217'), ('3220', '3184', '3216'), ('3219', '3183', '3215'), ('3218', '3182', '3214'), ('3217', '3181', '3213'), ('3216', '3180', '3212'), ('3215', '3179', '3211'), ('3214', '3178', '3210'), ('3213', '3177', '3209'), ('3212', '3176', '3208'), ('3211', '3175', '3207'), ('3210', '3174', '3206'), ('3209', '3173', '3205'), ('3208', '3172', '3204'), ('3207', '3171', '3203'), ('3206', '3170', '3202'), ('3205', '3169', '3201'), ('3204', '3168', '3200'), ('3203', '3167', '3199'), ('3202', '3166', '3198'), ('3201', '3165', '3197'), ('3200', '3164', '3196'), ('3199', '3163', '3195'), ('3198', '3162', '3194'), ('3197', '3161', '3193'), ('3196', '3160', '3192'), ('3195', '3159', '3191'), ('3194', '3158', '3190'), ('3193', '3157', '3189'), ('3192', '3156', '3188'), ('3191', '3155', '3187'), ('3190', '3154', '3186'), ('3189', '3153', '3185'), ('3188', '3152', '3184'), ('3187', '3151', '3183'), ('3186', '3150', '3182'), ('3185', '3149', '3181'), ('3184', '3148', '3180'), ('3183', '3147', '3179'), ('3182', '3146', '3178'), ('3181', '3145', '3177'), ('3180', '3144', '3176'), ('3179', '3143', '3175'), ('3178', '3142', '3174'), ('3177', '3141', '3173'), ('3176', '3140', '3172'), ('3175', '3139', '3171'), ('3174', '3138', '3170'), ('3173', '3137', '3169'), ('3172', '3136', '3168'), ('3171', '3135', '3167'), ('3170', '3134', '3166'), ('3169', '3133', '3165'), ('3168', '3132', '3164'), ('3167', '3131', '3163'), ('3166', '3130', '3162'), ('3165', '3129', '3161'), ('3164', '3128', '3160'), ('3163', '3127', '3159'), ('3162', '3126', '3158'), ('3161', '3125', '3157'), ('3160', '3124', '3156'), ('3159', '3123', '3155'), ('3158', '3122', '3154'), ('3157', '3121', '3153'), ('3156', '3120', '3152'), ('3155', '3119', '3151'), ('3154', '3118', '3150'), ('3153', '3117', '3149'), ('3152', '3116', '3148'), ('3151', '3115', '3147'), ('3150', '3114', '3146'), ('3149', '3113', '3145'), ('3148', '3112', '3144'), ('3147', '3111', '3143'), ('3146', '3110', '3142'), ('3145', '3109', '3141'), ('3144', '3108', '3140'), ('3143', '3107', '3139'), ('3142', '3106', '3138'), ('3141', '3105', '3137'), ('3140', '3104', '3136'), ('3139', '3103', '3135'), ('3138', '3102', '3134'), ('3137', '3101', '3133'), ('3136', '3100', '3132'), ('3135', '3099', '3131'), ('3134', '3098', '3130'), ('3133', '3097', '3129'), ('3132', '3096', '3128'), ('3131', '3095', '3127'), ('3130', '3094', '3126'), ('3129', '3093', '3125'), ('3128', '3092', '3124'), ('3127', '3091', '3123'), ('3126', '3090', '3122'), ('3125', '3089', '3121'), ('3124', '3088', '3120'), ('3123', '3087', '3119'), ('3122', '3086', '3118'), ('3121', '3085', '3117'), ('3120', '3084', '3116'), ('3119', '3083', '3115'), ('3118', '3082', '3114'), ('3117', '3081', '3113'), ('3116', '3080', '3112'), ('3115', '3079', '3111'), ('3114', '3078', '3110'), ('3113', '3077', '3109'), ('3112', '3076', '3108'), ('3111', '3075', '3107'), ('3110', '3074', '3106'), ('3109', '3073', '3105'), ('3108', '3072', '3104'), ('3107', '3071', '3103'), ('3106', '3070', '3102'), ('3105', '3069', '3101'), ('3104', '3068', '3100'), ('3103', '3067', '3099'), ('3102', '3066', '3098'), ('3101', '3065', '3097'), ('3100', '3064', '3096'), ('3099', '3063', '3095'), ('3098', '3062', '3094'), ('3097', '3061', '3093'), ('3096', '3060', '3092'), ('3095', '3059', '3091'), ('3094', '3058', '3090'), ('3093', '3057', '3089'), ('3092', '3056', '3088'), ('3091', '3055', '3087'), ('3090', '3054', '3086'), ('3089', '3053', '3085'), ('3088', '3052', '3084'), ('3087', '3051', '3083'), ('3086', '3050', '3082'), ('3085', '3049', '3081'), ('3084', '3048', '3080'), ('3083', '3047', '3079'), ('3082', '3046', '3078'), ('3081', '3045', '3077'), ('3080', '3044', '3076'), ('3079', '3043', '3075'), ('3078', '3042', '3074'), ('3077', '3041', '3073'), ('3076', '3040', '3072'), ('3075', '3039', '3071'), ('3074', '3038', '3070'), ('3073', '3037', '3069'), ('3072', '3036', '3068'), ('3071', '3035', '3067'), ('3070', '3034', '3066'), ('3069', '3033', '3065'), ('3068', '3032', '3064'), ('3067', '3031', '3063'), ('3066', '3030', '3062'), ('3065', '3029', '3061'), ('3064', '3028', '3060'), ('3063', '3027', '3059'), ('3062', '3026', '3058'), ('3061', '3025', '3057'), ('3060', '3024', '3056'), ('3059', '3023', '3055'), ('3058', '3022', '3054'), ('3057', '3021', '3053'), ('3056', '3020', '3052'), ('3055', '3019', '3051'), ('3054', '3018', '3050'), ('3053', '3017', '3049'), ('3052', '3016', '3048'), ('3051', '3015', '3047'), ('3050', '3014', '3046'), ('3049', '3013', '3045'), ('3048', '3012', '3044'), ('3047', '3011', '3043'), ('3046', '3010', '3042'), ('3045', '3009', '3041'), ('3044', '3008', '3040'), ('3043', '3007', '3039'), ('3042', '3006', '3038'), ('3041', '3005', '3037'), ('3040', '3004', '3036'), ('3039', '3003', '3035'), ('3038', '3002', '3034'), ('3037', '3001', '3033'), ('3036', '3000', '3032'), ('3035', '2999', '3031'), ('3034', '2998', '3030'), ('3033', '2997', '3029'), ('3032', '2996', '3028'), ('3031', '2995', '3027'), ('3030', '2994', '3026'), ('3029', '2993', '3025'), ('3028', '2992', '3024'), ('3027', '2991', '3023'), ('3026', '2990', '3022'), ('3025', '2989', '3021'), ('3024', '2988', '3020'), ('3023', '2987', '3019'), ('3022', '2986', '3018'), ('3021', '2985', '3017'), ('3020', '2984', '3016'), ('3019', '2983', '3015'), ('3018', '2982', '3014'), ('3017', '2981', '3013'), ('3016', '2980', '3012'), ('3015', '2979', '3011'), ('3014', '2978', '3010'), ('3013', '2977', '3009'), ('3012', '2976', '3008'), ('3011', '2975', '3007'), ('3010', '2974', '3006'), ('3009', '2973', '3005'), ('3008', '2972', '3004'), ('3007', '2971', '3003'), ('3006', '2970', '3002'), ('3005', '2969', '3001'), ('3004', '2968', '3000'), ('3003', '2967', '2999'), ('3002', '2966', '2998'), ('3001', '2965', '2997'), ('3000', '2964', '2996'), ('2999', '2963', '2995'), ('2998', '2962', '2994'), ('2997', '2961', '2993'), ('2996', '2960', '2992'), ('2995', '2959', '2991'), ('2994', '2958', '2990'), ('2993', '2957', '2989'), ('2992', '2956', '2988'), ('2991', '2955', '2987'), ('2990', '2954', '2986'), ('2989', '2953', '2985'), ('2988', '2952', '2984'), ('2987', '2951', '2983'), ('2986', '2950', '2982'), ('2985', '2949', '2981'), ('2984', '2948', '2980'), ('2983', '2947', '2979'), ('2982', '2946', '2978'), ('2981', '2945', '2977'), ('2980', '2944', '2976'), ('2979', '2943', '2975'), ('2978', '2942', '2974'), ('2977', '2941', '2973'), ('2976', '2940', '2972'), ('2975', '2939', '2971'), ('2974', '2938', '2970'), ('2973', '2937', '2969'), ('2972', '2936', '2968'), ('2971', '2935', '2967'), ('2970', '2934', '2966'), ('2969', '2933', '2965'), ('2968', '2932', '2964'), ('2967', '2931', '2963'), ('2966', '2930', '2962'), ('2965', '2929', '2961'), ('2964', '2928', '2960'), ('2963', '2927', '2959'), ('2962', '2926', '2958'), ('2961', '2925', '2957'), ('2960', '2924', '2956'), ('2959', '2923', '2955'), ('2958', '2922', '2954'), ('2957', '2921', '2953'), ('2956', '2920', '2952'), ('2955', '2919', '2951'), ('2954', '2918', '2950'), ('2953', '2917', '2949'), ('2952', '2916', '2948'), ('2951', '2915', '2947'), ('2950', '2914', '2946'), ('2949', '2913', '2945'), ('2948', '2912', '2944'), ('2947', '2911', '2943'), ('2946', '2910', '2942'), ('2945', '2909', '2941'), ('2944', '2908', '2940'), ('2943', '2907', '2939'), ('2942', '2906', '2938'), ('2941', '2905', '2937'), ('2940', '2904', '2936'), ('2939', '2903', '2935'), ('2938', '2902', '2934'), ('2937', '2901', '2933'), ('2936', '2900', '2932'), ('2935', '2899', '2931'), ('2934', '2898', '2930'), ('2933', '2897', '2929'), ('2932', '2896', '2928'), ('2931', '2895', '2927'), ('2930', '2894', '2926'), ('2929', '2893', '2925'), ('2928', '2892', '2924'), ('2927', '2891', '2923'), ('2926', '2890', '2922'), ('2925', '2889', '2921'), ('2924', '2888', '2920'), ('2923', '2887', '2919'), ('2922', '2886', '2918'), ('2921', '2885', '2917'), ('2920', '2884', '2916'), ('2919', '2883', '2915'), ('2918', '2882', '2914'), ('2917', '2881', '2913'), ('2916', '2880', '2912'), ('2915', '2879', '2911'), ('2914', '2878', '2910'), ('2913', '2877', '2909'), ('2912', '2876', '2908'), ('2911', '2875', '2907'), ('2910', '2874', '2906'), ('2909', '2873', '2905'), ('2908', '2872', '2904');
INSERT INTO `timeofwars_damage_strength` VALUES ('2907', '2871', '2903'), ('2906', '2870', '2902'), ('2905', '2869', '2901'), ('2904', '2868', '2900'), ('2903', '2867', '2899'), ('2902', '2866', '2898'), ('2901', '2865', '2897'), ('2900', '2864', '2896'), ('2899', '2863', '2895'), ('2898', '2862', '2894'), ('2897', '2861', '2893'), ('2896', '2860', '2892'), ('2895', '2859', '2891'), ('2894', '2858', '2890'), ('2893', '2857', '2889'), ('2892', '2856', '2888'), ('2891', '2855', '2887'), ('2890', '2854', '2886'), ('2889', '2853', '2885'), ('2888', '2852', '2884'), ('2887', '2851', '2883'), ('2886', '2850', '2882'), ('2885', '2849', '2881'), ('2884', '2848', '2880'), ('2883', '2847', '2879'), ('2882', '2846', '2878'), ('2881', '2845', '2877'), ('2880', '2844', '2876'), ('2879', '2843', '2875'), ('2878', '2842', '2874'), ('2877', '2841', '2873'), ('2876', '2840', '2872'), ('2875', '2839', '2871'), ('2874', '2838', '2870'), ('2873', '2837', '2869'), ('2872', '2836', '2868'), ('2871', '2835', '2867'), ('2870', '2834', '2866'), ('2869', '2833', '2865'), ('2868', '2832', '2864'), ('2867', '2831', '2863'), ('2866', '2830', '2862'), ('2865', '2829', '2861'), ('2864', '2828', '2860'), ('2863', '2827', '2859'), ('2862', '2826', '2858'), ('2861', '2825', '2857'), ('2860', '2824', '2856'), ('2859', '2823', '2855'), ('2858', '2822', '2854'), ('2857', '2821', '2853'), ('2856', '2820', '2852'), ('2855', '2819', '2851'), ('2854', '2818', '2850'), ('2853', '2817', '2849'), ('2852', '2816', '2848'), ('2851', '2815', '2847'), ('2850', '2814', '2846'), ('2849', '2813', '2845'), ('2848', '2812', '2844'), ('2847', '2811', '2843'), ('2846', '2810', '2842'), ('2845', '2809', '2841'), ('2844', '2808', '2840'), ('2843', '2807', '2839'), ('2842', '2806', '2838'), ('2841', '2805', '2837'), ('2840', '2804', '2836'), ('2839', '2803', '2835'), ('2838', '2802', '2834'), ('2837', '2801', '2833'), ('2836', '2800', '2832'), ('2835', '2799', '2831'), ('2834', '2798', '2830'), ('2833', '2797', '2829'), ('2832', '2796', '2828'), ('2831', '2795', '2827'), ('2830', '2794', '2826'), ('2829', '2793', '2825'), ('2828', '2792', '2824'), ('2827', '2791', '2823'), ('2826', '2790', '2822'), ('2825', '2789', '2821'), ('2824', '2788', '2820'), ('2823', '2787', '2819'), ('2822', '2786', '2818'), ('2821', '2785', '2817'), ('2820', '2784', '2816'), ('2819', '2783', '2815'), ('2818', '2782', '2814'), ('2817', '2781', '2813'), ('2816', '2780', '2812'), ('2815', '2779', '2811'), ('2814', '2778', '2810'), ('2813', '2777', '2809'), ('2812', '2776', '2808'), ('2811', '2775', '2807'), ('2810', '2774', '2806'), ('2809', '2773', '2805'), ('2808', '2772', '2804'), ('2807', '2771', '2803'), ('2806', '2770', '2802'), ('2805', '2769', '2801'), ('2804', '2768', '2800'), ('2803', '2767', '2799'), ('2802', '2766', '2798'), ('2801', '2765', '2797'), ('2800', '2764', '2796'), ('2799', '2763', '2795'), ('2798', '2762', '2794'), ('2797', '2761', '2793'), ('2796', '2760', '2792'), ('2795', '2759', '2791'), ('2794', '2758', '2790'), ('2793', '2757', '2789'), ('2792', '2756', '2788'), ('2791', '2755', '2787'), ('2790', '2754', '2786'), ('2789', '2753', '2785'), ('2788', '2752', '2784'), ('2787', '2751', '2783'), ('2786', '2750', '2782'), ('2785', '2749', '2781'), ('2784', '2748', '2780'), ('2783', '2747', '2779'), ('2782', '2746', '2778'), ('2781', '2745', '2777'), ('2780', '2744', '2776'), ('2779', '2743', '2775'), ('2778', '2742', '2774'), ('2777', '2741', '2773'), ('2776', '2740', '2772'), ('2775', '2739', '2771'), ('2774', '2738', '2770'), ('2773', '2737', '2769'), ('2772', '2736', '2768'), ('2771', '2735', '2767'), ('2770', '2734', '2766'), ('2769', '2733', '2765'), ('2768', '2732', '2764'), ('2767', '2731', '2763'), ('2766', '2730', '2762'), ('2765', '2729', '2761'), ('2764', '2728', '2760'), ('2763', '2727', '2759'), ('2762', '2726', '2758'), ('2761', '2725', '2757'), ('2760', '2724', '2756'), ('2759', '2723', '2755'), ('2758', '2722', '2754'), ('2757', '2721', '2753'), ('2756', '2720', '2752'), ('2755', '2719', '2751'), ('2754', '2718', '2750'), ('2753', '2717', '2749'), ('2752', '2716', '2748'), ('2751', '2715', '2747'), ('2750', '2714', '2746'), ('2749', '2713', '2745'), ('2748', '2712', '2744'), ('2747', '2711', '2743'), ('2746', '2710', '2742'), ('2745', '2709', '2741'), ('2744', '2708', '2740'), ('2743', '2707', '2739'), ('2742', '2706', '2738'), ('2741', '2705', '2737'), ('2740', '2704', '2736'), ('2739', '2703', '2735'), ('2738', '2702', '2734'), ('2737', '2701', '2733'), ('2736', '2700', '2732'), ('2735', '2699', '2731'), ('2734', '2698', '2730'), ('2733', '2697', '2729'), ('2732', '2696', '2728'), ('2731', '2695', '2727'), ('2730', '2694', '2726'), ('2729', '2693', '2725'), ('2728', '2692', '2724'), ('2727', '2691', '2723'), ('2726', '2690', '2722'), ('2725', '2689', '2721'), ('2724', '2688', '2720'), ('2723', '2687', '2719'), ('2722', '2686', '2718'), ('2721', '2685', '2717'), ('2720', '2684', '2716'), ('2719', '2683', '2715'), ('2718', '2682', '2714'), ('2717', '2681', '2713'), ('2716', '2680', '2712'), ('2715', '2679', '2711'), ('2714', '2678', '2710'), ('2713', '2677', '2709'), ('2712', '2676', '2708'), ('2711', '2675', '2707'), ('2710', '2674', '2706'), ('2709', '2673', '2705'), ('2708', '2672', '2704'), ('2707', '2671', '2703'), ('2706', '2670', '2702'), ('2705', '2669', '2701'), ('2704', '2668', '2700'), ('2703', '2667', '2699'), ('2702', '2666', '2698'), ('2701', '2665', '2697'), ('2700', '2664', '2696'), ('2699', '2663', '2695'), ('2698', '2662', '2694'), ('2697', '2661', '2693'), ('2696', '2660', '2692'), ('2695', '2659', '2691'), ('2694', '2658', '2690'), ('2693', '2657', '2689'), ('2692', '2656', '2688'), ('2691', '2655', '2687'), ('2690', '2654', '2686'), ('2689', '2653', '2685'), ('2688', '2652', '2684'), ('2687', '2651', '2683'), ('2686', '2650', '2682'), ('2685', '2649', '2681'), ('2684', '2648', '2680'), ('2683', '2647', '2679'), ('2682', '2646', '2678'), ('2681', '2645', '2677'), ('2680', '2644', '2676'), ('2679', '2643', '2675'), ('2678', '2642', '2674'), ('2677', '2641', '2673'), ('2676', '2640', '2672'), ('2675', '2639', '2671'), ('2674', '2638', '2670'), ('2673', '2637', '2669'), ('2672', '2636', '2668'), ('2671', '2635', '2667'), ('2670', '2634', '2666'), ('2669', '2633', '2665'), ('2668', '2632', '2664'), ('2667', '2631', '2663'), ('2666', '2630', '2662'), ('2665', '2629', '2661'), ('2664', '2628', '2660'), ('2663', '2627', '2659'), ('2662', '2626', '2658'), ('2661', '2625', '2657'), ('2660', '2624', '2656'), ('2659', '2623', '2655'), ('2658', '2622', '2654'), ('2657', '2621', '2653'), ('2656', '2620', '2652'), ('2655', '2619', '2651'), ('2654', '2618', '2650'), ('2653', '2617', '2649'), ('2652', '2616', '2648'), ('2651', '2615', '2647'), ('2650', '2614', '2646'), ('2649', '2613', '2645'), ('2648', '2612', '2644'), ('2647', '2611', '2643'), ('2646', '2610', '2642'), ('2645', '2609', '2641'), ('2644', '2608', '2640'), ('2643', '2607', '2639'), ('2642', '2606', '2638'), ('2641', '2605', '2637'), ('2640', '2604', '2636'), ('2639', '2603', '2635'), ('2638', '2602', '2634'), ('2637', '2601', '2633'), ('2636', '2600', '2632'), ('2635', '2599', '2631'), ('2634', '2598', '2630'), ('2633', '2597', '2629'), ('2632', '2596', '2628'), ('2631', '2595', '2627'), ('2630', '2594', '2626'), ('2629', '2593', '2625'), ('2628', '2592', '2624'), ('2627', '2591', '2623'), ('2626', '2590', '2622'), ('2625', '2589', '2621'), ('2624', '2588', '2620'), ('2623', '2587', '2619'), ('2622', '2586', '2618'), ('2621', '2585', '2617'), ('2620', '2584', '2616'), ('2619', '2583', '2615'), ('2618', '2582', '2614'), ('2617', '2581', '2613'), ('2616', '2580', '2612'), ('2615', '2579', '2611'), ('2614', '2578', '2610'), ('2613', '2577', '2609'), ('2612', '2576', '2608'), ('2611', '2575', '2607'), ('2610', '2574', '2606'), ('2609', '2573', '2605'), ('2608', '2572', '2604'), ('2607', '2571', '2603'), ('2606', '2570', '2602'), ('2605', '2569', '2601'), ('2604', '2568', '2600'), ('2603', '2567', '2599'), ('2602', '2566', '2598'), ('2601', '2565', '2597'), ('2600', '2564', '2596'), ('2599', '2563', '2595'), ('2598', '2562', '2594'), ('2597', '2561', '2593'), ('2596', '2560', '2592'), ('2595', '2559', '2591'), ('2594', '2558', '2590'), ('2593', '2557', '2589'), ('2592', '2556', '2588'), ('2591', '2555', '2587'), ('2590', '2554', '2586'), ('2589', '2553', '2585'), ('2588', '2552', '2584'), ('2587', '2551', '2583'), ('2586', '2550', '2582'), ('2585', '2549', '2581'), ('2584', '2548', '2580'), ('2583', '2547', '2579'), ('2582', '2546', '2578'), ('2581', '2545', '2577'), ('2580', '2544', '2576'), ('2579', '2543', '2575'), ('2578', '2542', '2574'), ('2577', '2541', '2573'), ('2576', '2540', '2572'), ('2575', '2539', '2571'), ('2574', '2538', '2570'), ('2573', '2537', '2569'), ('2572', '2536', '2568'), ('2571', '2535', '2567'), ('2570', '2534', '2566'), ('2569', '2533', '2565'), ('2568', '2532', '2564'), ('2567', '2531', '2563'), ('2566', '2530', '2562'), ('2565', '2529', '2561'), ('2564', '2528', '2560'), ('2563', '2527', '2559'), ('2562', '2526', '2558'), ('2561', '2525', '2557'), ('2560', '2524', '2556'), ('2559', '2523', '2555'), ('2558', '2522', '2554'), ('2557', '2521', '2553'), ('2556', '2520', '2552'), ('2555', '2519', '2551'), ('2554', '2518', '2550'), ('2553', '2517', '2549'), ('2552', '2516', '2548'), ('2551', '2515', '2547'), ('2550', '2514', '2546'), ('2549', '2513', '2545'), ('2548', '2512', '2544'), ('2547', '2511', '2543'), ('2546', '2510', '2542'), ('2545', '2509', '2541'), ('2544', '2508', '2540'), ('2543', '2507', '2539'), ('2542', '2506', '2538'), ('2541', '2505', '2537'), ('2540', '2504', '2536'), ('2539', '2503', '2535'), ('2538', '2502', '2534'), ('2537', '2501', '2533'), ('2536', '2500', '2532'), ('2535', '2499', '2531'), ('2534', '2498', '2530'), ('2533', '2497', '2529'), ('2532', '2496', '2528'), ('2531', '2495', '2527'), ('2530', '2494', '2526'), ('2529', '2493', '2525'), ('2528', '2492', '2524'), ('2527', '2491', '2523'), ('2526', '2490', '2522'), ('2525', '2489', '2521'), ('2524', '2488', '2520'), ('2523', '2487', '2519'), ('2522', '2486', '2518'), ('2521', '2485', '2517'), ('2520', '2484', '2516'), ('2519', '2483', '2515'), ('2518', '2482', '2514'), ('2517', '2481', '2513'), ('2516', '2480', '2512'), ('2515', '2479', '2511'), ('2514', '2478', '2510'), ('2513', '2477', '2509'), ('2512', '2476', '2508'), ('2511', '2475', '2507'), ('2510', '2474', '2506'), ('2509', '2473', '2505'), ('2508', '2472', '2504'), ('2507', '2471', '2503'), ('2506', '2470', '2502'), ('2505', '2469', '2501'), ('2504', '2468', '2500'), ('2503', '2467', '2499'), ('2502', '2466', '2498'), ('2501', '2465', '2497'), ('2500', '2464', '2496'), ('2499', '2463', '2495'), ('2498', '2462', '2494'), ('2497', '2461', '2493'), ('2496', '2460', '2492'), ('2495', '2459', '2491'), ('2494', '2458', '2490'), ('2493', '2457', '2489'), ('2492', '2456', '2488'), ('2491', '2455', '2487'), ('2490', '2454', '2486'), ('2489', '2453', '2485'), ('2488', '2452', '2484'), ('2487', '2451', '2483'), ('2486', '2450', '2482'), ('2485', '2449', '2481'), ('2484', '2448', '2480'), ('2483', '2447', '2479'), ('2482', '2446', '2478'), ('2481', '2445', '2477'), ('2480', '2444', '2476'), ('2479', '2443', '2475'), ('2478', '2442', '2474'), ('2477', '2441', '2473'), ('2476', '2440', '2472'), ('2475', '2439', '2471'), ('2474', '2438', '2470'), ('2473', '2437', '2469'), ('2472', '2436', '2468'), ('2471', '2435', '2467'), ('2470', '2434', '2466'), ('2469', '2433', '2465'), ('2468', '2432', '2464'), ('2467', '2431', '2463'), ('2466', '2430', '2462'), ('2465', '2429', '2461'), ('2464', '2428', '2460'), ('2463', '2427', '2459'), ('2462', '2426', '2458'), ('2461', '2425', '2457'), ('2460', '2424', '2456'), ('2459', '2423', '2455'), ('2458', '2422', '2454'), ('2457', '2421', '2453'), ('2456', '2420', '2452'), ('2455', '2419', '2451'), ('2454', '2418', '2450'), ('2453', '2417', '2449'), ('2452', '2416', '2448'), ('2451', '2415', '2447'), ('2450', '2414', '2446'), ('2449', '2413', '2445'), ('2448', '2412', '2444'), ('2447', '2411', '2443'), ('2446', '2410', '2442'), ('2445', '2409', '2441'), ('2444', '2408', '2440'), ('2443', '2407', '2439'), ('2442', '2406', '2438'), ('2441', '2405', '2437'), ('2440', '2404', '2436'), ('2439', '2403', '2435'), ('2438', '2402', '2434'), ('2437', '2401', '2433'), ('2436', '2400', '2432'), ('2435', '2399', '2431'), ('2434', '2398', '2430'), ('2433', '2397', '2429'), ('2432', '2396', '2428'), ('2431', '2395', '2427'), ('2430', '2394', '2426'), ('2429', '2393', '2425'), ('2428', '2392', '2424'), ('2427', '2391', '2423'), ('2426', '2390', '2422'), ('2425', '2389', '2421'), ('2424', '2388', '2420'), ('2423', '2387', '2419'), ('2422', '2386', '2418'), ('2421', '2385', '2417'), ('2420', '2384', '2416'), ('2419', '2383', '2415'), ('2418', '2382', '2414'), ('2417', '2381', '2413'), ('2416', '2380', '2412'), ('2415', '2379', '2411'), ('2414', '2378', '2410'), ('2413', '2377', '2409'), ('2412', '2376', '2408'), ('2411', '2375', '2407'), ('2410', '2374', '2406'), ('2409', '2373', '2405'), ('2408', '2372', '2404'), ('2407', '2371', '2403'), ('2406', '2370', '2402'), ('2405', '2369', '2401'), ('2404', '2368', '2400'), ('2403', '2367', '2399'), ('2402', '2366', '2398'), ('2401', '2365', '2397'), ('2400', '2364', '2396'), ('2399', '2363', '2395'), ('2398', '2362', '2394'), ('2397', '2361', '2393'), ('2396', '2360', '2392'), ('2395', '2359', '2391'), ('2394', '2358', '2390'), ('2393', '2357', '2389'), ('2392', '2356', '2388'), ('2391', '2355', '2387'), ('2390', '2354', '2386'), ('2389', '2353', '2385'), ('2388', '2352', '2384'), ('2387', '2351', '2383'), ('2386', '2350', '2382'), ('2385', '2349', '2381'), ('2384', '2348', '2380'), ('2383', '2347', '2379'), ('2382', '2346', '2378'), ('2381', '2345', '2377'), ('2380', '2344', '2376'), ('2379', '2343', '2375'), ('2378', '2342', '2374'), ('2377', '2341', '2373'), ('2376', '2340', '2372'), ('2375', '2339', '2371'), ('2374', '2338', '2370'), ('2373', '2337', '2369'), ('2372', '2336', '2368'), ('2371', '2335', '2367'), ('2370', '2334', '2366'), ('2369', '2333', '2365'), ('2368', '2332', '2364'), ('2367', '2331', '2363'), ('2366', '2330', '2362'), ('2365', '2329', '2361'), ('2364', '2328', '2360'), ('2363', '2327', '2359'), ('2362', '2326', '2358'), ('2361', '2325', '2357'), ('2360', '2324', '2356'), ('2359', '2323', '2355'), ('2358', '2322', '2354'), ('2357', '2321', '2353'), ('2356', '2320', '2352'), ('2355', '2319', '2351'), ('2354', '2318', '2350'), ('2353', '2317', '2349'), ('2352', '2316', '2348'), ('2351', '2315', '2347'), ('2350', '2314', '2346'), ('2349', '2313', '2345'), ('2348', '2312', '2344'), ('2347', '2311', '2343'), ('2346', '2310', '2342'), ('2345', '2309', '2341'), ('2344', '2308', '2340'), ('2343', '2307', '2339'), ('2342', '2306', '2338'), ('2341', '2305', '2337'), ('2340', '2304', '2336'), ('2339', '2303', '2335'), ('2338', '2302', '2334'), ('2337', '2301', '2333'), ('2336', '2300', '2332'), ('2335', '2299', '2331'), ('2334', '2298', '2330'), ('2333', '2297', '2329'), ('2332', '2296', '2328'), ('2331', '2295', '2327'), ('2330', '2294', '2326'), ('2329', '2293', '2325'), ('2328', '2292', '2324'), ('2327', '2291', '2323'), ('2326', '2290', '2322'), ('2325', '2289', '2321'), ('2324', '2288', '2320'), ('2323', '2287', '2319'), ('2322', '2286', '2318'), ('2321', '2285', '2317'), ('2320', '2284', '2316'), ('2319', '2283', '2315'), ('2318', '2282', '2314'), ('2317', '2281', '2313'), ('2316', '2280', '2312'), ('2315', '2279', '2311'), ('2314', '2278', '2310'), ('2313', '2277', '2309'), ('2312', '2276', '2308'), ('2311', '2275', '2307'), ('2310', '2274', '2306'), ('2309', '2273', '2305'), ('2308', '2272', '2304'), ('2307', '2271', '2303'), ('2306', '2270', '2302'), ('2305', '2269', '2301'), ('2304', '2268', '2300'), ('2303', '2267', '2299'), ('2302', '2266', '2298'), ('2301', '2265', '2297'), ('2300', '2264', '2296'), ('2299', '2263', '2295'), ('2298', '2262', '2294'), ('2297', '2261', '2293'), ('2296', '2260', '2292'), ('2295', '2259', '2291'), ('2294', '2258', '2290'), ('2293', '2257', '2289'), ('2292', '2256', '2288'), ('2291', '2255', '2287'), ('2290', '2254', '2286'), ('2289', '2253', '2285'), ('2288', '2252', '2284'), ('2287', '2251', '2283'), ('2286', '2250', '2282'), ('2285', '2249', '2281'), ('2284', '2248', '2280'), ('2283', '2247', '2279'), ('2282', '2246', '2278'), ('2281', '2245', '2277'), ('2280', '2244', '2276'), ('2279', '2243', '2275'), ('2278', '2242', '2274'), ('2277', '2241', '2273'), ('2276', '2240', '2272'), ('2275', '2239', '2271'), ('2274', '2238', '2270'), ('2273', '2237', '2269'), ('2272', '2236', '2268'), ('2271', '2235', '2267'), ('2270', '2234', '2266'), ('2269', '2233', '2265'), ('2268', '2232', '2264'), ('2267', '2231', '2263'), ('2266', '2230', '2262'), ('2265', '2229', '2261'), ('2264', '2228', '2260'), ('2263', '2227', '2259'), ('2262', '2226', '2258'), ('2261', '2225', '2257'), ('2260', '2224', '2256'), ('2259', '2223', '2255'), ('2258', '2222', '2254'), ('2257', '2221', '2253'), ('2256', '2220', '2252'), ('2255', '2219', '2251'), ('2254', '2218', '2250'), ('2253', '2217', '2249'), ('2252', '2216', '2248'), ('2251', '2215', '2247'), ('2250', '2214', '2246'), ('2249', '2213', '2245'), ('2248', '2212', '2244'), ('2247', '2211', '2243'), ('2246', '2210', '2242'), ('2245', '2209', '2241'), ('2244', '2208', '2240'), ('2243', '2207', '2239'), ('2242', '2206', '2238'), ('2241', '2205', '2237'), ('2240', '2204', '2236'), ('2239', '2203', '2235'), ('2238', '2202', '2234'), ('2237', '2201', '2233'), ('2236', '2200', '2232'), ('2235', '2199', '2231'), ('2234', '2198', '2230'), ('2233', '2197', '2229'), ('2232', '2196', '2228'), ('2231', '2195', '2227'), ('2230', '2194', '2226'), ('2229', '2193', '2225'), ('2228', '2192', '2224'), ('2227', '2191', '2223'), ('2226', '2190', '2222'), ('2225', '2189', '2221'), ('2224', '2188', '2220'), ('2223', '2187', '2219'), ('2222', '2186', '2218'), ('2221', '2185', '2217'), ('2220', '2184', '2216'), ('2219', '2183', '2215'), ('2218', '2182', '2214'), ('2217', '2181', '2213'), ('2216', '2180', '2212'), ('2215', '2179', '2211'), ('2214', '2178', '2210'), ('2213', '2177', '2209'), ('2212', '2176', '2208'), ('2211', '2175', '2207'), ('2210', '2174', '2206'), ('2209', '2173', '2205'), ('2208', '2172', '2204'), ('2207', '2171', '2203'), ('2206', '2170', '2202'), ('2205', '2169', '2201'), ('2204', '2168', '2200'), ('2203', '2167', '2199'), ('2202', '2166', '2198'), ('2201', '2165', '2197'), ('2200', '2164', '2196'), ('2199', '2163', '2195'), ('2198', '2162', '2194'), ('2197', '2161', '2193'), ('2196', '2160', '2192'), ('2195', '2159', '2191'), ('2194', '2158', '2190'), ('2193', '2157', '2189'), ('2192', '2156', '2188'), ('2191', '2155', '2187'), ('2190', '2154', '2186'), ('2189', '2153', '2185'), ('2188', '2152', '2184'), ('2187', '2151', '2183'), ('2186', '2150', '2182'), ('2185', '2149', '2181'), ('2184', '2148', '2180'), ('2183', '2147', '2179'), ('2182', '2146', '2178'), ('2181', '2145', '2177'), ('2180', '2144', '2176'), ('2179', '2143', '2175'), ('2178', '2142', '2174'), ('2177', '2141', '2173'), ('2176', '2140', '2172'), ('2175', '2139', '2171'), ('2174', '2138', '2170'), ('2173', '2137', '2169'), ('2172', '2136', '2168'), ('2171', '2135', '2167'), ('2170', '2134', '2166'), ('2169', '2133', '2165'), ('2168', '2132', '2164'), ('2167', '2131', '2163'), ('2166', '2130', '2162'), ('2165', '2129', '2161'), ('2164', '2128', '2160'), ('2163', '2127', '2159'), ('2162', '2126', '2158'), ('2161', '2125', '2157'), ('2160', '2124', '2156'), ('2159', '2123', '2155'), ('2158', '2122', '2154'), ('2157', '2121', '2153'), ('2156', '2120', '2152'), ('2155', '2119', '2151'), ('2154', '2118', '2150'), ('2153', '2117', '2149'), ('2152', '2116', '2148'), ('2151', '2115', '2147'), ('2150', '2114', '2146'), ('2149', '2113', '2145'), ('2148', '2112', '2144'), ('2147', '2111', '2143'), ('2146', '2110', '2142'), ('2145', '2109', '2141'), ('2144', '2108', '2140'), ('2143', '2107', '2139'), ('2142', '2106', '2138'), ('2141', '2105', '2137'), ('2140', '2104', '2136'), ('2139', '2103', '2135'), ('2138', '2102', '2134'), ('2137', '2101', '2133'), ('2136', '2100', '2132'), ('2135', '2099', '2131'), ('2134', '2098', '2130'), ('2133', '2097', '2129'), ('2132', '2096', '2128'), ('2131', '2095', '2127'), ('2130', '2094', '2126'), ('2129', '2093', '2125'), ('2128', '2092', '2124'), ('2127', '2091', '2123'), ('2126', '2090', '2122'), ('2125', '2089', '2121'), ('2124', '2088', '2120'), ('2123', '2087', '2119'), ('2122', '2086', '2118'), ('2121', '2085', '2117'), ('2120', '2084', '2116'), ('2119', '2083', '2115'), ('2118', '2082', '2114'), ('2117', '2081', '2113'), ('2116', '2080', '2112'), ('2115', '2079', '2111'), ('2114', '2078', '2110'), ('2113', '2077', '2109'), ('2112', '2076', '2108'), ('2111', '2075', '2107'), ('2110', '2074', '2106'), ('2109', '2073', '2105'), ('2108', '2072', '2104'), ('2107', '2071', '2103'), ('2106', '2070', '2102'), ('2105', '2069', '2101'), ('2104', '2068', '2100'), ('2103', '2067', '2099'), ('2102', '2066', '2098'), ('2101', '2065', '2097'), ('2100', '2064', '2096'), ('2099', '2063', '2095'), ('2098', '2062', '2094'), ('2097', '2061', '2093'), ('2096', '2060', '2092'), ('2095', '2059', '2091'), ('2094', '2058', '2090'), ('2093', '2057', '2089'), ('2092', '2056', '2088'), ('2091', '2055', '2087'), ('2090', '2054', '2086'), ('2089', '2053', '2085'), ('2088', '2052', '2084'), ('2087', '2051', '2083'), ('2086', '2050', '2082'), ('2085', '2049', '2081'), ('2084', '2048', '2080'), ('2083', '2047', '2079'), ('2082', '2046', '2078'), ('2081', '2045', '2077'), ('2080', '2044', '2076'), ('2079', '2043', '2075'), ('2078', '2042', '2074'), ('2077', '2041', '2073'), ('2076', '2040', '2072'), ('2075', '2039', '2071'), ('2074', '2038', '2070'), ('2073', '2037', '2069'), ('2072', '2036', '2068'), ('2071', '2035', '2067'), ('2070', '2034', '2066'), ('2069', '2033', '2065'), ('2068', '2032', '2064'), ('2067', '2031', '2063'), ('2066', '2030', '2062'), ('2065', '2029', '2061'), ('2064', '2028', '2060'), ('2063', '2027', '2059'), ('2062', '2026', '2058'), ('2061', '2025', '2057'), ('2060', '2024', '2056'), ('2059', '2023', '2055'), ('2058', '2022', '2054'), ('2057', '2021', '2053'), ('2056', '2020', '2052'), ('2055', '2019', '2051'), ('2054', '2018', '2050'), ('2053', '2017', '2049'), ('2052', '2016', '2048'), ('2051', '2015', '2047'), ('2050', '2014', '2046'), ('2049', '2013', '2045'), ('2048', '2012', '2044'), ('2047', '2011', '2043'), ('2046', '2010', '2042'), ('2045', '2009', '2041'), ('2044', '2008', '2040'), ('2043', '2007', '2039'), ('2042', '2006', '2038'), ('2041', '2005', '2037'), ('2040', '2004', '2036'), ('2039', '2003', '2035'), ('2038', '2002', '2034'), ('2037', '2001', '2033'), ('2036', '2000', '2032'), ('2035', '1999', '2031'), ('2034', '1998', '2030'), ('2033', '1997', '2029'), ('2032', '1996', '2028'), ('2031', '1995', '2027'), ('2030', '1994', '2026'), ('2029', '1993', '2025'), ('2028', '1992', '2024'), ('2027', '1991', '2023'), ('2026', '1990', '2022'), ('2025', '1989', '2021'), ('2024', '1988', '2020'), ('2023', '1987', '2019'), ('2022', '1986', '2018'), ('2021', '1985', '2017'), ('2020', '1984', '2016'), ('2019', '1983', '2015'), ('2018', '1982', '2014'), ('2017', '1981', '2013'), ('2016', '1980', '2012'), ('2015', '1979', '2011'), ('2014', '1978', '2010'), ('2013', '1977', '2009'), ('2012', '1976', '2008'), ('2011', '1975', '2007'), ('2010', '1974', '2006'), ('2009', '1973', '2005'), ('2008', '1972', '2004'), ('2007', '1971', '2003'), ('2006', '1970', '2002'), ('2005', '1969', '2001'), ('2004', '1968', '2000'), ('2003', '1967', '1999'), ('2002', '1966', '1998'), ('2001', '1965', '1997'), ('2000', '1964', '1996'), ('1999', '1963', '1995'), ('1998', '1962', '1994'), ('1997', '1961', '1993'), ('1996', '1960', '1992'), ('1995', '1959', '1991'), ('1994', '1958', '1990'), ('1993', '1957', '1989'), ('1992', '1956', '1988'), ('1991', '1955', '1987'), ('1990', '1954', '1986'), ('1989', '1953', '1985'), ('1988', '1952', '1984'), ('1987', '1951', '1983'), ('1986', '1950', '1982'), ('1985', '1949', '1981'), ('1984', '1948', '1980'), ('1983', '1947', '1979'), ('1982', '1946', '1978'), ('1981', '1945', '1977'), ('1980', '1944', '1976'), ('1979', '1943', '1975'), ('1978', '1942', '1974'), ('1977', '1941', '1973'), ('1976', '1940', '1972'), ('1975', '1939', '1971'), ('1974', '1938', '1970'), ('1973', '1937', '1969'), ('1972', '1936', '1968'), ('1971', '1935', '1967'), ('1970', '1934', '1966'), ('1969', '1933', '1965'), ('1968', '1932', '1964'), ('1967', '1931', '1963'), ('1966', '1930', '1962'), ('1965', '1929', '1961'), ('1964', '1928', '1960'), ('1963', '1927', '1959'), ('1962', '1926', '1958'), ('1961', '1925', '1957'), ('1960', '1924', '1956'), ('1959', '1923', '1955'), ('1958', '1922', '1954'), ('1957', '1921', '1953'), ('1956', '1920', '1952'), ('1955', '1919', '1951'), ('1954', '1918', '1950'), ('1953', '1917', '1949'), ('1952', '1916', '1948'), ('1951', '1915', '1947'), ('1950', '1914', '1946'), ('1949', '1913', '1945'), ('1948', '1912', '1944'), ('1947', '1911', '1943'), ('1946', '1910', '1942'), ('1945', '1909', '1941'), ('1944', '1908', '1940'), ('1943', '1907', '1939'), ('1942', '1906', '1938'), ('1941', '1905', '1937'), ('1940', '1904', '1936'), ('1939', '1903', '1935'), ('1938', '1902', '1934'), ('1937', '1901', '1933'), ('1936', '1900', '1932'), ('1935', '1899', '1931'), ('1934', '1898', '1930'), ('1933', '1897', '1929'), ('1932', '1896', '1928'), ('1931', '1895', '1927'), ('1930', '1894', '1926'), ('1929', '1893', '1925'), ('1928', '1892', '1924'), ('1927', '1891', '1923'), ('1926', '1890', '1922'), ('1925', '1889', '1921'), ('1924', '1888', '1920'), ('1923', '1887', '1919'), ('1922', '1886', '1918'), ('1921', '1885', '1917'), ('1920', '1884', '1916'), ('1919', '1883', '1915'), ('1918', '1882', '1914'), ('1917', '1881', '1913'), ('1916', '1880', '1912'), ('1915', '1879', '1911'), ('1914', '1878', '1910'), ('1913', '1877', '1909'), ('1912', '1876', '1908'), ('1911', '1875', '1907'), ('1910', '1874', '1906'), ('1909', '1873', '1905'), ('1908', '1872', '1904'), ('1907', '1871', '1903'), ('1906', '1870', '1902'), ('1905', '1869', '1901'), ('1904', '1868', '1900'), ('1903', '1867', '1899'), ('1902', '1866', '1898'), ('1901', '1865', '1897'), ('1900', '1864', '1896'), ('1899', '1863', '1895'), ('1898', '1862', '1894'), ('1897', '1861', '1893'), ('1896', '1860', '1892'), ('1895', '1859', '1891'), ('1894', '1858', '1890'), ('1893', '1857', '1889'), ('1892', '1856', '1888'), ('1891', '1855', '1887'), ('1890', '1854', '1886'), ('1889', '1853', '1885'), ('1888', '1852', '1884'), ('1887', '1851', '1883'), ('1886', '1850', '1882'), ('1885', '1849', '1881'), ('1884', '1848', '1880'), ('1883', '1847', '1879'), ('1882', '1846', '1878'), ('1881', '1845', '1877'), ('1880', '1844', '1876'), ('1879', '1843', '1875'), ('1878', '1842', '1874'), ('1877', '1841', '1873'), ('1876', '1840', '1872'), ('1875', '1839', '1871'), ('1874', '1838', '1870'), ('1873', '1837', '1869'), ('1872', '1836', '1868'), ('1871', '1835', '1867'), ('1870', '1834', '1866'), ('1869', '1833', '1865'), ('1868', '1832', '1864'), ('1867', '1831', '1863'), ('1866', '1830', '1862'), ('1865', '1829', '1861'), ('1864', '1828', '1860'), ('1863', '1827', '1859'), ('1862', '1826', '1858'), ('1861', '1825', '1857'), ('1860', '1824', '1856'), ('1859', '1823', '1855'), ('1858', '1822', '1854'), ('1857', '1821', '1853'), ('1856', '1820', '1852'), ('1855', '1819', '1851'), ('1854', '1818', '1850'), ('1853', '1817', '1849'), ('1852', '1816', '1848'), ('1851', '1815', '1847'), ('1850', '1814', '1846'), ('1849', '1813', '1845'), ('1848', '1812', '1844'), ('1847', '1811', '1843'), ('1846', '1810', '1842'), ('1845', '1809', '1841'), ('1844', '1808', '1840'), ('1843', '1807', '1839'), ('1842', '1806', '1838'), ('1841', '1805', '1837'), ('1840', '1804', '1836'), ('1839', '1803', '1835'), ('1838', '1802', '1834'), ('1837', '1801', '1833'), ('1836', '1800', '1832'), ('1835', '1799', '1831'), ('1834', '1798', '1830'), ('1833', '1797', '1829'), ('1832', '1796', '1828'), ('1831', '1795', '1827'), ('1830', '1794', '1826'), ('1829', '1793', '1825'), ('1828', '1792', '1824'), ('1827', '1791', '1823'), ('1826', '1790', '1822'), ('1825', '1789', '1821'), ('1824', '1788', '1820'), ('1823', '1787', '1819'), ('1822', '1786', '1818'), ('1821', '1785', '1817'), ('1820', '1784', '1816'), ('1819', '1783', '1815'), ('1818', '1782', '1814'), ('1817', '1781', '1813'), ('1816', '1780', '1812'), ('1815', '1779', '1811'), ('1814', '1778', '1810'), ('1813', '1777', '1809'), ('1812', '1776', '1808'), ('1811', '1775', '1807'), ('1810', '1774', '1806'), ('1809', '1773', '1805'), ('1808', '1772', '1804'), ('1807', '1771', '1803'), ('1806', '1770', '1802'), ('1805', '1769', '1801'), ('1804', '1768', '1800'), ('1803', '1767', '1799'), ('1802', '1766', '1798'), ('1801', '1765', '1797'), ('1800', '1764', '1796'), ('1799', '1763', '1795'), ('1798', '1762', '1794'), ('1797', '1761', '1793'), ('1796', '1760', '1792'), ('1795', '1759', '1791'), ('1794', '1758', '1790'), ('1793', '1757', '1789'), ('1792', '1756', '1788'), ('1791', '1755', '1787'), ('1790', '1754', '1786'), ('1789', '1753', '1785'), ('1788', '1752', '1784'), ('1787', '1751', '1783'), ('1786', '1750', '1782'), ('1785', '1749', '1781'), ('1784', '1748', '1780'), ('1783', '1747', '1779'), ('1782', '1746', '1778'), ('1781', '1745', '1777'), ('1780', '1744', '1776'), ('1779', '1743', '1775'), ('1778', '1742', '1774'), ('1777', '1741', '1773'), ('1776', '1740', '1772'), ('1775', '1739', '1771'), ('1774', '1738', '1770'), ('1773', '1737', '1769'), ('1772', '1736', '1768'), ('1771', '1735', '1767'), ('1770', '1734', '1766'), ('1769', '1733', '1765'), ('1768', '1732', '1764'), ('1767', '1731', '1763'), ('1766', '1730', '1762'), ('1765', '1729', '1761'), ('1764', '1728', '1760'), ('1763', '1727', '1759'), ('1762', '1726', '1758'), ('1761', '1725', '1757'), ('1760', '1724', '1756'), ('1759', '1723', '1755'), ('1758', '1722', '1754'), ('1757', '1721', '1753'), ('1756', '1720', '1752'), ('1755', '1719', '1751'), ('1754', '1718', '1750'), ('1753', '1717', '1749'), ('1752', '1716', '1748'), ('1751', '1715', '1747'), ('1750', '1714', '1746'), ('1749', '1713', '1745'), ('1748', '1712', '1744'), ('1747', '1711', '1743'), ('1746', '1710', '1742'), ('1745', '1709', '1741'), ('1744', '1708', '1740'), ('1743', '1707', '1739'), ('1742', '1706', '1738'), ('1741', '1705', '1737'), ('1740', '1704', '1736'), ('1739', '1703', '1735'), ('1738', '1702', '1734'), ('1737', '1701', '1733'), ('1736', '1700', '1732'), ('1735', '1699', '1731'), ('1734', '1698', '1730'), ('1733', '1697', '1729'), ('1732', '1696', '1728'), ('1731', '1695', '1727'), ('1730', '1694', '1726'), ('1729', '1693', '1725'), ('1728', '1692', '1724'), ('1727', '1691', '1723'), ('1726', '1690', '1722'), ('1725', '1689', '1721'), ('1724', '1688', '1720'), ('1723', '1687', '1719'), ('1722', '1686', '1718'), ('1721', '1685', '1717'), ('1720', '1684', '1716'), ('1719', '1683', '1715'), ('1718', '1682', '1714'), ('1717', '1681', '1713'), ('1716', '1680', '1712'), ('1715', '1679', '1711'), ('1714', '1678', '1710'), ('1713', '1677', '1709'), ('1712', '1676', '1708'), ('1711', '1675', '1707'), ('1710', '1674', '1706'), ('1709', '1673', '1705'), ('1708', '1672', '1704'), ('1707', '1671', '1703'), ('1706', '1670', '1702'), ('1705', '1669', '1701'), ('1704', '1668', '1700'), ('1703', '1667', '1699'), ('1702', '1666', '1698'), ('1701', '1665', '1697'), ('1700', '1664', '1696'), ('1699', '1663', '1695'), ('1698', '1662', '1694'), ('1697', '1661', '1693'), ('1696', '1660', '1692'), ('1695', '1659', '1691'), ('1694', '1658', '1690'), ('1693', '1657', '1689'), ('1692', '1656', '1688'), ('1691', '1655', '1687'), ('1690', '1654', '1686'), ('1689', '1653', '1685'), ('1688', '1652', '1684'), ('1687', '1651', '1683'), ('1686', '1650', '1682'), ('1685', '1649', '1681'), ('1684', '1648', '1680'), ('1683', '1647', '1679'), ('1682', '1646', '1678'), ('1681', '1645', '1677'), ('1680', '1644', '1676'), ('1679', '1643', '1675'), ('1678', '1642', '1674'), ('1677', '1641', '1673'), ('1676', '1640', '1672'), ('1675', '1639', '1671'), ('1674', '1638', '1670'), ('1673', '1637', '1669'), ('1672', '1636', '1668'), ('1671', '1635', '1667'), ('1670', '1634', '1666'), ('1669', '1633', '1665'), ('1668', '1632', '1664'), ('1667', '1631', '1663'), ('1666', '1630', '1662'), ('1665', '1629', '1661'), ('1664', '1628', '1660'), ('1663', '1627', '1659'), ('1662', '1626', '1658'), ('1661', '1625', '1657'), ('1660', '1624', '1656'), ('1659', '1623', '1655'), ('1658', '1622', '1654'), ('1657', '1621', '1653'), ('1656', '1620', '1652'), ('1655', '1619', '1651'), ('1654', '1618', '1650'), ('1653', '1617', '1649'), ('1652', '1616', '1648'), ('1651', '1615', '1647'), ('1650', '1614', '1646'), ('1649', '1613', '1645'), ('1648', '1612', '1644'), ('1647', '1611', '1643'), ('1646', '1610', '1642'), ('1645', '1609', '1641'), ('1644', '1608', '1640'), ('1643', '1607', '1639'), ('1642', '1606', '1638'), ('1641', '1605', '1637'), ('1640', '1604', '1636'), ('1639', '1603', '1635'), ('1638', '1602', '1634'), ('1637', '1601', '1633'), ('1636', '1600', '1632'), ('1635', '1599', '1631'), ('1634', '1598', '1630'), ('1633', '1597', '1629'), ('1632', '1596', '1628'), ('1631', '1595', '1627'), ('1630', '1594', '1626'), ('1629', '1593', '1625'), ('1628', '1592', '1624'), ('1627', '1591', '1623'), ('1626', '1590', '1622'), ('1625', '1589', '1621'), ('1624', '1588', '1620'), ('1623', '1587', '1619'), ('1622', '1586', '1618'), ('1621', '1585', '1617'), ('1620', '1584', '1616'), ('1619', '1583', '1615'), ('1618', '1582', '1614'), ('1617', '1581', '1613'), ('1616', '1580', '1612'), ('1615', '1579', '1611'), ('1614', '1578', '1610'), ('1613', '1577', '1609'), ('1612', '1576', '1608'), ('1611', '1575', '1607'), ('1610', '1574', '1606'), ('1609', '1573', '1605'), ('1608', '1572', '1604'), ('1607', '1571', '1603'), ('1606', '1570', '1602'), ('1605', '1569', '1601'), ('1604', '1568', '1600'), ('1603', '1567', '1599'), ('1602', '1566', '1598'), ('1601', '1565', '1597'), ('1600', '1564', '1596'), ('1599', '1563', '1595'), ('1598', '1562', '1594'), ('1597', '1561', '1593'), ('1596', '1560', '1592'), ('1595', '1559', '1591'), ('1594', '1558', '1590'), ('1593', '1557', '1589'), ('1592', '1556', '1588'), ('1591', '1555', '1587'), ('1590', '1554', '1586'), ('1589', '1553', '1585'), ('1588', '1552', '1584'), ('1587', '1551', '1583'), ('1586', '1550', '1582'), ('1585', '1549', '1581'), ('1584', '1548', '1580'), ('1583', '1547', '1579'), ('1582', '1546', '1578'), ('1581', '1545', '1577'), ('1580', '1544', '1576'), ('1579', '1543', '1575'), ('1578', '1542', '1574'), ('1577', '1541', '1573'), ('1576', '1540', '1572'), ('1575', '1539', '1571'), ('1574', '1538', '1570'), ('1573', '1537', '1569'), ('1572', '1536', '1568'), ('1571', '1535', '1567'), ('1570', '1534', '1566'), ('1569', '1533', '1565'), ('1568', '1532', '1564'), ('1567', '1531', '1563'), ('1566', '1530', '1562'), ('1565', '1529', '1561'), ('1564', '1528', '1560'), ('1563', '1527', '1559'), ('1562', '1526', '1558'), ('1561', '1525', '1557'), ('1560', '1524', '1556'), ('1559', '1523', '1555'), ('1558', '1522', '1554'), ('1557', '1521', '1553'), ('1556', '1520', '1552'), ('1555', '1519', '1551'), ('1554', '1518', '1550'), ('1553', '1517', '1549'), ('1552', '1516', '1548'), ('1551', '1515', '1547'), ('1550', '1514', '1546'), ('1549', '1513', '1545'), ('1548', '1512', '1544'), ('1547', '1511', '1543'), ('1546', '1510', '1542'), ('1545', '1509', '1541'), ('1544', '1508', '1540'), ('1543', '1507', '1539'), ('1542', '1506', '1538'), ('1541', '1505', '1537'), ('1540', '1504', '1536'), ('1539', '1503', '1535'), ('1538', '1502', '1534'), ('1537', '1501', '1533'), ('1536', '1500', '1532'), ('1535', '1499', '1531'), ('1534', '1498', '1530'), ('1533', '1497', '1529'), ('1532', '1496', '1528'), ('1531', '1495', '1527'), ('1530', '1494', '1526'), ('1529', '1493', '1525'), ('1528', '1492', '1524'), ('1527', '1491', '1523'), ('1526', '1490', '1522'), ('1525', '1489', '1521'), ('1524', '1488', '1520'), ('1523', '1487', '1519'), ('1522', '1486', '1518'), ('1521', '1485', '1517'), ('1520', '1484', '1516'), ('1519', '1483', '1515'), ('1518', '1482', '1514'), ('1517', '1481', '1513'), ('1516', '1480', '1512'), ('1515', '1479', '1511'), ('1514', '1478', '1510'), ('1513', '1477', '1509'), ('1512', '1476', '1508'), ('1511', '1475', '1507'), ('1510', '1474', '1506'), ('1509', '1473', '1505'), ('1508', '1472', '1504'), ('1507', '1471', '1503'), ('1506', '1470', '1502'), ('1505', '1469', '1501'), ('1504', '1468', '1500'), ('1503', '1467', '1499'), ('1502', '1466', '1498'), ('1501', '1465', '1497'), ('1500', '1464', '1496'), ('1499', '1463', '1495'), ('1498', '1462', '1494'), ('1497', '1461', '1493'), ('1496', '1460', '1492'), ('1495', '1459', '1491'), ('1494', '1458', '1490'), ('1493', '1457', '1489'), ('1492', '1456', '1488'), ('1491', '1455', '1487'), ('1490', '1454', '1486'), ('1489', '1453', '1485'), ('1488', '1452', '1484'), ('1487', '1451', '1483'), ('1486', '1450', '1482'), ('1485', '1449', '1481'), ('1484', '1448', '1480'), ('1483', '1447', '1479'), ('1482', '1446', '1478'), ('1481', '1445', '1477'), ('1480', '1444', '1476'), ('1479', '1443', '1475'), ('1478', '1442', '1474'), ('1477', '1441', '1473'), ('1476', '1440', '1472'), ('1475', '1439', '1471'), ('1474', '1438', '1470'), ('1473', '1437', '1469'), ('1472', '1436', '1468'), ('1471', '1435', '1467'), ('1470', '1434', '1466'), ('1469', '1433', '1465'), ('1468', '1432', '1464'), ('1467', '1431', '1463'), ('1466', '1430', '1462'), ('1465', '1429', '1461'), ('1464', '1428', '1460'), ('1463', '1427', '1459'), ('1462', '1426', '1458'), ('1461', '1425', '1457'), ('1460', '1424', '1456'), ('1459', '1423', '1455'), ('1458', '1422', '1454'), ('1457', '1421', '1453'), ('1456', '1420', '1452'), ('1455', '1419', '1451'), ('1454', '1418', '1450'), ('1453', '1417', '1449'), ('1452', '1416', '1448'), ('1451', '1415', '1447'), ('1450', '1414', '1446'), ('1449', '1413', '1445'), ('1448', '1412', '1444'), ('1447', '1411', '1443'), ('1446', '1410', '1442'), ('1445', '1409', '1441'), ('1444', '1408', '1440'), ('1443', '1407', '1439'), ('1442', '1406', '1438'), ('1441', '1405', '1437'), ('1440', '1404', '1436'), ('1439', '1403', '1435'), ('1438', '1402', '1434'), ('1437', '1401', '1433'), ('1436', '1400', '1432'), ('1435', '1399', '1431'), ('1434', '1398', '1430'), ('1433', '1397', '1429'), ('1432', '1396', '1428'), ('1431', '1395', '1427'), ('1430', '1394', '1426'), ('1429', '1393', '1425'), ('1428', '1392', '1424'), ('1427', '1391', '1423'), ('1426', '1390', '1422'), ('1425', '1389', '1421'), ('1424', '1388', '1420'), ('1423', '1387', '1419'), ('1422', '1386', '1418'), ('1421', '1385', '1417'), ('1420', '1384', '1416'), ('1419', '1383', '1415'), ('1418', '1382', '1414'), ('1417', '1381', '1413'), ('1416', '1380', '1412'), ('1415', '1379', '1411'), ('1414', '1378', '1410'), ('1413', '1377', '1409'), ('1412', '1376', '1408'), ('1411', '1375', '1407'), ('1410', '1374', '1406'), ('1409', '1373', '1405'), ('1408', '1372', '1404'), ('1407', '1371', '1403'), ('1406', '1370', '1402'), ('1405', '1369', '1401'), ('1404', '1368', '1400'), ('1403', '1367', '1399'), ('1402', '1366', '1398'), ('1401', '1365', '1397'), ('1400', '1364', '1396'), ('1399', '1363', '1395'), ('1398', '1362', '1394'), ('1397', '1361', '1393'), ('1396', '1360', '1392'), ('1395', '1359', '1391'), ('1394', '1358', '1390'), ('1393', '1357', '1389'), ('1392', '1356', '1388'), ('1391', '1355', '1387'), ('1390', '1354', '1386'), ('1389', '1353', '1385'), ('1388', '1352', '1384'), ('1387', '1351', '1383'), ('1386', '1350', '1382'), ('1385', '1349', '1381'), ('1384', '1348', '1380'), ('1383', '1347', '1379'), ('1382', '1346', '1378'), ('1381', '1345', '1377'), ('1380', '1344', '1376'), ('1379', '1343', '1375'), ('1378', '1342', '1374'), ('1377', '1341', '1373'), ('1376', '1340', '1372'), ('1375', '1339', '1371'), ('1374', '1338', '1370'), ('1373', '1337', '1369'), ('1372', '1336', '1368'), ('1371', '1335', '1367'), ('1370', '1334', '1366'), ('1369', '1333', '1365'), ('1368', '1332', '1364'), ('1367', '1331', '1363'), ('1366', '1330', '1362'), ('1365', '1329', '1361'), ('1364', '1328', '1360'), ('1363', '1327', '1359'), ('1362', '1326', '1358'), ('1361', '1325', '1357'), ('1360', '1324', '1356'), ('1359', '1323', '1355'), ('1358', '1322', '1354'), ('1357', '1321', '1353'), ('1356', '1320', '1352'), ('1355', '1319', '1351'), ('1354', '1318', '1350'), ('1353', '1317', '1349'), ('1352', '1316', '1348'), ('1351', '1315', '1347'), ('1350', '1314', '1346'), ('1349', '1313', '1345'), ('1348', '1312', '1344'), ('1347', '1311', '1343'), ('1346', '1310', '1342'), ('1345', '1309', '1341'), ('1344', '1308', '1340'), ('1343', '1307', '1339'), ('1342', '1306', '1338'), ('1341', '1305', '1337'), ('1340', '1304', '1336'), ('1339', '1303', '1335'), ('1338', '1302', '1334'), ('1337', '1301', '1333'), ('1336', '1300', '1332'), ('1335', '1299', '1331'), ('1334', '1298', '1330'), ('1333', '1297', '1329'), ('1332', '1296', '1328'), ('1331', '1295', '1327'), ('1330', '1294', '1326'), ('1329', '1293', '1325'), ('1328', '1292', '1324'), ('1327', '1291', '1323'), ('1326', '1290', '1322'), ('1325', '1289', '1321'), ('1324', '1288', '1320'), ('1323', '1287', '1319'), ('1322', '1286', '1318'), ('1321', '1285', '1317'), ('1320', '1284', '1316'), ('1319', '1283', '1315'), ('1318', '1282', '1314'), ('1317', '1281', '1313'), ('1316', '1280', '1312'), ('1315', '1279', '1311'), ('1314', '1278', '1310'), ('1313', '1277', '1309'), ('1312', '1276', '1308'), ('1311', '1275', '1307'), ('1310', '1274', '1306'), ('1309', '1273', '1305'), ('1308', '1272', '1304'), ('1307', '1271', '1303'), ('1306', '1270', '1302'), ('1305', '1269', '1301'), ('1304', '1268', '1300'), ('1303', '1267', '1299'), ('1302', '1266', '1298'), ('1301', '1265', '1297'), ('1300', '1264', '1296'), ('1299', '1263', '1295'), ('1298', '1262', '1294'), ('1297', '1261', '1293'), ('1296', '1260', '1292'), ('1295', '1259', '1291'), ('1294', '1258', '1290'), ('1293', '1257', '1289'), ('1292', '1256', '1288'), ('1291', '1255', '1287'), ('1290', '1254', '1286'), ('1289', '1253', '1285'), ('1288', '1252', '1284'), ('1287', '1251', '1283'), ('1286', '1250', '1282'), ('1285', '1249', '1281'), ('1284', '1248', '1280'), ('1283', '1247', '1279'), ('1282', '1246', '1278'), ('1281', '1245', '1277'), ('1280', '1244', '1276'), ('1279', '1243', '1275'), ('1278', '1242', '1274'), ('1277', '1241', '1273'), ('1276', '1240', '1272'), ('1275', '1239', '1271'), ('1274', '1238', '1270'), ('1273', '1237', '1269'), ('1272', '1236', '1268'), ('1271', '1235', '1267'), ('1270', '1234', '1266'), ('1269', '1233', '1265'), ('1268', '1232', '1264'), ('1267', '1231', '1263'), ('1266', '1230', '1262'), ('1265', '1229', '1261'), ('1264', '1228', '1260'), ('1263', '1227', '1259'), ('1262', '1226', '1258'), ('1261', '1225', '1257'), ('1260', '1224', '1256'), ('1259', '1223', '1255'), ('1258', '1222', '1254'), ('1257', '1221', '1253'), ('1256', '1220', '1252'), ('1255', '1219', '1251'), ('1254', '1218', '1250'), ('1253', '1217', '1249'), ('1252', '1216', '1248'), ('1251', '1215', '1247'), ('1250', '1214', '1246'), ('1249', '1213', '1245'), ('1248', '1212', '1244'), ('1247', '1211', '1243'), ('1246', '1210', '1242'), ('1245', '1209', '1241'), ('1244', '1208', '1240'), ('1243', '1207', '1239'), ('1242', '1206', '1238'), ('1241', '1205', '1237'), ('1240', '1204', '1236'), ('1239', '1203', '1235'), ('1238', '1202', '1234'), ('1237', '1201', '1233'), ('1236', '1200', '1232'), ('1235', '1199', '1231'), ('1234', '1198', '1230'), ('1233', '1197', '1229'), ('1232', '1196', '1228'), ('1231', '1195', '1227'), ('1230', '1194', '1226'), ('1229', '1193', '1225'), ('1228', '1192', '1224'), ('1227', '1191', '1223'), ('1226', '1190', '1222'), ('1225', '1189', '1221'), ('1224', '1188', '1220'), ('1223', '1187', '1219'), ('1222', '1186', '1218'), ('1221', '1185', '1217'), ('1220', '1184', '1216'), ('1219', '1183', '1215'), ('1218', '1182', '1214'), ('1217', '1181', '1213'), ('1216', '1180', '1212'), ('1215', '1179', '1211'), ('1214', '1178', '1210'), ('1213', '1177', '1209'), ('1212', '1176', '1208'), ('1211', '1175', '1207'), ('1210', '1174', '1206'), ('1209', '1173', '1205'), ('1208', '1172', '1204'), ('1207', '1171', '1203'), ('1206', '1170', '1202'), ('1205', '1169', '1201'), ('1204', '1168', '1200'), ('1203', '1167', '1199'), ('1202', '1166', '1198'), ('1201', '1165', '1197'), ('1200', '1164', '1196'), ('1199', '1163', '1195'), ('1198', '1162', '1194'), ('1197', '1161', '1193'), ('1196', '1160', '1192'), ('1195', '1159', '1191'), ('1194', '1158', '1190'), ('1193', '1157', '1189'), ('1192', '1156', '1188'), ('1191', '1155', '1187'), ('1190', '1154', '1186'), ('1189', '1153', '1185'), ('1188', '1152', '1184'), ('1187', '1151', '1183'), ('1186', '1150', '1182'), ('1185', '1149', '1181'), ('1184', '1148', '1180'), ('1183', '1147', '1179'), ('1182', '1146', '1178'), ('1181', '1145', '1177'), ('1180', '1144', '1176'), ('1179', '1143', '1175'), ('1178', '1142', '1174'), ('1177', '1141', '1173'), ('1176', '1140', '1172'), ('1175', '1139', '1171'), ('1174', '1138', '1170'), ('1173', '1137', '1169'), ('1172', '1136', '1168'), ('1171', '1135', '1167'), ('1170', '1134', '1166'), ('1169', '1133', '1165'), ('1168', '1132', '1164'), ('1167', '1131', '1163'), ('1166', '1130', '1162'), ('1165', '1129', '1161'), ('1164', '1128', '1160'), ('1163', '1127', '1159'), ('1162', '1126', '1158'), ('1161', '1125', '1157'), ('1160', '1124', '1156'), ('1159', '1123', '1155'), ('1158', '1122', '1154'), ('1157', '1121', '1153'), ('1156', '1120', '1152'), ('1155', '1119', '1151'), ('1154', '1118', '1150'), ('1153', '1117', '1149'), ('1152', '1116', '1148'), ('1151', '1115', '1147'), ('1150', '1114', '1146'), ('1149', '1113', '1145'), ('1148', '1112', '1144'), ('1147', '1111', '1143'), ('1146', '1110', '1142'), ('1145', '1109', '1141'), ('1144', '1108', '1140'), ('1143', '1107', '1139'), ('1142', '1106', '1138'), ('1141', '1105', '1137'), ('1140', '1104', '1136'), ('1139', '1103', '1135'), ('1138', '1102', '1134'), ('1137', '1101', '1133'), ('1136', '1100', '1132'), ('1135', '1099', '1131'), ('1134', '1098', '1130'), ('1133', '1097', '1129'), ('1132', '1096', '1128'), ('1131', '1095', '1127'), ('1130', '1094', '1126'), ('1129', '1093', '1125'), ('1128', '1092', '1124'), ('1127', '1091', '1123'), ('1126', '1090', '1122'), ('1125', '1089', '1121'), ('1124', '1088', '1120'), ('1123', '1087', '1119'), ('1122', '1086', '1118'), ('1121', '1085', '1117'), ('1120', '1084', '1116'), ('1119', '1083', '1115'), ('1118', '1082', '1114'), ('1117', '1081', '1113'), ('1116', '1080', '1112'), ('1115', '1079', '1111'), ('1114', '1078', '1110'), ('1113', '1077', '1109'), ('1112', '1076', '1108'), ('1111', '1075', '1107'), ('1110', '1074', '1106'), ('1109', '1073', '1105'), ('1108', '1072', '1104'), ('1107', '1071', '1103'), ('1106', '1070', '1102'), ('1105', '1069', '1101'), ('1104', '1068', '1100'), ('1103', '1067', '1099'), ('1102', '1066', '1098'), ('1101', '1065', '1097'), ('1100', '1064', '1096'), ('1099', '1063', '1095'), ('1098', '1062', '1094'), ('1097', '1061', '1093'), ('1096', '1060', '1092'), ('1095', '1059', '1091'), ('1094', '1058', '1090'), ('1093', '1057', '1089'), ('1092', '1056', '1088'), ('1091', '1055', '1087'), ('1090', '1054', '1086'), ('1089', '1053', '1085'), ('1088', '1052', '1084'), ('1087', '1051', '1083'), ('1086', '1050', '1082'), ('1085', '1049', '1081'), ('1084', '1048', '1080'), ('1083', '1047', '1079'), ('1082', '1046', '1078'), ('1081', '1045', '1077'), ('1080', '1044', '1076'), ('1079', '1043', '1075'), ('1078', '1042', '1074'), ('1077', '1041', '1073'), ('1076', '1040', '1072'), ('1075', '1039', '1071'), ('1074', '1038', '1070'), ('1073', '1037', '1069'), ('1072', '1036', '1068'), ('1071', '1035', '1067'), ('1070', '1034', '1066'), ('1069', '1033', '1065'), ('1068', '1032', '1064'), ('1067', '1031', '1063'), ('1066', '1030', '1062'), ('1065', '1029', '1061'), ('1064', '1028', '1060'), ('1063', '1027', '1059'), ('1062', '1026', '1058'), ('1061', '1025', '1057'), ('1060', '1024', '1056'), ('1059', '1023', '1055'), ('1058', '1022', '1054'), ('1057', '1021', '1053'), ('1056', '1020', '1052'), ('1055', '1019', '1051'), ('1054', '1018', '1050'), ('1053', '1017', '1049'), ('1052', '1016', '1048'), ('1051', '1015', '1047'), ('1050', '1014', '1046'), ('1049', '1013', '1045'), ('1048', '1012', '1044'), ('1047', '1011', '1043'), ('1046', '1010', '1042'), ('1045', '1009', '1041'), ('1044', '1008', '1040'), ('1043', '1007', '1039'), ('1042', '1006', '1038'), ('1041', '1005', '1037'), ('1040', '1004', '1036'), ('1039', '1003', '1035'), ('1038', '1002', '1034'), ('1037', '1001', '1033'), ('1036', '1000', '1032'), ('1035', '999', '1031'), ('1034', '998', '1030'), ('1033', '997', '1029'), ('1032', '996', '1028'), ('1031', '995', '1027'), ('1030', '994', '1026'), ('1029', '993', '1025'), ('1028', '992', '1024'), ('1027', '991', '1023'), ('1026', '990', '1022'), ('1025', '989', '1021'), ('1024', '988', '1020'), ('1023', '987', '1019'), ('1022', '986', '1018'), ('1021', '985', '1017'), ('1020', '984', '1016'), ('1019', '983', '1015'), ('1018', '982', '1014'), ('1017', '981', '1013'), ('1016', '980', '1012'), ('1015', '979', '1011'), ('1014', '978', '1010'), ('1013', '977', '1009'), ('1012', '976', '1008'), ('1011', '975', '1007'), ('1010', '974', '1006'), ('1009', '973', '1005'), ('1008', '972', '1004'), ('1007', '971', '1003'), ('1006', '970', '1002'), ('1005', '969', '1001'), ('1004', '968', '1000'), ('1003', '967', '999'), ('1002', '966', '998'), ('1001', '965', '997'), ('1000', '964', '996'), ('999', '963', '995'), ('998', '962', '994'), ('997', '961', '993'), ('996', '960', '992'), ('995', '959', '991'), ('994', '958', '990'), ('993', '957', '989'), ('992', '956', '988'), ('991', '955', '987'), ('990', '954', '986'), ('989', '953', '985'), ('988', '952', '984'), ('987', '951', '983'), ('986', '950', '982'), ('985', '949', '981'), ('984', '948', '980'), ('983', '947', '979'), ('982', '946', '978'), ('981', '945', '977'), ('980', '944', '976'), ('979', '943', '975'), ('978', '942', '974'), ('977', '941', '973'), ('976', '940', '972'), ('975', '939', '971'), ('974', '938', '970'), ('973', '937', '969'), ('972', '936', '968'), ('971', '935', '967'), ('970', '934', '966'), ('969', '933', '965'), ('968', '932', '964'), ('967', '931', '963'), ('966', '930', '962'), ('965', '929', '961'), ('964', '928', '960'), ('963', '927', '959'), ('962', '926', '958'), ('961', '925', '957'), ('960', '924', '956'), ('959', '923', '955'), ('958', '922', '954'), ('957', '921', '953'), ('956', '920', '952'), ('955', '919', '951'), ('954', '918', '950'), ('953', '917', '949'), ('952', '916', '948'), ('951', '915', '947'), ('950', '914', '946'), ('949', '913', '945'), ('948', '912', '944'), ('947', '911', '943'), ('946', '910', '942'), ('945', '909', '941'), ('944', '908', '940'), ('943', '907', '939'), ('942', '906', '938'), ('941', '905', '937'), ('940', '904', '936'), ('939', '903', '935'), ('938', '902', '934'), ('937', '901', '933'), ('936', '900', '932'), ('935', '899', '931'), ('934', '898', '930'), ('933', '897', '929'), ('932', '896', '928'), ('931', '895', '927'), ('930', '894', '926'), ('929', '893', '925'), ('928', '892', '924'), ('927', '891', '923'), ('926', '890', '922'), ('925', '889', '921'), ('924', '888', '920'), ('923', '887', '919'), ('922', '886', '918'), ('921', '885', '917'), ('920', '884', '916'), ('919', '883', '915'), ('918', '882', '914'), ('917', '881', '913'), ('916', '880', '912'), ('915', '879', '911'), ('914', '878', '910'), ('913', '877', '909'), ('912', '876', '908'), ('911', '875', '907'), ('910', '874', '906'), ('909', '873', '905'), ('908', '872', '904'), ('907', '871', '903'), ('906', '870', '902'), ('905', '869', '901'), ('904', '868', '900'), ('903', '867', '899'), ('902', '866', '898'), ('901', '865', '897'), ('900', '864', '896'), ('899', '863', '895'), ('898', '862', '894'), ('897', '861', '893'), ('896', '860', '892'), ('895', '859', '891'), ('894', '858', '890'), ('893', '857', '889'), ('892', '856', '888'), ('891', '855', '887'), ('890', '854', '886'), ('889', '853', '885'), ('888', '852', '884'), ('887', '851', '883'), ('886', '850', '882'), ('885', '849', '881'), ('884', '848', '880'), ('883', '847', '879'), ('882', '846', '878'), ('881', '845', '877'), ('880', '844', '876'), ('879', '843', '875'), ('878', '842', '874'), ('877', '841', '873'), ('876', '840', '872'), ('875', '839', '871'), ('874', '838', '870'), ('873', '837', '869'), ('872', '836', '868'), ('871', '835', '867'), ('870', '834', '866'), ('869', '833', '865'), ('868', '832', '864'), ('867', '831', '863'), ('866', '830', '862'), ('865', '829', '861'), ('864', '828', '860'), ('863', '827', '859'), ('862', '826', '858'), ('861', '825', '857'), ('860', '824', '856'), ('859', '823', '855'), ('858', '822', '854'), ('857', '821', '853'), ('856', '820', '852'), ('855', '819', '851'), ('854', '818', '850'), ('853', '817', '849'), ('852', '816', '848'), ('851', '815', '847'), ('850', '814', '846'), ('849', '813', '845'), ('848', '812', '844'), ('847', '811', '843'), ('846', '810', '842'), ('845', '809', '841'), ('844', '808', '840'), ('843', '807', '839'), ('842', '806', '838'), ('841', '805', '837'), ('840', '804', '836'), ('839', '803', '835'), ('838', '802', '834'), ('837', '801', '833'), ('836', '800', '832'), ('835', '799', '831'), ('834', '798', '830'), ('833', '797', '829'), ('832', '796', '828'), ('831', '795', '827'), ('830', '794', '826'), ('829', '793', '825'), ('828', '792', '824'), ('827', '791', '823'), ('826', '790', '822'), ('825', '789', '821'), ('824', '788', '820'), ('823', '787', '819'), ('822', '786', '818'), ('821', '785', '817'), ('820', '784', '816'), ('819', '783', '815'), ('818', '782', '814'), ('817', '781', '813'), ('816', '780', '812'), ('815', '779', '811'), ('814', '778', '810'), ('813', '777', '809'), ('812', '776', '808'), ('811', '775', '807'), ('810', '774', '806'), ('809', '773', '805'), ('808', '772', '804'), ('807', '771', '803'), ('806', '770', '802'), ('805', '769', '801'), ('804', '768', '800'), ('803', '767', '799'), ('802', '766', '798'), ('801', '765', '797'), ('800', '764', '796'), ('799', '763', '795'), ('798', '762', '794'), ('797', '761', '793'), ('796', '760', '792'), ('795', '759', '791'), ('794', '758', '790'), ('793', '757', '789'), ('792', '756', '788'), ('791', '755', '787'), ('790', '754', '786'), ('789', '753', '785'), ('788', '752', '784'), ('787', '751', '783'), ('786', '750', '782'), ('785', '749', '781'), ('784', '748', '780'), ('783', '747', '779'), ('782', '746', '778'), ('781', '745', '777'), ('780', '744', '776'), ('779', '743', '775'), ('778', '742', '774'), ('777', '741', '773'), ('776', '740', '772'), ('775', '739', '771'), ('774', '738', '770'), ('773', '737', '769'), ('772', '736', '768'), ('771', '735', '767'), ('770', '734', '766'), ('769', '733', '765'), ('768', '732', '764'), ('767', '731', '763'), ('766', '730', '762'), ('765', '729', '761'), ('764', '728', '760'), ('763', '727', '759'), ('762', '726', '758'), ('761', '725', '757'), ('760', '724', '756'), ('759', '723', '755'), ('758', '722', '754'), ('757', '721', '753'), ('756', '720', '752'), ('755', '719', '751'), ('754', '718', '750'), ('753', '717', '749'), ('752', '716', '748'), ('751', '715', '747'), ('750', '714', '746'), ('749', '713', '745'), ('748', '712', '744'), ('747', '711', '743'), ('746', '710', '742'), ('745', '709', '741'), ('744', '708', '740'), ('743', '707', '739'), ('742', '706', '738'), ('741', '705', '737'), ('740', '704', '736'), ('739', '703', '735'), ('738', '702', '734'), ('737', '701', '733'), ('736', '700', '732'), ('735', '699', '731'), ('734', '698', '730'), ('733', '697', '729'), ('732', '696', '728'), ('731', '695', '727'), ('730', '694', '726'), ('729', '693', '725'), ('728', '692', '724'), ('727', '691', '723'), ('726', '690', '722'), ('725', '689', '721'), ('724', '688', '720'), ('723', '687', '719'), ('722', '686', '718'), ('721', '685', '717'), ('720', '684', '716'), ('719', '683', '715'), ('718', '682', '714'), ('717', '681', '713'), ('716', '680', '712'), ('715', '679', '711'), ('714', '678', '710'), ('713', '677', '709'), ('712', '676', '708'), ('711', '675', '707'), ('710', '674', '706'), ('709', '673', '705'), ('708', '672', '704'), ('707', '671', '703'), ('706', '670', '702'), ('705', '669', '701'), ('704', '668', '700'), ('703', '667', '699'), ('702', '666', '698'), ('701', '665', '697'), ('700', '664', '696'), ('699', '663', '695'), ('698', '662', '694'), ('697', '661', '693'), ('696', '660', '692'), ('695', '659', '691'), ('694', '658', '690'), ('693', '657', '689'), ('692', '656', '688'), ('691', '655', '687'), ('690', '654', '686'), ('689', '653', '685'), ('688', '652', '684'), ('687', '651', '683'), ('686', '650', '682'), ('685', '649', '681'), ('684', '648', '680'), ('683', '647', '679'), ('682', '646', '678'), ('681', '645', '677'), ('680', '644', '676'), ('679', '643', '675'), ('678', '642', '674'), ('677', '641', '673'), ('676', '640', '672'), ('675', '639', '671'), ('674', '638', '670'), ('673', '637', '669'), ('672', '636', '668'), ('671', '635', '667'), ('670', '634', '666'), ('669', '633', '665'), ('668', '632', '664'), ('667', '631', '663'), ('666', '630', '662'), ('665', '629', '661'), ('664', '628', '660'), ('663', '627', '659'), ('662', '626', '658'), ('661', '625', '657'), ('660', '624', '656'), ('659', '623', '655'), ('658', '622', '654'), ('657', '621', '653'), ('656', '620', '652'), ('655', '619', '651'), ('654', '618', '650'), ('653', '617', '649'), ('652', '616', '648'), ('651', '615', '647'), ('650', '614', '646'), ('649', '613', '645'), ('648', '612', '644'), ('647', '611', '643'), ('646', '610', '642'), ('645', '609', '641'), ('644', '608', '640'), ('643', '607', '639'), ('642', '606', '638'), ('641', '605', '637'), ('640', '604', '636'), ('639', '603', '635'), ('638', '602', '634'), ('637', '601', '633'), ('636', '600', '632'), ('635', '599', '631'), ('634', '598', '630'), ('633', '597', '629'), ('632', '596', '628'), ('631', '595', '627'), ('630', '594', '626'), ('629', '593', '625'), ('628', '592', '624'), ('627', '591', '623'), ('626', '590', '622'), ('625', '589', '621'), ('624', '588', '620'), ('623', '587', '619'), ('622', '586', '618'), ('621', '585', '617'), ('620', '584', '616'), ('619', '583', '615'), ('618', '582', '614'), ('617', '581', '613'), ('616', '580', '612'), ('615', '579', '611'), ('614', '578', '610'), ('613', '577', '609'), ('612', '576', '608'), ('611', '575', '607'), ('610', '574', '606'), ('609', '573', '605'), ('608', '572', '604'), ('607', '571', '603'), ('606', '570', '602'), ('605', '569', '601'), ('604', '568', '600'), ('603', '567', '599'), ('602', '566', '598'), ('601', '565', '597'), ('600', '564', '596'), ('599', '563', '595'), ('598', '562', '594'), ('597', '561', '593'), ('596', '560', '592'), ('595', '559', '591'), ('594', '558', '590'), ('593', '557', '589'), ('592', '556', '588'), ('591', '555', '587'), ('590', '554', '586'), ('589', '553', '585'), ('588', '552', '584'), ('587', '551', '583'), ('586', '550', '582'), ('585', '549', '581'), ('584', '548', '580'), ('583', '547', '579'), ('582', '546', '578'), ('581', '545', '577'), ('580', '544', '576'), ('579', '543', '575'), ('578', '542', '574'), ('577', '541', '573'), ('576', '540', '572'), ('575', '539', '571'), ('574', '538', '570'), ('573', '537', '569'), ('572', '536', '568'), ('571', '535', '567'), ('570', '534', '566'), ('569', '533', '565'), ('568', '532', '564'), ('567', '531', '563'), ('566', '530', '562'), ('565', '529', '561'), ('564', '528', '560'), ('563', '527', '559'), ('562', '526', '558'), ('561', '525', '557'), ('560', '524', '556'), ('559', '523', '555'), ('558', '522', '554'), ('557', '521', '553'), ('556', '520', '552'), ('555', '519', '551'), ('554', '518', '550'), ('553', '517', '549'), ('552', '516', '548'), ('551', '515', '547'), ('550', '514', '546'), ('549', '513', '545'), ('548', '512', '544'), ('547', '511', '543'), ('546', '510', '542'), ('545', '509', '541'), ('544', '508', '540'), ('543', '507', '539'), ('542', '506', '538'), ('541', '505', '537'), ('540', '504', '536'), ('539', '503', '535'), ('538', '502', '534'), ('537', '501', '533'), ('536', '500', '532'), ('535', '499', '531'), ('534', '498', '530'), ('533', '497', '529'), ('532', '496', '528'), ('531', '495', '527'), ('530', '494', '526'), ('529', '493', '525'), ('528', '492', '524'), ('527', '491', '523'), ('526', '490', '522'), ('525', '489', '521'), ('524', '488', '520'), ('523', '487', '519'), ('522', '486', '518'), ('521', '485', '517'), ('520', '484', '516'), ('519', '483', '515'), ('518', '482', '514'), ('517', '481', '513'), ('516', '480', '512'), ('515', '479', '511'), ('514', '478', '510'), ('513', '477', '509'), ('512', '476', '508'), ('511', '475', '507'), ('510', '474', '506'), ('509', '473', '505'), ('508', '472', '504'), ('507', '471', '503'), ('506', '470', '502'), ('505', '469', '501'), ('504', '468', '500'), ('503', '467', '499'), ('502', '466', '498'), ('501', '465', '497');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_dd`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_dd`;
CREATE TABLE `timeofwars_dd` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `DD` enum('0','1') NOT NULL DEFAULT '0',
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_dealer_logs`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_dealer_logs`;
CREATE TABLE `timeofwars_dealer_logs` (
  `id_log` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  `Dealername` varchar(24) NOT NULL DEFAULT '',
  `action` varchar(24) NOT NULL DEFAULT '',
  `UsernameFrom` varchar(24) NOT NULL DEFAULT '',
  `UsernameTo` varchar(24) NOT NULL DEFAULT '',
  `Money` float(10,2) NOT NULL DEFAULT '0.00',
  `descr` text NOT NULL,
  `approved` enum('YES','NO') NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_dealers_log`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_dealers_log`;
CREATE TABLE `timeofwars_dealers_log` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Un_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Log` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_demands`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_demands`;
CREATE TABLE `timeofwars_demands` (
  `id` bigint(25) NOT NULL AUTO_INCREMENT,
  `Username` char(20) NOT NULL DEFAULT '',
  `Add_time` time NOT NULL DEFAULT '00:00:00',
  `Type` enum('1','2','3') NOT NULL DEFAULT '1',
  `Timeout` smallint(6) NOT NULL DEFAULT '0',
  `Name_pr` char(20) DEFAULT NULL,
  `In_battle` enum('0','1') NOT NULL DEFAULT '0',
  `Comment` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1215 DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_demands_2b`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_demands_2b`;
CREATE TABLE `timeofwars_demands_2b` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `battle_id` int(11) NOT NULL,
  `creator_id` smallint(4) unsigned NOT NULL,
  `opponent_id` smallint(4) unsigned NOT NULL,
  `add_time` int(10) NOT NULL,
  `status` set('end','action','wait') NOT NULL DEFAULT 'wait',
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_drinks`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_drinks`;
CREATE TABLE `timeofwars_drinks` (
  `drinkid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `Cost` double unsigned DEFAULT NULL,
  `Stre` int(8) DEFAULT NULL,
  `Agil` int(8) DEFAULT NULL,
  `Intu` int(8) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Alco` int(11) DEFAULT NULL,
  `message` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`drinkid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_drinks`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_drinks` VALUES ('2', 'Кефир (Сила:  +1)', '1', '1', '0', '0', '10', '10', ''), ('4', 'Кружка пива (Сила: +2)', '2', '2', '0', '0', '10', '30', ''), ('5', 'Мартини (С: +3, Л: -1)', '5', '3', '-1', '0', '60', '10', ''), ('6', 'Водка 200гр (С: +1, И: +1)', '10', '1', '0', '1', '5', '100', ''), ('7', 'Виски (С: +3, Л: -2, И: +1)', '20', '3', '-2', '1', '60', '30', '');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_drunk`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_drunk`;
CREATE TABLE `timeofwars_drunk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Stat` varchar(30) NOT NULL DEFAULT '',
  `Num` varchar(30) NOT NULL DEFAULT '',
  `Time` bigint(20) NOT NULL DEFAULT '0',
  `Alco` int(5) DEFAULT '0',
  `turnir` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_elka_reit`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_elka_reit`;
CREATE TABLE `timeofwars_elka_reit` (
  `Username` char(20) NOT NULL,
  `toys` smallint(4) NOT NULL DEFAULT '0',
  `vetki` smallint(4) NOT NULL DEFAULT '0',
  `podarok_for_user` char(20) NOT NULL,
  `podarok_id` mediumint(8) NOT NULL,
  `podarok_comment` char(60) NOT NULL,
  `podarok_from_user` char(20) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_elka_reit_presents`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_elka_reit_presents`;
CREATE TABLE `timeofwars_elka_reit_presents` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `podarok_for_user` char(20) NOT NULL,
  `podarok_id` mediumint(8) NOT NULL,
  `podarok_comment` char(60) NOT NULL,
  `podarok_from_user` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `podarok_for_user` (`podarok_for_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_enter_logs`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_enter_logs`;
CREATE TABLE `timeofwars_enter_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` int(11) unsigned NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  `ip` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Username` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_file_logs`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_file_logs`;
CREATE TABLE `timeofwars_file_logs` (
  `Id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `folder_path` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_first_come`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_first_come`;
CREATE TABLE `timeofwars_first_come` (
  `user_id` mediumint(8) NOT NULL,
  `arena` enum('0','1') NOT NULL DEFAULT '0',
  `pl` enum('0','1') NOT NULL DEFAULT '0',
  `inv` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_forum_answers`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_answers`;
CREATE TABLE `timeofwars_forum_answers` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `add_date` int(11) unsigned NOT NULL,
  `author_id` mediumint(8) unsigned NOT NULL,
  `txt` text NOT NULL,
  `theme_id` mediumint(8) unsigned NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `delete_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_forum_boards`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_boards`;
CREATE TABLE `timeofwars_forum_boards` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `is_it_header` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_forum_boards`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_forum_boards` VALUES ('1', 'Общие форумы:', '1'), ('2', 'Новости проекта', '0'), ('3', 'Пожелания', '0'), ('4', 'Ошибки', '0'), ('5', 'Сделки', '0'), ('6', 'Конкурсы', '0'), ('7', 'Журналистика', '0'), ('8', 'Форумы власти:', '1'), ('9', 'Законы и прайсы', '0'), ('10', 'Отдел Расследований', '0'), ('11', 'Отдел Прокачек', '0'), ('12', 'Отдел Работы с Гильдиями', '0'), ('13', 'Отдел Проверок на Чистоту', '0'), ('14', 'Отдел Жалоб на представителей ', '0'), ('15', 'Закрытый форум Властей', '0'), ('16', 'ЗАГС', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_forum_posts_del`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_posts_del`;
CREATE TABLE `timeofwars_forum_posts_del` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topicid` int(11) NOT NULL,
  `Author` char(30) NOT NULL,
  `msgtext` text NOT NULL,
  `msgdate` int(15) NOT NULL,
  `char` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_forum_redact`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_redact`;
CREATE TABLE `timeofwars_forum_redact` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `add_date` int(11) unsigned NOT NULL,
  `author_id` mediumint(8) unsigned NOT NULL,
  `txt` text NOT NULL,
  `answer_id` mediumint(8) unsigned NOT NULL,
  `type` set('post','theme') DEFAULT 'post',
  `strlen_do` smallint(4) NOT NULL,
  `strlen_posle` smallint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_id` (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_forum_topics`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_topics`;
CREATE TABLE `timeofwars_forum_topics` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `txt` text NOT NULL,
  `board_id` tinyint(3) NOT NULL,
  `is_closed` enum('0','1') NOT NULL DEFAULT '0',
  `is_important` enum('0','1') NOT NULL DEFAULT '0',
  `close_by` varchar(20) DEFAULT NULL,
  `add_date` int(11) unsigned NOT NULL,
  `author_id` mediumint(8) unsigned NOT NULL,
  `is_delete` enum('0','1') NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_forum_topics_del`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_forum_topics_del`;
CREATE TABLE `timeofwars_forum_topics_del` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'thread.gif',
  `isfixed` enum('0','1') NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `author` varchar(20) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `id_forum` int(11) NOT NULL DEFAULT '1',
  `datepost` int(11) NOT NULL,
  `char` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_friendsofuser`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_friendsofuser`;
CREATE TABLE `timeofwars_friendsofuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(25) NOT NULL,
  `loginof` char(25) NOT NULL,
  `is_what` enum('e','f') NOT NULL,
  `reason` char(50) NOT NULL,
  `dateoflogin` char(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_group_demands`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_group_demands`;
CREATE TABLE `timeofwars_group_demands` (
  `Team1` text NOT NULL,
  `Team1_level` text NOT NULL,
  `Team1_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Team2` text,
  `Team2_level` text NOT NULL,
  `Team2_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Add_time` time NOT NULL DEFAULT '00:00:00',
  `Start_time` bigint(20) NOT NULL DEFAULT '0',
  `Type` tinyint(4) NOT NULL DEFAULT '0',
  `Timeout` smallint(6) NOT NULL DEFAULT '0',
  `Comment` varchar(50) DEFAULT NULL,
  `In_battle` enum('0','1') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_hp`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_hp`;
CREATE TABLE `timeofwars_hp` (
  `Username` char(30) NOT NULL,
  `Time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_ilike`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_ilike`;
CREATE TABLE `timeofwars_ilike` (
  `viewer_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`viewer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_inv`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_inv`;
CREATE TABLE `timeofwars_inv` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Type` tinyint(4) NOT NULL DEFAULT '0',
  `Type2` tinyint(4) NOT NULL DEFAULT '0',
  `Type3` mediumint(9) NOT NULL DEFAULT '0',
  `Time` varchar(20) NOT NULL DEFAULT '',
  KEY `user_ind` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_ip`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_ip`;
CREATE TABLE `timeofwars_ip` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Ip` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`Username`),
  KEY `ip_ind` (`Ip`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_karma`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_karma`;
CREATE TABLE `timeofwars_karma` (
  `Username` char(20) NOT NULL DEFAULT '',
  `Count` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_karma_votes`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_karma_votes`;
CREATE TABLE `timeofwars_karma_votes` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Time` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_living_inside`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_living_inside`;
CREATE TABLE `timeofwars_living_inside` (
  `Id` mediumint(9) NOT NULL DEFAULT '0',
  `Username` char(30) NOT NULL,
  PRIMARY KEY (`Username`),
  KEY `Id` (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_living_rooms`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_living_rooms`;
CREATE TABLE `timeofwars_living_rooms` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Cost` mediumint(9) NOT NULL DEFAULT '0',
  `Founder` varchar(30) DEFAULT NULL,
  `Capacity` tinyint(4) NOT NULL DEFAULT '0',
  `Name` varchar(30) DEFAULT NULL,
  `Wallpaper` bigint(20) DEFAULT NULL,
  `Office` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  FULLTEXT KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_living_rooms`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_living_rooms` VALUES ('1', '70', 'Admin', '2', 'admin', null, '0'), ('2', '276', '', '10', '', null, '0'), ('3', '122', '', '9', '', null, '0'), ('4', '87', '', '4', '', null, '0'), ('5', '161', '', '7', '', null, '0'), ('6', '209', '', '1', '', null, '0'), ('7', '65', '', '6', '', null, '0'), ('8', '240', '', '10', '', null, '0'), ('9', '264', '', '10', '', null, '0'), ('10', '127', '', '6', '', null, '0'), ('11', '139', '', '7', '', null, '0'), ('12', '188', '', '9', '', null, '0'), ('13', '329', '', '8', '', null, '0'), ('14', '252', '', '1', '', null, '0'), ('15', '190', '', '5', '', null, '0'), ('16', '89', '', '3', '', null, '0'), ('17', '76', '', '6', '', null, '0'), ('18', '98', '', '7', '', null, '0'), ('19', '277', '', '2', '', null, '0'), ('20', '165', '', '3', '', null, '0'), ('21', '168', '', '7', '', null, '0'), ('22', '126', '', '5', '', null, '0'), ('23', '345', '', '6', '', null, '0'), ('24', '309', '', '8', '', null, '0'), ('25', '266', '', '3', '', null, '0'), ('26', '349', '', '3', '', null, '0'), ('27', '346', '', '1', '', null, '0'), ('28', '220', '', '8', '', null, '0'), ('29', '242', '', '5', '', null, '0'), ('30', '216', '', '6', '', null, '0'), ('31', '142', '', '5', '', null, '0'), ('32', '71', '', '7', '', null, '0'), ('33', '336', '', '8', '', null, '0'), ('34', '158', '', '5', '', null, '0'), ('35', '176', '', '4', '', null, '0'), ('36', '347', '', '2', '', null, '0'), ('37', '236', '', '1', '', null, '0'), ('38', '143', '', '10', '', null, '0'), ('39', '95', '', '8', '', null, '0'), ('40', '147', '', '3', '', null, '0'), ('41', '69', '', '6', '', null, '0'), ('42', '173', '', '4', '', null, '0'), ('43', '204', '', '5', '', null, '0'), ('44', '321', '', '9', '', null, '0'), ('45', '348', '', '9', '', null, '0'), ('46', '101', '', '3', '', null, '0'), ('47', '77', '', '9', '', null, '0'), ('48', '311', '', '4', '', null, '0'), ('49', '253', '', '2', '', null, '0'), ('50', '77', '', '9', '', null, '0'), ('51', '256', '', '3', '', null, '0'), ('52', '333', '', '7', '', null, '0'), ('53', '262', '', '9', '', null, '0'), ('54', '87', '', '9', '', null, '0'), ('55', '238', '', '8', '', null, '0'), ('56', '197', '', '5', '', null, '0'), ('57', '111', '', '4', '', null, '0'), ('58', '297', '', '10', '', null, '0'), ('59', '343', '', '6', '', null, '0'), ('60', '86', '', '10', '', null, '0'), ('61', '288', '', '6', '', null, '0'), ('62', '140', '', '6', '', null, '0'), ('63', '175', '', '5', '', null, '0'), ('64', '154', '', '1', '', null, '0'), ('65', '329', '', '9', '', null, '0'), ('66', '119', '', '1', '', null, '0'), ('67', '78', '', '2', '', null, '0'), ('68', '86', '', '4', '', null, '0'), ('69', '96', '', '10', '', null, '0'), ('70', '167', '', '1', '', null, '0'), ('71', '340', '', '9', '', null, '0'), ('72', '209', '', '7', '', null, '0'), ('73', '237', '', '8', '', null, '0'), ('74', '59', '', '9', '', null, '0'), ('75', '134', '', '5', '', null, '0'), ('76', '88', '', '3', '', null, '0'), ('77', '275', '', '5', '', null, '0'), ('78', '69', '', '5', '', null, '0'), ('79', '148', '', '10', '', null, '0'), ('80', '345', '', '3', '', null, '0'), ('81', '77', '', '10', '', null, '0'), ('82', '296', '', '3', '', null, '0'), ('83', '166', '', '6', '', null, '0'), ('84', '284', '', '6', '', null, '0'), ('85', '67', '', '4', '', null, '0'), ('86', '183', '', '4', '', null, '0'), ('87', '307', '', '10', '', null, '0'), ('88', '305', '', '5', '', null, '0'), ('89', '242', '', '5', '', null, '0'), ('90', '151', '', '9', '', null, '0'), ('91', '342', '', '6', '', null, '0'), ('92', '258', '', '9', '', null, '0'), ('93', '309', '', '9', '', null, '0'), ('94', '100', '', '8', '', null, '0'), ('95', '257', '', '3', '', null, '0'), ('96', '206', '', '6', '', null, '0'), ('97', '170', '', '9', '', null, '0'), ('98', '306', '', '2', '', null, '0'), ('99', '176', '', '4', '', null, '0'), ('100', '129', '', '1', '', null, '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_lock`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_lock`;
CREATE TABLE `timeofwars_lock` (
  `Username` char(30) NOT NULL,
  `locktime` varchar(30) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_logs`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_logs`;
CREATE TABLE `timeofwars_logs` (
  `Id` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `Log` mediumtext NOT NULL,
  `Team1` text NOT NULL,
  `Team2` text NOT NULL,
  `Team_won` enum('0','1','2') NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_mainforum`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_mainforum`;
CREATE TABLE `timeofwars_mainforum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('topic','razdel') NOT NULL DEFAULT 'topic',
  `name` char(50) NOT NULL,
  `about` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_mainforum`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_mainforum` VALUES ('30', 'razdel', 'Общий', ''), ('1', 'topic', 'Обо всем', 'Обсуждение общих вопросов в рамках законов игры.'), ('17', 'topic', 'Творчество', 'Творчество наших пользователей.'), ('18', 'topic', 'Сделки', 'Хотите заключить сделку?'), ('19', 'topic', 'Конкурсы и турниры', 'Различные конкурсы и турниры.'), ('20', 'topic', 'Совет Хранителей', 'Обсуждение проектов Хранителей'), ('21', 'razdel', 'Администрация', ''), ('22', 'topic', 'Баги', 'Нашли ошибку? Тогда вам сюда.'), ('23', 'topic', 'Новости', 'Актуальные и срочные новости.'), ('24', 'topic', 'Работа', 'Предложения и вакансии от администрации проекта.'), ('25', 'topic', 'Жалобы', 'Для всех обиженных.'), ('26', 'topic', 'Предложения', 'Предложения по улучшению проекта.'), ('27', 'razdel', 'Прочее', ''), ('28', 'topic', 'Кланы', 'Обсуждение кланов и все что с ними связано.'), ('29', 'topic', 'Дилерский форум', 'Все что связано с оным.');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_map`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_map`;
CREATE TABLE `timeofwars_map` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `x` int(2) NOT NULL DEFAULT '0',
  `y` int(2) NOT NULL DEFAULT '0',
  `url` varchar(20) NOT NULL DEFAULT '',
  `acses` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `acses` (`acses`)
) ENGINE=MyISAM AUTO_INCREMENT=1327 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_map`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_map` VALUES ('1', '1', '1', 'x1y1.jpg', '0'), ('2', '2', '1', 'x2y1.jpg', '0'), ('3', '3', '1', 'x3y1.jpg', '0'), ('4', '4', '1', 'x4y1.jpg', '0'), ('5', '5', '1', 'x5y1.jpg', '0'), ('6', '6', '1', 'x6y1.jpg', '0'), ('7', '7', '1', 'x7y1.jpg', '0'), ('8', '8', '1', 'x8y1.jpg', '0'), ('9', '9', '1', 'x9y1.jpg', '0'), ('10', '10', '1', 'x10y1.jpg', '0'), ('11', '11', '1', 'x11y1.jpg', '0'), ('12', '12', '1', 'x12y1.jpg', '0'), ('13', '13', '1', 'x13y1.jpg', '0'), ('14', '14', '1', 'x14y1.jpg', '0'), ('15', '15', '1', 'x15y1.jpg', '0'), ('16', '16', '1', 'x16y1.jpg', '0'), ('17', '17', '1', 'x17y1.jpg', '0'), ('18', '18', '1', 'x18y1.jpg', '0'), ('19', '19', '1', 'x19y1.jpg', '0'), ('20', '20', '1', 'x20y1.jpg', '0'), ('21', '21', '1', 'x21y1.jpg', '0'), ('22', '22', '1', 'x22y1.jpg', '0'), ('23', '23', '1', 'x23y1.jpg', '0'), ('24', '24', '1', 'x24y1.jpg', '0'), ('25', '25', '1', 'x25y1.jpg', '0'), ('26', '26', '1', 'x26y1.jpg', '0'), ('27', '27', '1', 'x27y1.jpg', '0'), ('28', '28', '1', 'x28y1.jpg', '0'), ('29', '29', '1', 'x29y1.jpg', '0'), ('30', '30', '1', 'x30y1.jpg', '0'), ('31', '31', '1', 'x31y1.jpg', '0'), ('32', '32', '1', 'x32y1.jpg', '0'), ('33', '33', '1', 'x33y1.jpg', '0'), ('34', '34', '1', 'x34y1.jpg', '0'), ('35', '35', '1', 'x35y1.jpg', '0'), ('36', '36', '1', 'x36y1.jpg', '0'), ('37', '37', '1', 'x37y1.jpg', '0'), ('38', '38', '1', 'x38y1.jpg', '0'), ('39', '39', '1', 'x39y1.jpg', '0'), ('40', '40', '1', 'x40y1.jpg', '0'), ('41', '41', '1', 'x41y1.jpg', '0'), ('42', '42', '1', 'x42y1.jpg', '0'), ('43', '43', '1', 'x43y1.jpg', '0'), ('44', '44', '1', 'x44y1.jpg', '0'), ('45', '45', '1', 'x45y1.jpg', '0'), ('46', '46', '1', 'x46y1.jpg', '0'), ('47', '47', '1', 'x47y1.jpg', '0'), ('48', '48', '1', 'x48y1.jpg', '0'), ('49', '49', '1', 'x49y1.jpg', '0'), ('50', '50', '1', 'x50y1.jpg', '0'), ('51', '51', '1', 'x51y1.jpg', '0'), ('52', '1', '2', 'x1y2.jpg', '0'), ('53', '2', '2', 'x2y2.jpg', '0'), ('54', '3', '2', 'x3y2.jpg', '1'), ('55', '4', '2', 'x4y2.jpg', '1'), ('56', '5', '2', 'x5y2.jpg', '0'), ('57', '6', '2', 'x6y2.jpg', '1'), ('58', '7', '2', 'x7y2.jpg', '1'), ('59', '8', '2', 'x8y2.jpg', '1'), ('60', '9', '2', 'x9y2.jpg', '1'), ('61', '10', '2', 'x10y2.jpg', '1'), ('62', '11', '2', 'x11y2.jpg', '1'), ('63', '12', '2', 'x12y2.jpg', '1'), ('64', '13', '2', 'x13y2.jpg', '1'), ('65', '14', '2', 'x14y2.jpg', '1'), ('66', '15', '2', 'x15y2.jpg', '1'), ('67', '16', '2', 'x16y2.jpg', '1'), ('68', '17', '2', 'x17y2.jpg', '1'), ('69', '18', '2', 'x18y2.jpg', '1'), ('70', '19', '2', 'x19y2.jpg', '1'), ('71', '20', '2', 'x20y2.jpg', '1'), ('72', '21', '2', 'x21y2.jpg', '1'), ('73', '22', '2', 'x22y2.jpg', '1'), ('74', '23', '2', 'x23y2.jpg', '1'), ('75', '24', '2', 'x24y2.jpg', '1'), ('76', '25', '2', 'x25y2.jpg', '1'), ('77', '26', '2', 'x26y2.jpg', '1'), ('78', '27', '2', 'x27y2.jpg', '1'), ('79', '28', '2', 'x28y2.jpg', '1'), ('80', '29', '2', 'x29y2.jpg', '1'), ('81', '30', '2', 'x30y2.jpg', '1'), ('82', '31', '2', 'x31y2.jpg', '1'), ('83', '32', '2', 'x32y2.jpg', '1'), ('84', '33', '2', 'x33y2.jpg', '1'), ('85', '34', '2', 'x34y2.jpg', '1'), ('86', '35', '2', 'x35y2.jpg', '1'), ('87', '36', '2', 'x36y2.jpg', '1'), ('88', '37', '2', 'x37y2.jpg', '1'), ('89', '38', '2', 'x38y2.jpg', '1'), ('90', '39', '2', 'x39y2.jpg', '1'), ('91', '40', '2', 'x40y2.jpg', '1'), ('92', '41', '2', 'x41y2.jpg', '1'), ('93', '42', '2', 'x42y2.jpg', '1'), ('94', '43', '2', 'x43y2.jpg', '1'), ('95', '44', '2', 'x44y2.jpg', '1'), ('96', '45', '2', 'x45y2.jpg', '1'), ('97', '46', '2', 'x46y2.jpg', '1'), ('98', '47', '2', 'x47y2.jpg', '1'), ('99', '48', '2', 'x48y2.jpg', '1'), ('100', '49', '2', 'x49y2.jpg', '1'), ('101', '50', '2', 'x50y2.jpg', '1'), ('102', '51', '2', 'x51y2.jpg', '1'), ('103', '1', '3', 'x1y3.jpg', '0'), ('104', '2', '3', 'x2y3.jpg', '0'), ('105', '3', '3', 'x3y3.jpg', '1'), ('106', '4', '3', 'x4y3.jpg', '1'), ('107', '5', '3', 'x5y3.jpg', '0'), ('108', '6', '3', 'x6y3.jpg', '1'), ('109', '7', '3', 'x7y3.jpg', '1'), ('110', '8', '3', 'x8y3.jpg', '1'), ('111', '9', '3', 'x9y3.jpg', '1'), ('112', '10', '3', 'x10y3.jpg', '1'), ('113', '11', '3', 'x11y3.jpg', '1'), ('114', '12', '3', 'x12y3.jpg', '0'), ('115', '13', '3', 'x13y3.jpg', '1'), ('116', '14', '3', 'x14y3.jpg', '1'), ('117', '15', '3', 'x15y3.jpg', '0'), ('118', '16', '3', 'x16y3.jpg', '0'), ('119', '17', '3', 'x17y3.jpg', '0'), ('120', '18', '3', 'x18y3.jpg', '0'), ('121', '19', '3', 'x19y3.jpg', '0'), ('122', '20', '3', 'x20y3.jpg', '0'), ('123', '21', '3', 'x21y3.jpg', '0'), ('124', '22', '3', 'x22y3.jpg', '0'), ('125', '23', '3', 'x23y3.jpg', '1'), ('126', '24', '3', 'x24y3.jpg', '1'), ('127', '25', '3', 'x25y3.jpg', '0'), ('128', '26', '3', 'x26y3.jpg', '0'), ('129', '27', '3', 'x27y3.jpg', '0'), ('130', '28', '3', 'x28y3.jpg', '0'), ('131', '29', '3', 'x29y3.jpg', '0'), ('132', '30', '3', 'x30y3.jpg', '1'), ('133', '31', '3', 'x31y3.jpg', '1'), ('134', '32', '3', 'x32y3.jpg', '0'), ('135', '33', '3', 'x33y3.jpg', '0'), ('136', '34', '3', 'x34y3.jpg', '0'), ('137', '35', '3', 'x35y3.jpg', '1'), ('138', '36', '3', 'x36y3.jpg', '1'), ('139', '37', '3', 'x37y3.jpg', '1'), ('140', '38', '3', 'x38y3.jpg', '1'), ('141', '39', '3', 'x39y3.jpg', '1'), ('142', '40', '3', 'x40y3.jpg', '1'), ('143', '41', '3', 'x41y3.jpg', '1'), ('144', '42', '3', 'x42y3.jpg', '1'), ('145', '43', '3', 'x43y3.jpg', '0'), ('146', '44', '3', 'x44y3.jpg', '0'), ('147', '45', '3', 'x45y3.jpg', '0'), ('148', '46', '3', 'x46y3.jpg', '1'), ('149', '47', '3', 'x47y3.jpg', '1'), ('150', '48', '3', 'x48y3.jpg', '1'), ('151', '49', '3', 'x49y3.jpg', '1'), ('152', '50', '3', 'x50y3.jpg', '1'), ('153', '51', '3', 'x51y3.jpg', '1'), ('154', '1', '4', 'x1y4.jpg', '0'), ('155', '2', '4', 'x2y4.jpg', '0'), ('156', '3', '4', 'x3y4.jpg', '1'), ('157', '4', '4', 'x4y4.jpg', '1'), ('158', '5', '4', 'x5y4.jpg', '1'), ('159', '6', '4', 'x6y4.jpg', '1'), ('160', '7', '4', 'x7y4.jpg', '1'), ('161', '8', '4', 'x8y4.jpg', '1'), ('162', '9', '4', 'x9y4.jpg', '1'), ('163', '10', '4', 'x10y4.jpg', '1'), ('164', '11', '4', 'x11y4.jpg', '0'), ('165', '12', '4', 'x12y4.jpg', '0'), ('166', '13', '4', 'x13y4.jpg', '0'), ('167', '14', '4', 'x14y4.jpg', '0'), ('168', '15', '4', 'x15y4.jpg', '0'), ('169', '16', '4', 'x16y4.jpg', '0'), ('170', '17', '4', 'x17y4.jpg', '0'), ('171', '18', '4', 'x18y4.jpg', '0'), ('172', '19', '4', 'x19y4.jpg', '0'), ('173', '20', '4', 'x20y4.jpg', '0'), ('174', '21', '4', 'x21y4.jpg', '0'), ('175', '22', '4', 'x22y4.jpg', '0'), ('176', '23', '4', 'x23y4.jpg', '0'), ('177', '24', '4', 'x24y4.jpg', '0'), ('178', '25', '4', 'x25y4.jpg', '0'), ('179', '26', '4', 'x26y4.jpg', '0'), ('180', '27', '4', 'x27y4.jpg', '0'), ('181', '28', '4', 'x28y4.jpg', '0'), ('182', '29', '4', 'x29y4.jpg', '0'), ('183', '30', '4', 'x30y4.jpg', '0'), ('184', '31', '4', 'x31y4.jpg', '0'), ('185', '32', '4', 'x32y4.jpg', '0'), ('186', '33', '4', 'x33y4.jpg', '0'), ('187', '34', '4', 'x34y4.jpg', '0'), ('188', '35', '4', 'x35y4.jpg', '0'), ('189', '36', '4', 'x36y4.jpg', '0'), ('190', '37', '4', 'x37y4.jpg', '0'), ('191', '38', '4', 'x38y4.jpg', '1'), ('192', '39', '4', 'x39y4.jpg', '1'), ('193', '40', '4', 'x40y4.jpg', '1'), ('194', '41', '4', 'x41y4.jpg', '0'), ('195', '42', '4', 'x42y4.jpg', '0'), ('196', '43', '4', 'x43y4.jpg', '0'), ('197', '44', '4', 'x44y4.jpg', '0'), ('198', '45', '4', 'x45y4.jpg', '0'), ('199', '46', '4', 'x46y4.jpg', '0'), ('200', '47', '4', 'x47y4.jpg', '0'), ('201', '48', '4', 'x48y4.jpg', '0'), ('202', '49', '4', 'x49y4.jpg', '1'), ('203', '50', '4', 'x50y4.jpg', '1'), ('204', '51', '4', 'x51y4.jpg', '1'), ('205', '1', '5', 'x1y5.jpg', '0'), ('206', '2', '5', 'x2y5.jpg', '0'), ('207', '3', '5', 'x3y5.jpg', '1'), ('208', '4', '5', 'x4y5.jpg', '1'), ('209', '5', '5', 'x5y5.jpg', '1'), ('210', '6', '5', 'x6y5.jpg', '1'), ('211', '7', '5', 'x7y5.jpg', '1'), ('212', '8', '5', 'x8y5.jpg', '1'), ('213', '9', '5', 'x9y5.jpg', '1'), ('214', '10', '5', 'x10y5.jpg', '1'), ('215', '11', '5', 'x11y5.jpg', '1'), ('216', '12', '5', 'x12y5.jpg', '1'), ('217', '13', '5', 'x13y5.jpg', '0'), ('218', '14', '5', 'x14y5.jpg', '0'), ('219', '15', '5', 'x15y5.jpg', '0'), ('220', '16', '5', 'x16y5.jpg', '0'), ('221', '17', '5', 'x17y5.jpg', '0'), ('222', '18', '5', 'x18y5.jpg', '0'), ('223', '19', '5', 'x19y5.jpg', '0'), ('224', '20', '5', 'x20y5.jpg', '0'), ('225', '21', '5', 'x21y5.jpg', '0'), ('226', '22', '5', 'x22y5.jpg', '0'), ('227', '23', '5', 'x23y5.jpg', '0'), ('228', '24', '5', 'x24y5.jpg', '0'), ('229', '25', '5', 'x25y5.jpg', '0'), ('230', '26', '5', 'x26y5.jpg', '0'), ('231', '27', '5', 'x27y5.jpg', '0'), ('232', '28', '5', 'x28y5.jpg', '0'), ('233', '29', '5', 'x29y5.jpg', '0'), ('234', '30', '5', 'x30y5.jpg', '0'), ('235', '31', '5', 'x31y5.jpg', '0'), ('236', '32', '5', 'x32y5.jpg', '0'), ('237', '33', '5', 'x33y5.jpg', '0'), ('238', '34', '5', 'x34y5.jpg', '0'), ('239', '35', '5', 'x35y5.jpg', '0'), ('240', '36', '5', 'x36y5.jpg', '0'), ('241', '37', '5', 'x37y5.jpg', '0'), ('242', '38', '5', 'x38y5.jpg', '0'), ('243', '39', '5', 'x39y5.jpg', '0'), ('244', '40', '5', 'x40y5.jpg', '0'), ('245', '41', '5', 'x41y5.jpg', '0'), ('246', '42', '5', 'x42y5.jpg', '0'), ('247', '43', '5', 'x43y5.jpg', '0'), ('248', '44', '5', 'x44y5.jpg', '0'), ('249', '45', '5', 'x45y5.jpg', '0'), ('250', '46', '5', 'x46y5.jpg', '0'), ('251', '47', '5', 'x47y5.jpg', '0'), ('252', '48', '5', 'x48y5.jpg', '0'), ('253', '49', '5', 'x49y5.jpg', '1'), ('254', '50', '5', 'x50y5.jpg', '1'), ('255', '51', '5', 'x51y5.jpg', '1'), ('256', '1', '6', 'x1y6.jpg', '0'), ('257', '2', '6', 'x2y6.jpg', '0'), ('258', '3', '6', 'x3y6.jpg', '1'), ('259', '4', '6', 'x4y6.jpg', '1'), ('260', '5', '6', 'x5y6.jpg', '1'), ('261', '6', '6', 'x6y6.jpg', '1'), ('262', '7', '6', 'x7y6.jpg', '1'), ('263', '8', '6', 'x8y6.jpg', '1'), ('264', '9', '6', 'x9y6.jpg', '1'), ('265', '10', '6', 'x10y6.jpg', '1'), ('266', '11', '6', 'x11y6.jpg', '1'), ('267', '12', '6', 'x12y6.jpg', '1'), ('268', '13', '6', 'x13y6.jpg', '0'), ('269', '14', '6', 'x14y6.jpg', '0'), ('270', '15', '6', 'x15y6.jpg', '0'), ('271', '16', '6', 'x16y6.jpg', '0'), ('272', '17', '6', 'x17y6.jpg', '0'), ('273', '18', '6', 'x18y6.jpg', '0'), ('274', '19', '6', 'x19y6.jpg', '0'), ('275', '20', '6', 'x20y6.jpg', '0'), ('276', '21', '6', 'x21y6.jpg', '0'), ('277', '22', '6', 'x22y6.jpg', '0'), ('278', '23', '6', 'x23y6.jpg', '0'), ('279', '24', '6', 'x24y6.jpg', '0'), ('280', '25', '6', 'x25y6.jpg', '0'), ('281', '26', '6', 'x26y6.jpg', '0'), ('282', '27', '6', 'x27y6.jpg', '0'), ('283', '28', '6', 'x28y6.jpg', '0'), ('284', '29', '6', 'x29y6.jpg', '0'), ('285', '30', '6', 'x30y6.jpg', '0'), ('286', '31', '6', 'x31y6.jpg', '0'), ('287', '32', '6', 'x32y6.jpg', '0'), ('288', '33', '6', 'x33y6.jpg', '0'), ('289', '34', '6', 'x34y6.jpg', '0'), ('290', '35', '6', 'x35y6.jpg', '0'), ('291', '36', '6', 'x36y6.jpg', '0'), ('292', '37', '6', 'x37y6.jpg', '0'), ('293', '38', '6', 'x38y6.jpg', '0'), ('294', '39', '6', 'x39y6.jpg', '0'), ('295', '40', '6', 'x40y6.jpg', '0'), ('296', '41', '6', 'x41y6.jpg', '0'), ('297', '42', '6', 'x42y6.jpg', '0'), ('298', '43', '6', 'x43y6.jpg', '0'), ('299', '44', '6', 'x44y6.jpg', '0'), ('300', '45', '6', 'x45y6.jpg', '0'), ('301', '46', '6', 'x46y6.jpg', '0'), ('302', '47', '6', 'x47y6.jpg', '1'), ('303', '48', '6', 'x48y6.jpg', '1'), ('304', '49', '6', 'x49y6.jpg', '1'), ('305', '50', '6', 'x50y6.jpg', '1'), ('306', '51', '6', 'x51y6.jpg', '1'), ('307', '1', '7', 'x1y7.jpg', '0'), ('308', '2', '7', 'x2y7.jpg', '0'), ('309', '3', '7', 'x3y7.jpg', '1'), ('310', '4', '7', 'x4y7.jpg', '1'), ('311', '5', '7', 'x5y7.jpg', '1'), ('312', '6', '7', 'x6y7.jpg', '0'), ('313', '7', '7', 'x7y7.jpg', '0'), ('314', '8', '7', 'x8y7.jpg', '0'), ('315', '9', '7', 'x9y7.jpg', '0'), ('316', '10', '7', 'x10y7.jpg', '0'), ('317', '11', '7', 'x11y7.jpg', '1'), ('318', '12', '7', 'x12y7.jpg', '0'), ('319', '13', '7', 'x13y7.jpg', '0'), ('320', '14', '7', 'x14y7.jpg', '0'), ('321', '15', '7', 'x15y7.jpg', '0'), ('322', '16', '7', 'x16y7.jpg', '0'), ('323', '17', '7', 'x17y7.jpg', '0'), ('324', '18', '7', 'x18y7.jpg', '0'), ('325', '19', '7', 'x19y7.jpg', '0'), ('326', '20', '7', 'x20y7.jpg', '0'), ('327', '21', '7', 'x21y7.jpg', '0'), ('328', '22', '7', 'x22y7.jpg', '0'), ('329', '23', '7', 'x23y7.jpg', '0'), ('330', '24', '7', 'x24y7.jpg', '0'), ('331', '25', '7', 'x25y7.jpg', '0'), ('332', '26', '7', 'x26y7.jpg', '0'), ('333', '27', '7', 'x27y7.jpg', '0'), ('334', '28', '7', 'x28y7.jpg', '0'), ('335', '29', '7', 'x29y7.jpg', '0'), ('336', '30', '7', 'x30y7.jpg', '0'), ('337', '31', '7', 'x31y7.jpg', '0'), ('338', '32', '7', 'x32y7.jpg', '0'), ('339', '33', '7', 'x33y7.jpg', '0'), ('340', '34', '7', 'x34y7.jpg', '0'), ('341', '35', '7', 'x35y7.jpg', '0'), ('342', '36', '7', 'x36y7.jpg', '0'), ('343', '37', '7', 'x37y7.jpg', '0'), ('344', '38', '7', 'x38y7.jpg', '0'), ('345', '39', '7', 'x39y7.jpg', '0'), ('346', '40', '7', 'x40y7.jpg', '0'), ('347', '41', '7', 'x41y7.jpg', '0'), ('348', '42', '7', 'x42y7.jpg', '0'), ('349', '43', '7', 'x43y7.jpg', '0'), ('350', '44', '7', 'x44y7.jpg', '0'), ('351', '45', '7', 'x45y7.jpg', '0'), ('352', '46', '7', 'x46y7.jpg', '0'), ('353', '47', '7', 'x47y7.jpg', '1'), ('354', '48', '7', 'x48y7.jpg', '1'), ('355', '49', '7', 'x49y7.jpg', '1'), ('356', '50', '7', 'x50y7.jpg', '1'), ('357', '51', '7', 'x51y7.jpg', '1'), ('358', '1', '8', 'x1y8.jpg', '0'), ('359', '2', '8', 'x2y8.jpg', '0'), ('360', '3', '8', 'x3y8.jpg', '1'), ('361', '4', '8', 'x4y8.jpg', '1'), ('362', '5', '8', 'x5y8.jpg', '1'), ('363', '6', '8', 'x6y8.jpg', '1'), ('364', '7', '8', 'x7y8.jpg', '0'), ('365', '8', '8', 'x8y8.jpg', '0'), ('366', '9', '8', 'x9y8.jpg', '0'), ('367', '10', '8', 'x10y8.jpg', '0'), ('368', '11', '8', 'x11y8.jpg', '0'), ('369', '12', '8', 'x12y8.jpg', '0'), ('370', '13', '8', 'x13y8.jpg', '0'), ('371', '14', '8', 'x14y8.jpg', '0'), ('372', '15', '8', 'x15y8.jpg', '0'), ('373', '16', '8', 'x16y8.jpg', '0'), ('374', '17', '8', 'x17y8.jpg', '0'), ('375', '18', '8', 'x18y8.jpg', '0'), ('376', '19', '8', 'x19y8.jpg', '0'), ('377', '20', '8', 'x20y8.jpg', '0'), ('378', '21', '8', 'x21y8.jpg', '0'), ('379', '22', '8', 'x22y8.jpg', '0'), ('380', '23', '8', 'x23y8.jpg', '0'), ('381', '24', '8', 'x24y8.jpg', '0'), ('382', '25', '8', 'x25y8.jpg', '0'), ('383', '26', '8', 'x26y8.jpg', '0'), ('384', '27', '8', 'x27y8.jpg', '0'), ('385', '28', '8', 'x28y8.jpg', '0'), ('386', '29', '8', 'x29y8.jpg', '0'), ('387', '30', '8', 'x30y8.jpg', '0'), ('388', '31', '8', 'x31y8.jpg', '0'), ('389', '32', '8', 'x32y8.jpg', '0'), ('390', '33', '8', 'x33y8.jpg', '0'), ('391', '34', '8', 'x34y8.jpg', '0'), ('392', '35', '8', 'x35y8.jpg', '0'), ('393', '36', '8', 'x36y8.jpg', '0'), ('394', '37', '8', 'x37y8.jpg', '0'), ('395', '38', '8', 'x38y8.jpg', '0'), ('396', '39', '8', 'x39y8.jpg', '0'), ('397', '40', '8', 'x40y8.jpg', '0'), ('398', '41', '8', 'x41y8.jpg', '0'), ('399', '42', '8', 'x42y8.jpg', '0'), ('400', '43', '8', 'x43y8.jpg', '0'), ('401', '44', '8', 'x44y8.jpg', '0'), ('402', '45', '8', 'x45y8.jpg', '0'), ('403', '46', '8', 'x46y8.jpg', '0'), ('404', '47', '8', 'x47y8.jpg', '0'), ('405', '48', '8', 'x48y8.jpg', '1'), ('406', '49', '8', 'x49y8.jpg', '1'), ('407', '50', '8', 'x50y8.jpg', '1'), ('408', '51', '8', 'x51y8.jpg', '0'), ('409', '1', '9', 'x1y9.jpg', '0'), ('410', '2', '9', 'x2y9.jpg', '0'), ('411', '3', '9', 'x3y9.jpg', '1'), ('412', '4', '9', 'x4y9.jpg', '1'), ('413', '5', '9', 'x5y9.jpg', '1'), ('414', '6', '9', 'x6y9.jpg', '1'), ('415', '7', '9', 'x7y9.jpg', '0'), ('416', '8', '9', 'x8y9.jpg', '0'), ('417', '9', '9', 'x9y9.jpg', '0'), ('418', '10', '9', 'x10y9.jpg', '0'), ('419', '11', '9', 'x11y9.jpg', '0'), ('420', '12', '9', 'x12y9.jpg', '0'), ('421', '13', '9', 'x13y9.jpg', '0'), ('422', '14', '9', 'x14y9.jpg', '0'), ('423', '15', '9', 'x15y9.jpg', '0'), ('424', '16', '9', 'x16y9.jpg', '0'), ('425', '17', '9', 'x17y9.jpg', '0'), ('426', '18', '9', 'x18y9.jpg', '0'), ('427', '19', '9', 'x19y9.jpg', '0'), ('428', '20', '9', 'x20y9.jpg', '0'), ('429', '21', '9', 'x21y9.jpg', '0'), ('430', '22', '9', 'x22y9.jpg', '0'), ('431', '23', '9', 'x23y9.jpg', '0'), ('432', '24', '9', 'x24y9.jpg', '0'), ('433', '25', '9', 'x25y9.jpg', '0'), ('434', '26', '9', 'x26y9.jpg', '0'), ('435', '27', '9', 'x27y9.jpg', '0'), ('436', '28', '9', 'x28y9.jpg', '0'), ('437', '29', '9', 'x29y9.jpg', '0'), ('438', '30', '9', 'x30y9.jpg', '0'), ('439', '31', '9', 'x31y9.jpg', '0'), ('440', '32', '9', 'x32y9.jpg', '0'), ('441', '33', '9', 'x33y9.jpg', '0'), ('442', '34', '9', 'x34y9.jpg', '0'), ('443', '35', '9', 'x35y9.jpg', '0'), ('444', '36', '9', 'x36y9.jpg', '0'), ('445', '37', '9', 'x37y9.jpg', '0'), ('446', '38', '9', 'x38y9.jpg', '0'), ('447', '39', '9', 'x39y9.jpg', '0'), ('448', '40', '9', 'x40y9.jpg', '0'), ('449', '41', '9', 'x41y9.jpg', '0'), ('450', '42', '9', 'x42y9.jpg', '0'), ('451', '43', '9', 'x43y9.jpg', '0'), ('452', '44', '9', 'x44y9.jpg', '0'), ('453', '45', '9', 'x45y9.jpg', '0'), ('454', '46', '9', 'x46y9.jpg', '0'), ('455', '47', '9', 'x47y9.jpg', '0'), ('456', '48', '9', 'x48y9.jpg', '1'), ('457', '49', '9', 'x49y9.jpg', '1'), ('458', '50', '9', 'x50y9.jpg', '1'), ('459', '51', '9', 'x51y9.jpg', '1'), ('460', '1', '10', 'x1y10.jpg', '0'), ('461', '2', '10', 'x2y10.jpg', '0'), ('462', '3', '10', 'x3y10.jpg', '0'), ('463', '4', '10', 'x4y10.jpg', '0'), ('464', '5', '10', 'x5y10.jpg', '0'), ('465', '6', '10', 'x6y10.jpg', '0'), ('466', '7', '10', 'x7y10.jpg', '0'), ('467', '8', '10', 'x8y10.jpg', '0'), ('468', '9', '10', 'x9y10.jpg', '0'), ('469', '10', '10', 'x10y10.jpg', '0'), ('470', '11', '10', 'x11y10.jpg', '0'), ('471', '12', '10', 'x12y10.jpg', '0'), ('472', '13', '10', 'x13y10.jpg', '0'), ('473', '14', '10', 'x14y10.jpg', '0'), ('474', '15', '10', 'x15y10.jpg', '0'), ('475', '16', '10', 'x16y10.jpg', '0'), ('476', '17', '10', 'x17y10.jpg', '0'), ('477', '18', '10', 'x18y10.jpg', '0'), ('478', '19', '10', 'x19y10.jpg', '0'), ('479', '20', '10', 'x20y10.jpg', '0'), ('480', '21', '10', 'x21y10.jpg', '0'), ('481', '22', '10', 'x22y10.jpg', '0'), ('482', '23', '10', 'x23y10.jpg', '0'), ('483', '24', '10', 'x24y10.jpg', '0'), ('484', '25', '10', 'x25y10.jpg', '0'), ('485', '26', '10', 'x26y10.jpg', '0'), ('486', '27', '10', 'x27y10.jpg', '0'), ('487', '28', '10', 'x28y10.jpg', '0'), ('488', '29', '10', 'x29y10.jpg', '0'), ('489', '30', '10', 'x30y10.jpg', '0'), ('490', '31', '10', 'x31y10.jpg', '0'), ('491', '32', '10', 'x32y10.jpg', '0'), ('492', '33', '10', 'x33y10.jpg', '0'), ('493', '34', '10', 'x34y10.jpg', '0'), ('494', '35', '10', 'x35y10.jpg', '0'), ('495', '36', '10', 'x36y10.jpg', '0'), ('496', '37', '10', 'x37y10.jpg', '0'), ('497', '38', '10', 'x38y10.jpg', '0'), ('498', '39', '10', 'x39y10.jpg', '0'), ('499', '40', '10', 'x40y10.jpg', '0'), ('500', '41', '10', 'x41y10.jpg', '1'), ('501', '42', '10', 'x42y10.jpg', '0'), ('502', '43', '10', 'x43y10.jpg', '0'), ('503', '44', '10', 'x44y10.jpg', '0'), ('504', '45', '10', 'x45y10.jpg', '0'), ('505', '46', '10', 'x46y10.jpg', '0'), ('506', '47', '10', 'x47y10.jpg', '1'), ('507', '48', '10', 'x48y10.jpg', '1'), ('508', '49', '10', 'x49y10.jpg', '1'), ('509', '50', '10', 'x50y10.jpg', '1'), ('510', '51', '10', 'x51y10.jpg', '1'), ('511', '1', '11', 'x1y11.jpg', '0'), ('512', '2', '11', 'x2y11.jpg', '0'), ('513', '3', '11', 'x3y11.jpg', '0'), ('514', '4', '11', 'x4y11.jpg', '1'), ('515', '5', '11', 'x5y11.jpg', '1'), ('516', '6', '11', 'x6y11.jpg', '0'), ('517', '7', '11', 'x7y11.jpg', '0'), ('518', '8', '11', 'x8y11.jpg', '0'), ('519', '9', '11', 'x9y11.jpg', '0'), ('520', '10', '11', 'x10y11.jpg', '0'), ('521', '11', '11', 'x11y11.jpg', '0'), ('522', '12', '11', 'x12y11.jpg', '0'), ('523', '13', '11', 'x13y11.jpg', '0'), ('524', '14', '11', 'x14y11.jpg', '0'), ('525', '15', '11', 'x15y11.jpg', '0'), ('526', '16', '11', 'x16y11.jpg', '0'), ('527', '17', '11', 'x17y11.jpg', '0'), ('528', '18', '11', 'x18y11.jpg', '0'), ('529', '19', '11', 'x19y11.jpg', '0'), ('530', '20', '11', 'x20y11.jpg', '0'), ('531', '21', '11', 'x21y11.jpg', '0'), ('532', '22', '11', 'x22y11.jpg', '0'), ('533', '23', '11', 'x23y11.jpg', '0'), ('534', '24', '11', 'x24y11.jpg', '0'), ('535', '25', '11', 'x25y11.jpg', '0'), ('536', '26', '11', 'x26y11.jpg', '0'), ('537', '27', '11', 'x27y11.jpg', '0'), ('538', '28', '11', 'x28y11.jpg', '0'), ('539', '29', '11', 'x29y11.jpg', '0'), ('540', '30', '11', 'x30y11.jpg', '0'), ('541', '31', '11', 'x31y11.jpg', '0'), ('542', '32', '11', 'x32y11.jpg', '0'), ('543', '33', '11', 'x33y11.jpg', '0'), ('544', '34', '11', 'x34y11.jpg', '0'), ('545', '35', '11', 'x35y11.jpg', '0'), ('546', '36', '11', 'x36y11.jpg', '0'), ('547', '37', '11', 'x37y11.jpg', '0'), ('548', '38', '11', 'x38y11.jpg', '0'), ('549', '39', '11', 'x39y11.jpg', '0'), ('550', '40', '11', 'x40y11.jpg', '0'), ('551', '41', '11', 'x41y11.jpg', '1'), ('552', '42', '11', 'x42y11.jpg', '1'), ('553', '43', '11', 'x43y11.jpg', '1'), ('554', '44', '11', 'x44y11.jpg', '1'), ('555', '45', '11', 'x45y11.jpg', '1'), ('556', '46', '11', 'x46y11.jpg', '0'), ('557', '47', '11', 'x47y11.jpg', '1'), ('558', '48', '11', 'x48y11.jpg', '1'), ('559', '49', '11', 'x49y11.jpg', '1'), ('560', '50', '11', 'x50y11.jpg', '1'), ('561', '51', '11', 'x51y11.jpg', '1'), ('562', '1', '12', 'x1y12.jpg', '0'), ('563', '2', '12', 'x2y12.jpg', '0'), ('564', '3', '12', 'x3y12.jpg', '1'), ('565', '4', '12', 'x4y12.jpg', '1'), ('566', '5', '12', 'x5y12.jpg', '1'), ('567', '6', '12', 'x6y12.jpg', '0'), ('568', '7', '12', 'x7y12.jpg', '0'), ('569', '8', '12', 'x8y12.jpg', '0'), ('570', '9', '12', 'x9y12.jpg', '0'), ('571', '10', '12', 'x10y12.jpg', '0'), ('572', '11', '12', 'x11y12.jpg', '0'), ('573', '12', '12', 'x12y12.jpg', '0'), ('574', '13', '12', 'x13y12.jpg', '0'), ('575', '14', '12', 'x14y12.jpg', '0'), ('576', '15', '12', 'x15y12.jpg', '0'), ('577', '16', '12', 'x16y12.jpg', '0'), ('578', '17', '12', 'x17y12.jpg', '0'), ('579', '18', '12', 'x18y12.jpg', '0'), ('580', '19', '12', 'x19y12.jpg', '0'), ('581', '20', '12', 'x20y12.jpg', '0'), ('582', '21', '12', 'x21y12.jpg', '0'), ('583', '22', '12', 'x22y12.jpg', '0'), ('584', '23', '12', 'x23y12.jpg', '0'), ('585', '24', '12', 'x24y12.jpg', '0'), ('586', '25', '12', 'x25y12.jpg', '0'), ('587', '26', '12', 'x26y12.jpg', '0'), ('588', '27', '12', 'x27y12.jpg', '0'), ('589', '28', '12', 'x28y12.jpg', '0'), ('590', '29', '12', 'x29y12.jpg', '0'), ('591', '30', '12', 'x30y12.jpg', '0'), ('592', '31', '12', 'x31y12.jpg', '0'), ('593', '32', '12', 'x32y12.jpg', '0'), ('594', '33', '12', 'x33y12.jpg', '0'), ('595', '34', '12', 'x34y12.jpg', '0'), ('596', '35', '12', 'x35y12.jpg', '0'), ('597', '36', '12', 'x36y12.jpg', '0'), ('598', '37', '12', 'x37y12.jpg', '0'), ('599', '38', '12', 'x38y12.jpg', '0'), ('600', '39', '12', 'x39y12.jpg', '1'), ('601', '40', '12', 'x40y12.jpg', '1'), ('602', '41', '12', 'x41y12.jpg', '0'), ('603', '42', '12', 'x42y12.jpg', '1'), ('604', '43', '12', 'x43y12.jpg', '1'), ('605', '44', '12', 'x44y12.jpg', '0'), ('606', '45', '12', 'x45y12.jpg', '0'), ('607', '46', '12', 'x46y12.jpg', '1'), ('608', '47', '12', 'x47y12.jpg', '1'), ('609', '48', '12', 'x48y12.jpg', '1'), ('610', '49', '12', 'x49y12.jpg', '1'), ('611', '50', '12', 'x50y12.jpg', '1'), ('612', '51', '12', 'x51y12.jpg', '1'), ('613', '1', '13', 'x1y13.jpg', '0'), ('614', '2', '13', 'x2y13.jpg', '0'), ('615', '3', '13', 'x3y13.jpg', '1'), ('616', '4', '13', 'x4y13.jpg', '1'), ('617', '5', '13', 'x5y13.jpg', '1'), ('618', '6', '13', 'x6y13.jpg', '0'), ('619', '7', '13', 'x7y13.jpg', '0'), ('620', '8', '13', 'x8y13.jpg', '0'), ('621', '9', '13', 'x9y13.jpg', '0'), ('622', '10', '13', 'x10y13.jpg', '0'), ('623', '11', '13', 'x11y13.jpg', '0'), ('624', '12', '13', 'x12y13.jpg', '0'), ('625', '13', '13', 'x13y13.jpg', '0'), ('626', '14', '13', 'x14y13.jpg', '0'), ('627', '15', '13', 'x15y13.jpg', '0'), ('628', '16', '13', 'x16y13.jpg', '0'), ('629', '17', '13', 'x17y13.jpg', '0'), ('630', '18', '13', 'x18y13.jpg', '0'), ('631', '19', '13', 'x19y13.jpg', '0'), ('632', '20', '13', 'x20y13.jpg', '0'), ('633', '21', '13', 'x21y13.jpg', '0'), ('634', '22', '13', 'x22y13.jpg', '0'), ('635', '23', '13', 'x23y13.jpg', '0'), ('636', '24', '13', 'x24y13.jpg', '0'), ('637', '25', '13', 'x25y13.jpg', '0'), ('638', '26', '13', 'x26y13.jpg', '0'), ('639', '27', '13', 'x27y13.jpg', '0'), ('640', '28', '13', 'x28y13.jpg', '0'), ('641', '29', '13', 'x29y13.jpg', '0'), ('642', '30', '13', 'x30y13.jpg', '0'), ('643', '31', '13', 'x31y13.jpg', '0'), ('644', '32', '13', 'x32y13.jpg', '0'), ('645', '33', '13', 'x33y13.jpg', '0'), ('646', '34', '13', 'x34y13.jpg', '1'), ('647', '35', '13', 'x35y13.jpg', '1'), ('648', '36', '13', 'x36y13.jpg', '1'), ('649', '37', '13', 'x37y13.jpg', '1'), ('650', '38', '13', 'x38y13.jpg', '0'), ('651', '39', '13', 'x39y13.jpg', '0'), ('652', '40', '13', 'x40y13.jpg', '1'), ('653', '41', '13', 'x41y13.jpg', '0'), ('654', '42', '13', 'x42y13.jpg', '0'), ('655', '43', '13', 'x43y13.jpg', '0'), ('656', '44', '13', 'x44y13.jpg', '0'), ('657', '45', '13', 'x45y13.jpg', '0'), ('658', '46', '13', 'x46y13.jpg', '0'), ('659', '47', '13', 'x47y13.jpg', '1'), ('660', '48', '13', 'x48y13.jpg', '0'), ('661', '49', '13', 'x49y13.jpg', '0'), ('662', '50', '13', 'x50y13.jpg', '1'), ('663', '51', '13', 'x51y13.jpg', '1'), ('664', '1', '14', 'x1y14.jpg', '0'), ('665', '2', '14', 'x2y14.jpg', '0'), ('666', '3', '14', 'x3y14.jpg', '1'), ('667', '4', '14', 'x4y14.jpg', '0'), ('668', '5', '14', 'x5y14.jpg', '0'), ('669', '6', '14', 'x6y14.jpg', '0'), ('670', '7', '14', 'x7y14.jpg', '0'), ('671', '8', '14', 'x8y14.jpg', '0'), ('672', '9', '14', 'x9y14.jpg', '0'), ('673', '10', '14', 'x10y14.jpg', '0'), ('674', '11', '14', 'x11y14.jpg', '0'), ('675', '12', '14', 'x12y14.jpg', '0'), ('676', '13', '14', 'x13y14.jpg', '0'), ('677', '14', '14', 'x14y14.jpg', '0'), ('678', '15', '14', 'x15y14.jpg', '0'), ('679', '16', '14', 'x16y14.jpg', '0'), ('680', '17', '14', 'x17y14.jpg', '0'), ('681', '18', '14', 'x18y14.jpg', '0'), ('682', '19', '14', 'x19y14.jpg', '0'), ('683', '20', '14', 'x20y14.jpg', '0'), ('684', '21', '14', 'x21y14.jpg', '0'), ('685', '22', '14', 'x22y14.jpg', '0'), ('686', '23', '14', 'x23y14.jpg', '0'), ('687', '24', '14', 'x24y14.jpg', '1'), ('688', '25', '14', 'x25y14.jpg', '1'), ('689', '26', '14', 'x26y14.jpg', '0'), ('690', '27', '14', 'x27y14.jpg', '0'), ('691', '28', '14', 'x28y14.jpg', '0'), ('692', '29', '14', 'x29y14.jpg', '0'), ('693', '30', '14', 'x30y14.jpg', '0'), ('694', '31', '14', 'x31y14.jpg', '0'), ('695', '32', '14', 'x32y14.jpg', '0'), ('696', '33', '14', 'x33y14.jpg', '0'), ('697', '34', '14', 'x34y14.jpg', '0'), ('698', '35', '14', 'x35y14.jpg', '0'), ('699', '36', '14', 'x36y14.jpg', '1'), ('700', '37', '14', 'x37y14.jpg', '1'), ('701', '38', '14', 'x38y14.jpg', '0'), ('702', '39', '14', 'x39y14.jpg', '0'), ('703', '40', '14', 'x40y14.jpg', '0'), ('704', '41', '14', 'x41y14.jpg', '0'), ('705', '42', '14', 'x42y14.jpg', '0'), ('706', '43', '14', 'x43y14.jpg', '0'), ('707', '44', '14', 'x44y14.jpg', '0'), ('708', '45', '14', 'x45y14.jpg', '0'), ('709', '46', '14', 'x46y14.jpg', '0'), ('710', '47', '14', 'x47y14.jpg', '1'), ('711', '48', '14', 'x48y14.jpg', '1'), ('712', '49', '14', 'x49y14.jpg', '1'), ('713', '50', '14', 'x50y14.jpg', '1'), ('714', '51', '14', 'x51y14.jpg', '1'), ('715', '1', '15', 'x1y15.jpg', '0'), ('716', '2', '15', 'x2y15.jpg', '0'), ('717', '3', '15', 'x3y15.jpg', '1'), ('718', '4', '15', 'x4y15.jpg', '1'), ('719', '5', '15', 'x5y15.jpg', '0'), ('720', '6', '15', 'x6y15.jpg', '0'), ('721', '7', '15', 'x7y15.jpg', '0'), ('722', '8', '15', 'x8y15.jpg', '0'), ('723', '9', '15', 'x9y15.jpg', '0'), ('724', '10', '15', 'x10y15.jpg', '0'), ('725', '11', '15', 'x11y15.jpg', '0'), ('726', '12', '15', 'x12y15.jpg', '0'), ('727', '13', '15', 'x13y15.jpg', '0'), ('728', '14', '15', 'x14y15.jpg', '0'), ('729', '15', '15', 'x15y15.jpg', '0'), ('730', '16', '15', 'x16y15.jpg', '0'), ('731', '17', '15', 'x17y15.jpg', '0'), ('732', '18', '15', 'x18y15.jpg', '0'), ('733', '19', '15', 'x19y15.jpg', '0'), ('734', '20', '15', 'x20y15.jpg', '0'), ('735', '21', '15', 'x21y15.jpg', '0'), ('736', '22', '15', 'x22y15.jpg', '0'), ('737', '23', '15', 'x23y15.jpg', '0'), ('738', '24', '15', 'x24y15.jpg', '1'), ('739', '25', '15', 'x25y15.jpg', '1'), ('740', '26', '15', 'x26y15.jpg', '0'), ('741', '27', '15', 'x27y15.jpg', '0'), ('742', '28', '15', 'x28y15.jpg', '0'), ('743', '29', '15', 'x29y15.jpg', '0'), ('744', '30', '15', 'x30y15.jpg', '0'), ('745', '31', '15', 'x31y15.jpg', '0'), ('746', '32', '15', 'x32y15.jpg', '0'), ('747', '33', '15', 'x33y15.jpg', '0'), ('748', '34', '15', 'x34y15.jpg', '0'), ('749', '35', '15', 'x35y15.jpg', '0'), ('750', '36', '15', 'x36y15.jpg', '0'), ('751', '37', '15', 'x37y15.jpg', '0'), ('752', '38', '15', 'x38y15.jpg', '0'), ('753', '39', '15', 'x39y15.jpg', '0'), ('754', '40', '15', 'x40y15.jpg', '0'), ('755', '41', '15', 'x41y15.jpg', '0'), ('756', '42', '15', 'x42y15.jpg', '0'), ('757', '43', '15', 'x43y15.jpg', '0'), ('758', '44', '15', 'x44y15.jpg', '0'), ('759', '45', '15', 'x45y15.jpg', '0'), ('760', '46', '15', 'x46y15.jpg', '0'), ('761', '47', '15', 'x47y15.jpg', '1'), ('762', '48', '15', 'x48y15.jpg', '1'), ('763', '49', '15', 'x49y15.jpg', '1'), ('764', '50', '15', 'x50y15.jpg', '1'), ('765', '51', '15', 'x51y15.jpg', '1'), ('766', '1', '16', 'x1y16.jpg', '0'), ('767', '2', '16', 'x2y16.jpg', '0'), ('768', '3', '16', 'x3y16.jpg', '1'), ('769', '4', '16', 'x4y16.jpg', '1'), ('770', '5', '16', 'x5y16.jpg', '0'), ('771', '6', '16', 'x6y16.jpg', '0'), ('772', '7', '16', 'x7y16.jpg', '0'), ('773', '8', '16', 'x8y16.jpg', '0'), ('774', '9', '16', 'x9y16.jpg', '0'), ('775', '10', '16', 'x10y16.jpg', '0'), ('776', '11', '16', 'x11y16.jpg', '0'), ('777', '12', '16', 'x12y16.jpg', '0'), ('778', '13', '16', 'x13y16.jpg', '0'), ('779', '14', '16', 'x14y16.jpg', '0'), ('780', '15', '16', 'x15y16.jpg', '0'), ('781', '16', '16', 'x16y16.jpg', '0'), ('782', '17', '16', 'x17y16.jpg', '0'), ('783', '18', '16', 'x18y16.jpg', '0'), ('784', '19', '16', 'x19y16.jpg', '0'), ('785', '20', '16', 'x20y16.jpg', '0'), ('786', '21', '16', 'x21y16.jpg', '0'), ('787', '22', '16', 'x22y16.jpg', '0'), ('788', '23', '16', 'x23y16.jpg', '0'), ('789', '24', '16', 'x24y16.jpg', '0'), ('790', '25', '16', 'x25y16.jpg', '0'), ('791', '26', '16', 'x26y16.jpg', '0'), ('792', '27', '16', 'x27y16.jpg', '0'), ('793', '28', '16', 'x28y16.jpg', '0'), ('794', '29', '16', 'x29y16.jpg', '0'), ('795', '30', '16', 'x30y16.jpg', '0'), ('796', '31', '16', 'x31y16.jpg', '0'), ('797', '32', '16', 'x32y16.jpg', '0'), ('798', '33', '16', 'x33y16.jpg', '0'), ('799', '34', '16', 'x34y16.jpg', '0'), ('800', '35', '16', 'x35y16.jpg', '0'), ('801', '36', '16', 'x36y16.jpg', '0'), ('802', '37', '16', 'x37y16.jpg', '0'), ('803', '38', '16', 'x38y16.jpg', '0'), ('804', '39', '16', 'x39y16.jpg', '0'), ('805', '40', '16', 'x40y16.jpg', '0'), ('806', '41', '16', 'x41y16.jpg', '0'), ('807', '42', '16', 'x42y16.jpg', '0'), ('808', '43', '16', 'x43y16.jpg', '0'), ('809', '44', '16', 'x44y16.jpg', '0'), ('810', '45', '16', 'x45y16.jpg', '0'), ('811', '46', '16', 'x46y16.jpg', '0'), ('812', '47', '16', 'x47y16.jpg', '1'), ('813', '48', '16', 'x48y16.jpg', '1'), ('814', '49', '16', 'x49y16.jpg', '1'), ('815', '50', '16', 'x50y16.jpg', '1'), ('816', '51', '16', 'x51y16.jpg', '1'), ('817', '1', '17', 'x1y17.jpg', '0'), ('818', '2', '17', 'x2y17.jpg', '0'), ('819', '3', '17', 'x3y17.jpg', '1'), ('820', '4', '17', 'x4y17.jpg', '1'), ('821', '5', '17', 'x5y17.jpg', '0'), ('822', '6', '17', 'x6y17.jpg', '0'), ('823', '7', '17', 'x7y17.jpg', '0'), ('824', '8', '17', 'x8y17.jpg', '0'), ('825', '9', '17', 'x9y17.jpg', '0'), ('826', '10', '17', 'x10y17.jpg', '0'), ('827', '11', '17', 'x11y17.jpg', '0'), ('828', '12', '17', 'x12y17.jpg', '0'), ('829', '13', '17', 'x13y17.jpg', '0'), ('830', '14', '17', 'x14y17.jpg', '0'), ('831', '15', '17', 'x15y17.jpg', '0'), ('832', '16', '17', 'x16y17.jpg', '0'), ('833', '17', '17', 'x17y17.jpg', '0'), ('834', '18', '17', 'x18y17.jpg', '0'), ('835', '19', '17', 'x19y17.jpg', '0'), ('836', '20', '17', 'x20y17.jpg', '0'), ('837', '21', '17', 'x21y17.jpg', '0'), ('838', '22', '17', 'x22y17.jpg', '0'), ('839', '23', '17', 'x23y17.jpg', '0'), ('840', '24', '17', 'x24y17.jpg', '0'), ('841', '25', '17', 'x25y17.jpg', '0'), ('842', '26', '17', 'x26y17.jpg', '0'), ('843', '27', '17', 'x27y17.jpg', '0'), ('844', '28', '17', 'x28y17.jpg', '0'), ('845', '29', '17', 'x29y17.jpg', '0'), ('846', '30', '17', 'x30y17.jpg', '0'), ('847', '31', '17', 'x31y17.jpg', '0'), ('848', '32', '17', 'x32y17.jpg', '0'), ('849', '33', '17', 'x33y17.jpg', '0'), ('850', '34', '17', 'x34y17.jpg', '0'), ('851', '35', '17', 'x35y17.jpg', '0'), ('852', '36', '17', 'x36y17.jpg', '0'), ('853', '37', '17', 'x37y17.jpg', '0'), ('854', '38', '17', 'x38y17.jpg', '0'), ('855', '39', '17', 'x39y17.jpg', '0'), ('856', '40', '17', 'x40y17.jpg', '0'), ('857', '41', '17', 'x41y17.jpg', '0'), ('858', '42', '17', 'x42y17.jpg', '0'), ('859', '43', '17', 'x43y17.jpg', '0'), ('860', '44', '17', 'x44y17.jpg', '0'), ('861', '45', '17', 'x45y17.jpg', '0'), ('862', '46', '17', 'x46y17.jpg', '0'), ('863', '47', '17', 'x47y17.jpg', '0'), ('864', '48', '17', 'x48y17.jpg', '1'), ('865', '49', '17', 'x49y17.jpg', '1'), ('866', '50', '17', 'x50y17.jpg', '1'), ('867', '51', '17', 'x51y17.jpg', '1'), ('868', '1', '18', 'x1y18.jpg', '0'), ('869', '2', '18', 'x2y18.jpg', '0'), ('870', '3', '18', 'x3y18.jpg', '1'), ('871', '4', '18', 'x4y18.jpg', '0'), ('872', '5', '18', 'x5y18.jpg', '0'), ('873', '6', '18', 'x6y18.jpg', '0'), ('874', '7', '18', 'x7y18.jpg', '0'), ('875', '8', '18', 'x8y18.jpg', '0'), ('876', '9', '18', 'x9y18.jpg', '0'), ('877', '10', '18', 'x10y18.jpg', '0'), ('878', '11', '18', 'x11y18.jpg', '0'), ('879', '12', '18', 'x12y18.jpg', '0'), ('880', '13', '18', 'x13y18.jpg', '0'), ('881', '14', '18', 'x14y18.jpg', '0'), ('882', '15', '18', 'x15y18.jpg', '0'), ('883', '16', '18', 'x16y18.jpg', '0'), ('884', '17', '18', 'x17y18.jpg', '0'), ('885', '18', '18', 'x18y18.jpg', '0'), ('886', '19', '18', 'x19y18.jpg', '0'), ('887', '20', '18', 'x20y18.jpg', '0'), ('888', '21', '18', 'x21y18.jpg', '0'), ('889', '22', '18', 'x22y18.jpg', '0'), ('890', '23', '18', 'x23y18.jpg', '0'), ('891', '24', '18', 'x24y18.jpg', '0'), ('892', '25', '18', 'x25y18.jpg', '0'), ('893', '26', '18', 'x26y18.jpg', '0'), ('894', '27', '18', 'x27y18.jpg', '0'), ('895', '28', '18', 'x28y18.jpg', '0'), ('896', '29', '18', 'x29y18.jpg', '0'), ('897', '30', '18', 'x30y18.jpg', '0'), ('898', '31', '18', 'x31y18.jpg', '0'), ('899', '32', '18', 'x32y18.jpg', '0'), ('900', '33', '18', 'x33y18.jpg', '0'), ('901', '34', '18', 'x34y18.jpg', '0'), ('902', '35', '18', 'x35y18.jpg', '0'), ('903', '36', '18', 'x36y18.jpg', '0'), ('904', '37', '18', 'x37y18.jpg', '0'), ('905', '38', '18', 'x38y18.jpg', '0'), ('906', '39', '18', 'x39y18.jpg', '0'), ('907', '40', '18', 'x40y18.jpg', '0'), ('908', '41', '18', 'x41y18.jpg', '0'), ('909', '42', '18', 'x42y18.jpg', '0'), ('910', '43', '18', 'x43y18.jpg', '0'), ('911', '44', '18', 'x44y18.jpg', '0'), ('912', '45', '18', 'x45y18.jpg', '0'), ('913', '46', '18', 'x46y18.jpg', '0'), ('914', '47', '18', 'x47y18.jpg', '0'), ('915', '48', '18', 'x48y18.jpg', '0'), ('916', '49', '18', 'x49y18.jpg', '1'), ('917', '50', '18', 'x50y18.jpg', '1'), ('918', '51', '18', 'x51y18.jpg', '1'), ('919', '1', '19', 'x1y19.jpg', '0'), ('920', '2', '19', 'x2y19.jpg', '0'), ('921', '3', '19', 'x3y19.jpg', '1'), ('922', '4', '19', 'x4y19.jpg', '1'), ('923', '5', '19', 'x5y19.jpg', '0'), ('924', '6', '19', 'x6y19.jpg', '0'), ('925', '7', '19', 'x7y19.jpg', '0'), ('926', '8', '19', 'x8y19.jpg', '0'), ('927', '9', '19', 'x9y19.jpg', '0'), ('928', '10', '19', 'x10y19.jpg', '0'), ('929', '11', '19', 'x11y19.jpg', '0'), ('930', '12', '19', 'x12y19.jpg', '0'), ('931', '13', '19', 'x13y19.jpg', '0'), ('932', '14', '19', 'x14y19.jpg', '0'), ('933', '15', '19', 'x15y19.jpg', '0'), ('934', '16', '19', 'x16y19.jpg', '0'), ('935', '17', '19', 'x17y19.jpg', '0'), ('936', '18', '19', 'x18y19.jpg', '0'), ('937', '19', '19', 'x19y19.jpg', '0'), ('938', '20', '19', 'x20y19.jpg', '0'), ('939', '21', '19', 'x21y19.jpg', '0'), ('940', '22', '19', 'x22y19.jpg', '0'), ('941', '23', '19', 'x23y19.jpg', '0'), ('942', '24', '19', 'x24y19.jpg', '0'), ('943', '25', '19', 'x25y19.jpg', '0'), ('944', '26', '19', 'x26y19.jpg', '0'), ('945', '27', '19', 'x27y19.jpg', '0'), ('946', '28', '19', 'x28y19.jpg', '0'), ('947', '29', '19', 'x29y19.jpg', '0'), ('948', '30', '19', 'x30y19.jpg', '0'), ('949', '31', '19', 'x31y19.jpg', '0'), ('950', '32', '19', 'x32y19.jpg', '0'), ('951', '33', '19', 'x33y19.jpg', '0'), ('952', '34', '19', 'x34y19.jpg', '0'), ('953', '35', '19', 'x35y19.jpg', '0'), ('954', '36', '19', 'x36y19.jpg', '0'), ('955', '37', '19', 'x37y19.jpg', '0'), ('956', '38', '19', 'x38y19.jpg', '0'), ('957', '39', '19', 'x39y19.jpg', '0'), ('958', '40', '19', 'x40y19.jpg', '0'), ('959', '41', '19', 'x41y19.jpg', '0'), ('960', '42', '19', 'x42y19.jpg', '0'), ('961', '43', '19', 'x43y19.jpg', '0'), ('962', '44', '19', 'x44y19.jpg', '0'), ('963', '45', '19', 'x45y19.jpg', '0'), ('964', '46', '19', 'x46y19.jpg', '0'), ('965', '47', '19', 'x47y19.jpg', '0'), ('966', '48', '19', 'x48y19.jpg', '1'), ('967', '49', '19', 'x49y19.jpg', '1'), ('968', '50', '19', 'x50y19.jpg', '1'), ('969', '51', '19', 'x51y19.jpg', '1'), ('970', '1', '20', 'x1y20.jpg', '0'), ('971', '2', '20', 'x2y20.jpg', '0'), ('972', '3', '20', 'x3y20.jpg', '1'), ('973', '4', '20', 'x4y20.jpg', '1'), ('974', '5', '20', 'x5y20.jpg', '0'), ('975', '6', '20', 'x6y20.jpg', '0'), ('976', '7', '20', 'x7y20.jpg', '0'), ('977', '8', '20', 'x8y20.jpg', '0'), ('978', '9', '20', 'x9y20.jpg', '0'), ('979', '10', '20', 'x10y20.jpg', '0'), ('980', '11', '20', 'x11y20.jpg', '0'), ('981', '12', '20', 'x12y20.jpg', '0'), ('982', '13', '20', 'x13y20.jpg', '0'), ('983', '14', '20', 'x14y20.jpg', '0'), ('984', '15', '20', 'x15y20.jpg', '0'), ('985', '16', '20', 'x16y20.jpg', '0'), ('986', '17', '20', 'x17y20.jpg', '0'), ('987', '18', '20', 'x18y20.jpg', '0'), ('988', '19', '20', 'x19y20.jpg', '0'), ('989', '20', '20', 'x20y20.jpg', '0'), ('990', '21', '20', 'x21y20.jpg', '0'), ('991', '22', '20', 'x22y20.jpg', '0'), ('992', '23', '20', 'x23y20.jpg', '0'), ('993', '24', '20', 'x24y20.jpg', '0'), ('994', '25', '20', 'x25y20.jpg', '0'), ('995', '26', '20', 'x26y20.jpg', '0'), ('996', '27', '20', 'x27y20.jpg', '0'), ('997', '28', '20', 'x28y20.jpg', '0'), ('998', '29', '20', 'x29y20.jpg', '0'), ('999', '30', '20', 'x30y20.jpg', '0'), ('1000', '31', '20', 'x31y20.jpg', '0'), ('1001', '32', '20', 'x32y20.jpg', '0'), ('1002', '33', '20', 'x33y20.jpg', '0'), ('1003', '34', '20', 'x34y20.jpg', '0'), ('1004', '35', '20', 'x35y20.jpg', '0'), ('1005', '36', '20', 'x36y20.jpg', '0'), ('1006', '37', '20', 'x37y20.jpg', '0'), ('1007', '38', '20', 'x38y20.jpg', '0'), ('1008', '39', '20', 'x39y20.jpg', '0'), ('1009', '40', '20', 'x40y20.jpg', '0'), ('1010', '41', '20', 'x41y20.jpg', '0'), ('1011', '42', '20', 'x42y20.jpg', '0'), ('1012', '43', '20', 'x43y20.jpg', '0'), ('1013', '44', '20', 'x44y20.jpg', '0'), ('1014', '45', '20', 'x45y20.jpg', '0'), ('1015', '46', '20', 'x46y20.jpg', '0'), ('1016', '47', '20', 'x47y20.jpg', '0'), ('1017', '48', '20', 'x48y20.jpg', '1'), ('1018', '49', '20', 'x49y20.jpg', '1'), ('1019', '50', '20', 'x50y20.jpg', '1'), ('1020', '51', '20', 'x51y20.jpg', '1'), ('1021', '1', '21', 'x1y21.jpg', '0'), ('1022', '2', '21', 'x2y21.jpg', '0'), ('1023', '3', '21', 'x3y21.jpg', '1'), ('1024', '4', '21', 'x4y21.jpg', '1'), ('1025', '5', '21', 'x5y21.jpg', '0'), ('1026', '6', '21', 'x6y21.jpg', '0'), ('1027', '7', '21', 'x7y21.jpg', '0'), ('1028', '8', '21', 'x8y21.jpg', '0'), ('1029', '9', '21', 'x9y21.jpg', '0'), ('1030', '10', '21', 'x10y21.jpg', '0'), ('1031', '11', '21', 'x11y21.jpg', '0'), ('1032', '12', '21', 'x12y21.jpg', '0'), ('1033', '13', '21', 'x13y21.jpg', '0'), ('1034', '14', '21', 'x14y21.jpg', '0'), ('1035', '15', '21', 'x15y21.jpg', '0'), ('1036', '16', '21', 'x16y21.jpg', '0'), ('1037', '17', '21', 'x17y21.jpg', '0'), ('1038', '18', '21', 'x18y21.jpg', '0'), ('1039', '19', '21', 'x19y21.jpg', '0'), ('1040', '20', '21', 'x20y21.jpg', '0'), ('1041', '21', '21', 'x21y21.jpg', '0'), ('1042', '22', '21', 'x22y21.jpg', '0'), ('1043', '23', '21', 'x23y21.jpg', '0'), ('1044', '24', '21', 'x24y21.jpg', '0'), ('1045', '25', '21', 'x25y21.jpg', '0'), ('1046', '26', '21', 'x26y21.jpg', '0'), ('1047', '27', '21', 'x27y21.jpg', '0'), ('1048', '28', '21', 'x28y21.jpg', '0'), ('1049', '29', '21', 'x29y21.jpg', '0'), ('1050', '30', '21', 'x30y21.jpg', '0'), ('1051', '31', '21', 'x31y21.jpg', '0'), ('1052', '32', '21', 'x32y21.jpg', '0'), ('1053', '33', '21', 'x33y21.jpg', '0'), ('1054', '34', '21', 'x34y21.jpg', '0'), ('1055', '35', '21', 'x35y21.jpg', '0'), ('1056', '36', '21', 'x36y21.jpg', '0'), ('1057', '37', '21', 'x37y21.jpg', '0'), ('1058', '38', '21', 'x38y21.jpg', '0'), ('1059', '39', '21', 'x39y21.jpg', '0'), ('1060', '40', '21', 'x40y21.jpg', '0'), ('1061', '41', '21', 'x41y21.jpg', '0'), ('1062', '42', '21', 'x42y21.jpg', '0'), ('1063', '43', '21', 'x43y21.jpg', '0'), ('1064', '44', '21', 'x44y21.jpg', '0'), ('1065', '45', '21', 'x45y21.jpg', '0'), ('1066', '46', '21', 'x46y21.jpg', '0'), ('1067', '47', '21', 'x47y21.jpg', '0'), ('1068', '48', '21', 'x48y21.jpg', '1'), ('1069', '49', '21', 'x49y21.jpg', '1'), ('1070', '50', '21', 'x50y21.jpg', '1'), ('1071', '51', '21', 'x51y21.jpg', '1'), ('1072', '1', '22', 'x1y22.jpg', '0'), ('1073', '2', '22', 'x2y22.jpg', '0'), ('1074', '3', '22', 'x3y22.jpg', '1'), ('1075', '4', '22', 'x4y22.jpg', '1'), ('1076', '5', '22', 'x5y22.jpg', '1'), ('1077', '6', '22', 'x6y22.jpg', '1'), ('1078', '7', '22', 'x7y22.jpg', '1'), ('1079', '8', '22', 'x8y22.jpg', '0'), ('1080', '9', '22', 'x9y22.jpg', '0'), ('1081', '10', '22', 'x10y22.jpg', '0'), ('1082', '11', '22', 'x11y22.jpg', '0'), ('1083', '12', '22', 'x12y22.jpg', '0'), ('1084', '13', '22', 'x13y22.jpg', '0'), ('1085', '14', '22', 'x14y22.jpg', '0'), ('1086', '15', '22', 'x15y22.jpg', '0'), ('1087', '16', '22', 'x16y22.jpg', '0'), ('1088', '17', '22', 'x17y22.jpg', '0'), ('1089', '18', '22', 'x18y22.jpg', '0'), ('1090', '19', '22', 'x19y22.jpg', '0'), ('1091', '20', '22', 'x20y22.jpg', '0'), ('1092', '21', '22', 'x21y22.jpg', '0'), ('1093', '22', '22', 'x22y22.jpg', '0'), ('1094', '23', '22', 'x23y22.jpg', '0'), ('1095', '24', '22', 'x24y22.jpg', '0'), ('1096', '25', '22', 'x25y22.jpg', '0'), ('1097', '26', '22', 'x26y22.jpg', '0'), ('1098', '27', '22', 'x27y22.jpg', '0'), ('1099', '28', '22', 'x28y22.jpg', '0'), ('1100', '29', '22', 'x29y22.jpg', '0'), ('1101', '30', '22', 'x30y22.jpg', '0'), ('1102', '31', '22', 'x31y22.jpg', '0'), ('1103', '32', '22', 'x32y22.jpg', '0'), ('1104', '33', '22', 'x33y22.jpg', '0'), ('1105', '34', '22', 'x34y22.jpg', '0'), ('1106', '35', '22', 'x35y22.jpg', '0'), ('1107', '36', '22', 'x36y22.jpg', '0'), ('1108', '37', '22', 'x37y22.jpg', '0'), ('1109', '38', '22', 'x38y22.jpg', '0'), ('1110', '39', '22', 'x39y22.jpg', '0'), ('1111', '40', '22', 'x40y22.jpg', '0'), ('1112', '41', '22', 'x41y22.jpg', '0'), ('1113', '42', '22', 'x42y22.jpg', '0'), ('1114', '43', '22', 'x43y22.jpg', '0'), ('1115', '44', '22', 'x44y22.jpg', '0'), ('1116', '45', '22', 'x45y22.jpg', '0'), ('1117', '46', '22', 'x46y22.jpg', '0'), ('1118', '47', '22', 'x47y22.jpg', '1'), ('1119', '48', '22', 'x48y22.jpg', '1'), ('1120', '49', '22', 'x49y22.jpg', '1'), ('1121', '50', '22', 'x50y22.jpg', '1'), ('1122', '51', '22', 'x51y22.jpg', '1'), ('1123', '1', '23', 'x1y23.jpg', '0'), ('1124', '2', '23', 'x2y23.jpg', '0'), ('1125', '3', '23', 'x3y23.jpg', '1'), ('1126', '4', '23', 'x4y23.jpg', '1'), ('1127', '5', '23', 'x5y23.jpg', '1'), ('1128', '6', '23', 'x6y23.jpg', '1'), ('1129', '7', '23', 'x7y23.jpg', '1'), ('1130', '8', '23', 'x8y23.jpg', '0'), ('1131', '9', '23', 'x9y23.jpg', '0'), ('1132', '10', '23', 'x10y23.jpg', '0'), ('1133', '11', '23', 'x11y23.jpg', '0'), ('1134', '12', '23', 'x12y23.jpg', '0'), ('1135', '13', '23', 'x13y23.jpg', '0'), ('1136', '14', '23', 'x14y23.jpg', '0'), ('1137', '15', '23', 'x15y23.jpg', '0'), ('1138', '16', '23', 'x16y23.jpg', '0'), ('1139', '17', '23', 'x17y23.jpg', '0'), ('1140', '18', '23', 'x18y23.jpg', '0'), ('1141', '19', '23', 'x19y23.jpg', '1'), ('1142', '20', '23', 'x20y23.jpg', '0'), ('1143', '21', '23', 'x21y23.jpg', '0'), ('1144', '22', '23', 'x22y23.jpg', '1'), ('1145', '23', '23', 'x23y23.jpg', '0'), ('1146', '24', '23', 'x24y23.jpg', '0'), ('1147', '25', '23', 'x25y23.jpg', '0'), ('1148', '26', '23', 'x26y23.jpg', '0'), ('1149', '27', '23', 'x27y23.jpg', '0'), ('1150', '28', '23', 'x28y23.jpg', '0'), ('1151', '29', '23', 'x29y23.jpg', '0'), ('1152', '30', '23', 'x30y23.jpg', '0'), ('1153', '31', '23', 'x31y23.jpg', '0'), ('1154', '32', '23', 'x32y23.jpg', '0'), ('1155', '33', '23', 'x33y23.jpg', '0'), ('1156', '34', '23', 'x34y23.jpg', '0'), ('1157', '35', '23', 'x35y23.jpg', '0'), ('1158', '36', '23', 'x36y23.jpg', '0'), ('1159', '37', '23', 'x37y23.jpg', '0'), ('1160', '38', '23', 'x38y23.jpg', '0'), ('1161', '39', '23', 'x39y23.jpg', '0'), ('1162', '40', '23', 'x40y23.jpg', '0'), ('1163', '41', '23', 'x41y23.jpg', '0'), ('1164', '42', '23', 'x42y23.jpg', '0'), ('1165', '43', '23', 'x43y23.jpg', '0'), ('1166', '44', '23', 'x44y23.jpg', '0'), ('1167', '45', '23', 'x45y23.jpg', '0'), ('1168', '46', '23', 'x46y23.jpg', '0'), ('1169', '47', '23', 'x47y23.jpg', '1'), ('1170', '48', '23', 'x48y23.jpg', '1'), ('1171', '49', '23', 'x49y23.jpg', '1'), ('1172', '50', '23', 'x50y23.jpg', '1'), ('1173', '51', '23', 'x51y23.jpg', '1'), ('1174', '1', '24', 'x1y24.jpg', '0'), ('1175', '2', '24', 'x2y24.jpg', '0'), ('1176', '3', '24', 'x3y24.jpg', '1'), ('1177', '4', '24', 'x4y24.jpg', '1'), ('1178', '5', '24', 'x5y24.jpg', '1'), ('1179', '6', '24', 'x6y24.jpg', '1'), ('1180', '7', '24', 'x7y24.jpg', '1'), ('1181', '8', '24', 'x8y24.jpg', '1'), ('1182', '9', '24', 'x9y24.jpg', '1'), ('1183', '10', '24', 'x10y24.jpg', '1'), ('1184', '11', '24', 'x11y24.jpg', '1'), ('1185', '12', '24', 'x12y24.jpg', '1'), ('1186', '13', '24', 'x13y24.jpg', '1'), ('1187', '14', '24', 'x14y24.jpg', '1'), ('1188', '15', '24', 'x15y24.jpg', '1'), ('1189', '16', '24', 'x16y24.jpg', '1'), ('1190', '17', '24', 'x17y24.jpg', '1'), ('1191', '18', '24', 'x18y24.jpg', '1'), ('1192', '19', '24', 'x19y24.jpg', '1'), ('1193', '20', '24', 'x20y24.jpg', '1'), ('1194', '21', '24', 'x21y24.jpg', '1'), ('1195', '22', '24', 'x22y24.jpg', '1'), ('1196', '23', '24', 'x23y24.jpg', '1'), ('1197', '24', '24', 'x24y24.jpg', '1'), ('1198', '25', '24', 'x25y24.jpg', '1'), ('1199', '26', '24', 'x26y24.jpg', '1'), ('1200', '27', '24', 'x27y24.jpg', '1'), ('1201', '28', '24', 'x28y24.jpg', '1'), ('1202', '29', '24', 'x29y24.jpg', '1'), ('1203', '30', '24', 'x30y24.jpg', '1'), ('1204', '31', '24', 'x31y24.jpg', '1'), ('1205', '32', '24', 'x32y24.jpg', '1'), ('1206', '33', '24', 'x33y24.jpg', '1'), ('1207', '34', '24', 'x34y24.jpg', '1'), ('1208', '35', '24', 'x35y24.jpg', '1'), ('1209', '36', '24', 'x36y24.jpg', '1'), ('1210', '37', '24', 'x37y24.jpg', '1'), ('1211', '38', '24', 'x38y24.jpg', '1'), ('1212', '39', '24', 'x39y24.jpg', '0'), ('1213', '40', '24', 'x40y24.jpg', '1'), ('1214', '41', '24', 'x41y24.jpg', '1'), ('1215', '42', '24', 'x42y24.jpg', '1'), ('1216', '43', '24', 'x43y24.jpg', '1'), ('1217', '44', '24', 'x44y24.jpg', '1'), ('1218', '45', '24', 'x45y24.jpg', '1'), ('1219', '46', '24', 'x46y24.jpg', '1'), ('1220', '47', '24', 'x47y24.jpg', '1'), ('1221', '48', '24', 'x48y24.jpg', '1'), ('1222', '49', '24', 'x49y24.jpg', '0'), ('1223', '50', '24', 'x50y24.jpg', '0'), ('1224', '51', '24', 'x51y24.jpg', '1'), ('1225', '1', '25', 'x1y25.jpg', '0'), ('1226', '2', '25', 'x2y25.jpg', '0'), ('1227', '3', '25', 'x3y25.jpg', '1'), ('1228', '4', '25', 'x4y25.jpg', '1'), ('1229', '5', '25', 'x5y25.jpg', '1'), ('1230', '6', '25', 'x6y25.jpg', '1'), ('1231', '7', '25', 'x7y25.jpg', '1'), ('1232', '8', '25', 'x8y25.jpg', '1'), ('1233', '9', '25', 'x9y25.jpg', '1'), ('1234', '10', '25', 'x10y25.jpg', '1'), ('1235', '11', '25', 'x11y25.jpg', '1'), ('1236', '12', '25', 'x12y25.jpg', '1'), ('1237', '13', '25', 'x13y25.jpg', '1'), ('1238', '14', '25', 'x14y25.jpg', '1'), ('1239', '15', '25', 'x15y25.jpg', '1'), ('1240', '16', '25', 'x16y25.jpg', '1'), ('1241', '17', '25', 'x17y25.jpg', '1'), ('1242', '18', '25', 'x18y25.jpg', '1'), ('1243', '19', '25', 'x19y25.jpg', '1'), ('1244', '20', '25', 'x20y25.jpg', '1'), ('1245', '21', '25', 'x21y25.jpg', '1'), ('1246', '22', '25', 'x22y25.jpg', '1'), ('1247', '23', '25', 'x23y25.jpg', '1'), ('1248', '24', '25', 'x24y25.jpg', '1'), ('1249', '25', '25', 'x25y25.jpg', '1'), ('1250', '26', '25', 'x26y25.jpg', '1'), ('1251', '27', '25', 'x27y25.jpg', '1'), ('1252', '28', '25', 'x28y25.jpg', '1'), ('1253', '29', '25', 'x29y25.jpg', '1'), ('1254', '30', '25', 'x30y25.jpg', '1'), ('1255', '31', '25', 'x31y25.jpg', '1'), ('1256', '32', '25', 'x32y25.jpg', '1'), ('1257', '33', '25', 'x33y25.jpg', '1'), ('1258', '34', '25', 'x34y25.jpg', '1'), ('1259', '35', '25', 'x35y25.jpg', '1'), ('1260', '36', '25', 'x36y25.jpg', '1'), ('1261', '37', '25', 'x37y25.jpg', '1'), ('1262', '38', '25', 'x38y25.jpg', '1'), ('1263', '39', '25', 'x39y25.jpg', '1'), ('1264', '40', '25', 'x40y25.jpg', '1'), ('1265', '41', '25', 'x41y25.jpg', '1'), ('1266', '42', '25', 'x42y25.jpg', '1'), ('1267', '43', '25', 'x43y25.jpg', '1'), ('1268', '44', '25', 'x44y25.jpg', '1'), ('1269', '45', '25', 'x45y25.jpg', '1'), ('1270', '46', '25', 'x46y25.jpg', '1'), ('1271', '47', '25', 'x47y25.jpg', '1'), ('1272', '48', '25', 'x48y25.jpg', '1'), ('1273', '49', '25', 'x49y25.jpg', '0'), ('1274', '50', '25', 'x50y25.jpg', '0'), ('1275', '51', '25', 'x51y25.jpg', '0'), ('1276', '1', '26', 'x1y26.jpg', '0'), ('1277', '2', '26', 'x2y26.jpg', '0'), ('1278', '3', '26', 'x3y26.jpg', '1'), ('1279', '4', '26', 'x4y26.jpg', '1'), ('1280', '5', '26', 'x5y26.jpg', '1'), ('1281', '6', '26', 'x6y26.jpg', '1'), ('1282', '7', '26', 'x7y26.jpg', '1'), ('1283', '8', '26', 'x8y26.jpg', '1'), ('1284', '9', '26', 'x9y26.jpg', '1'), ('1285', '10', '26', 'x10y26.jpg', '1'), ('1286', '11', '26', 'x11y26.jpg', '1'), ('1287', '12', '26', 'x12y26.jpg', '1'), ('1288', '13', '26', 'x13y26.jpg', '1'), ('1289', '14', '26', 'x14y26.jpg', '1'), ('1290', '15', '26', 'x15y26.jpg', '1'), ('1291', '16', '26', 'x16y26.jpg', '1'), ('1292', '17', '26', 'x17y26.jpg', '1'), ('1293', '18', '26', 'x18y26.jpg', '1'), ('1294', '19', '26', 'x19y26.jpg', '1'), ('1295', '20', '26', 'x20y26.jpg', '1'), ('1296', '21', '26', 'x21y26.jpg', '1'), ('1297', '22', '26', 'x22y26.jpg', '1'), ('1298', '23', '26', 'x23y26.jpg', '1'), ('1299', '24', '26', 'x24y26.jpg', '1'), ('1300', '25', '26', 'x25y26.jpg', '1'), ('1301', '26', '26', 'x26y26.jpg', '1'), ('1302', '27', '26', 'x27y26.jpg', '1'), ('1303', '28', '26', 'x28y26.jpg', '1'), ('1304', '29', '26', 'x29y26.jpg', '1'), ('1305', '30', '26', 'x30y26.jpg', '1'), ('1306', '31', '26', 'x31y26.jpg', '1'), ('1307', '32', '26', 'x32y26.jpg', '1'), ('1308', '33', '26', 'x33y26.jpg', '1'), ('1309', '34', '26', 'x34y26.jpg', '1'), ('1310', '35', '26', 'x35y26.jpg', '1'), ('1311', '36', '26', 'x36y26.jpg', '1'), ('1312', '37', '26', 'x37y26.jpg', '1'), ('1313', '38', '26', 'x38y26.jpg', '1'), ('1314', '39', '26', 'x39y26.jpg', '1'), ('1315', '40', '26', 'x40y26.jpg', '1'), ('1316', '41', '26', 'x41y26.jpg', '1'), ('1317', '42', '26', 'x42y26.jpg', '1'), ('1318', '43', '26', 'x43y26.jpg', '1'), ('1319', '44', '26', 'x44y26.jpg', '1'), ('1320', '45', '26', 'x45y26.jpg', '1'), ('1321', '46', '26', 'x46y26.jpg', '1'), ('1322', '47', '26', 'x47y26.jpg', '1'), ('1323', '48', '26', 'x48y26.jpg', '1'), ('1324', '49', '26', 'x49y26.jpg', '1'), ('1325', '50', '26', 'x50y26.jpg', '1'), ('1326', '51', '26', 'x51y26.jpg', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_messages`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_messages`;
CREATE TABLE `timeofwars_messages` (
  `Username` varchar(30) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `Text` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  KEY `user_ind` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_metall_store`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_metall_store`;
CREATE TABLE `timeofwars_metall_store` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Player` varchar(255) NOT NULL DEFAULT '',
  `Metall` varchar(255) NOT NULL DEFAULT '',
  `Count` int(11) unsigned NOT NULL DEFAULT '0',
  `Price` float(4,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Id`),
  KEY `Player` (`Player`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_mines`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_mines`;
CREATE TABLE `timeofwars_mines` (
  `Player` char(20) NOT NULL DEFAULT '',
  `Slots` text NOT NULL,
  `Exp` smallint(5) NOT NULL DEFAULT '0',
  `Cheat` smallint(4) NOT NULL DEFAULT '0',
  `last_activy` char(20) NOT NULL,
  PRIMARY KEY (`Player`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_more`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_more`;
CREATE TABLE `timeofwars_more` (
  `id` int(3) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `top_id` int(3) NOT NULL DEFAULT '0',
  `bottom_id` int(3) NOT NULL DEFAULT '0',
  `left_id` int(3) NOT NULL DEFAULT '0',
  `right_id` int(3) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_more`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_more` VALUES ('701', 'Море x5 y1', '0', '705', '0', '702', ''), ('702', 'Море x5 y2', '0', '706', '701', '703', ''), ('703', 'Море x5 y3', '0', '707', '702', '704', ''), ('704', 'Море x5 y4', '0', '708', '703', '0', ''), ('705', 'Море x4 y1', '701', '709', '0', '706', ''), ('713', 'Море x2 y1', '709', '717', '0', '714', ''), ('712', 'Море x3 y4', '708', '716', '711', '0', ''), ('711', 'Море x3 y3', '707', '715', '710', '712', ''), ('710', 'Море x3 y2', '706', '714', '710', '711', ''), ('706', 'Море x4 y2', '702', '710', '705', '707', ''), ('707', 'Море x4 y3', '703', '711', '706', '708', ''), ('708', 'Море x4 y4', '704', '712', '707', '0', ''), ('709', 'Море x3 y1', '705', '713', '743', '710', ''), ('714', 'Море x2 y2', '710', '718', '713', '715', ''), ('715', 'Море x2 y3', '711', '719', '714', '716', ''), ('716', 'Море x2 y4', '712', '720', '715', '0', ''), ('717', 'Море x1 y1', '713', '0', '740', '718', ''), ('718', 'Море x1 y2', '714', '721', '717', '719', ''), ('719', 'Море x1 y3', '715', '722', '718', '720', ''), ('720', 'Море x1 y4', '716', '0', '719', '0', ''), ('721', 'Море x-1 y2', '718', '0', '0', '722', ''), ('722', 'Море x-1 y3', '719', '723', '721', '0', ''), ('723', 'Море x-2 y3', '722', '725', '0', '724', ''), ('724', 'Море x-2 y4', '0', '0', '723', '0', ''), ('725', 'Море x-3 y3', '723', '0', '726', '0', ''), ('726', 'Море x-3 y2', '0', '0', '727', '725', ''), ('727', 'Море x-3 y1', '728', '729', '732', '726', ''), ('728', 'Море x-2 y1', '0', '727', '0', '0', ''), ('729', 'Море x-4 y1', '727', '0', '730', '0', ''), ('730', 'Море x-4 y-1', '732', '731', '0', '729', ''), ('731', 'Море x-5 y-1', '730', '0', '0', '0', ''), ('732', 'Море x-3 y-1', '0', '730', '733', '727', ''), ('733', 'Море x-3 y-2', '734', '0', '735', '732', ''), ('735', 'Море x-3 y-3', '737', '0', '0', '733', ''), ('734', 'Море x-2 y-2', '736', '733', '737', '0', ''), ('736', 'Море x-1 y-2', '738', '734', '0', '0', ''), ('737', 'Море x-2 y-3', '0', '735', '0', '734', '38'), ('738', 'Море x1 y-2', '741', '736', '739', '740', ''), ('739', 'Море x1 y-3', '0', '0', '0', '738', ''), ('740', 'Море x1 y-1', '0', '0', '738', '717', ''), ('741', 'Море x2 y-2', '742', '738', '0', '0', ''), ('742', 'Море x3 y-2', '0', '741', '744', '743', ''), ('743', 'Море x3 y-1', '739', '745', '0', '744', ''), ('744', 'Море x3 y-3', '745', '0', '0', '742', ''), ('745', 'Море x-5 y-1', '0', '744', '0', '0', '');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_more_players`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_more_players`;
CREATE TABLE `timeofwars_more_players` (
  `user_id` mediumint(8) NOT NULL,
  `lodka` enum('4','3','2','1') NOT NULL,
  `udochka` enum('4','3','2','1') NOT NULL,
  `last_coord_fish` smallint(3) NOT NULL,
  `end_fishing` char(20) NOT NULL,
  `end_move` char(20) NOT NULL,
  `coords` smallint(3) NOT NULL DEFAULT '717',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_news_comments`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_news_comments`;
CREATE TABLE `timeofwars_news_comments` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `board_id` mediumint(8) NOT NULL,
  `txt` text,
  `point` enum('0','5','4','3','2','1') NOT NULL DEFAULT '0',
  `author_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_online`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_online`;
CREATE TABLE `timeofwars_online` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Time` int(11) unsigned NOT NULL DEFAULT '0',
  `Room` varchar(30) NOT NULL DEFAULT '',
  `ClanID` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `Level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Align` int(4) unsigned NOT NULL DEFAULT '0',
  `Stop` enum('0','1') NOT NULL DEFAULT '0',
  `Inv` enum('0','1') NOT NULL DEFAULT '0',
  `SId` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`),
  KEY `ind_room` (`Room`,`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_online`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_online` VALUES ('Ламобот', '1302356530', 'cl', '99', '55', '0', '0', '0', '0'), ('Стрелок3', '1302356530', 'map', '99', '6', '0', '0', '0', '0'), ('Стрелок2', '1302356530', 'map', '99', '6', '0', '0', '0', '0'), ('Орк5', '1302356530', 'map', '99', '4', '0', '0', '0', '0'), ('Орк2', '1302356530', 'map', '99', '4', '0', '0', '0', '0'), ('Орк1', '1302356530', 'map', '99', '4', '0', '0', '0', '0'), ('Орк', '1302356530', 'map', '99', '4', '0', '0', '0', '0'), ('Воришка3', '1302356530', 'map', '99', '2', '0', '0', '0', '0'), ('Воришка1', '1302356530', 'map', '99', '2', '0', '0', '0', '0'), ('Стрелок4', '1302356530', 'map', '99', '6', '0', '0', '0', '0'), ('Стрелок', '1302356530', 'map', '99', '6', '0', '0', '0', '0'), ('Стрелок5', '1302356530', 'map', '99', '6', '0', '0', '0', '0'), ('Скорпион', '1302356530', 'map', '99', '10', '0', '0', '0', '0'), ('Скорпион4', '1302356530', 'map', '99', '10', '0', '0', '0', '0'), ('Скорпион1', '1302356530', 'map', '99', '10', '0', '0', '0', '0'), ('Скорпион2', '1302356530', 'map', '99', '10', '0', '0', '0', '0'), ('Скорпион 3', '1302356530', 'map', '99', '10', '0', '0', '0', '0'), ('Телепат', '1302356530', 'map', '99', '14', '0', '0', '0', '0'), ('Новичок3', '1302356530', 'map', '99', '0', '0', '0', '0', '0'), ('Телепат1', '1302356530', 'map', '99', '14', '0', '0', '0', '0'), ('Телепат2', '1302356530', 'map', '0', '14', '0', '0', '0', '0'), ('Телепат3', '1302356530', 'map', '99', '14', '0', '0', '0', '0'), ('Телепат4', '1302356530', 'map', '99', '14', '0', '0', '0', '0'), ('Гладиатор', '1302356530', 'map', '99', '12', '0', '0', '0', '0'), ('Гладиатор1', '1302356530', 'map', '99', '12', '0', '0', '0', '0'), ('Гладиатор2', '1302356530', 'map', '99', '12', '0', '0', '0', '0'), ('Гладиатор3', '1302356530', 'map', '99', '12', '0', '0', '0', '0'), ('Гладиатор4', '1302356530', 'map', '99', '12', '0', '0', '0', '0'), ('Воришка4', '1302356530', 'map', '99', '2', '0', '0', '0', '0'), ('Новичок', '1302356530', 'map', '99', '0', '0', '0', '0', '0'), ('Дровасек1', '1302356530', 'map', '99', '35', '0', '0', '0', '0'), ('Титан', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Всадник1', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Огрим4', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Титан1', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Титан2', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Титан3', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Титан4', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Титан5', '1302356530', 'map', '99', '16', '0', '0', '0', '0'), ('Огрим', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Огрим1', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Огрим2', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Огрим3', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Огрим5', '1302356530', 'map', '99', '18', '0', '0', '0', '0'), ('Всадник', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Всадник2', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Всадник3', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Всадник4', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Всадник5', '1302356530', 'map', '99', '20', '0', '0', '0', '0'), ('Оракул', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Минотавр4', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Оракул1', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Оракул2', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Оракул3', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Оракул4', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Оракул5', '1302356530', 'map', '99', '22', '0', '0', '0', '0'), ('Шахтёр4', '1302356530', 'map', '99', '24', '0', '0', '0', '0'), ('Шахтёр', '1302356530', 'map', '99', '24', '0', '0', '0', '0'), ('Шахтёр2', '1302356530', 'map', '99', '24', '0', '0', '0', '0'), ('Шахтёр3', '1302356530', 'map', '99', '24', '0', '0', '0', '0'), ('Минотавр2', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Шахтёр5', '1302356530', 'map', '99', '24', '0', '0', '0', '0'), ('Минотавр', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Минотавр1', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Минотавр3', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Минотавр5', '1302356530', 'map', '99', '26', '0', '0', '0', '0'), ('Небесный', '1302356530', 'map', '99', '28', '0', '0', '0', '0'), ('Небесный1', '1302356530', 'map', '99', '28', '0', '0', '0', '0'), ('Рыцарь', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Стрелок1', '1302356530', 'map', '99', '5', '0', '0', '0', '0'), ('Рыцарь4', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Рыцарь1', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Рыцарь2', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Рыцарь3', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Рыцарь5', '1302356530', 'map', '99', '8', '0', '0', '0', '0'), ('Громобой', '1302356530', 'map', '99', '30', '0', '0', '0', '0'), ('Громобой1', '1302356530', 'map', '99', '30', '0', '0', '0', '0'), ('Громобой2', '1302356530', 'map', '99', '30', '0', '0', '0', '0'), ('Громобой4', '1302356530', 'map', '99', '30', '0', '0', '0', '0'), ('Громобой5', '1302356530', 'map', '99', '30', '0', '0', '0', '0'), ('Дровасек', '1302356530', 'map', '99', '35', '0', '0', '0', '0'), ('Новичок2', '1302356530', 'map', '99', '0', '0', '0', '0', '0'), ('Новичок1', '1302356530', 'map', '99', '0', '0', '0', '0', '0'), ('Воришка', '1302356530', 'map', '99', '2', '0', '0', '0', '0'), ('Новичок4', '1302356530', 'map', '99', '0', '0', '0', '0', '0'), ('Воришка2', '1302356530', 'map', '99', '2', '0', '0', '0', '0'), ('Шакал2', '1302356530', 'map', '99', '31', '0', '0', '0', '0'), ('Дровасек2', '1302356530', 'map', '99', '35', '0', '0', '0', '0'), ('Дровасек3', '1302356530', 'map', '99', '35', '0', '0', '0', '0'), ('Блейзер', '1302356530', 'map', '99', '33', '0', '0', '0', '0'), ('Блейзер1', '1302356530', 'map', '99', '33', '0', '0', '0', '0'), ('Шакал1', '1302356530', 'map', '99', '31', '0', '0', '0', '0'), ('Блейзер3', '1302356530', 'map', '99', '33', '0', '0', '0', '0'), ('Шакал', '1302356530', 'map', '99', '31', '0', '0', '0', '0'), ('Шакал3', '1302356530', 'map', '99', '31', '0', '0', '0', '0'), ('Нумизиат', '1302356530', 'pl', '0', '200', '0', '0', '0', '0'), ('Тренер', '1302356530', 'bot_train', '99', '55', '0', '0', '0', '0'), ('Бот_255', '1302356530', 'zamok_255__train', '255', '13', '0', '0', '0', '0'), ('Кузя2', '1302356530', 'pl', '0', '13', '0', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_pict_unreg`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_pict_unreg`;
CREATE TABLE `timeofwars_pict_unreg` (
  `Id` char(70) NOT NULL,
  `Author` char(30) NOT NULL,
  `date` char(30) NOT NULL,
  `price` smallint(5) NOT NULL DEFAULT '0',
  `otdel` enum('F','M') NOT NULL DEFAULT 'M',
  `zamok` char(30) NOT NULL DEFAULT 'zamok_255',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_pict_zamok_255`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_pict_zamok_255`;
CREATE TABLE `timeofwars_pict_zamok_255` (
  `Id` varchar(30) NOT NULL,
  `Author` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `price` smallint(5) NOT NULL DEFAULT '0',
  `otdel` enum('F','M') NOT NULL DEFAULT 'M',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_players`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_players`;
CREATE TABLE `timeofwars_players` (
  `login` varchar(20) NOT NULL,
  `Username` varchar(20) CHARACTER SET cp1251 NOT NULL,
  `Password` varchar(30) CHARACTER SET cp1251 NOT NULL DEFAULT '',
  `RealName` varchar(30) CHARACTER SET cp1251 DEFAULT NULL,
  `Email` varchar(30) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `Sex` set('M','F') CHARACTER SET cp1251 NOT NULL DEFAULT 'M',
  `Birthdate` char(20) CHARACTER SET cp1251 DEFAULT NULL,
  `Pict` char(15) CHARACTER SET cp1251 DEFAULT NULL,
  `town` varchar(20) CHARACTER SET cp1251 NOT NULL DEFAULT '',
  `Room` varchar(30) CHARACTER SET cp1251 NOT NULL DEFAULT 'pl',
  `ChatRoom` varchar(30) CHARACTER SET cp1251 NOT NULL DEFAULT 'pl',
  `Align` enum('0','1','2','3','4','5') CHARACTER SET cp1251 NOT NULL DEFAULT '0',
  `ClanID` smallint(3) DEFAULT '0',
  `ClanRank` char(50) CHARACTER SET cp1251 DEFAULT NULL,
  `Stre` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Agil` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Intu` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Endu` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Intl` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Expa` int(11) unsigned NOT NULL DEFAULT '0',
  `Money` double(20,2) unsigned NOT NULL DEFAULT '0.00',
  `Won` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Lost` smallint(5) unsigned NOT NULL DEFAULT '0',
  `HPnow` smallint(5) unsigned NOT NULL DEFAULT '0',
  `HPall` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mana` smallint(5) unsigned NOT NULL DEFAULT '3',
  `mana_all` smallint(5) unsigned NOT NULL DEFAULT '3',
  `Level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Ups` smallint(5) unsigned NOT NULL DEFAULT '0',
  `PersBirthdate` char(30) CHARACTER SET cp1251 DEFAULT NULL,
  `ICQ` char(20) CHARACTER SET cp1251 DEFAULT NULL,
  `Info` text CHARACTER SET cp1251 NOT NULL,
  `BattleID` int(11) unsigned DEFAULT NULL,
  `BattleID2` mediumint(8) NOT NULL,
  `City` enum('1','2') CHARACTER SET cp1251 NOT NULL DEFAULT '1',
  `Id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `SId` int(5) NOT NULL DEFAULT '0',
  `color` char(30) CHARACTER SET cp1251 NOT NULL DEFAULT 'black',
  `Reg_IP` char(25) CHARACTER SET cp1251 NOT NULL,
  `map_id` smallint(4) NOT NULL,
  `warrior` tinyint(3) NOT NULL DEFAULT '0',
  `protector` tinyint(3) NOT NULL DEFAULT '0',
  `priest` tinyint(3) NOT NULL DEFAULT '0',
  `mag` tinyint(3) NOT NULL DEFAULT '0',
  `free_ability` tinyint(3) NOT NULL DEFAULT '0',
  `free_ups` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `batt_ind` (`BattleID`),
  KEY `ClanIDind` (`ClanID`)
) ENGINE=MyISAM AUTO_INCREMENT=576 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_players`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_players` VALUES ('Ламобот', 'Ламобот', '1234', 'Бот', '', 'F', '01.01.1985', 'M/17', '', 'cl', 'cl', '0', '99', null, '150', '69', '76', '80', '0', '40', '898.00', '10', '9', '710', '710', '3', '3', '55', '0', '2008-03-27 04:25:18', null, '', null, '0', '1', '1', '91376', 'black', 'бот', '427', '0', '0', '0', '0', '0', '0'), ('Admin', 'Admin', 'Admin', 'Иван', '', 'M', '01.01.1985', 'M/14', '', 'pl', 'pl', '1', '255', '<font color=red>Одмин</font>', '31', '23', '10', '39', '0', '7239', '1179519.90', '429', '83', '149', '149', '3', '3', '13', '0', '2008-03-27 04:25:18', '', '', '0', '0', '1', '2', '52761', 'black', '127.0.0.1', '589', '3', '7', '3', '0', '0', '0'), ('Стрелок3', 'Стрелок3', '3eRoQ', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '25', '20', '18', '20', '0', '0', '0.00', '0', '8', '60', '60', '3', '3', '6', '0', null, null, '', null, '0', '1', '304', '0', 'black', 'бот', '229', '0', '0', '0', '0', '0', '0'), ('Стрелок2', 'Стрелок2', 'VaJyb', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '20', '20', '20', '20', '0', '0', '0.00', '3', '3', '70', '70', '3', '3', '6', '0', null, null, '', null, '0', '1', '303', '0', 'black', 'бот', '936', '0', '0', '0', '0', '0', '0'), ('Орк5', 'Орк5', 'BudeLoDilo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '16', '12', '12', '15', '0', '0', '0.00', '6', '5', '60', '60', '3', '3', '4', '0', null, null, '', null, '0', '1', '300', '0', 'black', 'бот', '887', '0', '0', '0', '0', '0', '0'), ('Орк2', 'Орк2', 'muDoru', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '15', '15', '15', '15', '0', '0', '0.00', '2', '7', '50', '50', '3', '3', '4', '0', null, null, '', null, '0', '1', '298', '0', 'black', 'бот', '730', '0', '0', '0', '0', '0', '0'), ('Орк1', 'Орк1', 'LaHolymoR', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '15', '10', '15', '10', '0', '0', '0.00', '2', '2', '50', '50', '3', '3', '4', '0', null, null, '', null, '0', '1', '297', '0', 'black', 'бот', '771', '0', '0', '0', '0', '0', '0'), ('Орк', 'Орк', '0i0yty9', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '18', '10', '12', '10', '0', '0', '0.00', '2', '5', '65', '65', '3', '3', '4', '0', null, null, '', null, '0', '1', '296', '0', 'black', 'бот', '628', '0', '0', '0', '0', '0', '0'), ('Воришка3', 'Воришка3', 'eza8o3aLoR', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '12', '10', '8', '7', '0', '0', '0.00', '2', '13', '23', '23', '3', '3', '2', '0', null, null, '', null, '0', '1', '411', '0', 'black', 'бот', '417', '0', '0', '0', '0', '0', '0'), ('Воришка1', 'Воришка1', 'ZiryRuz', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '15', '8', '8', '8', '0', '0', '0.00', '3', '5', '28', '28', '3', '3', '2', '0', null, null, '', null, '0', '1', '409', '0', 'black', 'бот', '290', '0', '0', '0', '0', '0', '0'), ('Стрелок4', 'Стрелок4', 'eSySuzazot', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '22', '18', '20', '20', '0', '0', '0.00', '4', '1', '75', '75', '3', '3', '6', '0', null, null, '', null, '0', '1', '305', '0', 'black', 'бот', '1152', '0', '0', '0', '0', '0', '0'), ('Стрелок', 'Стрелок', 'giHug', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '22', '20', '20', '12', '0', '0', '0.00', '3', '5', '70', '70', '3', '3', '6', '0', null, null, '', null, '0', '1', '301', '0', 'black', 'бот', '914', '0', '0', '0', '0', '0', '0'), ('Стрелок5', 'Стрелок5', 'ypuqoRu1a6', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '25', '25', '25', '15', '0', '0', '0.00', '2', '8', '45', '45', '3', '3', '6', '0', null, null, '', null, '0', '1', '306', '0', 'black', 'бот', '1052', '0', '0', '0', '0', '0', '0'), ('Скорпион', 'Скорпион', 'umo5yruSiB', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '35', '30', '30', '45', '0', '0', '0.00', '0', '4', '120', '120', '3', '3', '10', '0', null, null, '', null, '0', '1', '174', '0', 'black', 'бот', '1225', '0', '0', '0', '0', '0', '0'), ('Скорпион4', 'Скорпион4', 'uBequMi2y', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '40', '25', '25', '30', '0', '0', '0.00', '3', '9', '100', '100', '3', '3', '10', '0', null, null, '', null, '0', '1', '179', '0', 'black', 'бот', '190', '0', '0', '0', '0', '0', '0'), ('Скорпион1', 'Скорпион1', 'reQuNihel', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '32', '23', '23', '36', '0', '0', '0.00', '1', '7', '120', '120', '3', '3', '10', '0', null, null, '', null, '0', '1', '176', '0', 'black', 'бот', '349', '0', '0', '0', '0', '0', '0'), ('Скорпион2', 'Скорпион2', '9ihy7', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '30', '50', '50', '34', '0', '0', '0.00', '0', '7', '112', '112', '3', '3', '10', '0', null, null, '', null, '0', '1', '177', '0', 'black', 'бот', '890', '0', '0', '0', '0', '0', '0'), ('Скорпион 3', 'Скорпион 3', '0o6iwyL', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '40', '30', '30', '50', '0', '0', '0.00', '6', '12', '150', '150', '3', '3', '10', '0', null, null, '', null, '0', '1', '178', '0', 'black', 'бот', '623', '0', '0', '0', '0', '0', '0'), ('Телепат', 'Телепат', 'yzy6axo5o', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '50', '50', '50', '52', '0', '0', '0.00', '0', '9', '200', '200', '3', '3', '14', '0', null, null, '', null, '0', '1', '182', '0', 'black', 'бот', '532', '0', '0', '0', '0', '0', '0'), ('Новичок3', 'Новичок3', 'ygaMo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '6', '6', '7', '6', '0', '0', '0.00', '2', '9', '21', '21', '3', '3', '0', '0', null, null, '', null, '0', '1', '406', '0', 'black', 'бот', '650', '0', '0', '0', '0', '0', '0'), ('Телепат1', 'Телепат1', 'yxu3emi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '60', '70', '70', '100', '0', '0', '0.00', '0', '6', '200', '200', '3', '3', '14', '0', null, null, '', null, '0', '1', '183', '0', 'black', 'бот', '403', '0', '0', '0', '0', '0', '0'), ('Телепат2', 'Телепат2', 'pyRejase', null, '', 'M', null, '0', '', 'map', 'map', '0', '0', null, '60', '150', '150', '100', '0', '0', '0.00', '1', '4', '225', '225', '3', '3', '14', '0', null, null, '', null, '0', '1', '184', '0', 'black', 'бот', '333', '0', '0', '0', '0', '0', '0'), ('Телепат3', 'Телепат3', 'iNyBud', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '50', '150', '150', '75', '0', '0', '0.00', '0', '5', '225', '225', '3', '3', '14', '0', null, null, '', null, '0', '1', '185', '0', 'black', 'бот', '1030', '0', '0', '0', '0', '0', '0'), ('Телепат4', 'Телепат4', 'Hy8a8il', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '30', '200', '175', '80', '0', '0', '0.00', '1', '4', '240', '240', '3', '3', '14', '0', null, null, '', null, '0', '1', '186', '0', 'black', 'бот', '180', '0', '0', '0', '0', '0', '0'), ('Гладиатор', 'Гладиатор', 'una2u5e', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '50', '37', '37', '50', '0', '0', '0.00', '1', '4', '150', '150', '3', '3', '12', '0', null, null, '', null, '0', '1', '187', '0', 'black', 'бот', '16', '0', '0', '0', '0', '0', '0'), ('Гладиатор1', 'Гладиатор1', 'BogoWely2', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '52', '36', '36', '50', '0', '0', '0.00', '1', '4', '150', '150', '3', '3', '12', '0', null, null, '', null, '0', '1', '188', '0', 'black', 'бот', '721', '0', '0', '0', '0', '0', '0'), ('Гладиатор2', 'Гладиатор2', '7iPezomi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '55', '40', '40', '50', '0', '0', '0.00', '0', '4', '150', '150', '3', '3', '12', '0', null, null, '', null, '0', '1', '189', '0', 'black', 'бот', '282', '0', '0', '0', '0', '0', '0'), ('Гладиатор3', 'Гладиатор3', 'LeSuWimyRe', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '45', '30', '30', '50', '0', '0', '0.00', '0', '3', '150', '150', '3', '3', '12', '0', null, null, '', null, '0', '1', '190', '0', 'black', 'бот', '774', '0', '0', '0', '0', '0', '0'), ('Гладиатор4', 'Гладиатор4', 'SaRaH', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '45', '30', '40', '50', '0', '0', '0.00', '2', '7', '150', '150', '3', '3', '12', '0', null, null, '', null, '0', '1', '191', '0', 'black', 'бот', '949', '0', '0', '0', '0', '0', '0'), ('Воришка4', 'Воришка4', 'ho0iQusuz', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '10', '12', '15', '10', '0', '0', '0.00', '1', '7', '28', '28', '3', '3', '2', '0', null, null, '', null, '0', '1', '412', '0', 'black', 'бот', '313', '0', '0', '0', '0', '0', '0'), ('Новичок', 'Новичок', '0uGyPyPyT', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '6', '6', '6', '6', '0', '0', '0.00', '2', '7', '20', '20', '3', '3', '0', '0', null, null, '', null, '0', '1', '403', '0', 'black', 'бот', '19', '0', '0', '0', '0', '0', '0'), ('Дровасек1', 'Дровасек1', 'gaQape', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '550', '350', '400', '900', '0', '0', '0.00', '1', '2', '2500', '2500', '3', '3', '35', '0', null, null, '', null, '0', '1', '390', '0', 'black', 'бот', '651', '0', '0', '0', '0', '0', '0'), ('Титан', 'Титан', 'aziQi6yNop', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '175', '175', '100', '0', '0', '0.00', '2', '5', '300', '300', '3', '3', '16', '0', null, null, '', null, '0', '1', '201', '0', 'black', 'бот', '1148', '0', '0', '0', '0', '0', '0'), ('Всадник1', 'Всадник1', 'yBavu', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '220', '140', '170', '150', '0', '0', '0.00', '1', '1', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '214', '0', 'black', 'бот', '322', '0', '0', '0', '0', '0', '0'), ('Огрим4', 'Огрим4', 'norajel', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '150', '150', '120', '0', '0', '0.00', '0', '20', '360', '360', '3', '3', '18', '0', null, null, '', null, '0', '1', '211', '0', 'black', 'бот', '1014', '0', '0', '0', '0', '0', '0'), ('Титан1', 'Титан1', 'Xu6y3i5yjo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '100', '100', '100', '0', '0', '0.00', '3', '4', '600', '600', '3', '3', '16', '0', null, null, '', null, '0', '1', '202', '0', 'black', 'бот', '218', '0', '0', '0', '0', '0', '0'), ('Титан2', 'Титан2', 'ibyryTyz', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '100', '100', '100', '0', '81', '0.00', '1', '13', '300', '300', '3', '3', '16', '0', null, null, '', null, '0', '1', '203', '0', 'black', 'бот', '238', '0', '0', '0', '0', '0', '0'), ('Титан3', 'Титан3', 'o0o2elohi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '100', '100', '200', '0', '0', '0.00', '1', '8', '300', '300', '3', '3', '16', '0', null, null, '', null, '0', '1', '204', '0', 'black', 'бот', '56', '0', '0', '0', '0', '0', '0'), ('Титан4', 'Титан4', 'u9u4al', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '75', '175', '175', '100', '0', '0', '0.00', '1', '3', '300', '300', '3', '3', '16', '0', null, null, '', null, '0', '1', '205', '0', 'black', 'бот', '622', '0', '0', '0', '0', '0', '0'), ('Титан5', 'Титан5', '5ugeda', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '50', '50', '50', '100', '0', '0', '0.00', '0', '7', '200', '200', '3', '3', '16', '0', null, null, '', null, '0', '1', '206', '0', 'black', 'бот', '15', '0', '0', '0', '0', '0', '0'), ('Огрим', 'Огрим', 'o0a3up', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '150', '200', '200', '120', '0', '0', '0.00', '3', '0', '360', '360', '3', '3', '18', '0', null, null, '', null, '0', '1', '207', '0', 'black', 'бот', '886', '0', '0', '0', '0', '0', '0'), ('Огрим1', 'Огрим1', 'QeSiB', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '170', '150', '150', '100', '0', '0', '0.00', '6', '10', '300', '300', '3', '3', '18', '0', null, null, '', null, '0', '1', '208', '0', 'black', 'бот', '521', '0', '0', '0', '0', '0', '0'), ('Огрим2', 'Огрим2', 'oVaMyWo6oT', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '160', '200', '200', '120', '0', '0', '0.00', '1', '0', '300', '300', '3', '3', '18', '0', null, null, '', null, '0', '1', '209', '0', 'black', 'бот', '525', '0', '0', '0', '0', '0', '0'), ('Огрим3', 'Огрим3', 'oQywelyRy', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '150', '150', '120', '0', '0', '0.00', '0', '1', '360', '360', '3', '3', '18', '0', null, null, '', null, '0', '1', '210', '0', 'black', 'бот', '343', '0', '0', '0', '0', '0', '0'), ('Огрим5', 'Огрим5', '0amig', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '180', '160', '150', '120', '0', '0', '0.00', '1', '2', '360', '360', '3', '3', '18', '0', null, null, '', null, '0', '1', '212', '0', 'black', 'бот', '513', '0', '0', '0', '0', '0', '0'), ('Всадник', 'Всадник', 'haByQa', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '220', '150', '130', '150', '0', '0', '0.00', '3', '0', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '213', '0', 'black', 'бот', '591', '0', '0', '0', '0', '0', '0'), ('Всадник2', 'Всадник2', 'qiBod', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '130', '130', '150', '0', '0', '0.00', '6', '5', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '215', '0', 'black', 'бот', '877', '0', '0', '0', '0', '0', '0'), ('Всадник3', 'Всадник3', 'u7aJut', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '130', '130', '150', '0', '0', '0.00', '1', '7', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '216', '0', 'black', 'бот', '523', '0', '0', '0', '0', '0', '0'), ('Всадник4', 'Всадник4', 'XusyDugy', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '250', '110', '100', '150', '0', '0', '0.00', '1', '2', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '217', '0', 'black', 'бот', '295', '0', '0', '0', '0', '0', '0'), ('Всадник5', 'Всадник5', 'o7yqa', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '190', '225', '225', '150', '0', '0', '0.00', '1', '2', '450', '450', '3', '3', '20', '0', null, null, '', null, '0', '1', '218', '0', 'black', 'бот', '1108', '0', '0', '0', '0', '0', '0'), ('Оракул', 'Оракул', 'oqiSoD', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '260', '200', '200', '130', '0', '0', '0.00', '0', '0', '390', '390', '3', '3', '22', '0', null, null, '', null, '0', '1', '219', '0', 'black', 'бот', '602', '0', '0', '0', '0', '0', '0'), ('Минотавр4', 'Минотавр4', 'uSupy', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '230', '230', '170', '0', '0', '0.00', '0', '3', '550', '550', '3', '3', '26', '0', null, null, '', null, '0', '1', '235', '0', 'black', 'бот', '428', '0', '0', '0', '0', '0', '0'), ('Оракул1', 'Оракул1', 'eMovuXaja', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '100', '200', '200', '130', '0', '0', '0.00', '1', '39', '390', '390', '3', '3', '22', '0', null, null, '', null, '0', '1', '220', '0', 'black', 'бот', '945', '0', '0', '0', '0', '0', '0'), ('Оракул2', 'Оракул2', 'i8yzy', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '100', '200', '200', '130', '0', '0', '0.00', '1', '27', '390', '390', '3', '3', '22', '0', null, null, '', null, '0', '1', '221', '0', 'black', 'бот', '683', '0', '0', '0', '0', '0', '0'), ('Оракул3', 'Оракул3', 'uze1uViLo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '250', '210', '210', '130', '0', '0', '0.00', '1', '0', '390', '390', '3', '3', '22', '0', null, null, '', null, '0', '1', '222', '0', 'black', 'бот', '426', '0', '0', '0', '0', '0', '0'), ('Оракул4', 'Оракул4', 'azuDiLo5u', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '180', '180', '130', '0', '0', '0.00', '1', '0', '390', '390', '3', '3', '22', '0', null, null, '', null, '0', '1', '223', '0', 'black', 'бот', '689', '0', '0', '0', '0', '0', '0'), ('Оракул5', 'Оракул5', 'elaBe6iqo5', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '180', '180', '130', '0', '0', '0.00', '1', '2', '450', '450', '3', '3', '22', '0', null, null, '', null, '0', '1', '224', '0', 'black', 'бот', '581', '0', '0', '0', '0', '0', '0'), ('Шахтёр4', 'Шахтёр4', 'yMe4yM', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '350', '250', '250', '150', '0', '0', '0.00', '1', '3', '550', '550', '3', '3', '24', '0', null, null, '', null, '0', '1', '229', '0', 'black', 'бот', '1050', '0', '0', '0', '0', '0', '0'), ('Шахтёр', 'Шахтёр', '4e9oneNe0', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '200', '200', '150', '0', '0', '0.00', '0', '3', '500', '500', '3', '3', '24', '0', null, null, '', null, '0', '1', '225', '0', 'black', 'бот', '329', '0', '0', '0', '0', '0', '0'), ('Шахтёр2', 'Шахтёр2', 'NoBoHy6uMo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '260', '260', '200', '0', '0', '0.00', '4', '0', '500', '500', '3', '3', '24', '0', null, null, '', null, '0', '1', '227', '0', 'black', 'бот', '120', '0', '0', '0', '0', '0', '0'), ('Шахтёр3', 'Шахтёр3', 'Nare6', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '280', '250', '400', '0', '0', '0.00', '0', '5', '500', '500', '3', '3', '24', '0', null, null, '', null, '0', '1', '228', '0', 'black', 'бот', '852', '0', '0', '0', '0', '0', '0'), ('Минотавр2', 'Минотавр2', 'uTy6ota', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '250', '230', '230', '170', '0', '0', '0.00', '0', '2', '650', '650', '3', '3', '26', '0', null, null, '', null, '0', '1', '233', '0', 'black', 'бот', '172', '0', '0', '0', '0', '0', '0'), ('Шахтёр5', 'Шахтёр5', 'byzi6ev', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '280', '280', '280', '150', '0', '0', '0.00', '2', '0', '450', '450', '3', '3', '24', '0', null, null, '', null, '0', '1', '230', '0', 'black', 'бот', '307', '0', '0', '0', '0', '0', '0'), ('Минотавр', 'Минотавр', 'a7i8o', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '250', '240', '200', '0', '0', '0.00', '0', '6', '650', '650', '3', '3', '26', '0', null, null, '', null, '0', '1', '231', '0', 'black', 'бот', '899', '0', '0', '0', '0', '0', '0'), ('Минотавр1', 'Минотавр1', 'SoVewu', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '230', '250', '250', '170', '0', '0', '0.00', '0', '2', '600', '600', '3', '3', '26', '0', null, null, '', null, '0', '1', '232', '0', 'black', 'бот', '1166', '0', '0', '0', '0', '0', '0'), ('Минотавр3', 'Минотавр3', '2i7oZy6', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '250', '250', '170', '0', '0', '0.00', '2', '1', '600', '600', '3', '3', '26', '0', null, null, '', null, '0', '1', '234', '0', 'black', 'бот', '824', '0', '0', '0', '0', '0', '0'), ('Минотавр5', 'Минотавр5', 'GuVuHoMuv', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '230', '200', '230', '170', '0', '0', '0.00', '0', '4', '600', '600', '3', '3', '26', '0', null, null, '', null, '0', '1', '236', '0', 'black', 'бот', '720', '0', '0', '0', '0', '0', '0'), ('Небесный', 'Небесный', 'yPiZoLo9oQ', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '250', '250', '600', '0', '0', '0.00', '0', '7', '800', '800', '3', '3', '28', '0', null, null, '', null, '0', '1', '237', '0', 'black', 'бот', '189', '0', '0', '0', '0', '0', '0'), ('Небесный1', 'Небесный1', 'otuTu7o', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '280', '250', '200', '0', '0', '0.00', '2', '4', '800', '800', '3', '3', '28', '0', null, null, '', null, '0', '1', '238', '0', 'black', 'бот', '908', '0', '0', '0', '0', '0', '0'), ('Рыцарь', 'Рыцарь', 'olaLolu9', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '30', '15', '25', '20', '0', '0', '0.00', '1', '9', '75', '75', '3', '3', '8', '0', null, null, '', null, '0', '1', '307', '0', 'black', 'бот', '1021', '0', '0', '0', '0', '0', '0'), ('Стрелок1', 'Стрелок1', 'Di7ojoSy6', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '20', '20', '20', '15', '0', '0', '0.00', '4', '8', '45', '45', '3', '3', '5', '0', null, null, '', null, '0', '1', '302', '0', 'black', 'бот', '462', '0', '0', '0', '0', '0', '0'), ('Рыцарь4', 'Рыцарь4', 'So1yVi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '25', '25', '20', '20', '0', '0', '0.00', '0', '12', '70', '70', '3', '3', '8', '0', null, null, '', null, '0', '1', '312', '0', 'black', 'бот', '274', '0', '0', '0', '0', '0', '0'), ('Рыцарь1', 'Рыцарь1', 'eZoSeJ', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '30', '30', '30', '25', '0', '0', '0.00', '1', '5', '80', '80', '3', '3', '8', '0', null, null, '', null, '0', '1', '308', '0', 'black', 'бот', '1054', '0', '0', '0', '0', '0', '0'), ('Рыцарь2', 'Рыцарь2', '5uQiNa', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '20', '25', '20', '20', '0', '0', '0.00', '0', '4', '75', '75', '3', '3', '8', '0', null, null, '', null, '0', '1', '310', '0', 'black', 'бот', '346', '0', '0', '0', '0', '0', '0'), ('Рыцарь3', 'Рыцарь3', 'RoSyr', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '22', '25', '25', '20', '0', '0', '0.00', '0', '6', '69', '69', '3', '3', '8', '0', null, null, '', null, '0', '1', '311', '0', 'black', 'бот', '351', '0', '0', '0', '0', '0', '0'), ('Рыцарь5', 'Рыцарь5', 'toByRo3', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '25', '25', '25', '20', '0', '0', '0.00', '1', '10', '75', '75', '3', '3', '8', '0', null, null, '', null, '0', '1', '313', '0', 'black', 'бот', '992', '0', '0', '0', '0', '0', '0'), ('Громобой', 'Громобой', 'a7a7oMyGiZ', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '350', '350', '250', '250', '0', '0', '0.00', '2', '21', '1000', '1000', '3', '3', '30', '0', null, null, '', null, '0', '1', '323', '0', 'black', 'бот', '803', '0', '0', '0', '0', '0', '0'), ('Громобой1', 'Громобой1', 'exubaRo', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '320', '300', '250', '600', '0', '0', '0.00', '1', '16', '1000', '1000', '3', '3', '30', '0', null, null, '', null, '0', '1', '324', '0', 'black', 'бот', '366', '0', '0', '0', '0', '0', '0'), ('Громобой2', 'Громобой2', '7yvaqu8', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '350', '300', '320', '800', '0', '0', '0.00', '1', '22', '1000', '1000', '3', '3', '30', '0', null, null, '', null, '0', '1', '325', '0', 'black', 'бот', '1130', '0', '0', '0', '0', '0', '0'), ('Громобой4', 'Громобой4', 'nevoM', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '200', '250', '250', '200', '0', '0', '0.00', '1', '23', '600', '600', '3', '3', '30', '0', null, null, '', null, '0', '1', '326', '0', 'black', 'бот', '1036', '0', '0', '0', '0', '0', '0'), ('Громобой5', 'Громобой5', 'lo3yQuZa8a', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '300', '300', '300', '800', '0', '0', '0.00', '1', '22', '1000', '1000', '3', '3', '30', '0', null, null, '', null, '0', '1', '327', '0', 'black', 'бот', '894', '0', '0', '0', '0', '0', '0'), ('Дровасек', 'Дровасек', 'PodaWujy', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '650', '500', '500', '1000', '0', '0', '0.00', '5', '0', '2500', '2500', '3', '3', '35', '0', null, null, '', null, '0', '1', '389', '0', 'black', 'бот', '249', '0', '0', '0', '0', '0', '0'), ('Новичок2', 'Новичок2', 'iTaQisiGu', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '7', '7', '6', '5', '0', '0', '0.00', '5', '8', '18', '18', '3', '3', '0', '0', null, null, '', null, '0', '1', '405', '0', 'black', 'бот', '1102', '0', '0', '0', '0', '0', '0'), ('Новичок1', 'Новичок1', 'oluhoNuwi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '7', '6', '7', '7', '0', '0', '0.00', '1', '4', '21', '21', '3', '3', '0', '0', null, null, '', null, '0', '1', '404', '0', 'black', 'бот', '801', '0', '0', '0', '0', '0', '0'), ('Воришка', 'Воришка', 'y8eWu1oLa', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '10', '8', '8', '8', '0', '0', '0.00', '1', '10', '25', '25', '3', '3', '2', '0', null, null, '', null, '0', '1', '408', '0', 'black', 'бот', '300', '0', '0', '0', '0', '0', '0'), ('Новичок4', 'Новичок4', 'Da7aM', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '5', '6', '5', '7', '0', '0', '0.00', '0', '8', '18', '18', '3', '3', '0', '0', null, null, '', null, '0', '1', '407', '0', 'black', 'бот', '401', '0', '0', '0', '0', '0', '0'), ('Воришка2', 'Воришка2', 'asity8i5', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '13', '10', '9', '10', '0', '0', '0.00', '5', '3', '26', '26', '3', '3', '2', '0', null, null, '', null, '0', '1', '410', '0', 'black', 'бот', '686', '0', '0', '0', '0', '0', '0'), ('Шакал2', 'Шакал2', 'lu5ome', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '350', '400', '300', '800', '0', '0', '0.00', '0', '10', '1400', '1400', '3', '3', '31', '0', null, null, '', null, '0', '1', '401', '0', 'black', 'бот', '464', '0', '0', '0', '0', '0', '0'), ('Дровасек2', 'Дровасек2', 'Ji7u1', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '500', '450', '350', '800', '0', '0', '0.00', '3', '0', '2500', '2500', '3', '3', '35', '0', null, null, '', null, '0', '1', '391', '0', 'black', 'бот', '326', '0', '0', '0', '0', '0', '0'), ('Дровасек3', 'Дровасек3', 'yWu5u', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '450', '380', '450', '1000', '0', '0', '0.00', '1', '4', '2350', '2350', '3', '3', '35', '0', null, null, '', null, '0', '1', '392', '0', 'black', 'бот', '900', '0', '0', '0', '0', '0', '0'), ('Блейзер', 'Блейзер', 'iMyXuRi', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '400', '400', '450', '700', '0', '0', '0.00', '3', '25', '1500', '1500', '3', '3', '33', '0', null, null, '', null, '0', '1', '394', '0', 'black', 'бот', '179', '0', '0', '0', '0', '0', '0'), ('Блейзер1', 'Блейзер1', 'wyGuvuB', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '450', '400', '350', '800', '0', '0', '0.00', '1', '25', '1200', '1200', '3', '3', '33', '0', null, null, '', null, '0', '1', '395', '0', 'black', 'бот', '1139', '0', '0', '0', '0', '0', '0'), ('Шакал1', 'Шакал1', 'aHeViJeGyL', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '400', '250', '350', '600', '0', '0', '0.00', '1', '8', '1200', '1200', '3', '3', '31', '0', null, null, '', null, '0', '1', '400', '0', 'black', 'бот', '592', '0', '0', '0', '0', '0', '0'), ('Блейзер3', 'Блейзер3', 'agiRisax', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '380', '350', '350', '1000', '0', '0', '0.00', '0', '22', '1500', '1500', '3', '3', '33', '0', null, null, '', null, '0', '1', '397', '0', 'black', 'бот', '120', '0', '0', '0', '0', '0', '0'), ('Шакал', 'Шакал', 'itoTa4a9a', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '400', '300', '450', '500', '0', '0', '0.00', '3', '3', '1700', '1700', '3', '3', '31', '0', null, null, '', null, '0', '1', '399', '0', 'black', 'бот', '1161', '0', '0', '0', '0', '0', '0'), ('Шакал3', 'Шакал3', 'ezu3a', null, '', 'M', null, '0', '', 'map', 'map', '0', '99', null, '450', '300', '350', '500', '0', '0', '0.00', '1', '5', '1300', '1300', '3', '3', '31', '0', null, null, '', null, '0', '1', '402', '0', 'black', 'бот', '3', '0', '0', '0', '0', '0', '0'), ('Нумизиат', 'Нумизиат', '01qJEQ', 'Создатель', '', 'M', '111950', '0', '', 'pl', 'pl', '2', '0', 'Творец', '3', '3', '3', '3', '3', '0', '20.00', '0', '0', '18', '18', '3', '3', '200', '0', '2008-06-08 23:09:13', null, '', null, '0', '1', '444', '78718', 'black', 'бот', '0', '0', '0', '0', '0', '0', '0'), ('Тренер', 'Тренер', 'ybemoby', null, '', 'M', null, '0', '', 'bot_train', 'bot_train', '0', '99', null, '150', '69', '80', '80', '0', '0', '0.00', '2', '1', '0', '307', '3', '3', '55', '0', null, null, '', null, '0', '1', '469', '0', 'black', 'бот', '757', '0', '0', '0', '0', '0', '0'), ('Бот_255', 'Бот_255', 'yDySoLySy', null, '', 'M', null, '0', '', 'zamok_train', 'zamok_255__train', '0', '255', null, '21', '23', '10', '39', '0', '109', '0.00', '2', '5', '224', '224', '3', '3', '13', '0', null, null, '', null, '0', '1', '470', '0', 'black', 'бот', '252', '0', '0', '0', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_postonthewall`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_postonthewall`;
CREATE TABLE `timeofwars_postonthewall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `txt` text NOT NULL,
  `attachment` varchar(200) NOT NULL,
  `complete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_posts`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_posts`;
CREATE TABLE `timeofwars_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topicid` int(11) NOT NULL,
  `Author` char(30) NOT NULL,
  `msgtext` text NOT NULL,
  `msgdate` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_presents`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_presents`;
CREATE TABLE `timeofwars_presents` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `Player` varchar(20) NOT NULL,
  `presentName` varchar(20) NOT NULL,
  `presentIMG` varchar(30) NOT NULL DEFAULT '0',
  `presentDATE` int(11) NOT NULL,
  `presentMSG` varchar(50) NOT NULL,
  `presentFROM` varchar(20) NOT NULL,
  `for_a_while` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_referal`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_referal`;
CREATE TABLE `timeofwars_referal` (
  `un` int(11) NOT NULL AUTO_INCREMENT,
  `refer_id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `add_time` int(11) NOT NULL,
  `http_referer` text NOT NULL,
  `login` char(20) NOT NULL,
  `status` set('bad','good','inprogress','none') NOT NULL DEFAULT 'none',
  PRIMARY KEY (`un`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_remind`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_remind`;
CREATE TABLE `timeofwars_remind` (
  `Username` char(20) NOT NULL,
  `Time` varchar(30) NOT NULL DEFAULT '0',
  KEY `Username` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_roul_bank`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_roul_bank`;
CREATE TABLE `timeofwars_roul_bank` (
  `id` tinyint(2) NOT NULL DEFAULT '2',
  `money` double(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_roul_bank`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_roul_bank` VALUES ('2', '2.00');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_roul_bets`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_roul_bets`;
CREATE TABLE `timeofwars_roul_bets` (
  `betid` int(11) NOT NULL AUTO_INCREMENT,
  `Username` char(20) DEFAULT NULL,
  `bet` float(4,2) NOT NULL DEFAULT '0.00',
  `betto` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`betid`)
) ENGINE=MyISAM AUTO_INCREMENT=1934 DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_roul_time`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_roul_time`;
CREATE TABLE `timeofwars_roul_time` (
  `shouldstart` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_roul_time`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_roul_time` VALUES ('1390916821');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_roul_wins`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_roul_wins`;
CREATE TABLE `timeofwars_roul_wins` (
  `winid` int(11) NOT NULL AUTO_INCREMENT,
  `Username` char(30) NOT NULL DEFAULT '',
  `bet` float(4,2) NOT NULL DEFAULT '0.00',
  `betto` tinyint(3) NOT NULL DEFAULT '0',
  `win` float(8,2) NOT NULL DEFAULT '0.00',
  `wintime` int(11) DEFAULT NULL,
  PRIMARY KEY (`winid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_session_data`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_session_data`;
CREATE TABLE `timeofwars_session_data` (
  `user_id` smallint(5) NOT NULL,
  `last_enemy_attack` int(11) unsigned NOT NULL,
  `last_vamp_attack` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_smith`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_smith`;
CREATE TABLE `timeofwars_smith` (
  `Player` char(20) NOT NULL DEFAULT '',
  `Exp` mediumint(5) DEFAULT '0',
  PRIMARY KEY (`Player`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_smith`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_smith` VALUES ('Admin', '5481');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_smith_shop`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_smith_shop`;
CREATE TABLE `timeofwars_smith_shop` (
  `metall` set('gold','trash','iron') NOT NULL,
  `num` mediumint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`metall`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_smith_shop`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_smith_shop` VALUES ('gold', '1');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_sms_2uron`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_sms_2uron`;
CREATE TABLE `timeofwars_sms_2uron` (
  `Username` char(20) NOT NULL,
  `Time` char(30) NOT NULL,
  `for_time` tinyint(1) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_sms_3uron`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_sms_3uron`;
CREATE TABLE `timeofwars_sms_3uron` (
  `Username` char(20) NOT NULL,
  `Time` char(30) NOT NULL,
  `for_time` tinyint(1) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_sms_euro`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_sms_euro`;
CREATE TABLE `timeofwars_sms_euro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` smallint(5) NOT NULL,
  `user_id` char(11) NOT NULL,
  `msg` varchar(20) NOT NULL,
  `skey` char(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `smsid` int(11) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `how_much` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_sms_kr`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_sms_kr`;
CREATE TABLE `timeofwars_sms_kr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` smallint(5) NOT NULL,
  `user_id` char(11) NOT NULL,
  `msg` varchar(20) NOT NULL,
  `skey` char(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `smsid` int(11) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `how_much` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_sms_turnir`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_sms_turnir`;
CREATE TABLE `timeofwars_sms_turnir` (
  `user_id` char(15) NOT NULL,
  `sms_time` char(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_stopped`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_stopped`;
CREATE TABLE `timeofwars_stopped` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Time` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_temple_spells`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_temple_spells`;
CREATE TABLE `timeofwars_temple_spells` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `img` char(50) NOT NULL,
  `type` set('destroy','magic','heal','help') NOT NULL,
  `min_level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `points_price` smallint(3) unsigned NOT NULL DEFAULT '0',
  `kr_price` smallint(5) unsigned NOT NULL DEFAULT '0',
  `take_mana` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `review` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_things`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things`;
CREATE TABLE `timeofwars_things` (
  `Owner` char(20) NOT NULL DEFAULT '',
  `Un_Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Id` char(16) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Cost` mediumint(8) unsigned DEFAULT '0',
  `Level_need` tinyint(3) unsigned DEFAULT '0',
  `Stre_need` smallint(5) unsigned DEFAULT '0',
  `Agil_need` smallint(5) unsigned DEFAULT '0',
  `Intu_need` smallint(5) unsigned DEFAULT '0',
  `Intl_need` smallint(5) DEFAULT '0',
  `Endu_need` smallint(5) unsigned DEFAULT '0',
  `Clan_need` tinyint(3) unsigned DEFAULT '0',
  `Level_add` smallint(6) DEFAULT '0',
  `Stre_add` smallint(6) DEFAULT '0',
  `Agil_add` smallint(6) DEFAULT '0',
  `Intu_add` smallint(6) DEFAULT '0',
  `Endu_add` smallint(6) DEFAULT '0',
  `MINdamage` smallint(5) unsigned DEFAULT '0',
  `MAXdamage` smallint(5) unsigned DEFAULT '0',
  `Crit` mediumint(8) DEFAULT '0',
  `AntiCrit` mediumint(8) DEFAULT '0',
  `Uv` mediumint(8) DEFAULT '0',
  `AntiUv` mediumint(8) DEFAULT '0',
  `Armor1` smallint(6) DEFAULT '0',
  `Armor2` smallint(6) DEFAULT '0',
  `Armor3` smallint(6) DEFAULT '0',
  `Armor4` smallint(6) DEFAULT '0',
  `MagicID` char(30) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT '0',
  `MAXwear` char(6) DEFAULT '1',
  `Wear_ON` enum('0','1') NOT NULL DEFAULT '0',
  `Srab` int(11) NOT NULL DEFAULT '0',
  `Count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Un_Id`),
  KEY `owner_ind` (`Owner`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_things`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things` VALUES ('Admin', '15', 'room_key', 'Ключ от квартиры №1 (оригинал)', '15', '5', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '0', '500', '0', '0', '0'), ('Admin', '8', 'fireball30', 'Малый огненный шар', '11', '3', '2', '0', '0', '6', '0', '0', '0', '0', '0', '0', '0', '0', '5', '15', '0', '0', '0', '0', '0', '0', '0', '0', 'Fireball', '2', '5', '0', '75', '0'), ('Admin', '9', 'e_me3', '[Освящено] Меч самурая', '2', '61', '6', '10', '0', '0', '0', '10', '0', '0', '0', '2', '0', '18', '10', '14', '0', '0', '30', '0', '0', '0', '0', '0', '', '1', '45', '1', '0', '0'), ('Admin', '12', 'items/krasnyi', 'Подосиновик', '15', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '0', '22'), ('Admin', '13', 'items/sandal', 'Листья сандалового дерева', '15', '6', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '0', '1', '0', '0', '1'), ('Admin', '14', 'lessapogi', 'Лесные сапоги', '10', '10', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '1', '10', '1', '0', '0'), ('Admin', '16', 'room_key', 'Ключ от квартиры №1 (дубликат)', '15', '5', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, '0', '500', '0', '0', '0'), ('Admin', '21', 'sv_tr', 'Лечение травм', '11', '10', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Лечение', '2', '3', '0', '50', '0'), ('Admin', '31', 'sm5', '[Освящено] Пчелиное жало', '2', '147', '12', '15', '15', '15', '0', '0', '0', '0', '1', '2', '0', '7', '22', '29', '24', '12', '18', '6', '2', '0', '2', '0', '', '0', '70', '0', '0', '0'), ('Admin', '34', 'recept_1', 'Рецепт эликсира силы (+5)', '16', '20', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Рецепт изготовления эликсира', '0', '1', '0', '0', '0'), ('Admin', '38', 'sv_tr', 'Лечение травмы', '12', '20', '3', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Лечение', '0', '10', '0', '75', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_apteka`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_apteka`;
CREATE TABLE `timeofwars_things_apteka` (
  `Un_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id` varchar(30) NOT NULL,
  `Thing_Name` varchar(40) NOT NULL,
  `Level_need` smallint(3) NOT NULL,
  `Cost` smallint(5) NOT NULL,
  `Amount` smallint(4) NOT NULL,
  `About` text NOT NULL,
  PRIMARY KEY (`Un_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_things_apteka`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_apteka` VALUES ('1', 'recept_1', 'Рецепт эликсира силы (+5)', '2', '20', '984', 'Для приготовления эликсира силы потребуется:<br /> 1 дурман, 2 девятесила, 2 мухомора'), ('2', 'recept_2', 'Рецепт эликсира ловкости (+6)', '2', '30', '996', 'Для приготовления эликсира ветра потребуется:<br /> 1 жень-шень, 1 пастушья сумка, 1 хмель, 3 масленка'), ('3', 'recept_3', 'Рецепт эликсира великого разума (+8)', '2', '35', '997', 'Дли приготовления эликсира потребуется:<br />2 мухомора, 4 цвета валерьяны, 5 восточных мака, 6 дурманов, 3 опят'), ('4', 'recept_4', 'Рецепт вкусняшки', '0', '100', '998', 'Готовит эликсир для пополнения хп. Емкость зависит от уровня обладателя.');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_apteka_trava`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_apteka_trava`;
CREATE TABLE `timeofwars_things_apteka_trava` (
  `trava` set('items/rose_g','items/maslenok','items/krasnyi','items/opata','items/siroezka','items/lisichka','items/muhomor','items/pustir','items/durman','items/vanil','items/valer','items/sandal','items/veresk','items/shalf_r','items/shalf','items/mak','items/devatisil','items/hmel','items/sumka','items/vetrenica','items/vasilek','items/kalendula','items/jen-shen','items/grass2','items/vetka','items/grass1') NOT NULL,
  `num` mediumint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trava`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_things_apteka_trava`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_apteka_trava` VALUES ('items/krasnyi', '39'), ('items/rose_g', '0'), ('items/muhomor', '0'), ('items/sandal', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_euroshop`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_euroshop`;
CREATE TABLE `timeofwars_things_euroshop` (
  `Amount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Otdel` tinyint(4) NOT NULL DEFAULT '0',
  `Id` char(40) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Eurocost` bigint(20) NOT NULL DEFAULT '0',
  `Cost` mediumint(3) unsigned DEFAULT NULL,
  `Level_need` tinyint(3) unsigned DEFAULT NULL,
  `Stre_need` smallint(5) unsigned DEFAULT NULL,
  `Agil_need` smallint(5) unsigned DEFAULT NULL,
  `Intu_need` smallint(5) unsigned DEFAULT NULL,
  `Endu_need` smallint(5) unsigned DEFAULT NULL,
  `Clan_need` tinyint(3) unsigned DEFAULT NULL,
  `Level_add` smallint(6) DEFAULT NULL,
  `Stre_add` smallint(6) DEFAULT NULL,
  `Agil_add` smallint(6) DEFAULT NULL,
  `Intu_add` smallint(6) DEFAULT NULL,
  `Endu_add` smallint(6) DEFAULT NULL,
  `MINdamage` smallint(5) unsigned DEFAULT NULL,
  `MAXdamage` smallint(5) unsigned DEFAULT NULL,
  `Crit` smallint(6) DEFAULT NULL,
  `AntiCrit` smallint(6) DEFAULT NULL,
  `Uv` smallint(6) DEFAULT NULL,
  `AntiUv` smallint(6) DEFAULT NULL,
  `Armor1` smallint(6) DEFAULT NULL,
  `Armor2` smallint(6) DEFAULT NULL,
  `Armor3` smallint(6) DEFAULT NULL,
  `Armor4` smallint(6) DEFAULT NULL,
  `MagicID` char(30) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT NULL,
  `MAXwear` char(6) DEFAULT NULL,
  `Srab` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_things_euroshop`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_euroshop` VALUES ('1000', '3', 'amul_c', 'Амулет черепа (артефакт)', '1', '45', '630', '12', null, '18', null, '18', null, null, null, null, null, '45', '10', '15', null, '50', null, null, '18', '18', '18', '18', null, '0', '200', '0'), ('999', '6', 'antimag1', 'Защита от магии', '15', '120', '1000', '10', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Защита 50%', '0', '500', '50'), ('998', '1', 'arm_1_13', 'Клинок отваги (артефакт)', '2', '70', '900', '10', null, null, null, null, null, null, '5', null, '2', null, '55', '68', '85', '15', null, '50', null, null, null, null, null, '0', '150', '0'), ('989', '1', 'arm_1_43', 'Меч Якудзы (артефакт)', '2', '25', '350', '5', '0', '0', null, null, null, null, '2', '2', null, '10', '20', '25', '25', '5', null, '15', null, '5', null, null, null, '0', '70', '0'), ('1000', '2', 'botart_1', 'Ботинки возрождения Тьмы (артефакт)', '10', '35', '350', '10', '10', '0', '0', '10', '0', '0', '0', '0', '0', '30', '16', '28', '48', '20', '0', '55', '0', '0', '5', '20', '', '0', '150', '0'), ('999', '2', 'botart_2', 'Ботинки Добрый вечер (артефакт)', '10', '35', '900', '12', '0', '0', '10', '12', '0', '0', '0', '0', '0', '55', '23', '44', '71', '0', '0', '26', '0', '0', '0', '30', '', '0', '200', '0'), ('995', '2', 'br_5_01', 'Броня шалости (артефакт)', '3', '30', '450', '5', null, null, null, null, null, null, null, null, '4', '50', null, null, null, '35', '15', '45', null, '13', '13', null, null, '0', '70', '0'), ('1000', '2', 'br_5_03', 'Броня Комфорта (артефакт)', '3', '50', '900', '13', null, null, null, null, null, null, null, '2', '4', '90', null, null, null, '55', '75', '25', null, '25', '25', null, null, '0', '130', '0'), ('1000', '6', 'crit100', '+100 крита (именная вещь) (ability)', '15', '50', '500', '10', null, null, null, null, null, null, null, null, null, null, null, null, '100', null, null, null, null, null, null, null, 'Дополнительный крит', '0', '100', '100'), ('999', '6', 'crit200', '+200 крита (именная вещь) (ability)', '15', '100', '1000', '15', null, null, null, null, null, null, null, null, null, null, null, null, '200', null, null, null, null, null, null, null, 'Дополнительный крит', '0', '100', '100'), ('998', '6', 'crit50', '+50 крита (именная вещь) (ability)', '15', '20', '250', '5', null, null, null, null, null, null, null, null, null, null, null, null, '50', null, null, null, null, null, null, null, 'Дополнительный крит', '0', '100', '100'), ('997', '6', 'damage100', '+100 урона (именная вещь) (ability)', '15', '70', '500', '10', null, null, null, null, null, null, null, null, null, null, '100', '100', '0', null, null, null, null, null, null, null, 'Дополнительный урон', '0', '100', '100'), ('998', '6', 'damage200', '+200 урона (именная вещь) (ability)', '15', '140', '1000', '15', null, null, null, null, null, null, null, null, null, null, '200', '200', '0', null, null, null, null, null, null, null, 'Дополнительный урон', '0', '100', '100'), ('1000', '6', 'damage50', '+50 урона (именная вещь) (ability)', '15', '50', '250', '5', null, null, null, null, null, null, null, null, null, null, '50', '50', null, null, null, null, null, null, null, null, 'Дополнительный урон', '0', '100', '100'), ('1000', '1', 'drob_2_01', 'Летаргия ужаса (артефакт)', '2', '45', '600', '8', null, null, null, null, null, null, '5', '2', '5', null, '35', '50', '55', '25', '10', '35', null, null, null, null, null, '0', '80', '0'), ('999', '5', 'h12l20', 'Импортный томатный сок 220 мл.', '11', '2', '14', '0', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 20 HP', '0', '11', '100'), ('999', '5', 'h20l50', 'Импортный томатный сок 350 мл.', '11', '3', '21', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 50 HP', '0', '7', '100'), ('959', '5', 'h45l50', 'Импортный томатный сок 750 мл.', '11', '6', '42', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 50 HP', '0', '15', '100'), ('998', '5', 'h60l20', 'Импортный томатный сок 100 мл.', '11', '1', '7', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 20 HP', '0', '5', '100'), ('998', '2', 'helm_black', 'Шлем Черного рыцаря (артефакт)', '7', '70', '1000', '12', '20', null, '19', null, null, null, null, '3', null, '50', '9', '19', null, '65', null, '75', '21', null, null, null, null, '0', '300', '0'), ('999', '2', 'helm_krest', 'Шлем крестоносца (артефакт)', '7', '40', '300', '10', '10', null, null, '12', null, null, null, null, null, '32', null, null, null, '45', null, '45', '21', null, null, null, null, '0', '100', '0'), ('1000', '3', 'kulon', 'Ожерелье Мертвецов (артефакт)', '1', '45', '1000', '9', '10', '0', '0', '10', '0', '0', '0', '0', '0', '30', '5', '11', '0', '49', '37', '20', '15', '15', '15', '15', '', '0', '150', '0'), ('991', '4', 'nap01', 'Свиток нападения', '12', '1', '7', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Нападение', '0', '6', '75'), ('991', '4', 'nap02', 'Свиток нападения', '12', '2', '14', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Нападение', '0', '12', '75'), ('998', '2', 'perch_stal', 'Стальные перчатки (артефакт)', '8', '30', '450', '12', '10', null, null, '12', null, null, null, null, null, null, '20', '32', '80', '25', null, null, null, '8', null, null, null, '0', '150', '0'), ('1000', '1', 'rapira', 'Рапира уничтожения (артефакт)', '2', '25', '300', '5', null, '0', null, '0', null, null, '2', null, '3', '10', '25', '32', '35', null, '0', '0', null, null, null, null, null, '0', '60', '0'), ('994', '3', 'ring_dd', 'Кольцо двойного урона (артефакт)', '4', '100', '150', '8', '8', null, null, '8', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'двойной урон', '0', '100', '0'), ('996', '3', 'ring_live', 'Кольцо Благородия (артефакт)', '4', '20', '280', '6', '10', '10', '10', '10', '0', null, null, null, null, '120', null, null, null, null, null, null, null, null, null, null, null, '0', '100', '0'), ('1000', '2', 'shitart_1', 'Щит Льва (артефакт)', '9', '40', '400', '10', '0', '10', '0', '10', '0', '0', '0', '0', '0', '20', '0', '0', '11', '50', '41', '10', '20', '20', '20', '20', '', '0', '150', '0'), ('1000', '2', 'shitart_2', 'Щит Мертвецов (артефакт)', '9', '45', '950', '14', '10', '0', '0', '14', '0', '0', '0', '0', '0', '85', '14', '22', '0', '82', '62', '20', '35', '35', '35', '35', '', '0', '200', '0'), ('1000', '4', 'svitok1', 'Вмешательство в бой', '12', '2', '14', '8', '0', '0', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Нападение', '0', '8', '100'), ('1000', '4', 'svitok2', 'Вмешательство в бой', '12', '3', '21', '9', '10', '10', '10', '10', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Нападение', '0', '12', '100'), ('998', '4', 'sv_tr', 'Лечение травмы', '12', '3', '20', '3', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лечение', '0', '10', '75'), ('998', '4', 's_exit', 'Сбежать из боя', '11', '5', '35', '8', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Уход', '0', '10', '100'), ('998', '4', 's_pod', 'Подчинение воли', '11', '10', '140', '10', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Подчинение', '0', '5', '100'), ('999', '6', 'uv100', '+100 уворота (именная вещь) (ability)', '15', '50', '500', '10', null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '100', null, null, null, null, null, 'Дополнительный уворот', '0', '100', '100'), ('998', '6', 'uv200', '+200 уворота (именная вещь) (ability)', '15', '100', '1000', '15', null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '200', null, null, null, null, null, 'Дополнительный уворот', '0', '100', '100'), ('998', '6', 'uv50', '+50 уворота (именная вещь) (ability)', '15', '25', '250', '5', null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '50', null, null, null, null, null, 'Дополнительный уворот', '0', '100', '100'), ('999', '6', 'whitecrit30', '+30 чистого крита (именная вещь) (ability)', '15', '100', '1000', '10', null, null, null, null, null, null, null, null, null, null, null, null, '30', null, null, null, null, null, null, null, 'Чистый крит', '0', '100', '100'), ('1000', '3', 'ko855', 'Проклятое кольцо (артефакт)', '4', '40', '100', '11', null, '18', '17', '14', null, null, '1', '5', '6', null, '6', '14', '65', '5', '40', '3', null, null, null, null, null, '0', '100', '0');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_komplekt`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_komplekt`;
CREATE TABLE `timeofwars_things_komplekt` (
  `Username` char(20) NOT NULL,
  `slot_thing` char(50) DEFAULT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_things_komplekt_turnir`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_komplekt_turnir`;
CREATE TABLE `timeofwars_things_komplekt_turnir` (
  `Username` char(20) NOT NULL,
  `slot_thing` char(50) DEFAULT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_things_lock`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_lock`;
CREATE TABLE `timeofwars_things_lock` (
  `Owner` char(20) NOT NULL DEFAULT '',
  `Un_Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Id` char(16) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Cost` mediumint(8) unsigned DEFAULT '0',
  `Level_need` tinyint(3) unsigned DEFAULT '0',
  `Stre_need` smallint(5) unsigned DEFAULT '0',
  `Agil_need` smallint(5) unsigned DEFAULT '0',
  `Intu_need` smallint(5) unsigned DEFAULT '0',
  `Intl_need` smallint(5) DEFAULT '0',
  `Endu_need` smallint(5) unsigned DEFAULT '0',
  `Clan_need` tinyint(3) unsigned DEFAULT '0',
  `Level_add` smallint(6) DEFAULT '0',
  `Stre_add` smallint(6) DEFAULT '0',
  `Agil_add` smallint(6) DEFAULT '0',
  `Intu_add` smallint(6) DEFAULT '0',
  `Endu_add` smallint(6) DEFAULT '0',
  `MINdamage` smallint(5) unsigned DEFAULT '0',
  `MAXdamage` smallint(5) unsigned DEFAULT '0',
  `Crit` mediumint(8) DEFAULT '0',
  `AntiCrit` mediumint(8) DEFAULT '0',
  `Uv` mediumint(8) DEFAULT '0',
  `AntiUv` mediumint(8) DEFAULT '0',
  `Armor1` smallint(6) DEFAULT '0',
  `Armor2` smallint(6) DEFAULT '0',
  `Armor3` smallint(6) DEFAULT '0',
  `Armor4` smallint(6) DEFAULT '0',
  `MagicID` char(30) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT '0',
  `MAXwear` char(6) DEFAULT '1',
  `Wear_ON` enum('0','1') NOT NULL DEFAULT '0',
  `Srab` int(11) NOT NULL DEFAULT '0',
  `Count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Un_Id`),
  KEY `owner_ind` (`Owner`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_things_presentshop`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_presentshop`;
CREATE TABLE `timeofwars_things_presentshop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presentNAME` varchar(30) NOT NULL,
  `presentIMG` varchar(30) NOT NULL,
  `presentABOUT` varchar(200) NOT NULL,
  `presentPRICE` smallint(5) NOT NULL,
  `presentCOUNT` smallint(4) NOT NULL DEFAULT '999',
  `otdel` tinyint(2) NOT NULL DEFAULT '1',
  `for_a_while` tinyint(3) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_things_presentshop`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_presentshop` VALUES ('23', 'Много роз', 'fl/2', '', '5', '998', '1', '5'), ('22', 'Летний букет', 'fl/1', '', '5', '999', '1', '5'), ('24', 'Нарцисс', 'fl/3', '', '5', '998', '1', '5'), ('25', 'Подсолнух', 'fl/4', '', '5', '999', '1', '5'), ('26', 'Розовые розы', 'fl/5', '', '5', '999', '1', '5'), ('27', 'Розовый букет', 'fl/6', '', '5', '999', '1', '5'), ('28', 'Розы', 'fl/7', '', '5', '999', '1', '5'), ('29', 'Тюльпаны', 'fl/8', '', '5', '999', '1', '5'), ('30', 'Древняя печатка', 'he/1', '', '10', '999', '2', '10'), ('31', 'Зажигалка Трансформеры', 'he/2', '', '10', '999', '2', '7'), ('32', 'Золотой зиппо', 'he/3', '', '12', '999', '2', '7'), ('33', 'Мистическое кольцо', 'he/4', '', '20', '999', '2', '7'), ('34', 'Парфюм', 'he/5', '', '10', '999', '2', '7'), ('35', 'Печатка', 'he/6', '', '10', '999', '2', '5'), ('36', 'Серебряный зиппо', 'he/7', '', '8', '999', '2', '5'), ('37', 'Сигары', 'he/8', '', '30', '999', '2', '3'), ('38', 'Сигары', 'he/9', '', '20', '999', '2', '3'), ('39', 'Духи', 'she/1', '', '10', '999', '3', '7'), ('40', 'Духи Версаче', 'she/2', '', '16', '999', '3', '7'), ('41', 'Духи вонючие', 'she/3', '', '33', '999', '3', '20'), ('42', 'Зеркальце', 'she/4', '', '10', '999', '3', '5'), ('43', 'Кольцо с жемчугом', 'she/5', '', '50', '999', '3', '30'), ('44', 'Кольцо', 'she/6', '', '50', '999', '3', '30'), ('45', 'Перстень', 'she/7', '', '50', '999', '3', '30'), ('46', 'Серебрянное кольцо', 'she/8', '', '30', '999', '3', '15'), ('47', 'Чёрное кольцо', 'she/9', '', '30', '999', '3', '15'), ('48', 'Жёлтый чебурашка', 'toy/1', '', '7', '998', '4', '5'), ('49', 'Каил', 'toy/2', '', '5', '998', '4', '5'), ('50', 'Тигрёнок', 'toy/3', '', '7', '998', '4', '5'), ('51', 'Хрюша', 'toy/4', '', '7', '999', '4', '5'), ('52', 'Чудик', 'toy/5', '', '5', '999', '4', '5'), ('53', 'Обручально кольцо(ж)', 'wed/1', '', '50', '999', '5', '30'), ('54', 'Обручальное кольцо(м)', 'wed/2', '', '50', '999', '5', '30'), ('55', 'Свадебные фигурки', 'wed/3', '', '10', '999', '5', '5'), ('56', 'Свадебные фигурки', 'wed/4', '', '10', '999', '5', '5'), ('57', 'Свадебные фигурки', 'wed/5', '', '10', '999', '5', '5'), ('58', 'Свадебный букет', 'wed/6', '', '5', '999', '5', '5'), ('59', 'Свадебный букет', 'wed/7', '', '5', '999', '5', '5'), ('60', 'Свадебный букет', 'wed/8', '', '5', '999', '5', '5'), ('61', 'Свадебный букет', 'wed/9', '', '5', '999', '5', '5'), ('62', 'Свадебный букет', 'wed/10', '', '5', '999', '5', '5'), ('63', 'Свадебный букет', 'wed/11', '', '5', '999', '5', '5'), ('64', 'Свадебный букет', 'wed/12', '', '5', '999', '5', '5'), ('65', 'Свадебный торт', 'wed/13', '', '10', '999', '5', '5'), ('66', 'Свадебный торт', 'wed/14', '', '10', '999', '5', '5'), ('67', 'Дорогой каньяк', 'oth/1', '', '10', '999', '6', '5'), ('68', 'Конфеты', 'oth/2', '', '8', '999', '6', '3'), ('69', 'Коньяк', 'oth/3', '', '12', '999', '6', '7'), ('71', 'Кружка пива', 'oth/5', '', '5', '999', '6', '5'), ('72', 'Советское шампанское', 'oth/6', '', '6', '998', '6', '5'), ('73', 'Чашечка кофе', 'oth/7', '', '5', '999', '6', '5'), ('74', 'Шампанское Одесса', 'oth/8', '', '10', '999', '6', '5'), ('75', 'Элитный Коньяк Хенеси', 'oth/9', '', '15', '999', '6', '7');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_presentshop_view`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_presentshop_view`;
CREATE TABLE `timeofwars_things_presentshop_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zamok_number` smallint(5) NOT NULL DEFAULT '1',
  `presentNAME` char(30) NOT NULL,
  `presentIMG` char(30) NOT NULL,
  `presentPRICE` int(11) NOT NULL,
  `presentDATEPOST` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_things_presentshop_zamok_255`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_presentshop_zamok_255`;
CREATE TABLE `timeofwars_things_presentshop_zamok_255` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presentNAME` char(30) NOT NULL,
  `presentIMG` char(30) NOT NULL,
  `presentABOUT` char(200) NOT NULL,
  `presentPRICE` int(11) NOT NULL,
  `presentCOUNT` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_things_samodel`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_samodel`;
CREATE TABLE `timeofwars_things_samodel` (
  `Owner` char(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `Un_Id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Id` char(16) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Otdel` enum('1','2','3') NOT NULL,
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Cost` float(8,0) unsigned DEFAULT NULL,
  `Level_need` tinyint(3) unsigned DEFAULT NULL,
  `Stre_need` smallint(5) unsigned DEFAULT NULL,
  `Agil_need` smallint(5) unsigned DEFAULT NULL,
  `Intu_need` smallint(5) unsigned DEFAULT NULL,
  `Endu_need` smallint(5) unsigned DEFAULT NULL,
  `Stre_add` smallint(6) DEFAULT NULL,
  `Agil_add` smallint(6) DEFAULT NULL,
  `Intu_add` smallint(6) DEFAULT NULL,
  `Endu_add` smallint(6) DEFAULT NULL,
  `MINdamage` smallint(5) unsigned DEFAULT NULL,
  `MAXdamage` smallint(5) unsigned DEFAULT NULL,
  `Crit` smallint(6) DEFAULT NULL,
  `AntiCrit` smallint(6) DEFAULT NULL,
  `Uv` smallint(6) DEFAULT NULL,
  `AntiUv` smallint(6) DEFAULT NULL,
  `Armor1` smallint(6) DEFAULT NULL,
  `Armor2` smallint(6) DEFAULT NULL,
  `Armor3` smallint(6) DEFAULT NULL,
  `Armor4` smallint(6) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT NULL,
  `MAXwear` char(6) DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Un_Id`),
  KEY `Un_Id` (`Un_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_things_samodel`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_samodel` VALUES ('Admin', '31085', 'smith_sh2', 'wqeq(made by s!.)', '1', '9', '6', '3', '3', '3', '3', '3', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '39', '1249721776'), ('Admin', '31083', 'smith_helm2', '1(made by s!.)', '2', '7', '5', '55', '55', '55', '55', '55', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '15', '1249721776');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_things_sell`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_sell`;
CREATE TABLE `timeofwars_things_sell` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `from_id` mediumint(8) unsigned NOT NULL,
  `to_id` mediumint(8) unsigned NOT NULL,
  `add_time` int(11) NOT NULL,
  `thing_id` mediumint(8) NOT NULL,
  `Cost` double(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_things_shop`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_things_shop`;
CREATE TABLE `timeofwars_things_shop` (
  `Amount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Otdel` tinyint(4) NOT NULL DEFAULT '0',
  `Id` char(16) NOT NULL DEFAULT '',
  `Thing_Name` char(80) NOT NULL DEFAULT '',
  `Slot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Cost` mediumint(3) unsigned DEFAULT NULL,
  `Level_need` tinyint(3) unsigned DEFAULT NULL,
  `Stre_need` smallint(5) unsigned DEFAULT NULL,
  `Agil_need` smallint(5) unsigned DEFAULT NULL,
  `Intu_need` smallint(5) unsigned DEFAULT NULL,
  `Endu_need` smallint(5) unsigned DEFAULT NULL,
  `Clan_need` tinyint(3) unsigned DEFAULT NULL,
  `Level_add` smallint(6) DEFAULT NULL,
  `Stre_add` smallint(6) DEFAULT NULL,
  `Agil_add` smallint(6) DEFAULT NULL,
  `Intu_add` smallint(6) DEFAULT NULL,
  `Endu_add` smallint(6) DEFAULT NULL,
  `MINdamage` smallint(5) unsigned DEFAULT NULL,
  `MAXdamage` smallint(5) unsigned DEFAULT NULL,
  `Crit` smallint(6) DEFAULT NULL,
  `AntiCrit` smallint(6) DEFAULT NULL,
  `Uv` smallint(6) DEFAULT NULL,
  `AntiUv` smallint(6) DEFAULT NULL,
  `Armor1` smallint(6) DEFAULT NULL,
  `Armor2` smallint(6) DEFAULT NULL,
  `Armor3` smallint(6) DEFAULT NULL,
  `Armor4` smallint(6) DEFAULT NULL,
  `MagicID` char(20) DEFAULT NULL,
  `NOWwear` char(6) DEFAULT NULL,
  `MAXwear` char(6) DEFAULT NULL,
  `Srab` int(11) NOT NULL DEFAULT '0',
  KEY `otd_ind` (`Otdel`,`Cost`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_things_shop`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_things_shop` VALUES ('975', '3', 'e_n5', 'Нож жертвоприношений', '2', '4', '1', '3', '4', '5', null, '0', null, '1', null, null, null, '2', '3', null, null, null, null, null, null, null, null, null, '0', '20', '0'), ('996', '10', 'shield1', 'Осевой Щит', '9', '36', '6', '10', '12', null, null, null, null, null, null, '2', null, null, null, '10', '30', null, null, '7', '7', '7', '7', null, '0', '50', '0'), ('999', '10', 'shield2', 'Лирический щит', '9', '320', '15', '21', '21', '21', null, null, null, null, null, null, null, null, null, null, '90', '20', null, '21', '21', '21', '21', null, '0', '100', '0'), ('999', '12', 'busi1', 'Литое ожерелье', '1', '18', '5', '9', null, null, null, null, null, null, null, null, null, null, null, null, '10', '5', null, null, null, null, null, null, '0', '35', '0'), ('999', '12', 'oger1', 'Рубиновое ожерелье', '1', '28', '6', null, null, null, '12', null, null, null, null, null, null, null, null, '5', '5', '10', null, null, null, null, null, null, '0', '40', '0'), ('984', '11', 'sergi1', 'Изящные серьги', '0', '10', '5', '8', null, null, '8', null, null, null, null, null, null, null, null, null, '0', '0', '5', '2', '2', '2', '2', null, '0', '20', '0'), ('998', '11', 'sergi2', 'Серьги Угадывания', '0', '28', '6', '10', null, null, null, null, null, null, null, null, null, null, null, '5', '10', null, '15', null, null, null, null, null, '0', '35', '0'), ('997', '12', 'busi2', 'Ожерелье спокойствия', '1', '32', '5', '12', null, null, '12', null, null, '2', '2', null, '6', null, null, null, null, '15', null, null, null, null, null, null, '0', '40', '0'), ('974', '11', 'sergi3', 'Облачные серьги', '0', '36', '6', null, '10', null, '8', null, null, '2', '2', null, '6', null, null, '15', null, '10', '10', null, null, null, null, null, '0', '35', '0'), ('986', '8', 'foot1', 'Майка новичка', '3', '3', '1', null, null, null, null, null, null, null, null, null, '3', null, null, null, null, null, null, null, null, null, null, null, '0', '10', '0'), ('952', '13', 'ring2', 'Кольцо Силы', '4', '12', '3', null, '6', null, '8', null, null, '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '25', '0'), ('954', '13', 'ring1', 'Кольцо Ловкости', '4', '12', '3', '10', null, null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '25', '0'), ('970', '13', 'ring3', 'Кольцо Интуиции', '4', '12', '3', '8', null, null, '10', null, null, null, null, '2', null, null, null, null, null, null, null, null, null, null, null, null, '0', '20', '0'), ('980', '9', 'shapka1', 'Простая шапка', '7', '6', '2', '5', null, null, '5', null, null, null, null, null, null, null, null, null, '5', '3', null, '2', null, null, null, null, '0', '20', '0'), ('999', '7', 'perchi1', 'Кожаные перчатки', '8', '18', '3', null, '10', null, '8', null, null, null, null, null, null, '2', '4', null, null, null, null, null, null, null, null, null, '0', '15', '0'), ('988', '6', 'boot1', 'Сапоги Феникса', '10', '12', '3', '6', null, null, '7', null, null, null, null, null, '3', null, null, null, null, '5', null, null, null, null, '3', null, '0', '20', '0'), ('992', '3', 'svord1', 'Меч раздачи', '2', '32', '5', '10', null, null, '12', null, null, null, null, null, null, '4', '10', '15', null, '15', null, null, null, null, null, null, '0', '45', '0'), ('984', '9', 'kaska1', 'Защитная каска', '7', '26', '5', '8', null, null, '10', null, null, null, '1', '1', null, null, null, null, '10', '5', null, '5', null, null, null, null, '0', '25', '0'), ('1000', '8', 'kirasa1', 'Прочная кираса', '3', '38', null, '10', null, null, '12', null, null, null, null, null, '6', null, null, null, '15', '5', '5', null, '6', '6', null, null, '0', '50', '0'), ('993', '6', 'boot2', 'Кирзовые сапоги', '10', '20', '5', '8', null, null, '8', null, null, null, null, null, '6', null, null, null, '10', '10', null, null, null, null, null, null, '0', '35', '0'), ('997', '3', 'topor1', 'Топор устрашения', '2', '19', '5', '7', '9', null, '10', null, null, null, null, '1', null, '3', '9', '5', '5', null, null, null, null, null, null, null, '0', '40', '0'), ('993', '1', 'e_mo2', 'Молот ветра', '2', '32', '5', '11', '10', '11', '0', null, null, null, null, null, '10', '7', '10', null, '10', '15', '0', '2', '2', null, null, null, '0', '50', '0'), ('934', '17', 'svitok1', 'Свиток вмешательства', '11', '10', '8', '10', '10', '10', '10', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Принуждение', '0', '5', '75'), ('880', '19', 'heal10', 'Зелье Жизни +10', '11', '3', '0', null, '3', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 10 HP', '0', '3', '75'), ('989', '19', 'heal20', 'Зелье Жизни +20', '11', '5', '1', null, '10', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 20 HP', '0', '3', '75'), ('996', '19', 'heal30', 'Зелье Жизни +30', '11', '11', '5', null, '12', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 30 HP', '0', '5', '75'), ('978', '19', 'heal50', 'Зелье Жизни +50', '11', '15', '8', null, '6', null, '12', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 50 HP', '0', '5', '75'), ('868', '19', 'heal100', 'Зелье Жизни +100', '11', '25', '10', null, null, null, '13', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 100 HP', '0', '5', '75'), ('392', '19', 'heal500', 'Mega Health', '11', '120', '20', null, null, null, '20', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '+ 500 HP', '0', '5', '75'), ('992', '1', 'e_kas1', 'Кастет насилия', '2', '11', '2', null, '6', '6', '0', null, null, null, null, null, '8', '3', '5', '5', '0', '10', null, '0', '1', '1', null, null, '0', '35', '0'), ('987', '1', 'e_kas2', 'Кастет тяжести', '2', '9', '2', '8', null, null, null, null, null, null, '1', null, null, '1', '7', null, null, '7', null, null, null, null, null, null, '0', '15', '0'), ('988', '9', 'shlem1', 'Шлем новичка', '7', '10', '2', null, '8', null, '6', null, null, null, null, null, null, null, null, '3', null, null, '10', '3', null, null, null, null, '0', '20', '0'), ('964', '3', 'knife2', 'Нож для рыбы', '2', '5', '1', null, null, '5', null, null, null, null, null, null, null, '2', '4', '5', null, null, null, null, null, null, null, null, '0', '15', '0'), ('902', '0', 'e_n3', 'Кинжал рыцаря', '2', '15', '3', '9', '6', null, null, null, null, '1', null, null, '6', '3', '5', '10', '0', null, null, '1', '1', null, null, null, '0', '25', '0'), ('968', '3', 'e_me5', 'Ударный меч', '2', '20', '3', '10', '0', null, null, null, null, '1', null, null, null, '6', '8', '10', null, '0', null, null, null, null, null, null, '0', '30', '0'), ('996', '10', 'shield3', 'Щит гидры', '9', '20', '3', null, '9', null, '9', null, null, null, null, null, null, null, null, null, '10', '25', null, '5', '5', '5', '5', null, '0', '35', '0'), ('993', '3', 'e_to2', 'Топор алхимика', '2', '50', '8', '15', '13', '0', '0', null, null, '1', '2', '1', '15', '9', '15', '20', '0', '15', null, null, null, null, null, null, '0', '60', '0'), ('996', '1', 'e_n2', 'Нож равновесия', '2', '19', '4', '10', '8', '0', null, null, null, null, '1', null, '10', '5', '7', null, '15', '5', '0', null, null, null, null, null, '0', '30', '0'), ('990', '1', 'e_d5', 'Дубинка омоновца', '2', '13', '3', '0', null, '8', null, null, null, '2', null, null, null, '4', '5', '5', null, '5', '5', null, null, null, null, null, '0', '70', '0'), ('990', '1', 'e_mo9', 'Молот изгиба', '2', '50', '7', '0', '13', '13', '0', null, null, null, '2', null, '15', '9', '14', '20', '10', null, '0', null, null, null, null, null, '0', '45', '0'), ('998', '9', 'helm1', 'Рогатый шлем', '7', '20', '4', '10', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, '10', '5', null, null, null, null, '0', '30', '0'), ('997', '9', 'helm2', 'Рыцарский шлем', '7', '50', '12', '15', '15', null, null, null, null, null, null, null, null, null, null, null, null, '20', '20', '9', null, null, null, null, '0', '40', '0'), ('993', '13', 'ring4', 'Печатное кольцо', '4', '31', '7', null, '12', null, null, null, null, '1', null, null, null, '1', '2', '10', '5', null, null, null, null, null, null, null, '0', '30', '0'), ('998', '10', 'shitok1', 'Щит бойца клуба', '9', '27', '5', '10', null, null, '10', null, null, null, '1', null, null, null, null, null, '20', null, '10', '5', '6', '6', '5', null, '0', '50', '0'), ('998', '10', 'shitok2', 'Щит малой стойкости', '9', '48', '8', '13', '12', null, null, null, null, null, null, null, '30', null, null, null, '20', '20', null, '9', '9', '9', '9', null, '0', '50', '0'), ('998', '13', 'ring5', 'Кольцо умиротворения', '4', '39', '9', null, null, '12', null, null, null, null, null, null, null, null, null, '25', null, '25', null, null, null, null, null, null, '0', '30', '0'), ('994', '10', 'shield4', 'Кактус', '9', '59', '10', '15', null, null, '15', null, null, null, null, null, null, '2', '4', '20', null, null, '20', '12', '12', '12', '12', null, '0', '50', '0'), ('991', '10', 'shield5', 'Щит предков', '9', '87', '12', '15', '15', null, '15', null, null, null, null, '2', '50', null, null, null, '50', null, '35', '15', '15', '15', '15', null, '0', '50', '0'), ('993', '7', 'perchi2', 'Перчатки усиления', '8', '64', '15', '20', '20', '16', null, null, null, '4', '2', '2', '18', null, null, '10', '10', '10', '10', null, null, null, null, null, '0', '60', '0'), ('971', '6', 'lessapogi', 'Лесные сапоги', '10', '10', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '10', '0'), ('995', '8', 'kirasa2', 'Бронзовая кираса здоровья', '3', '60', '7', '15', null, null, '15', null, null, null, '1', null, '45', null, null, null, '25', null, '30', null, '8', '8', null, null, '0', '60', '0'), ('992', '3', 'britva1', 'Опасная бритва (второе оружие)', '9', '51', '6', '6', null, '16', null, null, null, null, null, null, null, '3', '4', '40', null, null, null, null, null, null, null, null, '0', '20', '0'), ('992', '13', 'ring6', 'Кольцо ускользания', '4', '42', '7', null, '14', '10', null, null, null, '2', null, null, '10', null, null, null, '5', '40', null, null, null, null, null, null, '0', '50', '0'), ('993', '0', 'e_me2', 'Меч остроты', '2', '58', '8', '15', '13', '0', null, null, null, '4', null, null, '10', '10', '14', '10', '10', '15', '0', null, null, null, null, null, '0', '60', '0'), ('997', '1', 'bulava', 'Летаргия', '2', '52', '8', '14', null, null, '12', null, null, null, null, null, '24', '12', '16', null, '3', null, '3', null, null, null, null, null, '0', '75', '0'), ('991', '13', 'ring7', 'Витое кольцо', '4', '27', '5', null, '6', '6', null, null, null, null, null, '2', '12', null, null, '5', '5', '5', '5', null, null, null, null, null, '0', '45', '0'), ('997', '10', 'shield6', 'Щит друида', '9', '42', '6', '10', null, '14', null, null, null, null, '2', null, '12', null, null, null, '25', null, '30', '5', '7', '7', '5', null, '0', '50', '0'), ('988', '13', 'ring8', 'Продвинутое кольцо', '4', '40', '5', '5', '5', '5', '5', null, null, '2', '2', '2', '6', null, null, '2', '2', '2', '2', null, null, null, null, null, '0', '45', '0'), ('997', '13', 'ring9', 'Синее кольцо стойкости', '4', '45', '8', null, '13', '10', null, null, null, null, null, null, '21', null, null, null, '30', null, '30', null, null, null, null, null, '0', '60', '0'), ('992', '13', 'ring10', 'Кольцо счастья', '4', '43', '8', null, '14', '14', null, null, null, '2', null, null, '9', '5', '7', null, null, '10', null, null, null, null, null, null, '0', '65', '0'), ('999', '3', 'sekira', 'Секира \"Блестящая резня\"', '2', '45', '7', '10', '12', '12', null, null, null, null, '3', null, '12', '11', '12', null, null, null, null, null, null, null, null, null, '0', '55', '0'), ('989', '8', 'kirasa3', 'Сияние звезды', '3', '81', '8', '16', null, null, '15', null, null, null, '2', null, '50', null, null, null, '30', '10', null, null, '10', '10', null, null, '0', '100', '0'), ('992', '8', 'kirasa4', 'Рвань', '3', '16', '3', '6', '6', null, '8', null, null, null, '1', null, '7', null, null, null, '10', null, null, null, '3', '3', null, null, '0', '60', '0'), ('998', '8', 'kirasa5', 'Непробиваемый', '3', '45', '6', '10', null, null, '10', null, null, null, null, '0', '15', null, null, null, '15', null, null, null, '9', '9', null, null, '0', '50', '0'), ('992', '8', 'kirasa6', 'Кираса охранника', '3', '47', '6', '12', '12', null, null, null, null, null, '3', '3', '10', null, null, null, null, null, '5', null, '6', '6', null, null, '0', '50', '0'), ('992', '8', 'kirasa7', 'Ватник', '3', '18', '4', '8', null, null, '8', null, null, null, null, '1', '13', null, null, null, null, '10', null, null, '4', '4', null, null, '0', '45', '0'), ('990', '8', 'kirasa8', 'Кожаный купальник', '3', '31', '5', '10', null, null, '8', null, null, '2', null, null, '15', null, null, null, '5', null, null, null, '5', '5', null, null, '0', '45', '0'), ('999', '8', 'kirasa9', 'Нагрудник Земли', '3', '35', '5', '8', null, null, '14', null, null, null, '1', null, '10', null, null, null, '10', null, null, null, '6', '6', null, null, '0', '50', '0'), ('991', '10', 'shield7', 'Щит солнца', '9', '46', '7', '10', '10', null, null, null, null, null, null, null, '20', '7', '10', null, null, '-20', null, '7', '7', '7', '7', null, '0', '50', '0'), ('986', '10', 'shield8', 'Щит сатаниста', '9', '35', '5', null, '8', null, '8', null, null, '-2', null, '0', '15', null, null, '35', '5', null, '5', '5', '7', '7', '5', null, '0', '50', '0'), ('998', '10', 'shield9', 'Щит радуги', '9', '56', '8', '13', null, null, '13', null, null, null, null, null, '25', null, null, null, '15', '35', null, '9', '9', '9', '9', null, '0', '50', '0'), ('997', '10', 'shield10', 'Рыцарский щит льва', '9', '50', '7', '10', null, null, '10', null, null, null, null, null, '20', null, null, '25', '25', null, null, '10', '10', '10', '10', null, '0', '50', '0'), ('991', '10', 'shield11', 'Гербовый щит', '9', '57', '7', '12', null, null, '12', null, null, null, null, null, '12', null, null, '25', '10', '5', '10', '10', '10', '10', '10', null, '0', '50', '0'), ('966', '10', 'shield13', 'Щит \"Бублик\"', '9', '6', '2', '6', null, null, '6', null, null, null, null, null, null, null, null, null, '5', null, null, '1', '2', '2', '1', null, '0', '35', '0'), ('999', '10', 'shield12', 'Шахматный щит', '9', '40', '6', '10', null, null, '10', null, null, null, '1', null, '15', null, null, null, '25', null, '10', '7', '7', '7', '7', null, '0', '50', '0'), ('976', '0', 'e_me3', 'Меч самурая', '2', '37', '6', '10', null, null, '10', null, null, null, '2', '0', '15', '8', '12', '0', null, '25', null, null, null, null, null, null, '0', '45', '0'), ('979', '9', 'helm3', 'Шлем \"AVE, CAESAR..\"', '7', '34', '7', null, '12', '8', null, null, null, '1', null, '1', '15', null, null, '10', '5', '5', '5', '7', null, null, null, null, '0', '50', '0'), ('926', '17', 'note', 'Комментарии', '11', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'note', '0', '5', '75'), ('752', '16', 'fireball30', 'Малый огненный шар', '11', '3', '2', null, null, '6', null, null, null, null, null, null, null, '5', '15', null, null, null, null, null, null, null, null, 'Fireball', '0', '5', '75'), ('928', '16', 'fireball50', 'Огненный шар', '11', '7', '4', null, null, '8', null, null, null, null, null, null, null, '10', '25', null, null, null, null, null, null, null, null, 'Fireball', '0', '5', '75'), ('530', '16', 'ice1', 'Ледяное копье', '11', '17', '6', null, null, '12', null, null, null, null, null, null, null, '30', '75', null, null, null, null, null, null, null, null, 'Ледяной удар', '0', '5', '75'), ('927', '16', 'stone1', 'Каменный дождь', '11', '20', '8', null, null, '16', null, null, null, null, null, null, null, '20', '50', null, null, null, null, null, null, null, null, 'Камнепад', '0', '5', '75'), ('322', '17', 'napadenie', 'Свиток нападения', '11', '16', '6', null, '12', '12', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Нападение', '0', '3', '75'), ('997', '1', 'e_mo1', 'Молот страха', '2', '80', '14', null, '18', '18', null, null, null, null, null, null, '30', '23', '25', null, '20', null, null, '15', '15', '15', '15', null, '0', '80', '0'), ('997', '7', 'perchi5', 'Перчи смещения', '8', '35', '9', '20', '15', '15', null, null, null, null, null, null, null, '3', '6', '10', null, '10', null, null, null, null, null, null, '0', '40', '0'), ('998', '7', 'perchi6', 'Перчатки подавляющие', '8', '44', '11', '25', '17', '17', null, null, null, null, null, null, '12', '5', '9', null, '20', null, '5', null, null, null, null, null, '0', '45', '0'), ('999', '7', 'perchi3', 'Перчатки опережения', '8', '46', '13', '25', '20', null, null, null, null, '3', '3', '3', '18', null, null, null, null, null, null, null, null, null, null, null, '0', '30', '0'), ('1000', '7', 'perchi4', 'Перчатки намека', '8', '51', '15', '30', null, '25', null, null, null, '5', null, null, null, '6', '10', '15', '15', null, null, null, null, null, null, null, '0', '45', '0'), ('1000', '13', 'ring12', 'Кольцо плодородия', '4', '40', '9', '15', null, '15', null, null, null, '1', null, null, null, null, null, null, '30', '20', null, null, null, null, null, null, '0', '25', '0'), ('992', '13', 'ring11', 'Кольцо удачи', '4', '46', '11', '20', '20', null, null, null, null, null, '2', null, '6', null, null, '30', '10', '5', null, null, null, null, null, null, '0', '30', '0'), ('995', '11', 'sergi4', 'Танковые серьги', '0', '39', '9', '15', '15', null, null, null, null, null, '3', null, '15', null, null, null, '5', null, '5', '6', '6', '6', '6', null, '0', '35', '0'), ('997', '1', 'bulava2', 'Кровавая булава', '2', '54', '9', '15', null, '15', null, null, null, '1', null, null, '21', '14', '15', '5', '5', null, null, null, null, null, null, null, '0', '70', '0'), ('999', '1', 'e_mo4', 'Молот решимости', '2', '70', '11', '15', '15', '15', null, null, null, '4', '4', '0', '10', '15', '24', null, '25', '0', '25', null, null, null, null, null, '0', '70', '0'), ('999', '1', 'bulava4', 'Булава травматолога', '2', '78', '12', '20', '20', '20', null, null, null, '2', '2', null, '18', '19', '24', '15', '15', null, null, null, null, null, null, null, '0', '65', '0'), ('0', '1', 'amolot1', 'Дубинка Радости', '2', '1', '1', '3', '3', '3', null, null, null, '1000', '500', '500', '1000', '500', '1000', '10000', '10000', '10000', '10000', '10000', '10000', '10000', '10000', null, '0', '500', '0'), ('999', '3', 'topor3', 'Топор заката', '2', '51', '10', '15', '17', null, null, null, null, null, '1', null, null, '15', '18', '20', null, '5', '5', null, null, null, null, null, '0', '50', '0'), ('999', '3', 'sword4', 'Меч леденящий', '2', '63', '12', '17', '17', null, '20', null, null, '1', null, null, '15', '20', '23', null, '10', '15', null, null, null, null, null, null, '0', '55', '0'), ('996', '3', 'e_to5', 'Топор поднебесья', '2', '85', '14', '20', '20', '0', '22', null, null, '0', '5', '5', '40', '20', '24', '20', '20', null, '0', null, null, null, null, null, '0', '80', '0'), ('998', '3', 'e_to3', 'Топор великолепия', '2', '89', '15', '24', '21', '0', null, null, null, '0', '7', null, '20', '24', '26', '15', '0', '45', '0', null, null, null, null, null, '0', '70', '0'), ('972', '13', 'e_ko1', 'Кольцо Нового Света', '4', '130', '19', '30', '30', '20', null, null, '0', '5', '5', '5', '45', null, null, '45', '45', '45', '45', null, null, null, null, null, '0', '100', '0'), ('1000', '1', 'e_d2', 'Дубина прямоты', '2', '95', '16', '25', null, null, '25', null, null, null, null, null, '25', '23', '30', '30', '10', null, null, null, null, null, null, null, '0', '65', '0'), ('998', '9', 'helm4', 'Шеллер', '7', '80', '15', '25', '20', null, '15', null, null, '1', null, '2', '15', null, null, null, '15', '15', '15', '15', null, null, null, null, '0', '50', '0'), ('937', '10', 'sm4', 'Щит радости', '9', '1', '1', null, null, null, null, null, null, null, null, null, '5', null, null, null, null, null, null, null, null, null, null, null, '0', '1', '0'), ('998', '0', 'sm2', 'Воровская заточка', '2', '75', '9', '15', '15', null, null, null, null, '1', '0', null, '18', '14', '18', '5', '10', '20', '20', null, null, null, null, null, '0', '50', '0'), ('998', '6', 'boots2', 'Высокие сапоги', '10', '68', '14', '25', '20', null, '20', null, null, null, '2', null, '21', null, null, null, '25', '25', null, null, null, null, '10', null, '0', '40', '0'), ('1000', '6', 'boots4', 'Унты', '10', '46', '9', '15', null, null, '15', null, null, null, null, '1', null, null, null, null, '10', null, '10', null, null, null, '7', null, '0', '37', '0'), ('999', '6', 'boots5', 'Утепленные унты', '10', '130', '20', '35', '30', null, null, null, null, null, '1', '1', '39', null, null, null, '30', '30', '20', null, null, null, '21', null, '0', '60', '0'), ('993', '0', 'sm3', 'Арабская сабля', '2', '85', '10', '16', null, '16', null, null, null, '1', null, '1', null, '16', '20', '35', '5', '10', null, null, null, null, null, null, '0', '70', '0'), ('987', '0', 'sm5', 'Пчелиное жало', '2', '89', '12', '15', '15', '15', null, null, null, '1', '2', null, '6', '18', '24', '20', '10', '15', '5', '2', null, '2', null, null, '0', '70', '0'), ('971', '3', 'e_n4', 'Нож обрезки', '2', '9', '2', '6', null, null, null, '0', null, '1', null, null, null, '3', '5', null, '10', null, '0', null, null, null, null, null, '0', '20', '0'), ('990', '13', 'kolco3', 'Кольцо равенства', '4', '16', '4', null, '10', null, '9', null, null, null, '2', null, '10', null, null, null, null, '10', null, '2', null, null, null, null, '0', '35', '0'), ('999', '1', 'e_mo6', 'Возвышающий молот', '2', '250', '21', '38', '30', '29', null, null, null, '5', '5', '5', '40', '38', '50', '40', '40', '40', '40', null, null, null, null, null, '0', '120', '0'), ('996', '12', 'kulon3', 'Кулон устрашения', '1', '32', '7', null, null, '15', '12', null, null, null, null, '2', '15', null, null, '25', '-10', null, null, null, null, null, null, null, '0', '50', '0'), ('984', '12', 'kulon1', 'Кулон небес', '1', '18', '4', null, null, '10', '7', null, null, null, null, null, '5', '2', '3', '5', null, null, null, null, null, null, null, null, '0', '40', '0'), ('998', '12', 'kulon7', 'Ожерелье сноровки', '1', '40', '10', null, '15', null, '15', null, null, '1', '3', null, '12', null, null, null, '15', '30', null, null, null, null, null, null, '0', '35', '0'), ('999', '12', 'kulon6', 'Ожерелье крови', '1', '50', '13', null, '21', '21', '18', null, null, null, null, null, '20', null, null, '30', null, null, '30', null, null, null, null, null, '0', '40', '0'), ('996', '12', 'kulon4', 'Ожерелье вражды', '1', '62', '16', null, '25', null, '22', null, null, '3', null, null, '35', '7', '12', null, null, null, null, null, null, null, null, null, '0', '80', '0'), ('973', '12', 'kulon5', 'Кулон чудес', '1', '7', '2', null, null, '5', '5', null, null, null, null, null, '3', null, null, null, '5', null, null, null, '1', '1', null, null, '0', '25', '0'), ('998', '12', 'kulon2', 'Кулон развития', '1', '30', '6', null, '10', '7', '12', null, null, null, null, null, null, null, null, '10', '10', '10', '10', null, null, null, null, null, '0', '45', '0'), ('1000', '13', 'kolco4', 'Кольцо обмана', '4', '38', '9', '15', '14', null, '15', null, null, '3', null, null, '15', null, null, null, '10', null, '15', '5', '5', '5', '5', null, '0', '25', '0'), ('1000', '13', 'kolco7', 'Кольцо баланса', '4', '78', '18', '35', null, '32', null, null, null, null, null, '5', '10', null, null, '60', '-25', null, '20', null, null, null, null, null, '0', '55', '0'), ('968', '11', 'serg2', 'Серьги смирения', '0', '9', '3', null, '5', null, '8', null, null, null, '1', null, '3', null, null, '7', null, '7', null, null, null, null, null, null, '0', '20', '0'), ('999', '11', 'serg4', 'Серьги мужества', '0', '35', '9', '16', null, '14', null, null, null, null, '2', null, '15', null, null, null, null, '30', '15', null, null, null, null, null, '0', '25', '0'), ('1000', '11', 'sergi7', 'Серьги вихря', '0', '85', '18', null, '30', null, '24', null, null, null, null, null, '30', null, null, null, '20', '80', '10', null, null, null, null, null, '0', '40', '0'), ('1000', '11', 'serg1', 'Серьги раскола', '0', '65', '16', null, null, '27', '22', null, null, null, null, '3', null, null, null, '35', null, '25', null, null, null, null, null, null, '0', '30', '0'), ('992', '11', 'sergi5', 'Серьги короля', '0', '23', '7', null, '14', '15', null, null, null, null, null, null, '20', '4', '5', null, null, null, null, null, '4', '4', null, null, '0', '45', '0'), ('997', '13', 'kolco6', 'Кольцо прочности', '4', '52', '14', '30', null, null, '26', null, null, null, null, null, '35', null, null, null, null, null, null, '10', '10', '10', '10', null, '0', '40', '0'), ('994', '11', 'sergi6', 'Серьги духов', '0', '48', '13', '17', null, '15', '16', null, null, '3', null, '2', '25', null, null, '30', null, '10', null, null, null, null, null, null, '0', '35', '0'), ('994', '10', 'shit2', 'Щит сияния', '9', '135', '18', '30', '25', null, '24', null, null, '4', null, null, '75', null, null, '75', null, '25', null, '20', '20', '20', '20', null, '0', '80', '0'), ('994', '10', 'shit1', 'Щит мудрости', '9', '100', '15', null, '21', '23', '24', null, null, '3', null, null, '60', null, null, null, '55', '25', '40', '18', '18', '18', '18', null, '0', '50', '0'), ('986', '10', 'shit5', 'Щит манкурта', '9', '16', '4', null, null, '8', '9', null, null, null, null, null, '9', null, null, '15', '10', '0', '0', '5', '4', '4', '5', null, '0', '25', '0'), ('996', '9', 's1d', 'Шлем льва', '7', '105', '18', '25', '23', null, '22', null, null, null, null, '2', '25', null, null, '45', null, null, '25', '18', null, null, null, null, '0', '45', '0'), ('997', '9', 's2', 'Шлем крестоносца', '7', '42', '9', '13', '12', null, '11', null, null, null, '2', null, '10', null, null, '10', null, '35', null, '8', null, null, null, null, '0', '30', '0'), ('989', '9', 's3', 'Шлем темного рыцаря', '7', '43', '11', '16', '14', null, '15', null, null, null, null, '3', '20', null, null, '35', '-10', null, null, '9', null, null, null, null, '0', '35', '0'), ('987', '9', 's4', 'Шлем завоевателя', '7', '16', '4', '9', '5', null, '9', null, null, '2', null, null, '3', null, null, null, '15', null, null, '4', null, null, null, null, '0', '20', '0'), ('997', '9', 's5', 'Шлем брони теней', '7', '148', '21', '35', null, null, '30', null, null, '6', null, null, '45', null, null, '45', null, null, '35', '25', null, null, null, null, '0', '65', '0'), ('997', '9', 's6', 'Шлем защиты', '7', '39', '7', '15', null, null, '15', null, null, null, null, null, '35', null, null, null, '-20', '-15', null, '12', null, null, null, null, '0', '40', '0'), ('994', '8', 'br1', 'Доспех охотников', '3', '170', '21', '37', null, null, '30', null, null, null, null, null, '70', null, null, '30', '45', '35', '45', null, '20', '20', null, null, '0', '100', '0'), ('998', '8', 'br2', 'Доспех предчувствия', '3', '150', '18', '29', '28', null, null, null, null, null, '4', null, '65', null, null, null, '35', '75', '10', null, '18', '18', null, null, '0', '75', '0'), ('996', '8', 'b3', 'Кираса стойкости', '3', '132', '15', '25', '20', null, '25', null, null, '10', null, null, null, null, null, null, '45', null, '50', null, '14', '14', null, null, '0', '50', '0'), ('989', '8', 'b4', 'Броня систем', '3', '110', '12', '19', null, '14', '16', null, null, null, null, '4', '45', null, null, '35', '45', null, null, null, '12', '12', null, null, '0', '60', '0'), ('983', '8', 'b5', 'Нагрудник развертки', '3', '18', '4', '8', null, '7', '9', null, null, null, null, '1', '9', null, null, '10', '5', null, null, null, '4', '4', null, null, '0', '30', '0'), ('1000', '8', 'b6', 'Офицерский камзол', '3', '25', '5', '10', null, '8', '10', null, null, null, null, null, '6', null, null, null, null, '15', '15', null, '5', '5', null, null, '0', '25', '0'), ('985', '7', 'p1', 'Рабочие перчатки', '8', '22', '4', '10', '5', '7', null, null, null, null, null, null, null, '2', '3', null, '5', '5', null, null, null, null, null, null, '0', '20', '0'), ('987', '7', 'p2', 'Перчатки мощи', '8', '28', '6', '13', '12', null, null, null, null, null, null, null, null, null, null, '20', null, '3', null, null, null, null, null, null, '0', '30', '0'), ('994', '7', 'p3', 'Перчи разящих лезвий', '8', '33', '8', '15', '15', null, null, null, null, null, null, null, null, '4', '5', null, null, '20', null, null, null, null, null, null, '0', '40', '0'), ('997', '7', 'p4', 'Перчатки гнева', '8', '85', '18', '30', '23', null, '25', null, null, null, null, null, null, '13', '17', '40', '-20', null, null, null, null, null, null, null, '0', '50', '0'), ('974', '6', 'b1', 'Римские сандалии', '10', '16', '4', '7', null, '9', null, null, null, null, '1', '1', null, null, null, '10', null, null, null, null, null, null, '4', null, '0', '20', '0'), ('997', '6', 'bo2', 'Сапоги воина', '10', '27', '6', '13', '10', null, null, null, null, '2', null, null, '14', null, null, null, null, '20', null, null, null, null, '6', null, '0', '30', '0'), ('1000', '6', 'bs3', 'Кольчужные сапоги', '10', '51', '12', '35', '30', null, null, null, null, null, null, null, '15', null, null, '30', null, null, '20', null, null, null, '9', null, '0', '45', '0'), ('997', '6', 'bs4', 'Сапоги корсара', '10', '95', '18', '30', '25', null, null, null, null, null, '2', null, '35', null, null, null, null, '45', '30', null, null, null, '16', null, '0', '50', '0'), ('984', '6', 'bs5', 'Песчаные сапоги', '10', '35', '7', '14', null, '15', null, null, null, null, '1', '1', '39', null, null, '30', null, '-10', null, null, null, null, '6', null, '0', '25', '0'), ('998', '1', 'e_d8', 'Боевая дубина кочевника', '2', '99', '17', '25', '25', '25', null, null, null, '4', '4', null, null, '30', '32', '25', '25', '25', '25', null, null, null, null, null, '0', '70', '0'), ('988', '3', 'e_to1', 'Топор Судьбы', '2', '35', '5', '13', '10', '10', null, null, null, null, null, null, '10', '9', '11', '10', '10', '10', '10', null, null, null, null, null, '0', '30', '0'), ('995', '3', 'p5', 'Меч серебра', '2', '60', '10', '14', '13', '13', null, null, null, null, '2', '2', null, '16', '19', '20', null, '20', null, null, null, null, null, null, '0', '45', '0'), ('999', '3', 'pu4', 'Секира древности', '2', '67', '12', '16', '15', null, '17', null, null, '2', null, null, '25', '21', '25', null, '20', null, '20', null, null, null, null, null, '0', '60', '0'), ('997', '1', 'e_d3', 'Возвышающий молот', '2', '140', '18', '30', '27', null, null, null, null, null, null, '7', '60', '30', '48', '35', null, '75', null, null, null, null, null, null, '0', '100', '0'), ('995', '3', 'e_me1', 'Меч сущности', '2', '58', '9', '13', '14', '10', '0', null, null, null, '0', null, '30', '12', '15', '40', '-10', '0', null, null, null, null, null, null, '0', '70', '0'), ('993', '0', 'c_bt02', 'Рассекатель', '2', '700', '16', '30', '25', '30', null, null, null, '4', '2', '2', '150', '38', '56', '70', '0', '-45', '45', null, null, null, null, null, '0', '50', '0'), ('998', '1', 'e_mo8', 'Разрушитель', '2', '150', '18', '35', '0', '30', null, null, null, null, '5', null, '30', '28', '50', '75', '-20', '-15', '45', null, null, null, null, null, '0', '90', '0'), ('972', '13', 'e_ko2', 'Малое кольцо равновесия', '4', '50', '12', '15', '15', '15', null, null, null, '2', null, null, '20', null, null, '20', '20', '20', '20', null, null, null, null, null, '0', '70', '0'), ('970', '13', 'e_ko4', 'Кольцо ученика', '4', '30', '5', null, '8', '8', null, null, null, '1', null, null, '10', null, null, '20', null, '15', null, null, null, null, null, null, '0', '20', '0'), ('974', '13', 'e_ko5', 'Огненное кольцо', '4', '38', '10', '13', '12', null, null, null, null, '3', '3', null, '45', null, null, null, '10', null, null, null, null, null, null, null, '0', '45', '0'), ('893', '13', 'e_ko6', 'Кольцо печали', '4', '12', '3', null, null, '7', null, null, null, null, null, null, '10', null, null, '10', null, null, null, null, null, null, null, null, '0', '20', '0'), ('984', '13', 'e_ko3', 'Кольцо одержимости', '4', '60', '12', '15', '15', '15', null, null, null, null, null, null, '15', '7', '10', '20', null, null, null, null, null, null, null, null, '0', '40', '0'), ('990', '12', 'e_q1', 'Кулон Нового Света', '1', '80', '19', '30', '30', '20', null, null, null, '3', '3', '3', '25', null, null, '25', '25', '25', '25', null, null, null, null, null, '0', '100', '0'), ('998', '12', 'e_q2', 'Кулон смещения', '1', '60', '12', '15', '15', '15', null, null, null, null, '2', null, '15', '0', '0', '15', '15', '15', '15', null, null, null, null, null, '0', '70', '0'), ('990', '12', 'e_q3', 'Кулон оптики', '1', '30', '5', '10', '10', null, null, null, null, null, null, null, '20', null, null, null, null, '35', null, null, null, null, null, null, '0', '40', '0'), ('990', '12', 'e_q4', 'Кулон решимости', '1', '50', '10', '12', '12', '12', null, null, null, null, null, null, '50', '0', '0', '0', '0', null, null, '15', '15', '15', '15', null, '0', '45', '0'), ('957', '12', 'e_q5', 'Ожерелье жадности', '1', '30', '7', '10', '10', '10', null, null, null, '4', '4', '4', '24', null, null, null, null, null, null, null, null, null, null, null, '0', '30', '0'), ('997', '12', 'e_q6', 'Ожерелье медитации', '1', '25', '5', '10', '9', null, null, null, null, null, null, null, null, null, null, null, '10', null, '10', '3', '0', '3', null, null, '0', '20', '0'), ('993', '11', 'e_se4', 'Серьги малой брони', '0', '65', '12', '15', '15', null, null, null, null, null, null, null, '50', null, null, null, '10', null, null, '15', '15', '15', '15', null, '0', '55', '0'), ('995', '11', 'e_se5', 'Серьги успеха', '0', '65', '16', '30', '22', '19', null, null, null, '4', '4', null, '30', null, null, null, '45', null, '35', null, null, null, null, null, '0', '60', '0'), ('993', '11', 'e_se2', 'Серьги смещения', '0', '60', '12', '15', '15', '15', null, null, null, null, '0', '2', '15', null, null, '15', '15', '15', '15', null, null, null, null, null, '0', '70', '0'), ('987', '11', 'e_se1', 'Серьги Нового Света', '0', '90', '19', '30', '30', '20', null, null, null, '2', '2', '2', '30', null, null, '30', '30', '30', '30', null, null, null, null, null, '0', '100', '0'), ('991', '8', 'e_br1', 'Броня мантии', '3', '34', '6', '10', '10', '10', null, null, null, null, null, null, '6', '2', '5', '10', null, '15', null, '6', null, '6', null, null, '0', '30', '0'), ('994', '8', 'e_br2', 'Царский нагрудник', '3', '50', '8', '12', '0', null, '12', null, null, '3', null, null, '21', null, null, null, '20', '25', null, '8', null, '8', null, null, '0', '45', '0'), ('978', '8', 'e_br3', 'Серебрянный нагрудник', '3', '13', '2', '6', '6', null, null, null, null, '1', '1', null, null, null, null, null, '5', null, '5', '2', null, '2', null, null, '0', '15', '0'), ('987', '8', 'e_br4', 'Жесткая броня', '3', '130', '14', '19', '15', null, '18', null, null, null, '4', '0', '45', '10', '15', '20', '20', '20', '20', '12', null, '12', null, null, '0', '70', '0'), ('995', '8', 'e_br5', 'Пластиковый нагрудник', '3', '18', '4', '9', '6', '6', null, null, null, null, null, null, '10', null, null, null, null, '8', '8', '4', null, '4', null, null, '0', '65', '0'), ('996', '8', 'e_br6', 'Экзотический нагрудник', '3', '160', '18', '35', '30', '0', '30', null, null, null, '2', null, '90', null, null, null, '70', '55', '25', '0', '24', '24', null, null, '0', '80', '0'), ('977', '7', 'e_pe1', 'Перчатки дерзости', '8', '25', '6', '10', '10', '10', null, null, null, null, '2', null, '10', '3', '5', null, null, '15', '15', null, null, null, null, null, '0', '40', '0'), ('986', '7', 'e_pe2', 'Стальные руковицы', '8', '55', '12', '15', '15', '15', null, null, null, null, null, null, '20', '10', '11', '5', '35', null, null, null, null, null, null, null, '0', '50', '0'), ('990', '7', 'e_pe3', 'Перчи сметения', '8', '40', '10', '13', '9', null, '13', null, null, null, null, null, '30', null, null, null, '20', '20', '20', null, null, null, null, null, '0', '45', '0'), ('962', '7', 'e_pe4', 'Перчатки светил', '8', '15', '2', '6', '6', null, null, null, null, '1', '1', '1', '3', null, null, '2', '2', '2', '2', null, null, null, null, null, '0', '20', '0'), ('983', '6', 'e_sa1', 'Сапоги наместника', '10', '30', '7', '12', '10', null, null, null, null, null, '2', null, '45', null, null, null, '10', null, null, null, null, null, '6', null, '0', '30', '0'), ('984', '6', 'e_sa2', 'Смятые сапоги', '10', '50', '9', '12', '12', null, '12', null, null, null, null, null, '20', '5', '6', '20', null, null, '15', null, null, null, '8', null, '0', '60', '0'), ('989', '6', 'e_sa3', 'Боты согласия', '10', '75', '12', '15', '13', '16', null, null, null, '2', '2', '2', '15', null, null, '15', '15', '15', '15', null, null, null, '10', null, '0', '80', '0'), ('991', '6', 'e_sa4', 'Вечные подошвы', '10', '15', '3', '0', '9', '5', null, null, null, null, null, null, '5', null, null, null, null, '5', '5', null, null, null, '2', null, '0', '20', '0'), ('996', '9', 'e_sh1', 'Каска стражи', '7', '90', '16', '0', '16', null, '15', null, null, null, null, null, '25', '7', '10', '15', '15', '15', '15', '10', null, null, null, null, '0', '50', '0'), ('996', '9', 'e_sh2', 'Шлем циклопа', '7', '100', '17', '24', '24', null, null, null, null, null, '3', '2', '30', null, null, null, null, '55', '35', '15', null, null, null, null, '0', '65', '0'), ('1000', '9', 'e_sh3', 'Броненосец', '7', '80', '16', '30', null, '23', null, null, null, null, null, null, '40', null, null, '0', '40', null, '40', '20', null, null, null, null, '0', '70', '0'), ('993', '9', 'e_sh4', 'Шлем разочарования', '7', '45', '10', '15', null, null, '15', null, null, null, null, null, '15', null, null, '20', '20', null, null, '8', null, null, null, null, '0', '45', '0'), ('994', '9', 'e_sh5', 'Шлем пластин', '7', '90', '15', '21', '21', '21', '21', null, null, null, null, null, '25', '3', '6', '30', '10', '30', null, '14', null, null, null, null, '0', '65', '0'), ('999', '10', 'e_st1', 'Щит тайны', '9', '90', '16', '25', '25', null, null, null, null, null, null, null, '55', null, null, null, '40', null, '40', '19', '19', '19', '19', null, '0', '65', '0'), ('998', '10', 'e_st2', 'Щит статики', '9', '58', '9', '15', null, '12', null, null, null, null, null, '2', '20', null, null, null, '35', null, '25', '9', '9', '9', '9', null, '0', '40', '0'), ('991', '10', 'e_st3', 'Щит Нового Света', '9', '150', '19', '25', '30', '20', null, null, null, '5', null, '7', '80', null, null, '40', '40', '40', '40', '22', '22', '22', '22', null, '0', '100', '0'), ('992', '10', 'e_st4', 'Щит откровений', '9', '25', '5', '10', '8', '8', null, null, null, null, null, null, null, '2', '4', '10', null, '15', null, '6', '6', '6', '6', null, '0', '30', '0'), ('996', '10', 'e_st5', 'Щит торговца', '9', '40', '7', '11', null, null, '11', null, null, null, null, null, '20', null, null, '30', '-10', null, '5', '7', '7', '7', '7', null, '0', '45', '0'), ('994', '10', 'e_st6', 'Щит тоски', '9', '80', '14', '14', '13', null, null, null, null, null, '2', null, '45', null, null, '35', '30', '20', null, '14', '14', '14', '14', null, '0', '50', '0'), ('999', '10', 'e_st7', 'Щит развертки', '9', '93', '14', '20', '21', null, null, null, null, '2', '2', null, '50', null, null, null, '40', '65', null, '17', '17', '17', '17', null, '0', '60', '0'), ('990', '10', 'e_st8', 'Щит настроя', '9', '15', '4', null, '7', '7', null, null, null, '1', null, null, '7', null, null, '10', null, '10', null, '5', '4', '4', '5', null, '0', '30', '0'), ('987', '7', 'e_pe5', 'Перчатки мироздания', '8', '120', '20', '30', '30', '30', null, null, null, null, '3', '3', '50', '22', '24', '40', '40', null, null, null, null, null, null, null, '0', '70', '0'), ('996', '6', 'e_sa5', 'Сапоги царей', '10', '200', '21', null, '40', '40', '30', null, null, null, '5', null, '50', null, null, '40', null, null, '30', null, null, null, '24', null, '0', '80', '0'), ('992', '9', 'e_sh6', 'Шлем реакции', '7', '250', '21', '35', '35', null, '30', null, null, null, null, null, '70', '10', '15', '70', '15', null, '25', '30', null, null, null, null, '0', '100', '0'), ('996', '3', 'c_bt04', 'Леденящий топор', '2', '850', '27', '47', '49', '38', null, null, null, '4', '2', '5', '250', '79', '96', '77', null, null, '109', null, null, null, null, null, '0', '150', '0'), ('977', '14', 's_l50', 'Свиток восстановления +50', '11', '20', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лекарь 50', '0', '5', '75'), ('957', '14', 's_l10', 'Свиток восстановления +10', '11', '4', '3', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лекарь 10', '0', '3', '75'), ('980', '14', 's_l20', 'Свиток восстановления +20', '11', '6', '4', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лекарь 20', '0', '3', '75'), ('905', '14', 's_l100', 'Свиток восстановления +100', '11', '28', '8', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лекарь 100', '0', '5', '75'), ('942', '14', 'sv_tr', 'Лечение травм', '11', '10', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Лечение', '0', '3', '50'), ('992', '10', 'b_bt7', 'Золотой щит вечности', '9', '580', '31', '55', '45', '34', null, null, null, '5', null, '7', '130', null, null, '30', '110', '60', null, '50', '50', '50', '50', null, '0', '180', '0'), ('988', '11', 'b_bt8', 'Золотые серьги печали', '0', '250', '27', '35', '40', '30', '35', null, null, '5', '8', '6', '50', null, null, '90', '50', null, '100', null, null, null, null, null, '0', '100', '0'), ('998', '12', 'b_bt10', 'Золотое ожерелье Радости', '1', '180', '25', '40', '45', '35', null, null, null, '5', '4', '4', '50', null, null, '30', '45', null, '60', null, null, null, null, null, '0', '180', '0'), ('990', '7', 'b_bt5', 'Золотые перчатки могущества', '8', '290', '28', '50', '45', '45', null, null, null, '10', null, '7', '75', '38', '54', '75', '45', null, null, null, '40', null, null, null, '0', '135', '0'), ('1000', '9', 'b_bt9', 'Золотой шлем вдохновения', '7', '330', '26', '40', '45', null, '30', null, null, '1', null, '2', '45', null, null, null, '90', '60', null, '50', null, null, null, null, '0', '150', '0'), ('999', '8', 'b_bt6', 'Броня Превосходства', '3', '350', '26', '45', '40', null, '40', null, null, null, '3', null, '100', null, null, null, '100', '85', '-25', null, null, '45', '45', null, '0', '150', '0'), ('994', '6', 'b_bt3', 'Ботинки перехода', '10', '240', '24', '0', '45', '35', '35', null, null, null, '8', null, '90', null, null, '35', null, '65', '50', null, null, null, '40', null, '0', '130', '0'), ('990', '6', 'b_bt4', 'Сапоги травмирования', '10', '550', '32', null, '55', '45', '45', null, null, null, '8', null, '100', '28', '42', '55', '55', '95', null, null, null, null, '50', null, '0', '250', '0'), ('999', '1', 'b_bt1', 'Молот прессования', '2', '550', '30', '55', '50', '45', null, null, null, '8', '-5', '4', '60', '69', '93', '95', '55', null, '80', null, null, null, null, null, '0', '200', '0'), ('999', '3', 'b_bt2', 'Меч мучений', '2', '350', '25', '50', '40', '35', null, null, null, '6', null, '5', '40', '54', '76', '85', '40', null, '60', null, null, null, null, null, '0', '150', '0'), ('989', '8', 'b_bt12', 'Золотая броня коллекции', '3', '600', '29', '65', '50', null, '50', null, null, null, null, '5', '250', null, null, '90', '45', '75', '45', null, '60', '60', null, null, '0', '200', '0'), ('1000', '3', 'b_bt13', 'Топор мести', '2', '450', '28', '50', '50', '40', null, null, null, '6', null, null, '50', '63', '85', '90', null, '40', '65', null, null, null, null, null, '0', '150', '0'), ('998', '9', 'b_bt16', 'Шлем забвения', '7', '480', '28', '50', '45', null, null, null, null, null, null, null, '150', null, null, '20', '85', '100', '5', '60', null, null, null, null, '0', '250', '0'), ('991', '9', 'b_bt17', 'Шлем наёмника', '7', '550', '31', '60', '50', '45', null, null, null, '3', '2', null, '80', '27', '41', '80', '30', '25', '85', '80', null, null, null, null, '0', '250', '0'), ('992', '13', 'b_bt11', 'Золотое кольцо Света', '4', '180', '23', '40', '40', '30', null, null, null, '5', '5', '5', '200', null, null, null, null, '100', null, '25', '25', '25', '25', null, '0', '180', '0'), ('988', '13', 'b_bt19', 'Золотое кольцо Тьмы', '4', '200', '25', '45', '40', '35', null, null, null, '5', '5', null, null, '20', '36', '100', null, null, null, null, null, null, null, null, '0', '180', '0'), ('995', '13', 'b_bt18', 'Золотое кольцо Нейтралитета', '4', '240', '27', '50', '45', '45', null, null, null, null, null, null, '100', null, null, '35', '75', '35', '75', null, null, null, null, null, '0', '180', '0'), ('999', '3', 'c_bt08', 'Меч обжигающей ярости', '2', '550', '18', '30', '25', '30', null, null, null, '6', null, null, '200', '39', '54', '85', null, '-55', '75', null, null, null, null, null, '0', '150', '0'), ('997', '3', 'c_bt01', 'Поющий меч', '2', '1400', '35', '60', '60', '60', null, null, null, '6', '5', '6', '450', '103', '131', '188', null, null, '102', null, null, null, null, null, '0', '150', '0'), ('1000', '3', 'c_bt07', 'Меч броненосца', '2', '450', '24', '50', '50', '40', null, null, null, '5', '4', '3', '250', '48', '71', '60', '95', '40', null, null, null, '20', null, null, '0', '150', '0'), ('993', '3', 'c_bt06', 'Скальпель', '2', '300', '23', '45', null, '32', null, null, null, '10', '5', null, '370', '42', '70', '90', null, null, '25', null, null, null, null, null, '0', '100', '0'), ('999', '1', 'c_bt05', 'Булава каприза', '2', '350', '23', '40', '32', '31', null, null, null, '6', '4', '5', '70', '43', '61', '95', null, null, '65', null, null, null, null, null, '0', '150', '0'), ('996', '3', 'c_bt03', 'Топор хитрости', '2', '650', '20', '25', '35', '20', null, null, null, '3', '1', '3', '250', '43', '58', '90', null, null, '55', null, null, null, null, null, '0', '50', '0'), ('998', '11', 'f_bt1', 'Серьги терпения', '0', '222', '30', '55', null, '70', '55', null, null, '5', '0', '5', '350', null, null, '90', '35', '100', null, null, null, null, null, null, '0', '80', '0'), ('987', '13', 'f_bt3', 'Кольцо упорства', '4', '200', '33', '55', '55', null, '55', null, null, '5', null, '2', '250', null, null, '95', '65', '80', null, null, null, null, null, null, '0', '110', '0'), ('990', '12', 'f_bt2', 'Кулон одержимости', '1', '240', '26', '50', '55', '50', null, null, null, '4', '3', '2', '250', null, null, '80', '45', '90', null, null, null, null, null, null, '0', '100', '0'), ('995', '3', 'ar_01', 'Топор Ненавести', '2', '3000', '45', '70', '60', '60', null, null, null, '7', '6', '6', '550', '120', '149', '212', '40', null, '120', null, null, null, null, null, '0', '100', '0'), ('990', '8', 'br_02', 'Чёрная броня', '3', '1200', '47', '70', '50', null, '55', null, null, '2', null, '5', '350', null, null, '80', '90', '80', '50', null, '85', '85', null, null, '0', '100', '0'), ('996', '8', 'br_01', 'Клёпаная броня', '3', '280', '25', '55', '0', '50', '45', null, null, null, null, '3', '180', null, null, '30', '60', '20', '60', null, '40', '40', null, null, '0', '80', '0'), ('998', '7', 'gr_01', 'Кожаные перчатки равновесия', '8', '850', '43', '55', '50', '50', null, null, null, '6', '5', null, '130', '45', '59', '90', '60', null, null, null, '45', null, null, null, '0', '100', '0'), ('991', '9', 'he_03', 'Маска Тьмы', '7', '950', '39', '65', '55', '40', null, null, null, '3', '0', '3', '150', null, null, null, '80', null, '100', '100', null, null, null, null, '0', '100', '0'), ('991', '12', 'ku_01', 'Шипастый кулон', '1', '450', '49', '70', '65', '50', null, null, null, '3', '3', '3', '250', null, null, '90', null, '120', '50', null, null, null, null, null, '0', '100', '0'), ('972', '13', 'ri_01', 'Чёрное кольцо', '4', '420', '44', '60', '70', '55', null, null, null, '0', '4', '4', '280', null, null, '60', '90', '50', '95', null, null, null, null, null, '0', '100', '0'), ('992', '13', 'ri_02', 'Песчаное кольцо', '4', '250', '41', '60', '70', '55', null, null, null, '3', null, '3', '280', null, null, '90', '90', '120', null, null, null, null, null, null, '0', '100', '0'), ('988', '6', 'sa_01', 'Сапоги наемника', '10', '950', '42', null, '65', '50', '50', null, null, '5', '5', null, '150', '35', '50', '60', '50', '110', null, null, null, null, '80', null, '0', '100', '0'), ('996', '10', 'sc_03', 'Щит скорпиона', '9', '1100', '41', '55', '50', '40', null, null, null, '6', null, '5', '200', null, null, '50', '110', '70', null, '70', '70', '70', '70', null, '0', '100', '0'), ('994', '10', 'sc_02', 'Обсидиановый Щит', '9', '340', '26', '30', '33', '30', null, null, null, null, null, null, null, '10', '15', '40', '70', '30', '60', '30', '30', '30', '30', null, '0', '80', '0'), ('987', '11', 'se_02', 'Экзотические серьги', '0', '470', '50', '0', '70', '70', '60', null, null, '5', '5', '5', '400', null, null, '140', '40', '80', null, null, null, null, null, null, '0', '100', '0'), ('992', '3', 'me_gl', 'Меч Боли', '2', '4500', '57', '85', '75', '0', '80', null, null, '8', null, '7', '400', '165', '231', '235', null, '90', '260', null, null, null, null, null, '0', '100', '0'), ('990', '10', 'sh_gl', 'Золотой щит солнца', '9', '2500', '54', '65', '70', '65', null, null, null, '4', '5', '8', '500', null, null, null, '200', '180', '90', '94', '94', '94', '94', null, '0', '100', '0'), ('989', '7', 'per_gl', 'Стальные перчатки рыцаря', '8', '1900', '51', '77', '50', '65', null, null, null, '10', null, '7', '250', '63', '112', '200', null, null, '90', null, '90', null, null, null, '0', '100', '0'), ('996', '17', 'stat2_2', 'Сброс статов', '11', '350', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Сброс статов', '0', '5', '100'), ('994', '17', 'stat1_2', 'Сброс своих статов', '11', '250', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'Сброс своих статов', '0', '5', '100'), ('994', '5', 'amolot1', 'SAD', '2', '11', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'шахтёр', '0', '9999', '44');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_top5_exclude`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_top5_exclude`;
CREATE TABLE `timeofwars_top5_exclude` (
  `Username` char(20) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_top5_exclude`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_top5_exclude` VALUES ('Admin');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_topics`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_topics`;
CREATE TABLE `timeofwars_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'thread.gif',
  `isfixed` enum('0','1') NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `author` varchar(20) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `id_forum` int(11) NOT NULL DEFAULT '1',
  `datepost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_transfer`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_transfer`;
CREATE TABLE `timeofwars_transfer` (
  `Date` date NOT NULL DEFAULT '0000-00-00',
  `From` varchar(30) NOT NULL DEFAULT '',
  `To` varchar(30) NOT NULL DEFAULT '',
  `What` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_turnir`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_turnir`;
CREATE TABLE `timeofwars_turnir` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `date` char(11) NOT NULL,
  `creator` char(25) NOT NULL,
  `stavka` smallint(5) NOT NULL,
  `next_stavka` smallint(3) NOT NULL,
  `players` tinyint(3) NOT NULL,
  `wait` smallint(4) NOT NULL,
  `winner` char(25) NOT NULL,
  `status` enum('3','2','1') NOT NULL DEFAULT '1' COMMENT '1 - начало, 2 - в бою, 3 - закончен',
  `prize` smallint(5) NOT NULL DEFAULT '0',
  `points` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_turnir_things`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_turnir_things`;
CREATE TABLE `timeofwars_turnir_things` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `turnir_id` mediumint(8) NOT NULL,
  `in_use` mediumint(8) NOT NULL,
  `coord` smallint(5) NOT NULL,
  `Thing_Name` char(30) NOT NULL,
  `img` char(30) NOT NULL,
  `slot` tinyint(2) NOT NULL,
  `Crit` tinyint(3) NOT NULL DEFAULT '0',
  `AntiCrit` tinyint(3) NOT NULL DEFAULT '0',
  `Uv` tinyint(3) NOT NULL DEFAULT '0',
  `AntiUv` tinyint(3) NOT NULL DEFAULT '0',
  `Armor1` tinyint(3) NOT NULL DEFAULT '0',
  `Armor2` tinyint(3) NOT NULL DEFAULT '0',
  `Armor3` tinyint(3) NOT NULL DEFAULT '0',
  `Armor4` tinyint(3) NOT NULL DEFAULT '0',
  `MINdamage` tinyint(3) NOT NULL DEFAULT '0',
  `MAXdamage` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `turnir_id` (`turnir_id`),
  KEY `in_use` (`in_use`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_turnir_users`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_turnir_users`;
CREATE TABLE `timeofwars_turnir_users` (
  `turnir_id` mediumint(8) NOT NULL,
  `user` char(20) NOT NULL,
  `coord` tinyint(3) NOT NULL DEFAULT '0',
  `battle_id` mediumint(8) NOT NULL,
  `do_level` tinyint(3) unsigned NOT NULL,
  `do_stre` smallint(3) NOT NULL,
  `do_agil` smallint(3) NOT NULL,
  `do_intu` smallint(3) NOT NULL,
  `do_endu` smallint(3) NOT NULL,
  `do_intl` smallint(3) NOT NULL,
  `do_ups` smallint(3) NOT NULL,
  `do_hpall` smallint(4) NOT NULL,
  `end_move` char(11) NOT NULL,
  `move_direction` set('right','left','bottom','top') NOT NULL,
  `points` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_user_has_admin_abils`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_user_has_admin_abils`;
CREATE TABLE `timeofwars_user_has_admin_abils` (
  `Username` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `id_admin_abils` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`,`id_admin_abils`),
  FULLTEXT KEY `Username` (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_user_has_admin_abils`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_user_has_admin_abils` VALUES ('Admin', '1');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_user_has_admin_rules`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_user_has_admin_rules`;
CREATE TABLE `timeofwars_user_has_admin_rules` (
  `Username` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_bin NOT NULL DEFAULT '',
  `id_admin_rules` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Username`,`id_admin_rules`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `timeofwars_user_has_admin_rules`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_user_has_admin_rules` VALUES ('Admin', '255');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_users_peak`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_users_peak`;
CREATE TABLE `timeofwars_users_peak` (
  `Date` varchar(100) NOT NULL DEFAULT '',
  `Num` bigint(20) NOT NULL DEFAULT '0',
  `Temp` char(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_vampirizm`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_vampirizm`;
CREATE TABLE `timeofwars_vampirizm` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `clan_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `timeofwars_vampirizm`
-- ----------------------------
BEGIN;
INSERT INTO `timeofwars_vampirizm` VALUES ('1', '255');
COMMIT;

-- ----------------------------
--  Table structure for `timeofwars_vip`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_vip`;
CREATE TABLE `timeofwars_vip` (
  `Username` varchar(30) NOT NULL DEFAULT '',
  `Link` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `timeofwars_voting`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_voting`;
CREATE TABLE `timeofwars_voting` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `vote_id` tinyint(3) NOT NULL,
  `poll` tinyint(3) NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `timeofwars_wood_g`
-- ----------------------------
DROP TABLE IF EXISTS `timeofwars_wood_g`;
CREATE TABLE `timeofwars_wood_g` (
  `persid` varchar(30) NOT NULL DEFAULT '',
  `time` varchar(30) NOT NULL DEFAULT '',
  `pict` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
