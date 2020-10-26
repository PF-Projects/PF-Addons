<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.phpfusion.com/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: RobiNN
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
defined('IN_FUSION') || exit;

$locale = fusion_get_locale('', LG_LOCALE);

// Infusion general information
$inf_title       = $locale['lg_title'];
$inf_description = '';
$inf_version     = '1.0.0';
$inf_developer   = 'RobiNN';
$inf_email       = 'robinn@php-fusion.eu';
$inf_weburl      = 'https://github.com/RobiNN1';
$inf_folder      = 'legal';
$inf_image       = 'legal.svg';

// Create tables
$inf_newtable[] = DB_LEGAL." (
    legal_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    legal_type VARCHAR(50) NOT NULL DEFAULT '',
    legal_text TEXT NOT NULL,
    legal_language VARCHAR(50) NOT NULL DEFAULT '".LANGUAGE."',
    PRIMARY KEY (legal_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_adminpanel[] = [
    'rights'   => 'LG',
    'image'    => $inf_image,
    'title'    => $locale['lg_title'],
    'panel'    => 'admin.php',
    'page'     => 5,
    'language' => LANGUAGE
];

// Uninstallation
$inf_deldbrow[] = DB_ADMIN." WHERE admin_rights='LG'";
