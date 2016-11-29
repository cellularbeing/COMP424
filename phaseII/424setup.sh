#!/bin/bash

#This echo is used to prompt the user to enter their root password
#so that the system can install and setup the necessary components for the server
echo "++INPUT ROOT PASSWORD++"

#This command first updates the systems packages to make sure everyting is up to date
sudo apt-get update

#This command installs the apache2 server which allows clients to access the login page
sudo apt-get install apache2

#This command installs mysql-server which is used to create and modify databses and tables
sudo apt-get install mysql-server

#This command install php 5 which allows us to use our code that controls all of the 
#backend functionality of the website
sudo apt-get install php5

#This command allows us to view and modify databases in the browser
sudo apt-get install phpmyadmin

#This command installs git which is necessary to retrieve the project files
sudo apt-get install git

#This command gives the user and groups reading, writing, and executing priviledges on the file path
#/var/www/html. This allows us to place code in the respective file to make it live in the web
sudo chmod -R ugo+rwx /var/www/html

#This command is used to set up a general information page about the characterisitcs of
#the PHP version that is currently running on the system
sudo echo "<?php phpinfo(); ?>" >> /var/www/html/info.php

#This command create a folder where the databses backup file will live
mkdir /var/www/html/db_backup

#This command moves into the /var/www/html directory. This is where
#new folder that make the project work will go
cd /var/www/html

#This command clones the project from github.
#This allows the system to recieve all of the project code
sudo git clone https://comp424repo@bitbucket.org/comp424repo/424projectphase2.git

#This command gives reading. writing, and executing priviledges to the folder COMP424
#This is done so the the website can be modified
sudo chmod -R ugo+rwx /var/www/html/COMP424

#This command prompts the user to input the password they set up in order to creat the databse abd tables
echo "++INPUT MYSQL PASSWORD FOR DB SETUP++"

#This command generates the databse and tables that will be used for the website
mysql -u root -p -e "create database Security424; use Security424; create table users (id int not null auto_increment, primary key (id), username varchar(255), email varchar(255), password varchar(255), salt varchar(12), loginCount int(100), firstName varchar(255), lastName varchar(255), token varchar(255), unique (username, email) ); describe users;"

#This command prompts the user to input their mysql password again to create backup file for the databse
echo "++ENTER MYSQL PASSWORD AGAIN FOR DB BACK UP++"

#This command goes into the back up folder which will house the backup datbase file
cd db_backup

#This command creates a backup file for the databse Security424 which is the db the project uses
mysqldump -u root -p Security424 > Security424.sql

#This command gets us back to the home directory, which is where we first started
cd ~
