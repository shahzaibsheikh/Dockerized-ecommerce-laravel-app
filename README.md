
docker-compose up -d -- build (detachmode)
docker-compose exec php php /var/www/html/artisan migrate (here php is the container and exec stands for execute)
docker-compose down (remove container)