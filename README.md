# MySQL with Docker

## Description
How to run MySQL in Docker and using volumes to create persistent data.

## Setup
1. Make sure you have volume (for persistent purpose)
   1. Check if volume `mysql_data` exists
        ```
        docker volume ls
        ```
   2. If not exist, create volume
        ```
        docker volume create mysql_data 
        ```

2. To run image `mysql` as a container (for the first time) in detach (in background) mode and expose port(s) *3306*, attach volume mysql_data to `/var/lib/mysql` with password `rahasia` (for the best practice on input password, see documentation page of mysql image in docker hub, topics called secret). This is only run at the first time for image createion, the next time you only need command to start the container.
    ```
    docker run --name mysql -p 3306:3306 -v mysql_data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=rahasia -d mysql:latest 
    ```
    Docker will automatically pull mysql image if it is not exist in local images.

3. Check if database connection is made. Assumes that you have webserver running, just check the connection in database.php or if you have installed php in your machine you may try to run
    ```
    php connection.php
    ```
    or to check your data in in `db_users.tb_users`
    ```
    php data.php
    ```

    ![image](https://user-images.githubusercontent.com/31872453/126221383-25a06d15-a06b-44b1-8cc1-3fb85260753c.png)


## Run
* to start container `mysql`
    ```
    docker container start mysql
    ```
* to restart container `mysql`
    ```
    docker container restart mysql
    ```
* to stop container `mysql`
    ```
    docker container stop mysql
    ```
* to remove the mysql (would not erase the volume)
    ```
    docker container rm mysql
    ```
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
    enter mysql, then enter root password `rahasia` and then show database then create database `db_users` and use it
    ```bash
    mysql -u root -p
    show databases;
    create database db_users;
    use db_users;
    ```

## Additional
If you want run mysql with no root password, create container with this command
```bash
docker run --name mysql -p 3306:3306 -v mysql_data:/var/lib/mysql -e MYSQL_ALLOW_EMPTY_PASSWORD=yes -d mysql:latest
```
