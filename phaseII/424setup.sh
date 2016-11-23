# to run do: source p.sh

sudo apt-get update
sudo apt-get install apache2
sudo apt-get install mysql-server
sudo apt-get install php5
sudo apt-get install phpmyadmin

#sudo chmod -R 777 /var/www/html/ #this works! to access /var/www/html/

#sudo echo "<?php phpinfo(); ?>" >> /var/www/html/info.php

#sudo chmod -R 644 /var/www/html #this gets rid of permission on /var/www/html/

#sudo echo "hello world man guy" >> /var/www/html/what.txt

#chmod +x /var/www/html
echo "++INPUT MYSQL PASSWORD++"

mysql -u root -p -e "create database Security424; use Security424; create table users (id int not null auto_increment, primary key (id), username varchar(255), email varchar(255), password varchar(255), loginCount int(100), firstName varchar(255), lastName varchar(255) ); describe users;"
