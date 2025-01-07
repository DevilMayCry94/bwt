## Run application
- cp config.php.example config.php
- put the api key for rateexchangeapi
- php app.php <path to file>

## Run application with docker
- cp config.php.example config.php
- put the api key for rateexchangeapi
- ./run.sh
- run script: docker-compose exec -it app php app.php input.txt

## unit test
- vendor/bin/phpunit
- run via docker: docker-compose exec -it app vendor/bin/phpunit
