<?php
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

$f3->route('GET|POST /xssr','Controller\Xssr->cookie_theft');
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
    //ctdb routes the rest are hydrated by the resource routes
    //Deals with Frontend Retrieval of information from the hooking script
    $f3->route('GET|POST /cnc/xssr','Controller\Xssr->cookie_theft');
    //Purely Backend Version of XSSR to create attack campaigns more features to come that will allow deleting campaigns and possibly filtering them
    $f3->route('GET|POST /cnc/xssrc','Controller\Xssrc->create_campaign');
    // no auth again
    $f3->redirect('GET|POST /login', '/cnc', false);

} else {
    // login
    $f3->redirect(array('GET|POST /cnc/*','GET|POST /cnc'), '/login', false);
    $f3->route('GET|POST /login','Controller\Auth->login');
    
}

 $f3->route('GET /leave','Controller\Auth->logout');