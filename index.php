<?php

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require 'application/libs/application.php';
require 'application/libs/parametres.php';
require 'application/libs/modules.php';
require 'application/libs/controller.php';
require "application/libs/controller_modules.php";

// start the application
$app = new Application();
