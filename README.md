#OWASP Mth3l3m3nt Framework

Modules Packed in so far are: 
* Payload Store
* Shell Generator (PHP/ASP/JSP/JSPX)
* Payload Encoder and Decoder (Base64/Rot13/Hex/Hexwith \x seperator/ Hex with 0x Prefix)
* CURL GUI (GET/POST)
* LFI Exploitation module (currently prepacked with: Koha Lib Lime LFI/ Wordpress Aspose E-book generator LFI/ Zimbra Collaboration Server LFI)
* HTTP Bot Herd to control web shells. 

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

It's been tested on : 

* Apache 
* Lightspeed
* Lighttpd

Incase you test on another server please give your review.

If installing it in a subfolder edit the .htaccess file to reflect the RewriteBase as the subfolder.

Webserver Configuration in event you encounter issues with the routing engines and URLs give 404: 

###Sample Apache2 Configuration

```
<Directory /var/www/>
    Options -Indexes +FollowSymLinks +Includes
    AllowOverride All
    Order allow,deny
    Allow from all
    Require all granted # This is required for apache 2.4.3 or higher if lower version remove this line
</Directory>
```


###Sample Nginx Configuration

``` 
server {
    root /var/www/html;
    location / {
        index index.php index.html index.htm;
        try_files $uri /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass ip_address:port;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    } 
    
```

###Sample IIS Configuration

``` 

<?xml version="1.0" encoding="UTF-8"?>
<configuration>
  <system.webServer>
    <rewrite>
      <rules>
        <rule name="Application" stopProcessing="true">
          <match url=".*" ignoreCase="false" />
          <conditions logicalGrouping="MatchAll">
            <add input="{REQUEST_FILENAME}" matchType="IsFile" ignoreCase="false" negate="true" />
            <add input="{REQUEST_FILENAME}" matchType="IsDirectory" ignoreCase="false" negate="true" />
          </conditions>
          <action type="Rewrite" url="index.php" appendQueryString="true" />
        </rule>
      </rules>
    </rewrite>
  </system.webServer>
</configuration> 

```

###Sample Lighttpd Configuration
```
$HTTP["host"] =~ "www\.example\.com$" {
    url.rewrite-once = ( "^/(.*?)(\?.+)?$"=>"/index.php/$1?$2" )
    server.error-handler-404 = "/index.php"
}

}

```

