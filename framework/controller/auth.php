<?php
/**
 Purpose: Handles Authentications and Sessions
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
namespace Controller;



class Auth extends Mth3l3m3nt {

    protected
        $response;

    /**
     * init the View
     */
    public function beforeroute() {
        $this->response = new \View\Backend();
    }

    /**
     * Check Logged In State of the User
     * @return bool
     */
    static public function isLoggedIn() {
        /** @var Base $f3 */
        $f3 = \Base::instance();
        if ($f3->exists('SESSION.user_id')) {
            $user = new \Model\User();
            $user->load(array('_id = ?',$f3->get('SESSION.user_id')));
            if(!$user->dry()) {
                $f3->set('BACKEND_USER',$user);
                return true;
            }
        }
        return false;
    }

    /**
     * Login Procedure
     * @param $f3
     * @param $params
     */
    public function login($f3,$params) {
        if ($f3->exists('POST.username') && $f3->exists('POST.password')) {
            sleep(3); // login should take a while to kick-ass brute force attacks
            $user = new \Model\User();
            $user->load(array('username = ?',$f3->get('POST.username')));
            if (!$user->dry()) {
                // check hash engine
                $hash_engine = $f3->get('password_hash_engine');
                $valid = false;
                if($hash_engine == 'bcrypt') {
                    $valid = \Bcrypt::instance()->verify($f3->get('POST.password'),$user->password);
                } elseif($hash_engine == 'md5') {
                    $valid = (md5($f3->get('POST.password').$f3->get('password_md5_salt')) == $user->password);
                }
                if($valid) {
                    @$f3->clear('SESSION'); //recreate session id
                    $f3->set('SESSION.user_id',$user->_id);
                    if($f3->get('CONFIG.ssl_backend'))
                        $f3->reroute('https://'.$f3->get('HOST').$f3->get('BASE').'/');
                    else $f3->reroute('/cnc');
                }
            }
            \Flash::instance()->addMessage('Wrong Username/Password', 'danger');
        }
        $this->response->setTemplate('templates/login.html');
    }

    /**
     * Logout Procedure
     * @param $f3
     * @param $params
     */
    public function logout($f3,$params) {
        $f3->clear('SESSION');
        $f3->reroute('http://'.$f3->get('HOST').$f3->get('BASE').'/');
    }

} 