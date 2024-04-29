# eID Identity Provider OpenID Connect PHP Example

The PHP example web application demonstrates how to integration the eID Identity Provider of e-Contract.be BV using the OpenID Connect protocol.
More information about the supported OpenID Connect protocol is available at:
https://www.e-contract.be/developers/webapp/idp/oidc

We use Composer to install the required dependencies.
Check availability of PHP via:
```
php --version
```
Check availability of composer via:
```
composer about
```
Install all required dependencies via:
```
composer install
```
In the following example configuration, replace `$EXAMPLE_HOME` with the actual directory of this example.


## macOS
We assume that you are using the Homebrew Apache Web Server.

Install `composer` on macOS via:
```
brew install composer
```

Add the following Apache configuration file as `/opt/homebrew/etc/httpd/conf.d/openid-connect-php.conf`, with content:
```
Alias /openid-connect-php $EXAMPLE_HOME

<Directory $EXAMPLE_HOME>
	Require all granted
</Directory>
```

Restart the Apache web server on macOS via:
```
brew services restart httpd
```
Enable PHP on Homebrew Apache Web Server as follows.
Add to `/opt/homebrew/etc/httpd/httpd.conf`:
```
LoadModule php_module /opt/homebrew/lib/httpd/modules/libphp.so
Include /opt/homebrew/etc/httpd/extra/httpd-php.conf
IncludeOptional /opt/homebrew/etc/httpd/conf.d/*.conf
```
Configure `/opt/homebrew/etc/httpd/extra/httpd-php.conf` with:
```xml
<IfModule php_module>
  <FilesMatch \.php$>
    SetHandler application/x-httpd-php
  </FilesMatch>

  <IfModule dir_module>
    DirectoryIndex index.html index.php
  </IfModule>
</IfModule>
```
Check whether PHP is available within the Apache Web Server via:
https://localhost/openid-connect-php/info.php

The web application should be available at:
https://localhost/openid-connect-php/

## Ubuntu Linux

If required, install Apache and PHP as follows.
```
sudo apt update
sudo apt install apache2
sudo apt install php
sudo apt install php-curl
sudo apt install libapache2-mod-php
sudo apt install composer
sudo a2enmod ssl
sudo systemctl restart apache2
```

We install a self-signed certificate as follows:
```
sudo apt install mkcert
sudo apt install libnss3-tools
mkcert -install
```

The web application should be available at:
https://localhost/openid-connect-php/


## Fedora/CentOS Linux

Install Apache as follows:
```
sudo yum install httpd
```

Configure Apache HTTPD via `/etc/httpd/conf.d/openid-connect-php.conf` as follows:
```
Alias /openid-connect-php $EXAMPLE_HOME

<Directory $EXAMPLE_HOME>
	Require all granted
</Directory>
```
Change SELinux configuration via:
```
chcon -R -t httpd_sys_content_t $EXAMPLE_HOME
```

Restart Apache HTTPD via:
```
sudo systemctl restart httpd
```
The web application should be available at:
https://localhost/openid-connect-php/


## Debugging via NetBeans

Debug PHP via Xdebug in NetBeans:
```
sudo dnf install php-pecl-xdebug
sudo systemctl restart httpd
```

Add to `/etc/php.d/xdebug.ini`:
```
xdebug.remote_enable=1
xdebug.remote_handler=dbgp
xdebug.remote_mode=req
xdebug.remote_host=127.0.0.1
xdebug.remote_port=9000
xdebug.remote_autostart=1
```


## syslog

Enable syslog in `/etc/php.ini`:
```
error_log = syslog
```

View syslog via:
```
sudo journalctl -f
```
