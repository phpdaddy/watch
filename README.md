# Watch

Test application by Maksym Prysiazhnyi

### Prerequisites

- Install docker, docker-compose
- If you want to run tests, you will probably need php zip extension for linux

### Running

- Run `make docker-start`
- Open http://localhost:8000/watch/1
- If you want to switch to different source, change /web/.env file

Files are located 
- var/source.xml - For simplicity xml is loaded from local storage
- var/cache.json

MySql db will be loaded automatically with docker, as well as composer and php and phpmyadmin

http://localhost:8080/ - phpmyadmin container
### Endpoints

- GET /watch/{id}           - Load watch

## Running the tests
 
From web dir
sudo ./vendor/bin/simple-phpunit


## Authors

* **Maksym Prysiazhnyi** - *Initial work*
