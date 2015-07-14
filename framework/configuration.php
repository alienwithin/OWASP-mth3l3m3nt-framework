<?php
/**
 Purpose: Site Configuration
    
    Copyright (c) 2015 ~ alienwithin
    Munir Njiru <munir@skilledsoft.com>
 
        @version 1.0.0
        @date: 30.06.2015
        @url : http://munir.skilledsoft.com
 **/
[globals]
AUTOLOAD = framework/;framework/__includes/
UI = themes/default/
BACKEND_UI = framework/themes/default/
LOCALES = framework/dict/
HIGHLIGHT = FALSE
DEV = FALSE
DEBUG = 0
CACHE = false
TZ = Africa/Nairobi
ONERROR = \Error->render
db_table_prefix = mth3l3m3nt_
password_hash_engine = md5
password_md5_salt = JKjdk%^Y(198237#)
error_mail = munir@skilledsoft.com