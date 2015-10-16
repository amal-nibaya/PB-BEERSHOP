<?php

$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('aove_attributes')};
CREATE TABLE {$this->getTable('aove_attributes')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `attribute` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('aove_options')};
CREATE TABLE {$this->getTable('aove_options')} (
  `option_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` int(11) NOT NULL default '0',
  `perent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `image_name` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
