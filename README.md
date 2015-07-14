#Mth3l3m3nt Framework - Beta



In order to use this Application Usage is easy. 

Currently it is set to use a flat file database. 

Copy all the files into your webroot except db_dump_optional

Ensure the Folders Below are writeable: 

* tmp
* framework/data
* framework/data/site_config.json

It should run from the get go All just navigate to it.

the login url is: /cnc

username:mth3l3m3nt
password:mth3l3m3nt

By Default I have set it to use the JIG database but this you can change at any point in the backend. 
The DB Dump in place is for users who use MySQL and need demo data. Unfortunately I have only done for MySQL. It's my DB of choice. 

If you would like to switch from JIG you can do so in the settings. Please note the DB has to be created, it only populates it with the required tables, it doesn't drop or create the DB , other supported Databases are: 

* Mongo DB 
* MSSQL
* PostgreSQL
* SQLite
* MySQL

Other than SQLite please ensure that you have the PHP extensions for the Databases above so that it can access them through PHP Data Objects.

For MySQL users needing MySQL Sample Data like alot of it especially payloads switch the database to MySQL and import data from the Dump to populate.

Incase of questions or suggestions or bugs and what nots : 

munir.n.n@gmail.com

It's been tested on : 

* Apache 
* Lightspeed
* Lighttpd

Incase you test on another server please give your review.

If installing it in a subfolder edit the .htaccess file to reflect the RewriteBase as the subfolder.

