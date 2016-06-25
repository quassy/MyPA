# System requirements

MyPA has been tested on the following configuration, which is hereby also defined as the minimum
requirements to run MyPA

* Ubuntu 16.04
* Apache 2.4
* PHP 7.0
* MariaDB 10.0

    sudo apt purge mysql-server mysql-common mysql*
    sudo apt autoclean; sudo apt clean; sudo apt autoremove
    sudo apt install apache2 libapache2-mod-php7.0 php7.0 php7.0-mysql mariadb-server 
    sudo apt install libmysqlclient-dev build-essential

# Change config files

* online/options.php
* online/sendpass.php
* ticker/myppa.cfg
* online/motd.php

In the future all config information will reside in `config.yaml`

# Set up database

    mysql -u root -p --execute='CREATE USER mypa@localhost IDENTIFIED BY defaultpassword;'
    mysql -u root -p --execute='GRANT SELECT, INSERT, UPDATE ON mypa.* TO mypa@localhost;'
    mysql -u root -p --execute='CREATE DATABASE mypa;'
    mysql -u root -p mypa < newdatabase.sql
