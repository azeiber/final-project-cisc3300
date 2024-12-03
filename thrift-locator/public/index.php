<?php
require '../app/core/setup.php';

use app\core\Router;
use app\models\Model;

$router = new Router();

$model = new Model();

$contact = $model-> getAllContacts();
if (!is_array(value: $contact))
{
    $contact = [];
}

include '/assets/views/index.html';


