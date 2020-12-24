<?php
/*-------------------------------------------------------+
| PHPFusion Content Management System
| Copyright (C) PHP Fusion Inc
| https://www.phpfusion.com/
+--------------------------------------------------------+
| Filename: infusion_db.php
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

if (!defined('DOCS_LOCALE')) {
    if (file_exists(INFUSIONS.'docs/locale/'.LANGUAGE.'.php')) {
        define('DOCS_LOCALE', INFUSIONS.'docs/locale/'.LANGUAGE.'.php');
    } else {
        define('DOCS_LOCALE', INFUSIONS.'docs/locale/English.php');
    }
}

if (!defined('DOCS')) {
    define('DOCS', INFUSIONS.'docs/');
}

if (!defined('DB_DOCS')) {
    define('DB_DOCS', DB_PREFIX.'docs');
}

if (!defined('DB_DOCS_CATS')) {
    define('DB_DOCS_CATS', DB_PREFIX.'docs_cats');
}

\PHPFusion\Admins::getInstance()->setAdminPageIcons('DOCS', '<i class="admin-ico fa fa-fw fa-file-alt"></i>');
