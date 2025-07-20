
1) docker-compose up -d -- build (detachmode)
2) docker-compose exec php php /var/www/html/artisan migrate (here php is the container and exec stands for execute)
3) docker-compose down (remove container)
