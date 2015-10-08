CREATE TABLE i_ann (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    msg_date INT(32) NOT NULL,
    msg TEXT NOT NULL,
    msg_type VARCHAR(16) NOT NULL,
    msg_onoff VARCHAR(16) NOT NULL,
    msg_perm VARCHAR(16) NOT NULL
);

CREATE TABLE i_shouts (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL,
    shout TEXT NOT NULL,
    user_ip VARCHAR(16) NOT NULL
);

CREATE TABLE i_shouts_sr (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL,
    shout TEXT NOT NULL,
    user_ip VARCHAR(16) NOT NULL
);

CREATE TABLE i_shouts_gc (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL,
    shout TEXT NOT NULL,
    user_ip VARCHAR(16) NOT NULL
);

CREATE TABLE i_users (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userwd VARCHAR(64) NOT NULL,
    passwd VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL,
    fullname TEXT NOT NULL,
    tagline TEXT NOT NULL,
    reg_time INT(32) NOT NULL,
    free_note TEXT NOT NULL,
    userip VARCHAR(16) NOT NULL,
    keypass VARCHAR(64) NOT NULL
);
CREATE TABLE i_sharerlinks (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    owner VARCHAR(255) NOT NULL,
    sharername VARCHAR(255) NOT NULL,
    sharerlink VARCHAR(255) NOT NULL,
    sharerdesc TEXT NOT NULL,
    add_date INT(32) NOT NULL,
    likes INT(16) NOT NULL,
    status INT(8) NOT NULL
);
CREATE TABLE i_fcontrol (
    client_ip VARCHAR(16) NOT NULL PRIMARY KEY,
    shout_time INT(24) NOT NULL
);
CREATE TABLE i_bans (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ip VARCHAR(16) NOT NULL,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL
);
CREATE TABLE i_requests (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL,
    item TEXT NOT NULL,
    user_ip VARCHAR(16) NOT NULL
);
CREATE TABLE i_replies (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_id INT(8) NOT NULL,
    answer TEXT NOT NULL,
    user VARCHAR(16) NOT NULL
);
CREATE TABLE i_updates (
    id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    datetime INT(32) NOT NULL,
    item TEXT NOT NULL,
    user_ip VARCHAR(16) NOT NULL
);

CREATE TABLE `i_online` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
