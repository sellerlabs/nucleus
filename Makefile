cleanup:
	php-formatter formatter:header:fix src
	php-formatter formatter:use:sort src
	php-formatter formatter:header:fix tests
	php-formatter formatter:use:sort tests
	php-cs-fixer fix --config-file=phpcs.php --diff -vvv
