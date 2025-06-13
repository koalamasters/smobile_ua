<?php

if(strpos($_SERVER['REQUEST_URI'],'?route=information/landing') !== false) { 
	if ($_REQUEST['language'] !== 'uk-ua')
	   header('Location: /pitaka_case_5'); 
	else 
	   header('Location: /pitaka_case_5_ru'); 
}

if(strpos($_SERVER['REQUEST_URI'],'/ru/index.php?route=product/catalog') !== false) {
    header('Location: /ru/shop', true, 301);
}

// Version
define('VERSION', '3.0.3.6');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}



// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');


