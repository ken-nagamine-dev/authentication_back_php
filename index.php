<?php
header('Content-Type: application/json; charset=UTF-8');
require_once 'vendor/autoload.php';

use app\models\Rest;

if(isset($_SERVER["REQUEST_URI"]) || !empty($_SERVER))
{
   $rest = new Rest($_SERVER);
   echo $rest->run();
}