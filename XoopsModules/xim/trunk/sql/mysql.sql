CREATE TABLE `xim_chat` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` mediumint(8) unsigned NOT NULL,
  `to` mediumint(8) unsigned NOT NULL,
  `message` TEXT NOT NULL,
  `sent` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE = InnoDB;