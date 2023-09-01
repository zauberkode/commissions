test:
	./vendor/bin/phpunit ./tests

phpcs:
	./vendor/bin/phpcs --standard=PSR12 ./src ./tests 

phpcbf:
	./vendor/bin/phpcbf --standard=PSR12 ./src ./tests 

run:
	php ./app.php input.txt
