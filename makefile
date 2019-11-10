docker_name = symfonybackend_php_1
docker_image = backend_php-fpm

idu = $(shell id -u)
idg = $(shell id -g)

start: #start docker container #
	@CURRENT_UID=$(idu):$(idg) docker-compose up -d

stop: #stop docker container
	@CURRENT_UID=$(idu):$(idg) docker-compose down

build: #restart docker container
	@CURRENT_UID=$(idu):$(idg) docker exec -it symfonybackend_php_1 sh -c 'cd .. && ./build.sh'
