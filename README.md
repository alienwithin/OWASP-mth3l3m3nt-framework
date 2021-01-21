#OWASP Mth3l3m3nt Framework

A slightly major (forgive pun) upgrade is on going. This is to bring in things like: 
* Easier coding standard
* Support for PHP 8
* More robust features
* Fix bug requests sent in.

This tool is released under  [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.en.html).

Modules Packed in so far are: 
* Payload Store
* Shell Generator (PHP/ASP/JSP/JSPX/CFM)
* Payload Encoder and Decoder (Base64/Rot13/Hex/Hexwith \x seperator/ Hex with 0x Prefix)
* CURL GUI (GET/POST/TRACE/OPTIONS/HEAD)
* LFI Exploitation module (currently prepacked with: Koha Lib Lime LFI/ Wordpress Aspose E-book generator LFI/ Zimbra Collaboration Server LFI)
* HTTP Bot Herd to control web shells. 
* WHOIS
* String Tools 
* Client Side Obfuscator
* Cookie Theft Database (Enables you to steal session cookies & download page content if a stored XSS is present)

Currently it is set to use a flat file database. 

Copy all the files into your webroot except db_dump_optional

Ensure the Folders Below are writeable: 

* tmp
* framework/data
* framework/data/site_config.json
* incoming/
* scripts/

It should run from the get go All just navigate to it.

the login url is: /cnc

username:mth3l3m3nt
password:mth3l3m3nt


By Default I have set it to use the JIG database but this you can change at any point in the backend. 
The DB Dump in place is for users who use MySQL and need demo data. Unfortunately I have only done for MySQL. It's my DB of choice. 

Alternatively watch the installation here: 

https://www.youtube.com/playlist?list=PL8peOGsl5TC4WscgWaNMx0xJlS6X2QJI0

If you would like to switch from JIG you can do so in the settings. Please note the DB has to be created, it only populates it with the required tables, it doesn't drop or create the DB , other supported Databases are: 

* Mongo DB 
* MSSQL
* PostgreSQL
* SQLite
* MySQL

Other than SQLite please ensure that you have the PHP extensions for the Databases above so that it can access them through PHP Data Objects.

For MySQL users needing MySQL Sample Data like alot of it especially payloads switch the database to MySQL and import data from the Dump to populate.

Incase of questions or suggestions or bugs and what nots:
http://munir.skilledsoft.com

You may also send them or subscribe to the mailing list: 
https://lists.owasp.org/mailman/listinfo/owasp-mth3l3m3nt-framework-project

It's been tested on : 

* Apache 
* Litespeed
* Nginx
* Lighttpd

Incase you test on another server please give your review.

If installing it in a subfolder edit the .htaccess file to reflect the RewriteBase as the subfolder.

Having Problems getting it running on your webserver, check out our [webserver configuration guide](https://github.com/alienwithin/OWASP-mth3l3m3nt-framework/wiki/WebServer-Configuration).
