# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-15 00:05:27
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "third_video"
#

DROP TABLE IF EXISTS `third_video`;
CREATE TABLE `third_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(150) DEFAULT '',
  `video_price` decimal(8,2) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_pic` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='第三方爬取';

#
# Data for table "third_video"
#

/*!40000 ALTER TABLE `third_video` DISABLE KEYS */;
INSERT INTO `third_video` VALUES (1,'小区超市老板娘经常光顾混熟后约到宾馆啪啪',3.00,'https://p.cdnplay001.com//20181214/93/2231/2231.mp4.m3u8','https://pic.5ppav.com/Uploads/vod/2018-12-14/2231.mp4.gif',1544803470);
/*!40000 ALTER TABLE `third_video` ENABLE KEYS */;
