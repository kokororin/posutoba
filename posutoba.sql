DROP TABLE IF EXISTS tb_block_users;
CREATE TABLE `tb_block_users` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `block_date` datetime NOT NULL,
  `block_days` int(11) NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_forum;
CREATE TABLE `tb_forum` (
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`forum_id`),
  UNIQUE KEY `forum_name` (`forum_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum` VALUES('3fmebrw','诺艾尔','5177dfe3a4e4580d1ecb7f70c7d493f2.jpg','可是一直在这等着。一直等着大家等着乃乃香','4','9');
DROP TABLE IF EXISTS tb_forum_class;
CREATE TABLE `tb_forum_class` (
  `data_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `class_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum_class` VALUES('1','0','1','娱乐明星','entertainment');
INSERT INTO `tb_forum_class` VALUES('2','1','1','港台东南亚明星',null);
INSERT INTO `tb_forum_class` VALUES('3','2','1','内地明星',null);
INSERT INTO `tb_forum_class` VALUES('4','3','1','韩国明星',null);
INSERT INTO `tb_forum_class` VALUES('5','4','1','日本明星',null);
INSERT INTO `tb_forum_class` VALUES('6','5','1','时尚人物',null);
INSERT INTO `tb_forum_class` VALUES('7','6','1','欧美明星',null);
INSERT INTO `tb_forum_class` VALUES('8','7','1','主持人',null);
INSERT INTO `tb_forum_class` VALUES('9','8','1','其他娱乐明星',null);
INSERT INTO `tb_forum_class` VALUES('10','9','1','娱乐明星话题',null);
INSERT INTO `tb_forum_class` VALUES('11','10','1','导演',null);
INSERT INTO `tb_forum_class` VALUES('12','11','1','戏曲曲艺明星',null);
INSERT INTO `tb_forum_class` VALUES('13','12','1','2012中国好声音',null);
INSERT INTO `tb_forum_class` VALUES('14','13','1','音乐制作人',null);
INSERT INTO `tb_forum_class` VALUES('15','14','1','其他粉丝组织',null);
INSERT INTO `tb_forum_class` VALUES('16','0','2','爱综艺','tvshows');
INSERT INTO `tb_forum_class` VALUES('17','1','2','内地综艺',null);
INSERT INTO `tb_forum_class` VALUES('18','2','2','台湾综艺',null);
INSERT INTO `tb_forum_class` VALUES('19','3','2','韩国综艺',null);
INSERT INTO `tb_forum_class` VALUES('20','4','2','时尚·生活服务',null);
INSERT INTO `tb_forum_class` VALUES('21','5','2','体育运动·健身',null);
INSERT INTO `tb_forum_class` VALUES('22','6','2','财经·职场',null);
INSERT INTO `tb_forum_class` VALUES('23','7','2','新闻资讯',null);
INSERT INTO `tb_forum_class` VALUES('24','8','2','电视台及频道',null);
INSERT INTO `tb_forum_class` VALUES('25','9','2','音乐·文艺',null);
INSERT INTO `tb_forum_class` VALUES('26','10','2','其他节目及话题',null);
INSERT INTO `tb_forum_class` VALUES('27','11','2','科教记录·社会与法',null);
INSERT INTO `tb_forum_class` VALUES('28','12','2','少儿·教育',null);
INSERT INTO `tb_forum_class` VALUES('29','13','2','广播电台',null);
INSERT INTO `tb_forum_class` VALUES('30','0','3','追剧狂','teleplay');
INSERT INTO `tb_forum_class` VALUES('31','1','3','韩国电视剧',null);
INSERT INTO `tb_forum_class` VALUES('32','2','3','香港电视剧',null);
INSERT INTO `tb_forum_class` VALUES('33','3','3','美剧',null);
INSERT INTO `tb_forum_class` VALUES('34','4','3','日本电视剧',null);
INSERT INTO `tb_forum_class` VALUES('35','5','3','内地电视剧',null);
INSERT INTO `tb_forum_class` VALUES('36','6','3','台湾电视剧',null);
INSERT INTO `tb_forum_class` VALUES('37','7','3','东南亚电视剧',null);
INSERT INTO `tb_forum_class` VALUES('38','8','3','其他地区电视剧',null);
INSERT INTO `tb_forum_class` VALUES('39','9','3','电视剧角色',null);
INSERT INTO `tb_forum_class` VALUES('40','10','3','电视剧话题',null);
INSERT INTO `tb_forum_class` VALUES('41','0','4','看电影','movie');
INSERT INTO `tb_forum_class` VALUES('42','1','4','香港电影',null);
INSERT INTO `tb_forum_class` VALUES('43','2','4','欧美电影',null);
INSERT INTO `tb_forum_class` VALUES('44','3','4','内地电影',null);
INSERT INTO `tb_forum_class` VALUES('45','4','4','韩国电影',null);
INSERT INTO `tb_forum_class` VALUES('46','5','4','日本电影',null);
INSERT INTO `tb_forum_class` VALUES('47','6','4','台湾电影',null);
INSERT INTO `tb_forum_class` VALUES('48','7','4','电影话题',null);
INSERT INTO `tb_forum_class` VALUES('49','8','4','东南亚电影',null);
INSERT INTO `tb_forum_class` VALUES('50','9','4','其他地区电影',null);
INSERT INTO `tb_forum_class` VALUES('51','0','5','体育','sports');
INSERT INTO `tb_forum_class` VALUES('52','1','5','nba球队及赛事',null);
INSERT INTO `tb_forum_class` VALUES('53','2','5','中国足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('54','3','5','台球',null);
INSERT INTO `tb_forum_class` VALUES('55','4','5','赛车',null);
INSERT INTO `tb_forum_class` VALUES('56','5','5','田径',null);
INSERT INTO `tb_forum_class` VALUES('57','6','5','田径明星',null);
INSERT INTO `tb_forum_class` VALUES('58','7','5','英国足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('59','8','5','西班牙足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('60','9','5','德国足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('61','10','5','意大利足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('62','11','5','法国足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('63','12','5','足球明星',null);
INSERT INTO `tb_forum_class` VALUES('64','13','5','篮球明星',null);
INSERT INTO `tb_forum_class` VALUES('65','14','5','网球明星',null);
INSERT INTO `tb_forum_class` VALUES('66','15','5','体操明星',null);
INSERT INTO `tb_forum_class` VALUES('67','16','5','台球明星篮球国家队、协会及赛事',null);
INSERT INTO `tb_forum_class` VALUES('68','17','5','cba球队及赛事',null);
INSERT INTO `tb_forum_class` VALUES('69','18','5','电子竞技及选手',null);
INSERT INTO `tb_forum_class` VALUES('70','19','5','排球',null);
INSERT INTO `tb_forum_class` VALUES('71','20','5','排球明星',null);
INSERT INTO `tb_forum_class` VALUES('72','21','5','棋牌类',null);
INSERT INTO `tb_forum_class` VALUES('73','22','5','武术搏击',null);
INSERT INTO `tb_forum_class` VALUES('74','23','5','水上运动',null);
INSERT INTO `tb_forum_class` VALUES('75','24','5','水上运动明星',null);
INSERT INTO `tb_forum_class` VALUES('76','25','5','冬季项目明星',null);
INSERT INTO `tb_forum_class` VALUES('77','26','5','冰上运动',null);
INSERT INTO `tb_forum_class` VALUES('78','27','5','乒羽明星',null);
INSERT INTO `tb_forum_class` VALUES('79','28','5','休闲体育',null);
INSERT INTO `tb_forum_class` VALUES('80','29','5','舞蹈',null);
INSERT INTO `tb_forum_class` VALUES('81','30','5','乒羽·网球',null);
INSERT INTO `tb_forum_class` VALUES('82','31','5','赛车明星',null);
INSERT INTO `tb_forum_class` VALUES('83','32','5','足球国家队及协会',null);
INSERT INTO `tb_forum_class` VALUES('84','33','5','体育相关话题',null);
INSERT INTO `tb_forum_class` VALUES('85','34','5','体育记者及媒体',null);
INSERT INTO `tb_forum_class` VALUES('86','35','5','其他体育明星',null);
INSERT INTO `tb_forum_class` VALUES('87','36','5','其他体育项目及赛事',null);
INSERT INTO `tb_forum_class` VALUES('88','37','5','其他足球俱乐部及赛事',null);
INSERT INTO `tb_forum_class` VALUES('89','0','6','生活家','livingexpert');
INSERT INTO `tb_forum_class` VALUES('90','1','6','DIY',null);
INSERT INTO `tb_forum_class` VALUES('91','2','6','摄影',null);
INSERT INTO `tb_forum_class` VALUES('92','3','6','画画',null);
INSERT INTO `tb_forum_class` VALUES('93','4','6','旅行',null);
INSERT INTO `tb_forum_class` VALUES('94','5','6','奢侈品',null);
INSERT INTO `tb_forum_class` VALUES('95','6','6','手绘',null);
INSERT INTO `tb_forum_class` VALUES('96','7','6','意境',null);
INSERT INTO `tb_forum_class` VALUES('97','8','6','古玩',null);
INSERT INTO `tb_forum_class` VALUES('98','9','6','模型',null);
INSERT INTO `tb_forum_class` VALUES('99','10','6','彩票',null);
INSERT INTO `tb_forum_class` VALUES('100','11','6','茶',null);
INSERT INTO `tb_forum_class` VALUES('101','12','6','车',null);
INSERT INTO `tb_forum_class` VALUES('102','13','6','创作',null);
INSERT INTO `tb_forum_class` VALUES('103','14','6','二手',null);
INSERT INTO `tb_forum_class` VALUES('104','15','6','交流',null);
INSERT INTO `tb_forum_class` VALUES('105','16','6','经验',null);
INSERT INTO `tb_forum_class` VALUES('106','17','6','花',null);
INSERT INTO `tb_forum_class` VALUES('107','18','6','植物',null);
INSERT INTO `tb_forum_class` VALUES('108','19','6','家居',null);
INSERT INTO `tb_forum_class` VALUES('109','20','6','小而美',null);
INSERT INTO `tb_forum_class` VALUES('110','21','6','理财',null);
INSERT INTO `tb_forum_class` VALUES('111','22','6','投资',null);
INSERT INTO `tb_forum_class` VALUES('112','23','6','职场',null);
INSERT INTO `tb_forum_class` VALUES('113','24','6','多肉植物',null);
INSERT INTO `tb_forum_class` VALUES('114','25','6','手工冷门',null);
INSERT INTO `tb_forum_class` VALUES('115','26','6','收藏',null);
INSERT INTO `tb_forum_class` VALUES('116','27','6','甜品美食',null);
INSERT INTO `tb_forum_class` VALUES('117','28','6','购物',null);
INSERT INTO `tb_forum_class` VALUES('118','0','7','闲·趣','xianqu');
INSERT INTO `tb_forum_class` VALUES('119','1','7','萌宠',null);
INSERT INTO `tb_forum_class` VALUES('120','2','7','喵星人',null);
INSERT INTO `tb_forum_class` VALUES('121','3','7','萝莉',null);
INSERT INTO `tb_forum_class` VALUES('122','4','7','童年',null);
INSERT INTO `tb_forum_class` VALUES('123','5','7','汪星人',null);
INSERT INTO `tb_forum_class` VALUES('124','6','7','正太',null);
INSERT INTO `tb_forum_class` VALUES('125','7','7','爆料',null);
INSERT INTO `tb_forum_class` VALUES('126','8','7','吐槽',null);
INSERT INTO `tb_forum_class` VALUES('127','9','7','内涵',null);
INSERT INTO `tb_forum_class` VALUES('128','10','7','恐怖',null);
INSERT INTO `tb_forum_class` VALUES('129','11','7','重口味',null);
INSERT INTO `tb_forum_class` VALUES('130','12','7','星座',null);
INSERT INTO `tb_forum_class` VALUES('131','0','8','游戏','game');
INSERT INTO `tb_forum_class` VALUES('132','1','8','客户端网游',null);
INSERT INTO `tb_forum_class` VALUES('133','2','8','桌游',null);
INSERT INTO `tb_forum_class` VALUES('134','3','8','游戏角色',null);
INSERT INTO `tb_forum_class` VALUES('135','4','8','网页版网游',null);
INSERT INTO `tb_forum_class` VALUES('136','5','8','手机游戏',null);
INSERT INTO `tb_forum_class` VALUES('137','6','8','小游戏',null);
INSERT INTO `tb_forum_class` VALUES('138','7','8','单机游戏',null);
INSERT INTO `tb_forum_class` VALUES('139','8','8','掌机游戏',null);
INSERT INTO `tb_forum_class` VALUES('140','9','8','电视游戏',null);
INSERT INTO `tb_forum_class` VALUES('141','10','8','其他游戏及话题',null);
INSERT INTO `tb_forum_class` VALUES('142','0','9','动漫宅','cartoon');
INSERT INTO `tb_forum_class` VALUES('143','1','9','推理',null);
INSERT INTO `tb_forum_class` VALUES('144','2','9','声优',null);
INSERT INTO `tb_forum_class` VALUES('145','3','9','COS',null);
INSERT INTO `tb_forum_class` VALUES('146','4','9','日本动漫',null);
INSERT INTO `tb_forum_class` VALUES('147','5','9','国产动漫',null);
INSERT INTO `tb_forum_class` VALUES('148','6','9','欧美动漫',null);
INSERT INTO `tb_forum_class` VALUES('149','7','9','少男漫',null);
INSERT INTO `tb_forum_class` VALUES('150','8','9','暴走漫画',null);
INSERT INTO `tb_forum_class` VALUES('151','9','9','耽美漫画',null);
INSERT INTO `tb_forum_class` VALUES('152','10','9','少女漫画',null);
INSERT INTO `tb_forum_class` VALUES('153','11','9','搞笑漫画',null);
INSERT INTO `tb_forum_class` VALUES('154','12','9','科幻系',null);
INSERT INTO `tb_forum_class` VALUES('155','13','9','冒险',null);
INSERT INTO `tb_forum_class` VALUES('156','14','9','青春恋爱',null);
INSERT INTO `tb_forum_class` VALUES('157','15','9','热血动漫',null);
INSERT INTO `tb_forum_class` VALUES('158','16','9','同人',null);
INSERT INTO `tb_forum_class` VALUES('159','17','9','手办',null);
INSERT INTO `tb_forum_class` VALUES('160','0','10','追星族',null);
INSERT INTO `tb_forum_class` VALUES('161','1','10','偶像明星',null);
INSERT INTO `tb_forum_class` VALUES('162','2','10','韩饭',null);
INSERT INTO `tb_forum_class` VALUES('163','3','10','娱乐八卦',null);
INSERT INTO `tb_forum_class` VALUES('164','4','10','欧美明星',null);
INSERT INTO `tb_forum_class` VALUES('165','5','10','港台明星',null);
INSERT INTO `tb_forum_class` VALUES('166','6','10','内地明星',null);
INSERT INTO `tb_forum_class` VALUES('167','7','10','球星',null);
INSERT INTO `tb_forum_class` VALUES('168','8','10','篮球明星',null);
INSERT INTO `tb_forum_class` VALUES('169','9','10','笑星',null);
INSERT INTO `tb_forum_class` VALUES('170','10','10','乐队',null);
INSERT INTO `tb_forum_class` VALUES('171','11','10','时尚明星',null);
INSERT INTO `tb_forum_class` VALUES('172','12','10','主持人',null);
INSERT INTO `tb_forum_class` VALUES('173','13','10','声优控',null);
INSERT INTO `tb_forum_class` VALUES('174','14','10','帅大叔',null);
INSERT INTO `tb_forum_class` VALUES('175','15','10','日饭',null);
INSERT INTO `tb_forum_class` VALUES('176','0','11','工农业产品',null);
INSERT INTO `tb_forum_class` VALUES('177','1','11','其他工农业产品及话题',null);
INSERT INTO `tb_forum_class` VALUES('178','2','11','农林牧渔',null);
INSERT INTO `tb_forum_class` VALUES('179','3','11','包装/印刷/纸业',null);
INSERT INTO `tb_forum_class` VALUES('180','4','11','医疗器械',null);
INSERT INTO `tb_forum_class` VALUES('181','5','11','安全防护',null);
INSERT INTO `tb_forum_class` VALUES('182','6','11','机械设备',null);
INSERT INTO `tb_forum_class` VALUES('183','7','11','电子电工',null);
INSERT INTO `tb_forum_class` VALUES('184','8','11','纺织/化工/化学品',null);
INSERT INTO `tb_forum_class` VALUES('185','9','11','能源/冶金/建材',null);
INSERT INTO `tb_forum_class` VALUES('186','0','12','音乐',null);
INSERT INTO `tb_forum_class` VALUES('187','1','12','内地流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('188','2','12','港台流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('189','3','12','日本流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('190','4','12','韩国流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('191','5','12','欧美流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('192','6','12','摇滚音乐',null);
INSERT INTO `tb_forum_class` VALUES('193','7','12','古典音乐&轻音乐',null);
INSERT INTO `tb_forum_class` VALUES('194','8','12','少儿歌曲',null);
INSERT INTO `tb_forum_class` VALUES('195','9','12','民歌',null);
INSERT INTO `tb_forum_class` VALUES('196','10','12','乐器',null);
INSERT INTO `tb_forum_class` VALUES('197','11','12','音乐话题',null);
INSERT INTO `tb_forum_class` VALUES('198','12','12','其他地区流行音乐',null);
INSERT INTO `tb_forum_class` VALUES('199','0','13','高等院校','academy');
INSERT INTO `tb_forum_class` VALUES('200','1','13','北京院校',null);
INSERT INTO `tb_forum_class` VALUES('201','2','13','山东院校',null);
INSERT INTO `tb_forum_class` VALUES('202','3','13','江苏院校',null);
INSERT INTO `tb_forum_class` VALUES('203','4','13','四川院校',null);
INSERT INTO `tb_forum_class` VALUES('204','5','13','湖北院校',null);
INSERT INTO `tb_forum_class` VALUES('205','6','13','河北院校',null);
INSERT INTO `tb_forum_class` VALUES('206','7','13','安徽院校',null);
INSERT INTO `tb_forum_class` VALUES('207','8','13','陕西院校',null);
INSERT INTO `tb_forum_class` VALUES('208','9','13','浙江院校',null);
INSERT INTO `tb_forum_class` VALUES('209','10','13','辽宁院校',null);
INSERT INTO `tb_forum_class` VALUES('210','11','13','湖南院校',null);
INSERT INTO `tb_forum_class` VALUES('211','12','13','福建院校',null);
INSERT INTO `tb_forum_class` VALUES('212','13','13','江西院校',null);
INSERT INTO `tb_forum_class` VALUES('213','14','13','重庆院校',null);
INSERT INTO `tb_forum_class` VALUES('214','15','13','广东院校',null);
INSERT INTO `tb_forum_class` VALUES('215','16','13','河南院校',null);
INSERT INTO `tb_forum_class` VALUES('216','17','13','山西院校',null);
INSERT INTO `tb_forum_class` VALUES('217','18','13','上海院校',null);
INSERT INTO `tb_forum_class` VALUES('218','19','13','黑龙江院校',null);
INSERT INTO `tb_forum_class` VALUES('219','20','13','天津院校',null);
INSERT INTO `tb_forum_class` VALUES('220','21','13','吉林院校',null);
INSERT INTO `tb_forum_class` VALUES('221','22','13','广西院校',null);
INSERT INTO `tb_forum_class` VALUES('222','23','13','云南院校',null);
INSERT INTO `tb_forum_class` VALUES('223','24','13','甘肃院校',null);
INSERT INTO `tb_forum_class` VALUES('224','25','13','内蒙古院校',null);
INSERT INTO `tb_forum_class` VALUES('225','26','13','贵州院校',null);
INSERT INTO `tb_forum_class` VALUES('226','27','13','海南院校',null);
INSERT INTO `tb_forum_class` VALUES('227','28','13','新疆院校',null);
INSERT INTO `tb_forum_class` VALUES('228','29','13','宁夏院校',null);
INSERT INTO `tb_forum_class` VALUES('229','30','13','港澳台院校',null);
INSERT INTO `tb_forum_class` VALUES('230','31','13','海外院校',null);
INSERT INTO `tb_forum_class` VALUES('231','32','13','青海院校',null);
INSERT INTO `tb_forum_class` VALUES('232','33','13','西藏院校',null);
INSERT INTO `tb_forum_class` VALUES('233','34','13','学校话题',null);
INSERT INTO `tb_forum_class` VALUES('234','35','13','校园青春',null);
INSERT INTO `tb_forum_class` VALUES('235','0','14','中小学',null);
INSERT INTO `tb_forum_class` VALUES('236','1','14','广东中小学',null);
INSERT INTO `tb_forum_class` VALUES('237','2','14','上海中小学',null);
INSERT INTO `tb_forum_class` VALUES('238','3','14','云南中小学',null);
INSERT INTO `tb_forum_class` VALUES('239','4','14','北京中小学',null);
INSERT INTO `tb_forum_class` VALUES('240','5','14','内蒙古中小学',null);
INSERT INTO `tb_forum_class` VALUES('241','6','14','吉林中小学',null);
INSERT INTO `tb_forum_class` VALUES('242','7','14','四川中小学',null);
INSERT INTO `tb_forum_class` VALUES('243','8','14','天津中小学',null);
INSERT INTO `tb_forum_class` VALUES('244','9','14','安徽中小学',null);
INSERT INTO `tb_forum_class` VALUES('245','10','14','山东中小学',null);
INSERT INTO `tb_forum_class` VALUES('246','11','14','山西中小学',null);
INSERT INTO `tb_forum_class` VALUES('247','12','14','广西中小学',null);
INSERT INTO `tb_forum_class` VALUES('248','13','14','新疆中小学',null);
INSERT INTO `tb_forum_class` VALUES('249','14','14','江苏中小学',null);
INSERT INTO `tb_forum_class` VALUES('250','15','14','江西中小学',null);
INSERT INTO `tb_forum_class` VALUES('251','16','14','河北中小学',null);
INSERT INTO `tb_forum_class` VALUES('252','17','14','河南中小学',null);
INSERT INTO `tb_forum_class` VALUES('253','18','14','浙江中小学',null);
INSERT INTO `tb_forum_class` VALUES('254','19','14','海南中小学',null);
INSERT INTO `tb_forum_class` VALUES('255','20','14','湖北中小学',null);
INSERT INTO `tb_forum_class` VALUES('256','21','14','湖南中小学',null);
INSERT INTO `tb_forum_class` VALUES('257','22','14','福建中小学',null);
INSERT INTO `tb_forum_class` VALUES('258','23','14','贵州中小学',null);
INSERT INTO `tb_forum_class` VALUES('259','24','14','辽宁中小学',null);
INSERT INTO `tb_forum_class` VALUES('260','25','14','重庆中小学',null);
INSERT INTO `tb_forum_class` VALUES('261','26','14','陕西中小学',null);
INSERT INTO `tb_forum_class` VALUES('262','27','14','黑龙江中小学',null);
INSERT INTO `tb_forum_class` VALUES('263','28','14','宁夏中小学',null);
INSERT INTO `tb_forum_class` VALUES('264','29','14','西藏中小学',null);
INSERT INTO `tb_forum_class` VALUES('265','30','14','青海中小学',null);
INSERT INTO `tb_forum_class` VALUES('266','31','14','甘肃中小学',null);
INSERT INTO `tb_forum_class` VALUES('267','32','14','其他地区中小学及话题',null);
INSERT INTO `tb_forum_class` VALUES('268','0','15','地区','district');
INSERT INTO `tb_forum_class` VALUES('269','1','15','山东',null);
INSERT INTO `tb_forum_class` VALUES('270','2','15','河北',null);
INSERT INTO `tb_forum_class` VALUES('271','3','15','河南',null);
INSERT INTO `tb_forum_class` VALUES('272','4','15','山西',null);
INSERT INTO `tb_forum_class` VALUES('273','5','15','江苏',null);
INSERT INTO `tb_forum_class` VALUES('274','6','15','辽宁',null);
INSERT INTO `tb_forum_class` VALUES('275','7','15','四川',null);
INSERT INTO `tb_forum_class` VALUES('276','8','15','广东',null);
INSERT INTO `tb_forum_class` VALUES('277','9','15','黑龙江',null);
INSERT INTO `tb_forum_class` VALUES('278','10','15','陕西',null);
INSERT INTO `tb_forum_class` VALUES('279','11','15','安徽',null);
INSERT INTO `tb_forum_class` VALUES('280','12','15','浙江',null);
INSERT INTO `tb_forum_class` VALUES('281','13','15','江西',null);
INSERT INTO `tb_forum_class` VALUES('282','14','15','吉林',null);
INSERT INTO `tb_forum_class` VALUES('283','15','15','内蒙古',null);
INSERT INTO `tb_forum_class` VALUES('284','16','15','湖北',null);
INSERT INTO `tb_forum_class` VALUES('285','17','15','福建',null);
INSERT INTO `tb_forum_class` VALUES('286','18','15','甘肃',null);
INSERT INTO `tb_forum_class` VALUES('287','19','15','海外',null);
INSERT INTO `tb_forum_class` VALUES('288','20','15','湖南',null);
INSERT INTO `tb_forum_class` VALUES('289','21','15','贵州',null);
INSERT INTO `tb_forum_class` VALUES('290','22','15','北京',null);
INSERT INTO `tb_forum_class` VALUES('291','23','15','云南',null);
INSERT INTO `tb_forum_class` VALUES('292','24','15','广西',null);
INSERT INTO `tb_forum_class` VALUES('293','25','15','天津',null);
INSERT INTO `tb_forum_class` VALUES('294','26','15','重庆',null);
INSERT INTO `tb_forum_class` VALUES('295','27','15','上海',null);
INSERT INTO `tb_forum_class` VALUES('296','28','15','宁夏',null);
INSERT INTO `tb_forum_class` VALUES('297','29','15','新疆',null);
INSERT INTO `tb_forum_class` VALUES('298','30','15','青海',null);
INSERT INTO `tb_forum_class` VALUES('299','31','15','海南',null);
INSERT INTO `tb_forum_class` VALUES('300','32','15','港澳台',null);
INSERT INTO `tb_forum_class` VALUES('301','33','15','西藏',null);
INSERT INTO `tb_forum_class` VALUES('302','34','15','其他地区及话题',null);
INSERT INTO `tb_forum_class` VALUES('303','0','16','人文自然','humanity');
INSERT INTO `tb_forum_class` VALUES('304','1','16','艺术',null);
INSERT INTO `tb_forum_class` VALUES('305','2','16','军事',null);
INSERT INTO `tb_forum_class` VALUES('306','3','16','历史',null);
INSERT INTO `tb_forum_class` VALUES('307','4','16','自然',null);
INSERT INTO `tb_forum_class` VALUES('308','5','16','鉴赏收藏',null);
INSERT INTO `tb_forum_class` VALUES('309','6','16','民族文化',null);
INSERT INTO `tb_forum_class` VALUES('310','7','16','语言文化',null);
INSERT INTO `tb_forum_class` VALUES('311','8','16','动植物',null);
INSERT INTO `tb_forum_class` VALUES('312','9','16','姓氏文化',null);
INSERT INTO `tb_forum_class` VALUES('313','10','16','社会科学话题',null);
INSERT INTO `tb_forum_class` VALUES('314','11','16','其他人文话题',null);
INSERT INTO `tb_forum_class` VALUES('315','12','16','其他自然话题',null);
INSERT INTO `tb_forum_class` VALUES('316','0','17','探索者',null);
INSERT INTO `tb_forum_class` VALUES('317','1','17','辩证',null);
INSERT INTO `tb_forum_class` VALUES('318','2','17','地理',null);
INSERT INTO `tb_forum_class` VALUES('319','3','17','方言',null);
INSERT INTO `tb_forum_class` VALUES('320','4','17','攻略',null);
INSERT INTO `tb_forum_class` VALUES('321','5','17','建筑',null);
INSERT INTO `tb_forum_class` VALUES('322','6','17','教学',null);
INSERT INTO `tb_forum_class` VALUES('323','7','17','冷门',null);
INSERT INTO `tb_forum_class` VALUES('324','8','17','点评',null);
INSERT INTO `tb_forum_class` VALUES('325','9','17','物理',null);
INSERT INTO `tb_forum_class` VALUES('326','10','17','心理学',null);
INSERT INTO `tb_forum_class` VALUES('327','11','17','大自然',null);
INSERT INTO `tb_forum_class` VALUES('328','12','17','科学',null);
INSERT INTO `tb_forum_class` VALUES('329','13','17','信仰',null);
INSERT INTO `tb_forum_class` VALUES('330','14','17','修炼',null);
INSERT INTO `tb_forum_class` VALUES('331','15','17','宗教研究',null);
INSERT INTO `tb_forum_class` VALUES('332','16','17','神秘行为',null);
INSERT INTO `tb_forum_class` VALUES('333','0','18','生活','xingqing');
INSERT INTO `tb_forum_class` VALUES('334','1','18','休闲活动',null);
INSERT INTO `tb_forum_class` VALUES('335','2','18','兴趣收藏',null);
INSERT INTO `tb_forum_class` VALUES('336','3','18','贴图',null);
INSERT INTO `tb_forum_class` VALUES('337','4','18','宠物',null);
INSERT INTO `tb_forum_class` VALUES('338','5','18','娱乐八卦',null);
INSERT INTO `tb_forum_class` VALUES('339','6','18','星座运势',null);
INSERT INTO `tb_forum_class` VALUES('340','7','18','旅游',null);
INSERT INTO `tb_forum_class` VALUES('341','8','18','时尚美容',null);
INSERT INTO `tb_forum_class` VALUES('342','9','18','饮食',null);
INSERT INTO `tb_forum_class` VALUES('343','10','18','杂志期刊',null);
INSERT INTO `tb_forum_class` VALUES('344','11','18','母婴',null);
INSERT INTO `tb_forum_class` VALUES('345','12','18','节日',null);
INSERT INTO `tb_forum_class` VALUES('346','13','18','健康保健',null);
INSERT INTO `tb_forum_class` VALUES('347','14','18','原创音视频话题',null);
INSERT INTO `tb_forum_class` VALUES('348','15','18','其他生活话题',null);
INSERT INTO `tb_forum_class` VALUES('349','0','19','生活用品',null);
INSERT INTO `tb_forum_class` VALUES('350','1','19','个护化妆',null);
INSERT INTO `tb_forum_class` VALUES('351','2','19','交通工具、配件及设施',null);
INSERT INTO `tb_forum_class` VALUES('352','3','19','汽车及配件',null);
INSERT INTO `tb_forum_class` VALUES('353','4','19','医药保健',null);
INSERT INTO `tb_forum_class` VALUES('354','5','19','家居用品',null);
INSERT INTO `tb_forum_class` VALUES('355','6','19','文教·体育·娱乐和工美用品',null);
INSERT INTO `tb_forum_class` VALUES('356','7','19','服装服饰',null);
INSERT INTO `tb_forum_class` VALUES('357','8','19','箱包配饰',null);
INSERT INTO `tb_forum_class` VALUES('358','9','19','食品饮料',null);
INSERT INTO `tb_forum_class` VALUES('359','10','19','其他生活用品及话题',null);
INSERT INTO `tb_forum_class` VALUES('360','0','20','商业服务',null);
INSERT INTO `tb_forum_class` VALUES('361','1','20','交通运输',null);
INSERT INTO `tb_forum_class` VALUES('362','2','20','商务服务',null);
INSERT INTO `tb_forum_class` VALUES('363','3','20','开采·加工',null);
INSERT INTO `tb_forum_class` VALUES('364','4','20','生活服务',null);
INSERT INTO `tb_forum_class` VALUES('365','5','20','网络通信服务',null);
INSERT INTO `tb_forum_class` VALUES('366','6','20','其他类型服务',null);
INSERT INTO `tb_forum_class` VALUES('367','0','21','情感',null);
INSERT INTO `tb_forum_class` VALUES('368','1','21','恋爱',null);
INSERT INTO `tb_forum_class` VALUES('369','2','21','年代秀',null);
INSERT INTO `tb_forum_class` VALUES('370','3','21','婚姻家庭',null);
INSERT INTO `tb_forum_class` VALUES('371','4','21','女性话题',null);
INSERT INTO `tb_forum_class` VALUES('372','5','21','感情文化',null);
INSERT INTO `tb_forum_class` VALUES('373','6','21','其他情感话题',null);
INSERT INTO `tb_forum_class` VALUES('374','0','22','电脑数码',null);
INSERT INTO `tb_forum_class` VALUES('375','1','22','手机',null);
INSERT INTO `tb_forum_class` VALUES('376','2','22','数码家电',null);
INSERT INTO `tb_forum_class` VALUES('377','3','22','电脑及硬件',null);
INSERT INTO `tb_forum_class` VALUES('378','4','22','电脑数码话题',null);
INSERT INTO `tb_forum_class` VALUES('379','0','23','社会',null);
INSERT INTO `tb_forum_class` VALUES('380','1','23','公益慈善',null);
INSERT INTO `tb_forum_class` VALUES('381','2','23','医疗机构',null);
INSERT INTO `tb_forum_class` VALUES('382','3','23','社会事件及话题',null);
INSERT INTO `tb_forum_class` VALUES('383','4','23','社会机构',null);
INSERT INTO `tb_forum_class` VALUES('384','5','23','职业话题',null);
INSERT INTO `tb_forum_class` VALUES('385','0','24','教育培训',null);
INSERT INTO `tb_forum_class` VALUES('386','1','24','培训机构',null);
INSERT INTO `tb_forum_class` VALUES('387','2','24','基础教育',null);
INSERT INTO `tb_forum_class` VALUES('388','3','24','外语学习',null);
INSERT INTO `tb_forum_class` VALUES('389','4','24','教育话题',null);
INSERT INTO `tb_forum_class` VALUES('390','5','24','留学',null);
INSERT INTO `tb_forum_class` VALUES('391','6','24','职业技能考试与培训',null);
INSERT INTO `tb_forum_class` VALUES('392','7','24','高等教育',null);
INSERT INTO `tb_forum_class` VALUES('393','0','25','历史人物',null);
INSERT INTO `tb_forum_class` VALUES('394','1','25','中国古代历史人物',null);
INSERT INTO `tb_forum_class` VALUES('395','2','25','中国近现代历史人物',null);
INSERT INTO `tb_forum_class` VALUES('396','3','25','历史人物话题',null);
INSERT INTO `tb_forum_class` VALUES('397','4','25','外国历史人物',null);
INSERT INTO `tb_forum_class` VALUES('398','0','26','当代人物',null);
INSERT INTO `tb_forum_class` VALUES('399','1','26','其他当代人物',null);
INSERT INTO `tb_forum_class` VALUES('400','2','26','商业人物',null);
INSERT INTO `tb_forum_class` VALUES('401','3','26','当代军事政治人物',null);
INSERT INTO `tb_forum_class` VALUES('402','4','26','当代社会科学人物',null);
INSERT INTO `tb_forum_class` VALUES('403','5','26','当代自然科学人物',null);
INSERT INTO `tb_forum_class` VALUES('404','6','26','当代艺术人物',null);
INSERT INTO `tb_forum_class` VALUES('405','7','26','热点新闻人物',null);
INSERT INTO `tb_forum_class` VALUES('406','0','27','科学技术',null);
INSERT INTO `tb_forum_class` VALUES('407','1','27','互联网产品及话题',null);
INSERT INTO `tb_forum_class` VALUES('408','2','27','程序设计',null);
INSERT INTO `tb_forum_class` VALUES('409','3','27','自然科学话题',null);
INSERT INTO `tb_forum_class` VALUES('410','4','27','计算机软件',null);
INSERT INTO `tb_forum_class` VALUES('411','5','27','其他科技话题',null);
INSERT INTO `tb_forum_class` VALUES('412','6','27','其他计算机相关',null);
INSERT INTO `tb_forum_class` VALUES('413','0','28','金融',null);
INSERT INTO `tb_forum_class` VALUES('414','1','28','B股',null);
INSERT INTO `tb_forum_class` VALUES('415','2','28','基金',null);
INSERT INTO `tb_forum_class` VALUES('416','3','28','期货/权证',null);
INSERT INTO `tb_forum_class` VALUES('417','4','28','沪市A股',null);
INSERT INTO `tb_forum_class` VALUES('418','5','28','深市A股',null);
INSERT INTO `tb_forum_class` VALUES('419','6','28','金融组织机构',null);
INSERT INTO `tb_forum_class` VALUES('420','7','28','其他金融服务及产品',null);
INSERT INTO `tb_forum_class` VALUES('421','0','29','企业',null);
INSERT INTO `tb_forum_class` VALUES('422','1','29','美容保健',null);
INSERT INTO `tb_forum_class` VALUES('423','2','29','互联网企业',null);
INSERT INTO `tb_forum_class` VALUES('424','3','29','交通运输、仓储和邮政业',null);
INSERT INTO `tb_forum_class` VALUES('425','4','29','企业话题',null);
INSERT INTO `tb_forum_class` VALUES('426','5','29','餐饮美食',null);
INSERT INTO `tb_forum_class` VALUES('427','6','29','农林牧渔',null);
INSERT INTO `tb_forum_class` VALUES('428','7','29','包装/印刷/纸业',null);
INSERT INTO `tb_forum_class` VALUES('429','8','29','医药保健企业',null);
INSERT INTO `tb_forum_class` VALUES('430','9','29','商务服务业',null);
INSERT INTO `tb_forum_class` VALUES('431','10','29','家居用品',null);
INSERT INTO `tb_forum_class` VALUES('432','11','29','建筑业',null);
INSERT INTO `tb_forum_class` VALUES('433','12','29','房地产',null);
INSERT INTO `tb_forum_class` VALUES('434','13','29','批发零售业',null);
INSERT INTO `tb_forum_class` VALUES('435','14','29','数码家电',null);
INSERT INTO `tb_forum_class` VALUES('436','15','29','娱乐休闲',null);
INSERT INTO `tb_forum_class` VALUES('437','16','29','服装服饰企业',null);
INSERT INTO `tb_forum_class` VALUES('438','17','29','机械设备',null);
INSERT INTO `tb_forum_class` VALUES('439','18','29','汽车制造业',null);
INSERT INTO `tb_forum_class` VALUES('440','19','29','生活服务业',null);
INSERT INTO `tb_forum_class` VALUES('441','20','29','IT行业',null);
INSERT INTO `tb_forum_class` VALUES('442','21','29','商场购物',null);
INSERT INTO `tb_forum_class` VALUES('443','22','29','纺织/化工/化学品',null);
INSERT INTO `tb_forum_class` VALUES('444','23','29','能源/冶金/建材',null);
INSERT INTO `tb_forum_class` VALUES('445','24','29','其他类型企业',null);
INSERT INTO `tb_forum_class` VALUES('446','0','30','服务中心',null);
INSERT INTO `tb_forum_class` VALUES('447','1','30','贴吧活动与交流',null);
INSERT INTO `tb_forum_class` VALUES('448','2','30','贴吧管理中心',null);
DROP TABLE IF EXISTS tb_forum_fans;
CREATE TABLE `tb_forum_fans` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fans_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum_fans` VALUES('1d7mj70','3fmebrw','3ixtnqv');
INSERT INTO `tb_forum_fans` VALUES('3r75rnu','3fmebrw','`1k`c');
INSERT INTO `tb_forum_fans` VALUES('4kz13zg','3fmebrw','16l2bkr');
DROP TABLE IF EXISTS tb_forum_manager;
CREATE TABLE `tb_forum_manager` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manager_type` int(11) NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum_manager` VALUES('18tr3j','3fmebrw','16l2bkr','0');
INSERT INTO `tb_forum_manager` VALUES('25brhij','3fmebrw','3ixtnqv','0');
INSERT INTO `tb_forum_manager` VALUES('44fxl0m','3fmebrw','3zh9fsm','1');
DROP TABLE IF EXISTS tb_forum_manager_apply;
CREATE TABLE `tb_forum_manager_apply` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apply_date` datetime NOT NULL,
  `apply_type` int(11) NOT NULL,
  `apply_content` text COLLATE utf8_unicode_ci NOT NULL,
  `is_pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum_manager_apply` VALUES('3m8wdrg','3ixtnqv','3fmebrw','2015-05-14 10:17:16','0','申请吧主谢谢','1');
INSERT INTO `tb_forum_manager_apply` VALUES('2aafp8j','3zh9fsm','3fmebrw','2015-05-16 19:05:39','1','','1');
DROP TABLE IF EXISTS tb_forum_sign;
CREATE TABLE `tb_forum_sign` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sign_date` datetime NOT NULL,
  `keep_day` int(11) NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_forum_sign` VALUES('18tr3j','16l2bkr','3fmebrw','2015-05-11 10:14:07','1');
INSERT INTO `tb_forum_sign` VALUES('220mlk8','16l2bkr','3fmebrw','2015-05-14 10:30:00','2');
INSERT INTO `tb_forum_sign` VALUES('26yvzzv','16l2bkr','3fmebrw','2015-05-07 14:40:59','1');
INSERT INTO `tb_forum_sign` VALUES('2u4gmhy','16l2bkr','3fmebrw','2015-05-08 13:34:30','2');
INSERT INTO `tb_forum_sign` VALUES('35pl1fu','16l2bkr','3fmebrw','2015-05-15 13:52:10','3');
INSERT INTO `tb_forum_sign` VALUES('3klb982','16l2bkr','3fmebrw','2015-05-13 11:13:54','1');
DROP TABLE IF EXISTS tb_log;
CREATE TABLE `tb_log` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_log` VALUES('13a1g3t','cancel-good','7us2qt','3fmebrw','16l2bkr','2015-05-08 13:42:33');
INSERT INTO `tb_log` VALUES('1tqn01g','set-good','7us2qt','3fmebrw','16l2bkr','2015-05-08 13:43:16');
INSERT INTO `tb_log` VALUES('2vry7eq','set-good','7us2qt','3fmebrw','16l2bkr','2015-05-07 14:41:06');
INSERT INTO `tb_log` VALUES('3xtb6rx','set-top','7us2qt','3fmebrw','16l2bkr','2015-05-07 14:41:17');
INSERT INTO `tb_log` VALUES('b69kx4','del-post','1ypm2oy','3fmebrw','16l2bkr','2015-05-15 14:37:28');
DROP TABLE IF EXISTS tb_member_title;
CREATE TABLE `tb_member_title` (
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_title` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_member_title` VALUES('3fmebrw','观星者','的的的的,飞碟滞空,久别重逢,水色精灵,纷争逃离,重归于好,七年之约,圆盘本体,歌,户川汐音,椎原小春,乃乃香,初拥,真爱,NOLE控,萝莉赛高,实现愿望,NOEL');
DROP TABLE IF EXISTS tb_notify;
CREATE TABLE `tb_notify` (
  `notify_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notify_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_read` int(11) NOT NULL,
  PRIMARY KEY (`notify_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_password_key;
CREATE TABLE `tb_password_key` (
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_password_key` VALUES('16l2bkr','575839102ac80158933582f17ad82b06');
DROP TABLE IF EXISTS tb_post;
CREATE TABLE `tb_post` (
  `post_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `reply_post_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `floor_id` int(11) NOT NULL,
  `is_exist` int(11) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_post` VALUES('18mp7g','18mp7g','16l2bkr','恐怕是借此证明他的存在吧。挖坟挖坟。。。。。。神经病。。。。','2015-05-07 14:50:04','0','1','1');
INSERT INTO `tb_post` VALUES('1d77r5y','1d77r5y','16l2bkr','有人玩过树莓派吗?好玩吗?买了vps发现也就当个vpn。。。想搭网站都不知道网站上放啥╮(╯▽╰)╭\n','2015-05-07 14:42:14','0','1','1');
INSERT INTO `tb_post` VALUES('1eur3qd','1eur3qd','16l2bkr','说实话Java工作好找，工资也不算低。而且亲爹还是sun。不过这括号真是对的我心碎。。。。。。\n[img]45822d51658a48dc5629a3bb1a628ce8.jpg[/img]','2015-05-07 14:43:49','0','1','1');
INSERT INTO `tb_post` VALUES('1orz6ua','1orz6ua','16l2bkr','设计太忒么坑爹了！[emo]吐舌[/emo]\n\n\n首先是拆后盖，竟然在后盖中间放置了6个卡扣，我一直以为是有螺丝，不敢硬来[emo]啊[/emo]\n拆电池也是超级的坑，一般都是用手拨开卡锁，忒么的这台要拿尖状物去拨开，没法用手的\n再忒么硬盘竟然是没锁螺丝固定的，电脑翻转一下就掉下来了，就只有一根线连着[emo]狂汗[/emo]\n\n\n设计师你是怎么想的，要不要这么丧心病狂，你出来，保证不打死你。让我折腾了一个多钟','2015-05-07 14:46:58','0','1','1');
INSERT INTO `tb_post` VALUES('1ypm2oy','28mfd4u','16l2bkr','[emo]呵呵[/emo]','2015-05-15 14:37:22','0','2','0');
INSERT INTO `tb_post` VALUES('23ntbcc','23ntbcc','16l2bkr','我是一名网管，刚刚有人要泡面，之后我去拿烟忘记了。结果老板就狠劲骂我骂的像坨翔一样！老子也生气了，不管他了，你们进来留下QQ 劳资给你们充QB。反正劳资随便充，充完今晚就跑路。妈的，反正他也不知道我在哪！  [emo]哈哈[/emo][emo]哈哈[/emo][emo]哈哈[/emo]','2015-05-07 14:48:12','0','1','1');
INSERT INTO `tb_post` VALUES('28mfd4u','28mfd4u','16l2bkr','在登陆页面输入相应信息，转到如下代码处理，不能跳转到lookmail.php。怎样解决？求大神指教\n&lt;?php\nsession_start();\n$hostname=&quot;{&quot;.$_POST[hostname].&quot;:110/pop3}INBOX&quot;;\n$username=$_POST[username];\n$userpwd=$_POST[userpwd];\nif(!$mbox=@imap_open(&quot;{pop3.czk.cn:110}&quot;,&quot;$username&quot;,&quot;$userpwd&quot;)){\necho &quot;&lt;script charset=\'utf-8\'&gt;alert(\'登录失败!\');window.location.href=\'index.php\';&lt;/script&gt;&quot;;\n}else{\nsession_register(&quot;host&quot;);\nsession_register(&quot;user&quot;);\nsession_register(&quot;pwd&quot;);\n$_SESSION[host]=$hostname;\n$_SESSION[user]=$username;\n$_SESSION[pwd]=$userpwd;\nimap_close($mbox);\necho &quot;&lt;script charset=\'utf-8\'&gt;window.location.href=\'lookmail.php\';&lt;/script&gt;&quot;; \n}\n?&gt;\n','2015-05-07 14:54:54','0','1','1');
INSERT INTO `tb_post` VALUES('2vxvajd','9o8i8c','16l2bkr','[img]33b79285da95cddb5bc56208003aab2a.jpg[/img][img]4c36f9dfd1be01ada7fca1d5c7838fad.jpg[/img][img]05e32bd786b4c2958d0b21e9599dda16.jpg[/img][img]ae0025549fa064c8c415b46f1ce52e7a.jpg[/img][img]aea813d4ae97048199c5917c9465281f.jpg[/img][img]301cc7497e924e4b7aaa5db9afb5e580.jpg[/img][img]5699cdce3fb79910baf55b581a505319.jpg[/img]','2015-08-30 16:17:29','0','3','1');
INSERT INTO `tb_post` VALUES('2z30v74','2z30v74','16l2bkr','[img]495a3bf45180e519965ff447f81b6806.jpg[/img]\r\n刚更新了微信，终于不再是照搬水果的界面\r\n但一直期待的夜间模式还是没有半点动静\r\n\r\n为什么微信至今都没做夜间模式？\r\n难道是为了夜间防沉迷？[emo]乖[/emo]','2015-05-07 14:15:12','0','1','1');
INSERT INTO `tb_post` VALUES('3ixh354','3ixh354','16l2bkr','[img]7c176d249f29d9cf36314a9f8fd50bc4.jpg[/img]\n我们这一代人很荣幸能见证中国一步步的成长','2015-05-07 14:58:48','0','1','1');
INSERT INTO `tb_post` VALUES('3nw340c','3nw340c','16l2bkr','求吧友推荐一下，要求功能全面一些，可以上网','2015-05-07 14:45:32','0','1','1');
INSERT INTO `tb_post` VALUES('3pjmghg','3pjmghg','16l2bkr','2个穿着防弹衣，拿着冲锋枪绿教VS一个拿手枪的保安，结果被双杀。。。。\noh man....u should read this.....\n[img]1282cb8b8ffdd626c0bcea42e38e84ca.jpg[/img]','2015-05-07 14:45:08','0','1','1');
INSERT INTO `tb_post` VALUES('3ui8hoo','3ui8hoo','16l2bkr','他是怎么拿到的驾照？\n[img]80749e483e673574406f01308639e46b.jpg[/img]','2015-05-07 14:39:04','0','1','1');
INSERT INTO `tb_post` VALUES('3w5ru9f','7us2qt','16l2bkr','二楼备用，用于更新地址，不知道还要被和谐多少次此楼禁止回复，否则。。。。。。','2015-05-07 14:40:51','0','2','1');
INSERT INTO `tb_post` VALUES('3zgujib','3zgujib','16l2bkr','自己写的，感觉有用的大家支持一下啊，谢谢啦\n网址：https://chrome.google.com/webstore/detail/downloadbingimage/hkekoelmdejjgpjkkifoljcofiddgdhb\n[img]9d1dd22a752e90edf76923f11496a56a.jpg[/img]\n[img]7b961b697d48b4e033b058e2de59dc57.jpg[/img]\n[img]123ba83525cbcdf2228e074ca299e7a2.jpg[/img]\n[img]3dcf4d3cc96052dfb6886fa4ee359278.jpg[/img]','2015-05-07 14:46:27','0','1','1');
INSERT INTO `tb_post` VALUES('414dw1v','414dw1v','16l2bkr','安卓5.1，现在用Firefox浏览触屏版，连个表情都发不了٩(๑´0`๑)۶','2015-05-07 14:47:31','0','1','1');
INSERT INTO `tb_post` VALUES('49jzper','9o8i8c','16l2bkr','[img]997cc4a5b65275baca772587bd0008df.jpg[/img][img]7dc6ead011fd6665756b10e042234e5c.jpg[/img][img]e8bebcc5442b544b3053cf0a814db8b8.jpg[/img][img]fcedf0f6159c320533a0d7111e8419aa.jpg[/img]','2015-08-30 16:18:43','0','4','1');
INSERT INTO `tb_post` VALUES('4cp5bdf','4cp5bdf','16l2bkr','人大网公布了国家安全法（草案二次审议稿）全文，以向社会征求意见。有意见要提的人可以访问NPC.GOV.CN网站，意见截至日期6月5日。\n草案第二十条中，不良文化被认为事关国家安全，“国家坚持社会主义先进文化前进方向，推进社会主义核心价值体系建设，加强社会主义核心价值观教育和宣传，掌握意识形态领域主导权，继承和弘扬中华民族优秀传统文化，防范和抵御不良文化的渗透，增强文化整体实力和竞争力。”','2015-05-07 14:44:35','0','1','1');
INSERT INTO `tb_post` VALUES('4pmgts','9o8i8c','16l2bkr','[img]1b2d54444be276634f6622a884e96ad3.jpg[/img][img]fba7c64e08911f1279ac9c8b32314b4e.jpg[/img][img]29cd167a1480df5e583e8a6ba5f151da.jpg[/img][img]f2250835dbfa2ece52dfd96a278c23f3.jpg[/img][img]1ecd63d76b52c5f79b83df061e95d44c.jpg[/img][img]83976f9d61a4d1fd9a7472e221522140.jpg[/img]','2015-08-30 16:15:44','0','2','1');
INSERT INTO `tb_post` VALUES('7us2qt','7us2qt','16l2bkr','话不多说，直接上链接：http://pan.baidu.com/s/1dDztAYP\n之前的被举报了，也就只有呵呵了。。。原帖终结，重开一贴。\n[img]ecce2fc3907e1f159a82b5f4edbc248b.jpg[/img]','2015-05-07 14:40:37','0','1','1');
INSERT INTO `tb_post` VALUES('9o8i8c','9o8i8c','16l2bkr','[img]e1d2e668b2365bc50ded39ade1ce3525.jpg[/img][img]4880d89fb1d8800025b99f91d97b9366.jpg[/img]','2015-08-30 16:14:04','0','1','1');
INSERT INTO `tb_post` VALUES('b5urup','b5urup','16l2bkr','不知道是电脑原因还是系统，风扇呼呼的比kde都凶\n还有权限问题，安装VirtualBox的拓展时，其他桌面环境会弹出root认证，而gnome就直接卡死，也不安装，问题是它本身又不允许root登录','2015-05-07 14:43:13','0','1','1');
INSERT INTO `tb_post` VALUES('l32usr','l32usr','16l2bkr','RT.本意是想造一个网易云音乐的轮子，最近把播放本地音乐的功能实现了一下。\n欢迎大家拍砖[emo]滑稽[/emo]\n[img]b19a47b3b034add3ec86737604a493f1.jpg[/img]','2015-05-07 14:42:51','0','1','1');
INSERT INTO `tb_post` VALUES('oe5k5t','oe5k5t','16l2bkr','效果如图\n[img]e6218cb551a6aee3d7d0eda268d17a30.jpg[/img]','2015-05-07 14:50:57','0','1','1');
DROP TABLE IF EXISTS tb_related_forum;
CREATE TABLE `tb_related_forum` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_stored_thread;
CREATE TABLE `tb_stored_thread` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stored_date` datetime NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_thread;
CREATE TABLE `tb_thread` (
  `thread_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_date` datetime NOT NULL,
  `is_exist` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_thread` VALUES('18mp7g','贴吧就是个奇葩。不管什么时间长点就算“挖坟”。神经病。','16l2bkr','3fmebrw','2015-05-07 14:50:04','1');
INSERT INTO `tb_thread` VALUES('1d77r5y','有人玩过树莓派吗?好玩吗?买了','16l2bkr','3fmebrw','2015-05-07 14:42:14','1');
INSERT INTO `tb_thread` VALUES('1eur3qd','我果然不适合Java。。。。。','16l2bkr','3fmebrw','2015-05-07 14:43:49','1');
INSERT INTO `tb_thread` VALUES('1orz6ua','我要吐槽一下今天拆的笔记本电脑','16l2bkr','3fmebrw','2015-05-07 14:46:58','1');
INSERT INTO `tb_thread` VALUES('23ntbcc','我是一名网管，刚刚有人要泡面，','16l2bkr','3fmebrw','2015-05-07 14:48:12','1');
INSERT INTO `tb_thread` VALUES('28mfd4u','php函数 imap_open使用问题','16l2bkr','3fmebrw','2015-05-07 14:54:54','1');
INSERT INTO `tb_thread` VALUES('2z30v74','为什么微信至今都没有夜间模式？','16l2bkr','3fmebrw','2015-05-07 14:15:12','1');
INSERT INTO `tb_thread` VALUES('3ixh354','等到90后都长成40岁大叔，中国社会该会有多美好','16l2bkr','3fmebrw','2015-05-07 14:58:48','1');
INSERT INTO `tb_thread` VALUES('3nw340c','大家用什么WindowsPE呀','16l2bkr','3fmebrw','2015-05-07 14:45:32','1');
INSERT INTO `tb_thread` VALUES('3pjmghg','关于德州的枪击事件','16l2bkr','3fmebrw','2015-05-07 14:45:08','1');
INSERT INTO `tb_thread` VALUES('3ui8hoo','Facebook创始人扎克伯格 是个红绿色盲','16l2bkr','3fmebrw','2015-05-07 14:39:04','1');
INSERT INTO `tb_thread` VALUES('3zgujib','下载微软必应首页图片的扩展程序','16l2bkr','3fmebrw','2015-05-07 14:46:27','1');
INSERT INTO `tb_thread` VALUES('414dw1v','安卓用哪个贴吧客户端好一些','16l2bkr','3fmebrw','2015-05-07 14:47:31','1');
INSERT INTO `tb_thread` VALUES('4cp5bdf','国家安全法全文公布','16l2bkr','3fmebrw','2015-05-07 14:44:35','1');
INSERT INTO `tb_thread` VALUES('7us2qt','【资源】重开一贴，Win10系统镜像百度云分享','16l2bkr','3fmebrw','2015-05-07 14:40:37','1');
INSERT INTO `tb_thread` VALUES('9o8i8c','Niconiconi~','16l2bkr','3fmebrw','2015-08-30 16:14:04','1');
INSERT INTO `tb_thread` VALUES('b5urup','debian 8的gnome是不是有问题啊？','16l2bkr','3fmebrw','2015-05-07 14:43:13','1');
INSERT INTO `tb_thread` VALUES('l32usr','用nw.js撸了一个音乐播放器','16l2bkr','3fmebrw','2015-05-07 14:42:51','1');
INSERT INTO `tb_thread` VALUES('oe5k5t','用php+mysql做了一个留言板','16l2bkr','3fmebrw','2015-05-07 14:50:57','1');
DROP TABLE IF EXISTS tb_thread_type;
CREATE TABLE `tb_thread_type` (
  `thread_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_thread_type` VALUES('18mp7g','normal');
INSERT INTO `tb_thread_type` VALUES('1d77r5y','normal');
INSERT INTO `tb_thread_type` VALUES('1eur3qd','normal');
INSERT INTO `tb_thread_type` VALUES('1orz6ua','normal');
INSERT INTO `tb_thread_type` VALUES('23ntbcc','normal');
INSERT INTO `tb_thread_type` VALUES('28mfd4u','normal');
INSERT INTO `tb_thread_type` VALUES('2z30v74','normal');
INSERT INTO `tb_thread_type` VALUES('3ixh354','normal');
INSERT INTO `tb_thread_type` VALUES('3nw340c','normal');
INSERT INTO `tb_thread_type` VALUES('3pjmghg','normal');
INSERT INTO `tb_thread_type` VALUES('3ui8hoo','normal');
INSERT INTO `tb_thread_type` VALUES('3zgujib','normal');
INSERT INTO `tb_thread_type` VALUES('414dw1v','normal');
INSERT INTO `tb_thread_type` VALUES('4cp5bdf','normal');
INSERT INTO `tb_thread_type` VALUES('7us2qt','good,top');
INSERT INTO `tb_thread_type` VALUES('9o8i8c','normal');
INSERT INTO `tb_thread_type` VALUES('b5urup','normal');
INSERT INTO `tb_thread_type` VALUES('l32usr','normal');
INSERT INTO `tb_thread_type` VALUES('oe5k5t','normal');
DROP TABLE IF EXISTS tb_user_fans;
CREATE TABLE `tb_user_fans` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fans_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_user_status;
CREATE TABLE `tb_user_status` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS tb_user_visitor;
CREATE TABLE `tb_user_visitor` (
  `data_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visitor_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visitor_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_user_visitor` VALUES('3m8yidd','3ixtnqv','16l2bkr','1');
INSERT INTO `tb_user_visitor` VALUES('42s9tr2','16l2bkr','3ixtnqv','1');
DROP TABLE IF EXISTS tb_users;
CREATE TABLE `tb_users` (
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_sex` tinyint(4) NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_regdate` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_users` VALUES('16l2bkr','未闻花名','70110c42465beafda6c139ba93fe1eca','0','shizukana@qq.com','','1b1ce587f49d247047bf83ea1879d7cb.jpg','2015-01-20 19:08:54');
INSERT INTO `tb_users` VALUES('3ixtnqv','上神大人','e10adc3949ba59abbe56e057f20f883e','0','409256101@qq.com','','b7358c6deb9a59a220fa429578bb4be2.png','2015-05-14 09:55:03');
INSERT INTO `tb_users` VALUES('3zh9fsm','小吧主','e10adc3949ba59abbe56e057f20f883e','1','123456@qq.com','','0','2015-05-15 15:50:14');
DROP TABLE IF EXISTS tb_uuid;
CREATE TABLE `tb_uuid` (
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tb_uuid` VALUES('13a1g3t');
INSERT INTO `tb_uuid` VALUES('16l2bkr');
INSERT INTO `tb_uuid` VALUES('18mp7g');
INSERT INTO `tb_uuid` VALUES('18tr3j');
INSERT INTO `tb_uuid` VALUES('1d77r5y');
INSERT INTO `tb_uuid` VALUES('1d7mj70');
INSERT INTO `tb_uuid` VALUES('1eur3qd');
INSERT INTO `tb_uuid` VALUES('1i5tr1j');
INSERT INTO `tb_uuid` VALUES('1orz6ua');
INSERT INTO `tb_uuid` VALUES('1osi2li');
INSERT INTO `tb_uuid` VALUES('1tql6hy');
INSERT INTO `tb_uuid` VALUES('1tqn01g');
INSERT INTO `tb_uuid` VALUES('1ypm2oy');
INSERT INTO `tb_uuid` VALUES('220mlk8');
INSERT INTO `tb_uuid` VALUES('23ntbcc');
INSERT INTO `tb_uuid` VALUES('25bcly5');
INSERT INTO `tb_uuid` VALUES('25brhij');
INSERT INTO `tb_uuid` VALUES('26yvzzv');
INSERT INTO `tb_uuid` VALUES('28mfd4u');
INSERT INTO `tb_uuid` VALUES('2aafp8j');
INSERT INTO `tb_uuid` VALUES('2p65exq');
INSERT INTO `tb_uuid` VALUES('2u4gmhy');
INSERT INTO `tb_uuid` VALUES('2vry7eq');
INSERT INTO `tb_uuid` VALUES('2vxvajd');
INSERT INTO `tb_uuid` VALUES('2z30v74');
INSERT INTO `tb_uuid` VALUES('32e3jtl');
INSERT INTO `tb_uuid` VALUES('35pl1fu');
INSERT INTO `tb_uuid` VALUES('3fmebrw');
INSERT INTO `tb_uuid` VALUES('3h9xo9h');
INSERT INTO `tb_uuid` VALUES('3ixh354');
INSERT INTO `tb_uuid` VALUES('3ixtnqv');
INSERT INTO `tb_uuid` VALUES('3klb982');
INSERT INTO `tb_uuid` VALUES('3m8wdrg');
INSERT INTO `tb_uuid` VALUES('3m8yidd');
INSERT INTO `tb_uuid` VALUES('3nw328f');
INSERT INTO `tb_uuid` VALUES('3nw328u');
INSERT INTO `tb_uuid` VALUES('3nw340c');
INSERT INTO `tb_uuid` VALUES('3nw77dt');
INSERT INTO `tb_uuid` VALUES('3pjmghg');
INSERT INTO `tb_uuid` VALUES('3r75rnu');
INSERT INTO `tb_uuid` VALUES('3ui8hoo');
INSERT INTO `tb_uuid` VALUES('3w5ru9f');
INSERT INTO `tb_uuid` VALUES('3xtb6rx');
INSERT INTO `tb_uuid` VALUES('3zgujib');
INSERT INTO `tb_uuid` VALUES('3zh9fsm');
INSERT INTO `tb_uuid` VALUES('414dw1v');
INSERT INTO `tb_uuid` VALUES('41aaysw');
INSERT INTO `tb_uuid` VALUES('42s9tr2');
INSERT INTO `tb_uuid` VALUES('44fvc0c');
INSERT INTO `tb_uuid` VALUES('44fxl0m');
INSERT INTO `tb_uuid` VALUES('49jzper');
INSERT INTO `tb_uuid` VALUES('4cp59n7');
INSERT INTO `tb_uuid` VALUES('4cp5bdf');
INSERT INTO `tb_uuid` VALUES('4cp9epe');
INSERT INTO `tb_uuid` VALUES('4cv2ec9');
INSERT INTO `tb_uuid` VALUES('4jbanm4');
INSERT INTO `tb_uuid` VALUES('4kz13zg');
INSERT INTO `tb_uuid` VALUES('4pmgts');
INSERT INTO `tb_uuid` VALUES('7us2qt');
INSERT INTO `tb_uuid` VALUES('9o8i8c');
INSERT INTO `tb_uuid` VALUES('b5urup');
INSERT INTO `tb_uuid` VALUES('b69kx4');
INSERT INTO `tb_uuid` VALUES('cte2ow');
INSERT INTO `tb_uuid` VALUES('hs05no');
INSERT INTO `tb_uuid` VALUES('l32tkn');
INSERT INTO `tb_uuid` VALUES('l32usr');
INSERT INTO `tb_uuid` VALUES('oe5k5t');
INSERT INTO `tb_uuid` VALUES('tcrjml');
INSERT INTO `tb_uuid` VALUES('yhapur');
