<?php
// Config soubor do DB
define('DB_HOST', 'localhost');
define('DB_USER', 'admin');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'mysql');
define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);

