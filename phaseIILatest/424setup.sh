# to run do: source p.sh
echo "++INPUT USER PASSWORD++"
sudo apt-get update
sudo apt-get install apache2
sudo apt-get install mysql-server
sudo apt-get install php5
sudo apt-get install phpmyadmin
sudo echo "<?php phpinfo(); ?>" >> /var/www/html/info.php

#sudo chmod -R 777 /var/www/html/ #this works! to access /var/www/html/
#sudo chmod -R 644 /var/www/html #this gets rid of permission on /var/www/html/
#chmod +x /var/www/html

sudo chown -R $USER:$USER /var/www/html
cd /var/www/html
sudo git clone https://github.com/iuc73663/COMP424.git
cd ~

#sudo su $USER -c "cd /var/www/html"
#sudo su $USER -c "cat info.php"
#sudo su $USER << 'EOF'
#	cd /var/www/html
#	pwd
#EOF

echo "++INPUT MYSQL PASSWORD++"
mysql -u root -p -e "create database Security424; use Security424; create table users (id int not null auto_increment, primary key (id), username varchar(255), email varchar(255), password varchar(255), salt varchar(12), loginCount int(100), firstName varchar(255), lastName varchar(255), unique (username, email) ); describe users;"
