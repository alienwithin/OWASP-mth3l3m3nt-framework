<?php
/**
Purpose: Handles CRUD for CTDB

Copyright (c) 2016 ~ alienwithin
Munir Njiru <munir@skilledsoft.com>

@version 1.0.0
@date: 04.04.2016
@url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Hydrates and handles CRUD for Cookie Theft Database (XSSR)
 * Class Ctdb
 * @package Controller
 */
class Ctdb extends Resource {

    /**
     * Initialize the database mapper and load Model
     */
    public function __construct() {
        $mapper = new \Model\Xssr();
        parent::__construct($mapper);
    }

    /**
     * Load 1 record
     * @param \Base $f3
     * @param array $params
     */
    public function getSingle(\Base $f3, $params) {
        $this->response->data['SUBPART'] = 'ctdb_edit.html';
        if (isset($params['id'])) {
            $this->resource->load(array('_id = ?', $params['id']));
            if ($this->resource->dry())
                $f3->error(404, 'Payload not found');
            $this->response->data['POST'] = $this->resource;
        }
    }

    /**
     * @param \Base $f3
     * @param array $param
     */
    public function getList(\Base $f3,$param) {
        $this->response->data['SUBPART'] = 'ctdb_list.html';
        $page = \Pagination::findCurrentPage();
        if ($this->response instanceof \View\Backend) {
            // backend view
            $records = $this->resource->paginate($page-1,10,null,
                array('order'=>'id desc'));
        } else {
            // frontend view

            $records = $this->resource->paginate($page-1,10,null,
                array('order'=>'id desc'));
        }
        $this->response->data['content'] = $records;
    }

    /**
     * @param \Base $f3
     * @param array $params
     */
    public function post(\Base $f3, $params) {
        $this->response->data['SUBPART'] = 'ctdb_edit.html';
        $msg = \Flash::instance();
        if (isset($params['id'])) {
            // update existing
            $this->resource->load(array('_id = ?', $params['id']));
        }
        parent::post($f3,$params);
    }

    /**
     * View Single Item
     * @param \Base $f3
     * @param array $params
     */
    public function viewSingle(\Base $f3, $params) {
        $this->response->data['SUBPART'] = 'ctdb_view.html';
        if (isset($params['id'])) {
            $this->resource->load(array('_id = ?', $params['id']));
            if ($this->resource->dry())
                $f3->error(404, 'Payload not found');
            $this->response->data['POST'] = $this->resource;
        }

    }

    /**Search CookieJar Backend
     * @param $f3
     */
    public function getSearchResults($f3) {
        $this->response->data['SUBPART'] = 'ctdb_list.html';
        $page = \Pagination::findCurrentPage();

        $term=$f3->get('GET.term');
        $search_filter = array('hosttag LIKE ? OR vulnerableUrl LIKE ? OR referer LIKE ? ',"%$term%","%$term%","%$term%");
        $records = $this->resource->paginate($page-1,10,
            $search_filter,	array('order' => 'id desc'));


        $this->response->data['content'] = $records;
    }


    /**
     * Delete Cookies & Files with content from hooking page
     * @param \Base $f3
     * @param array $params
     */
    public function delete(\Base $f3, $params) {
        $this->resource->reset();
        $msg = \Flash::instance();
        if (isset($params['id'])) {
            $this->resource->load(array('_id = ?', $params['id']));
            $url1=$this->resource->vulnerablePageContent;
            $url2=$this->resource->indirect_target_page;
            $vulnPage=$f3->ROOT.parse_url($url1, PHP_URL_PATH);
            $targetPage=$f3->ROOT.parse_url($url2, PHP_URL_PATH);
            unlink($vulnPage);
            unlink($targetPage);
            parent::delete($f3,$params);

        }
        $f3->reroute($f3->get('SESSION.LastPageURL'));
    }


}
