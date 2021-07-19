* check if image mysql already exists?
```
docker image ls
```

*if image mysql did NOT exists*

* to create image `mysql`
```
docker build my-nginx-app .
```

* check if volume `mysql_data` exists
```
docker volume ls
```

* to remove volume
```
docker volume rm mysql_data
```

* to create volume
```
docker volume create mysql_data 
```

* to run image `mysql` in detach (in background) mode and expose port(s) *3306*, attach volume mysql_data to `/var/lib/mysql` dengan password `rahasia` (untuk best practice input password, lihat dokumentasi mysql di docker hub)
```
docker run --name mysql -p 3306:3306 -v mysql_data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=rahasia -d mysql:latest 
```

* check if database connection is made
assume that you have webserver running, just check the connection in database.php or if you have installed php in your machine you may try to run
```
php connection.php
```
or to check your data in in `db_users.tb_users`
```
php data.php
```

![image](https://user-images.githubusercontent.com/31872453/126221383-25a06d15-a06b-44b1-8cc1-3fb85260753c.png)


* to dump (backup) database container `mysql` , database `db_users`, -proot means `rahasia` is the password (it is not safe, but yeah it woks for simplicity), `db_users.sql` is the file name output (can be full directory to your local machine)
```
docker exec mysql bash -c "exec mysqldump db_users -uroot -prahasia" > db_users.sql
```

* to restore database to container`mysql` , -proot means `rahasia` is the password (it is not safe, but yeah it woks for simplicity), `db_users.sql` is the file name source (can be full directory to your local machine). *Note, commands can not run in powershell. try in bash / cmd (in windows) *
```
docker exec -i mysql bash -c "exec mysql -uroot -prahasia" < db_users.sql
```

* if restore failed becasue you did not select database yet, please add `use db_users;` in the beginning of your sql file.

* before restore, make sure have already database created and use it.

* to create database, enter interactive cli of the container
```
docker exec -it mysql bin/bash
```

enter mysql, then enter root password `rahasia`
```
mysql -u root -p
```

show database 
```
show databases;
```

create database `db_users` 
```
create database db_users
```

use database
```
use db_users;
```
