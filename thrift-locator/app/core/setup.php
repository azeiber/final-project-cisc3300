<?php

// require our files, remember should be relative to index.php
require '../app/core/Router.php';

require '../app/models/Model.php';
require '../app/models/Contact.php'; 
require '../app/models/Store.php'; 

require '../app/controllers/Controller.php';
require '../app/controllers/ContactController.php';
require '../app/controllers/StoreController.php';  
require '../app/controllers/MainController.php';  

$env = parse_ini_file('../.env');

define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);
define('DBDRIVER', 'mysql');

// set up other configs
define('DEBUG', true);  // Set to false in production for performance
