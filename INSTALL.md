# System requirements

MyPA has been tested on the following configuration, which is hereby also defined as the recommended
set-up:

* Ubuntu 16.04
* Apache 2.4
* PHP 7.0
* MariaDB 10.0

```
sudo apt purge mysql-server mysql-common mysql*
sudo apt autoclean; sudo apt clean; sudo apt autoremove
sudo apt install apache2 libapache2-mod-php7.0 php7.0 php7.0-mysql mariadb-server 
sudo apt install libmysqlclient-dev build-essential
```

# Change config files

* online/options.php
* online/sendpass.php
* ticker/myppa.cfg
* online/motd.php

In the future all config information (including ticker config) will reside in `config.yaml`

The default password for admin is `admin4`, for moderator it's `moderator4`. Both are set in the last line of `newdatabase.sql` and `online/admin/freset.php`.

# Set up database

```
mysql -u root -p --execute='CREATE USER mypa@localhost IDENTIFIED BY defaultpassword;'
mysql -u root -p --execute='GRANT SELECT, INSERT, UPDATE ON mypa.* TO mypa@localhost;'
mysql -u root -p --execute='CREATE DATABASE mypa;'
mysql -u root -p mypa < newdatabase.sql
```

# Configure ticker

* core_sql.c (fallback logins)
* mypa.cfg       (logins)

then `make all`. To start the game have `tick.sh` running in the background, it calls the ticker every 30 s.

If you want to provide stats to the users, edit `scripts/dump_stat.sh` according to your needs.
