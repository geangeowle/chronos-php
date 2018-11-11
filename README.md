# chronos-php
Very Small Lite Framework for PHP

:boom: Under development! :boom:

## Setup
To run the library, follow these steps:
 1. Run `composer install`
 2. Run `npm install`

## Setup for testing
To test the library, follow these steps:
 1. Copy file `phpunit.xml.dist` to `phpunit.xml`
 2. Copy file `.php_cs.dist` to `.php_cs`
 3. Run `./vendor/bin/phpunit` from project directory

## Setup Twig Template Engine
To enable and use twig template engine follow these steps:
 1. Access the file boot at `app/Config/boot`
 2. Change `Configure::write('App.RenderEngine', 'Default');` to `Configure::write('App.RenderEngine', 'Twig');`
 3. Run `composer require "twig/twig:^2.0"` to install the twig package
 4. On `app/Views` change all file extensions from **.php** to **.html** and that's it. Now you can use twig as you would normally use
