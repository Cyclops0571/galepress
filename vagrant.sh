#!/bin/sh
#update installed packages
apt-get update
#set mysql root password for installation
echo "mysql-server mysql-server/root_password password vagrant" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password vagrant" | debconf-set-selections
#install required packages
apt-get install -y vim git-core curl apache2 php5 libapache2-mod-php5 php5-mcrypt php5-curl mysql-server libapache2-mod-auth-mysql php5-mysql imagemagick php5-imagick build-essential ia32-libs-multiarch
#create default virtual host file
VHOST=$(cat <<EOF
<VirtualHost *:80>
  ServerAdmin webmaster@localhost
  DocumentRoot "/vagrant/public"
  ServerName localhost
  <Directory "/vagrant/public">
    EnableSendfile Off
    AllowOverride All
  </Directory>
  ErrorLog /var/log/apache2/error.log
  CustomLog /var/log/apache2/access.log combined
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/default
#create httpd.conf
echo "ServerName localhost" > /etc/apache2/httpd.conf
#install pdflib
cd /home/vagrant
wget http://www.pdflib.com/binaries/PDFlib/900/PDFlib-9.0.0-Linux-php.tar.gz
tar xf PDFlib-9.0.0-Linux-php.tar.gz
echo "extension=/home/vagrant/PDFlib-9.0.0-Linux-php/bind/php/php-530/php_pdflib.so" >> /etc/php5/cli/php.ini
echo "extension=/home/vagrant/PDFlib-9.0.0-Linux-php/bind/php/php-530/php_pdflib.so" >> /etc/php5/apache2/php.ini
#echo "maximum_execution_time=3600" >> /etc/php5/apache2/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 100M/g' /etc/php5/apache2/php.ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 100M/g' /etc/php5/apache2/php.ini
#enable rewrite module for apache
a2enmod rewrite
#restart apache service
service apache2 restart
#mysql configuration
#mysql -u root -p'vagrant' -e ";DROP DATABASE test;DROP USER ''@'localhost';DROP USER ''@'precise32';DROP USER 'root'@'precise32';GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'::1' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '';FLUSH PRIVILEGES;CREATE DATABASE db;"
mysql -u root -p'vagrant' -e ";GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'::1' IDENTIFIED BY '';GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '';FLUSH PRIVILEGES;CREATE DATABASE db;"
#backup mysql configuration file
cp /etc/mysql/my.cnf /etc/mysql/my.cnf.backup
#enable remote connection to mysql
sed -i 's/127.0.0.1/0.0.0.0/g' /etc/mysql/my.cnf
#restart mysql service
service mysql restart
#import db
cd /vagrant
#mysql -u root db < db.sql
#clean installation files
apt-get clean