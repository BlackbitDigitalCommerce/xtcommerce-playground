<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');
date_default_timezone_set('Europe/Berlin');
define('_SYSTEM_DATABASE_HOST', 'mariadb');
define('_SYSTEM_DATABASE_USER', 'docker');
define('_SYSTEM_DATABASE_PWD', 'docker');
define('_SYSTEM_DATABASE_DATABASE', 'docker');
define('DB_PREFIX','xt');
define('DB_STORAGE_ENGINE','innodb');
define('_CORE_DEBUG_MAIL_ADDRESS','xt@blackbit.de');
$_SYSTEM_INSTALL_SUCCESS = 'true';
