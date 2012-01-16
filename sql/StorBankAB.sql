-- 
-- Create database `storbankab`
-- 

CREATE DATABASE `storbankab` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

-- 
-- Structure for table `users`
-- 
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(25) collate utf8_bin NOT NULL,
  `password` varchar(35) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Data in table `users`
-- 
--
-- password = green
--
INSERT INTO users (username, password) VALUES ('Magnus', '9f27410725ab8cc8854a2769c7a516b8');

-- 
-- Structure for table `accounts`
-- 
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(20) collate utf8_bin NOT NULL,
  `balance` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Data in table `accounts`
-- 
INSERT INTO accounts (user_id, name, balance) VALUES ('1','Sparkonto', '10000');

-- 
-- Structure for table `logins`
-- 
CREATE TABLE `logins` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `success` enum('true','false') collate utf8_bin NOT NULL default 'false',
  `sessionid` varchar(255) collate utf8_bin NOT NULL,
  `IP` varchar(15) collate utf8_bin NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;