<?php

require_once __DIR__ . '/../vendor/autoload.php';

use projeto_olx\Controller\AppController;
use projeto_olx\Config\Route;

define('BASEPATH', '/');

// Add base route (startpage)
Route::add('/', function () {
  include('./form.php');
});

// Simple test route that simulates static html file
Route::add('/api/getBrands', function () {
  $api = new AppController();
  echo $api->getBrands();
}, 'get');

Route::add('/api/getModels/(.*)', function ($brandId) {
  $api = new AppController();
  echo $api->getModels($brandId);
}, 'get');


// // Post route example
// Route::add('/contact-form', function () {
//   echo '<form method="post"><input type="text" name="test" /><input type="submit" value="send" /></form>';
// }, 'get');

// // Post route example
// Route::add('/contact-form', function () {
//   echo 'Hey! The form has been sent:<br/>';
//   print_r($_POST);
// }, 'post');

// // Accept only numbers as parameter. Other characters will result in a 404 error
// Route::add('/foo/([0-9]*)/bar', function ($var1) {
//   echo $var1 . ' is a great number!';
// });

Route::run('/');

// $uri = $_SERVER["REQUEST_URI"];

// if ($uri == '/api/getMarcasModelos') {


//   $obj = $api->getMarcas();
//   echo json_encode($obj);
//   die();
// }
