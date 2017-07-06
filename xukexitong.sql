-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-05 05:20:30
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xukexitong`
--

-- --------------------------------------------------------

--
-- 表的结构 `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- 转存表中的数据 `photo`
--

INSERT INTO `photo` (`id`, `address`) VALUES
(56, '595324260f4fa.png'),
(57, '5953242610c6b.jpeg'),
(58, '59532426123db.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `tb_chagecourse`
--

CREATE TABLE IF NOT EXISTS `tb_chagecourse` (
  `change_id` int(10) NOT NULL AUTO_INCREMENT,
  `studentName` int(10) NOT NULL,
  `courseName` int(10) NOT NULL,
  `teacherName` int(10) DEFAULT NULL,
  `grades` varchar(50) NOT NULL DEFAULT '尚未结课',
  PRIMARY KEY (`change_id`),
  KEY `studentName` (`studentName`),
  KEY `courseName` (`courseName`),
  KEY `teacherName` (`teacherName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- 转存表中的数据 `tb_chagecourse`
--

INSERT INTO `tb_chagecourse` (`change_id`, `studentName`, `courseName`, `teacherName`, `grades`) VALUES
(2, 2, 1, 1, '尚未结课'),
(3, 3, 2, 2, '尚未结课'),
(88, 2, 5, 1, '尚未结课'),
(89, 1, 1, 1, '尚未结课'),
(90, 1, 2, 2, '尚未结课'),
(92, 1, 5, 1, '尚未结课'),
(93, 1, 4, 4, '尚未结课');

-- --------------------------------------------------------

--
-- 表的结构 `tb_course`
--

CREATE TABLE IF NOT EXISTS `tb_course` (
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `courseName` varchar(20) NOT NULL,
  `teacherName` int(10) NOT NULL,
  `credit` int(10) NOT NULL,
  `courseTime` varchar(20) DEFAULT NULL,
  `courseAction` int(10) DEFAULT '0',
  PRIMARY KEY (`course_id`),
  KEY `teacherName` (`teacherName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `tb_course`
--

INSERT INTO `tb_course` (`course_id`, `courseName`, `teacherName`, `credit`, `courseTime`, `courseAction`) VALUES
(1, 'web前端', 1, 3, '周一到周五全天', 4),
(2, 'JAVA', 2, 3, '周六到周日', 2),
(3, '思想教育', 3, 0, 'everytime', 0),
(4, 'php', 4, 3, '周日', 2),
(5, 'jquery', 1, 3, '周六', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tb_department`
--

CREATE TABLE IF NOT EXISTS `tb_department` (
  `dept_id` int(10) NOT NULL AUTO_INCREMENT,
  `departmentNum` char(10) NOT NULL,
  `departmentName` varchar(20) NOT NULL,
  `departmentChairman` varchar(20) NOT NULL,
  `departmentDesc` varchar(100) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `tb_department`
--

INSERT INTO `tb_department` (`dept_id`, `departmentNum`, `departmentName`, `departmentChairman`, `departmentDesc`) VALUES
(1, '1516', '历史文化学院', '张三', '历史文化学院办学历史悠久，师资力量雄厚，学风优良，在国内外享有盛誉。现有教职工118人，其中教授、副教授59人，具有博士学位者80人'),
(2, '1517', '文学院', '李四', '文学院是河南大学设立最早的院系之一，其前身是设立于1923年的中国文学系，首任系主任是我国著名哲学家冯友兰先生。'),
(3, '1518', '法学院', '王五', '河南大学法学院源于1907年的河南法政学堂。其后经历了河南法政专门学校(1912)、国立开封中山大学法学院(1929)。');

-- --------------------------------------------------------

--
-- 表的结构 `tb_level`
--

CREATE TABLE IF NOT EXISTS `tb_level` (
  `user_id` int(10) NOT NULL,
  `level` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `user_id_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tb_level`
--

INSERT INTO `tb_level` (`user_id`, `level`) VALUES
(3001, '2'),
(3002, '2'),
(3003, '2'),
(3004, '2'),
(1321010036, '1'),
(1321010037, '2'),
(1321010038, '3'),
(1321010039, '3'),
(1321010040, '3'),
(1321010041, '3'),
(1321010042, '3'),
(1321010043, '3'),
(1321010044, '3'),
(1321010045, '3'),
(1321010046, '3'),
(1321010047, '3'),
(1321010048, '3'),
(1321010051, '2'),
(1321010052, '3'),
(1321010055, '3'),
(1321010056, '3');

-- --------------------------------------------------------

--
-- 表的结构 `tb_major`
--

CREATE TABLE IF NOT EXISTS `tb_major` (
  `major_id` int(10) NOT NULL AUTO_INCREMENT,
  `majorNum` char(10) NOT NULL,
  `departmentNum` int(10) NOT NULL,
  `majorName` varchar(20) NOT NULL,
  `majorAssistant` varchar(20) NOT NULL,
  PRIMARY KEY (`major_id`),
  KEY `departmentNum` (`departmentNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `tb_major`
--

INSERT INTO `tb_major` (`major_id`, `majorNum`, `departmentNum`, `majorName`, `majorAssistant`) VALUES
(1, '3310', 1, '旅游管理', '大雄'),
(2, '3311', 1, '历史学', '小玉'),
(3, '3410', 2, '世界文学', '大玉'),
(4, '3411', 2, '中国文学', '小熊'),
(5, '3510', 3, '刑法', '哇1'),
(6, '3511', 3, '民法', '哇2');

-- --------------------------------------------------------

--
-- 表的结构 `tb_manager`
--

CREATE TABLE IF NOT EXISTS `tb_manager` (
  `manager_id` int(10) NOT NULL AUTO_INCREMENT,
  `managerNum` int(10) NOT NULL,
  `magagerName` varchar(20) NOT NULL,
  `managerSex` char(2) NOT NULL,
  PRIMARY KEY (`manager_id`),
  KEY `managerNum` (`managerNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tb_student`
--

CREATE TABLE IF NOT EXISTS `tb_student` (
  `stu_id` int(10) NOT NULL AUTO_INCREMENT,
  `studentNum` int(10) NOT NULL,
  `studentName` varchar(20) NOT NULL,
  `studentSex` char(2) NOT NULL,
  `studentBirthday` datetime NOT NULL,
  `departmentNum` int(10) NOT NULL,
  `majorNum` int(10) NOT NULL,
  `politicalStatus` varchar(10) NOT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `studentNum` (`studentNum`),
  KEY `departmentNum` (`departmentNum`),
  KEY `majorNum` (`majorNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `tb_student`
--

INSERT INTO `tb_student` (`stu_id`, `studentNum`, `studentName`, `studentSex`, `studentBirthday`, `departmentNum`, `majorNum`, `politicalStatus`) VALUES
(1, 3, '魏万欣', '女', '2015-06-01 06:19:26', 2, 3, '群众'),
(2, 4, '王朝玉', '人妖', '1960-05-15 05:23:12', 1, 1, '邪教人员'),
(3, 5, '秦雄1', '男', '1994-06-15 13:15:17', 2, 3, '党员'),
(4, 6, '齐振宁', '男', '1995-06-16 00:00:00', 2, 4, '群众'),
(5, 24, '王邦明', '男', '2017-06-08 00:00:00', 1, 1, '群众'),
(6, 25, '易成龙', '男', '2017-06-10 00:00:00', 3, 5, '群众'),
(7, 24, '黄平', '男', '2017-06-02 00:00:00', 1, 1, '群众');

-- --------------------------------------------------------

--
-- 表的结构 `tb_teacher`
--

CREATE TABLE IF NOT EXISTS `tb_teacher` (
  `teacher_id` int(10) NOT NULL AUTO_INCREMENT,
  `teacherNum` int(10) NOT NULL,
  `teacherName` varchar(20) NOT NULL,
  `teacherSex` char(2) DEFAULT NULL,
  `departmentNum` int(10) NOT NULL,
  `teacherBirthday` datetime NOT NULL,
  `teacherTitle` varchar(20) DEFAULT NULL,
  `introduce` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`),
  KEY `teacherNum` (`teacherNum`),
  KEY `departmentNum` (`departmentNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tb_teacher`
--

INSERT INTO `tb_teacher` (`teacher_id`, `teacherNum`, `teacherName`, `teacherSex`, `departmentNum`, `teacherBirthday`, `teacherTitle`, `introduce`) VALUES
(1, 2, '康勤生', '男', 1, '1994-05-10 00:00:00', '教授', '我年轻我任性，我帅气更任性，任性的人生不需要解释，选我的课没有商量'),
(2, 16, '张盛泉', '男', 2, '1980-04-11 00:00:00', '副教授', NULL),
(3, 26, '杨丹丹', '女', 3, '2017-06-24 00:00:00', '讲师', NULL),
(4, 27, '康勤生1', '男1', 3, '1994-06-24 00:00:00', '副教授', '世界很大，我想出去走走');

-- --------------------------------------------------------

--
-- 表的结构 `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `usernameId` int(10) NOT NULL,
  `password` varchar(20) NOT NULL DEFAULT '123123123',
  PRIMARY KEY (`user_id`),
  KEY `usernameId` (`usernameId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `usernameId`, `password`) VALUES
(1, 1321010036, '123123123'),
(2, 3001, '123123'),
(3, 1321010038, '123'),
(4, 1321010039, '123321'),
(5, 1321010040, '123123123'),
(6, 1321010041, '123123123'),
(7, 1321010042, '123123123'),
(8, 1321010043, '123123123'),
(9, 1321010044, '123123123'),
(10, 1321010045, '123123123'),
(11, 1321010046, '123123123'),
(12, 1321010047, '123123123'),
(13, 1321010048, '123123123'),
(16, 3002, '123123123'),
(17, 1321010052, '123123123'),
(24, 1321010055, '123123123'),
(25, 1321010056, '123123123'),
(26, 3003, '123123123'),
(27, 3004, '123123123');

--
-- 限制导出的表
--

--
-- 限制表 `tb_chagecourse`
--
ALTER TABLE `tb_chagecourse`
  ADD CONSTRAINT `tb_chagecourse_ibfk_1` FOREIGN KEY (`studentName`) REFERENCES `tb_student` (`stu_id`),
  ADD CONSTRAINT `tb_chagecourse_ibfk_2` FOREIGN KEY (`courseName`) REFERENCES `tb_course` (`course_id`),
  ADD CONSTRAINT `tb_chagecourse_ibfk_3` FOREIGN KEY (`teacherName`) REFERENCES `tb_teacher` (`teacher_id`);

--
-- 限制表 `tb_course`
--
ALTER TABLE `tb_course`
  ADD CONSTRAINT `tb_course_ibfk_1` FOREIGN KEY (`teacherName`) REFERENCES `tb_teacher` (`teacher_id`);

--
-- 限制表 `tb_major`
--
ALTER TABLE `tb_major`
  ADD CONSTRAINT `tb_major_ibfk_1` FOREIGN KEY (`departmentNum`) REFERENCES `tb_department` (`dept_id`);

--
-- 限制表 `tb_manager`
--
ALTER TABLE `tb_manager`
  ADD CONSTRAINT `tb_manager_ibfk_1` FOREIGN KEY (`managerNum`) REFERENCES `tb_user` (`user_id`);

--
-- 限制表 `tb_student`
--
ALTER TABLE `tb_student`
  ADD CONSTRAINT `tb_student_ibfk_1` FOREIGN KEY (`studentNum`) REFERENCES `tb_user` (`user_id`),
  ADD CONSTRAINT `tb_student_ibfk_2` FOREIGN KEY (`departmentNum`) REFERENCES `tb_department` (`dept_id`),
  ADD CONSTRAINT `tb_student_ibfk_3` FOREIGN KEY (`majorNum`) REFERENCES `tb_major` (`major_id`);

--
-- 限制表 `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD CONSTRAINT `tb_teacher_ibfk_1` FOREIGN KEY (`teacherNum`) REFERENCES `tb_user` (`user_id`),
  ADD CONSTRAINT `tb_teacher_ibfk_2` FOREIGN KEY (`departmentNum`) REFERENCES `tb_department` (`dept_id`);

--
-- 限制表 `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`usernameId`) REFERENCES `tb_level` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
