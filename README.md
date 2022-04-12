# xtcommerce-playground

###Prerequisite
You need a running docker environment.
This project creates three docker container:
- xtcplayground_wb (Webserver Port 80)
- xtcplayground_db (Database MariaDB Port 3306)
- xtcplayground_redis (Redis-Instance Port 6379)

The container-names, php and mariaDB-version can be changed in `.env`.
If the used ports are already used on your system, you can be changed them in `docker-compose.yml`.


###First steps:
- Use `docker-compose build` to create the container
- Use `docker-compose up` to start the container
- Use `./docker/db-dump.sh` to import the initial database-dump with example data
- Open http://localhost/create_demo_lic.php to fetch a 30-day-trial-license


###Use the playgound
- Just use `docker-compose up` to start and `ctrl-c` to stop
- Alternatively, you can start a detached session with `docker-compose up -d` and stop with `docker-compose down` 

###Usefull links
- Official user documentation (german only): https://xtcommerce.atlassian.net/wiki/spaces/MANUAL/overview
- Official developer documentation (german only): https://xtcommerce.atlassian.net/wiki/spaces/XT41DUE/overview
