paratest:
	vendor/bin/paratest --processes=3 --runner WrapperRunner

phpunit:
	vendor/bin/phpunit

local-test:
	vendor/bin/phpunit --exclude tier_dependency
	
t:
	XDEBUG_MODE=off \
	vendor/bin/paratest \
	--processes=6 --runner WrapperRunner

fresh:
	php artisan view:clear
	php artisan route:clear
	php artisan config:clear
	php artisan migrate:fresh
