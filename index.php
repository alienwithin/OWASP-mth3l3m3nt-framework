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
///////////////
//  frontend //
///////////////

$f3->route(array(
	'GET /',
	'GET /@page',
    'GET /payloads',
    'GET /page/@page'
   ),'Controller\Payload->getList');
// view single
$f3->route(array(
      'GET /payload/@id'
   ), 'Controller\Payload->viewSingle');
   
$f3->route(array(
      'GET /payload/search'
   ), 'Controller\Payload->search_frontend');
///////////////
//  backend  //
///////////////

if (\Controller\Auth::isLoggedIn()) {


    // general CRUD operations
    $f3->route('GET|POST /cnc/@module', 'Controller\Backend->getList');
    $f3->route('GET|POST /cnc/@module/@page', 'Controller\Backend->getList');
    $f3->route('GET|POST /cnc/@module/@action/@id', 'Controller\Backend->@action');
    // some method reroutes
    $f3->route('GET /cnc/@module/create', 'Controller\Backend->getSingle');
    $f3->route('POST /cnc/@module/create', 'Controller\Backend->post');
    $f3->route('GET /cnc/@module/edit/@id', 'Controller\Backend->getSingle');
    $f3->route('POST /cnc/@module/edit/@id', 'Controller\Backend->post');
    $f3->route('GET /cnc/@module/view/@id', 'Controller\Backend->viewSingle');
    $f3->route('POST /cnc/@module/view/@id', 'Controller\Backend->viewSingle');
    //Search
    $f3->route('GET /cnc/@module/search', 'Controller\Backend->getSearchResults');
    $f3->route('POST /cnc/@module/search', 'Controller\Backend->getSearchResults');


    $f3->route('GET /cnc', 'Controller\Dashboard->main');

	
	$f3->route('GET|POST /cnc/settings','Controller\Settings->general');
	$f3->route('GET|POST /cnc/settings/@type','Controller\Settings->@type');
	//LFI stuff
	$f3->route('GET|POST /cnc/lfi','Controller\lfiplugins->koha_lfi');
	$f3->route('GET|POST /cnc/lfi/@type','Controller\lfiplugins->@type');
	
    //Client Side Tools
    $f3->route('GET|POST /cnc/cst/cso','Controller\Cst->client_side_obfuscator');
    $f3->route('GET|POST /cnc/cst/@type','Controller\Cst->@type');

	//Websaccre-routes
	$f3->route('GET|POST /cnc/websaccre','Controller\Websaccre->generic_request');
	$f3->route('GET|POST /cnc/websaccre/@type','Controller\Websaccre->@type');
    //recon tools
    $f3->route('GET|POST /cnc/recon','Controller\Recon->getwhois');
    $f3->route('GET|POST /cnc/recon/@type','Controller\Recon->@type');
		//Dencoder-routes
	$f3->route('GET|POST /cnc/dencoder','Controller\Dencoder->encoder_multi');
	$f3->route('GET|POST /cnc/dencoder/@type','Controller\Dencoder->@type');
    
    // no auth again
    $f3->redirect('GET|POST /login', '/cnc', false);

} else {
    // login
    $f3->redirect(array('GET|POST /cnc/*','GET|POST /cnc'), '/login', false);
    $f3->route('GET|POST /login','Controller\Auth->login');
    
}

 $f3->route('GET /leave','Controller\Auth->logout');


$f3->run();
