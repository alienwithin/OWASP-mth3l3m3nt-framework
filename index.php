<?php
/**
 Purpose: Where the story begins (Welcome to the Mth3l3m3nt Framework)
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
 
// Kickstart the framework
$f3=require('lib/base.php');

//load the configuration
$f3->config('framework/configuration.php');

$f3->set('APP_VERSION', '1.2');
$f3->set('ESCAPE', TRUE);
$f3->set('PACKAGE', 'OWASP Mth3l3m3nt Framework');

//Check Writeable Directories and Files have the right permissions

if (!is_dir($f3->get('TEMP')) || !is_writable($f3->get('TEMP')))
	$writeableErr[] = sprintf('please make sure that the \'%s\' directory is existing and writable.',$f3->get('TEMP'));
if (!is_writable('framework/data/'))
	$writeableErr[] = sprintf('please make sure that the \'%s\' directory is writable.','framework/data/');
if (!is_writable('framework/data/site_config.json'))
	$writeableErr[] = sprintf('please make sure that the \'%s\' file is writable.','framework/data/site_config.json');
	//handles all pagination
	\Template::instance()->extend('pagebrowser','\Pagination::renderTag');

	\Template\FooForms::init();

if(isset($writeableErr)) {
	header('Content-Type: text;');
	die(implode("\n",$writeableErr));
}

//Initialize some F3 Settings 

$f3->set('FLASH', Flash::instance());
$web= Web::instance();
//Database Setup From our Config Class Instance
$cfg = Config::instance();
$f3->set('CONFIG', $cfg);

if ($cfg->ACTIVE_DB)
    $f3->set('DB', DBHandler::instance()->get($cfg->ACTIVE_DB));
else {
    $f3->error(500,'Sorry, but there is no active DB setup.');
}
require('framework/paths.php');


$f3->run();
