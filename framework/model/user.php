<?php
/**
 Purpose: Handles User table structure and password encryption
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/

namespace Model;
/*
* Defines Schema for the user table
*/
class User extends Mth3l3m3nt {

    protected
        $fieldConf = array(
            'username' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'nullable'=>false,
                'required'=>true,
                'unique'=>true,
            ),
            'name' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR128,
                'required' => true,
            ),
            'password' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'nullable'=>false,
                'required'=>true,
            ),
            'email' => array(
                'type' => \DB\SQL\Schema::DT_VARCHAR256,
                'unique'=>true,
            ),
         ),
        $table = 'user',
        $db = 'DB';


    /**
     * crypt password
     * @param $val
     * @return string
     */
    public function set_password($val) {
        $f3 = \Base::instance();
        $hash_engine = $f3->get('password_hash_engine');
        switch($hash_engine) {
            case 'bcrypt':
                $crypt = \Bcrypt::instance();
                $val = $crypt->hash($val);
                break;
            case 'md5':
                // fall-through
            default:
                $val = md5($val.$f3->get('password_md5_salt'));
                break;
        }
        return $val;
    }

    /**
     * validate email address
     * @param $val
     * @return null
     */
    public function set_mail($val) {
        return \Validation::instance()->email($val)
            ? $val : null;
    }

}
