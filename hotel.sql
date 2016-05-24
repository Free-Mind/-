# Host: localhost  (Version 5.6.17)
# Date: 2016-05-24 13:44:24
# Generator: MySQL-Front 5.3  (Build 5.39)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "f_evaluation"
#

DROP TABLE IF EXISTS `f_evaluation`;
CREATE TABLE `f_evaluation` (
  `pk_eval_f` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `eval_cat` int(11) NOT NULL,
  `customer_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pk_eval_f`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "f_evaluation"
#


#
# Structure for table "f_info"
#

DROP TABLE IF EXISTS `f_info`;
CREATE TABLE `f_info` (
  `f_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_desc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_price` double NOT NULL,
  `f_discount` double NOT NULL,
  `f_sale_num` int(11) NOT NULL,
  `f_eval_num` int(11) NOT NULL,
  `f_status` int(11) NOT NULL,
  `f_hotel` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_pic` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "f_info"
#

INSERT INTO `f_info` VALUES ('food201605102123','美味可口','至尊披萨',120,0.8,21,15,1,'hotel7','url');

#
# Structure for table "h_evaluation"
#

DROP TABLE IF EXISTS `h_evaluation`;
CREATE TABLE `h_evaluation` (
  `pk_eval_h` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `h_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `eval_cat` int(11) NOT NULL,
  `u_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pk_eval_h`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "h_evaluation"
#

INSERT INTO `h_evaluation` VALUES ('14631264302553','','hotel0',5,'18366117613'),('14631264309144','','hotel1',1,'18366117613'),('14631264312140','','hotel5',5,'18366117613'),('14631264312156','','hotel2',1,'18366117613'),('14631264316863','','hotel3',3,'18366117613'),('14631264316974','','hotel4',3,'18366117613'),('14631264321005','','hotel8',2,'18366117613'),('14631264322093','','hotel0',4,'18366117614'),('14631264322145','','hotel2',5,'18366117614'),('14631264322584','','hotel3',3,'18366117614'),('14631264324120','','hotel9',2,'18366117613'),('14631264325445','','hotel6',3,'18366117613'),('14631264327698','','hotel1',1,'18366117614'),('1463126432913','','hotel7',5,'18366117613'),('14631264334717','','hotel5',3,'18366117614'),('14631264335033','','hotel7',4,'18366117614'),('14631264335467','','hotel8',5,'18366117614'),('14631264335754','','hotel0',3,'18366117615'),('14631264337895','','hotel6',1,'18366117614'),('14631264338966','','hotel1',1,'18366117615'),('14631264339470','','hotel9',1,'18366117614'),('14631264339600','','hotel4',3,'18366117614'),('14631264341285','','hotel9',3,'18366117615'),('14631264341883','','hotel5',1,'18366117615'),('14631264342180','','hotel7',3,'18366117615'),('14631264342278','','hotel6',4,'18366117615'),('14631264343222','','hotel4',5,'18366117615'),('14631264345137','','hotel1',1,'18366117616'),('14631264347193','','hotel2',2,'18366117615'),('14631264347800','','hotel8',2,'18366117615'),('14631264348223','','hotel0',5,'18366117616'),('14631264349458','','hotel3',3,'18366117615'),('14631264351753','','hotel9',5,'18366117616'),('14631264352527','','hotel4',2,'18366117616'),('14631264352691','','hotel8',1,'18366117616'),('14631264354672','','hotel3',2,'18366117616'),('14631264355828','','hotel5',3,'18366117616'),('14631264356987','','hotel2',1,'18366117616'),('14631264358283','','hotel6',2,'18366117616'),('14631264359542','','hotel7',1,'18366117616'),('14631264363397','','hotel1',3,'18366117617'),('14631264363736','','hotel5',3,'18366117617'),('1463126436412','','hotel3',5,'18366117617'),('1463126436596','','hotel6',1,'18366117617'),('14631264366214','','hotel2',4,'18366117617'),('14631264367204','','hotel4',3,'18366117617'),('14631264368060','','hotel9',5,'18366117617'),('14631264369189','','hotel0',3,'18366117617'),('14631264369307','','hotel7',2,'18366117617'),('14631264369828','','hotel8',1,'18366117617'),('1463135137','','hotel7',5,'18366117612'),('14631351596169','','hotel2',1,'18366117612'),('14631351622978','','hotel5',4,'18366117612');

#
# Structure for table "h_info"
#

DROP TABLE IF EXISTS `h_info`;
CREATE TABLE `h_info` (
  `h_id` varchar(255) NOT NULL,
  `h_name` varchar(255) NOT NULL,
  `h_address` varchar(255) NOT NULL,
  `h_desc` text NOT NULL,
  `h_eval_num` int(11) NOT NULL,
  `h_good_eval_num` int(11) NOT NULL,
  `h_sale_num` int(11) NOT NULL,
  `h_first_pic` varchar(255) NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  PRIMARY KEY (`h_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "h_info"
#

INSERT INTO `h_info` VALUES ('hotel0','汉丽轩','舜华路89号','好吃的不得了',49,29,86,'',35.07,116.77),('hotel1','湘江风情','舜华路100号','正宗湘菜，麻辣风味',87,55,99,'',36.51,116.38),('hotel2','济南往事','舜华路30号','老济南风味',78,12,120,'',35.51,117.56),('hotel3','城南旧事','舜华路54号','现在下单立享优惠',78,40,99,'',36.8,117.78),('hotel4','川菜馆','舜华路10号','正宗川菜',83,12,87,'',35,117.74),('hotel5','刘一锅','舜华路32号','味道纯正',27,4,65,'',36.24,116.78),('hotel6','小天鹅火锅','舜华路43号','成都火锅',94,76,109,'',35.5,116.48),('hotel7','豪客来牛排餐厅','舜华路1500号','正宗牛排，毕业季大优惠',98,214,0,'',36.27,116.07),('hotel8','必胜客','舜华路98号','半价来袭！',52,31,88,'',35.93,117.99),('hotel9','肯德基山大店','舜华路65号','甜筒第二杯半价哟！',77,66,88,'',35.32,117.35);

#
# Structure for table "h_pic"
#

DROP TABLE IF EXISTS `h_pic`;
CREATE TABLE `h_pic` (
  `h_pic_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `h_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `p_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`h_pic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "h_pic"
#


#
# Structure for table "order"
#

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `o_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `u_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `h_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `f_id` text CHARACTER SET utf8 NOT NULL,
  `f_number` int(11) NOT NULL,
  `r_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "order"
#

INSERT INTO `order` VALUES ('order146315399583','18366117612','hotel7','food201605102123&amp;',0,'','1473781140000',1),('order146315401534','18366117612','hotel7','',0,'room20160510213','1473781200000',1),('order146337517136','18366117612','hotel7','',0,'room20160510213','NaN',1);

#
# Structure for table "r_info"
#

DROP TABLE IF EXISTS `r_info`;
CREATE TABLE `r_info` (
  `r_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_status` int(11) NOT NULL,
  `r_hotel` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_cat` int(11) NOT NULL,
  `r_desc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_first_pic` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "r_info"
#

INSERT INTO `r_info` VALUES ('room20160510213','西班牙风情',0,'hotel7',1,'西班牙特色餐厅','url\r\n');

#
# Structure for table "r_pic"
#

DROP TABLE IF EXISTS `r_pic`;
CREATE TABLE `r_pic` (
  `r_pic_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `p_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`r_pic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "r_pic"
#


#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `telphone` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`telphone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "user"
#

INSERT INTO `user` VALUES ('18366117612','1'),('18366117613','1'),('18366117614','1'),('18366117615','1'),('18366117616','1'),('18366117617','1');
