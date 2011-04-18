-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `ctime`
--

CREATE TABLE IF NOT EXISTS `ctime` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `guid` varchar(36) NOT NULL,
  `came` varchar(11) default NULL,
  `gone` varchar(11) default NULL,
  `nick` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;