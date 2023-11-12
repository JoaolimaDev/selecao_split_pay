<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function loader() : void
{
    spl_autoload_register(function($class){

        $prefix = str_replace("\\", DIRECTORY_SEPARATOR, $class);


        require_once($prefix.".php");


    });
}

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->post('/insert/', function () {

    loader();
    
    new controller\crud_controller;
    
    
});


$app->delete('/delete/{id}', function (Request $request, Response $response, array $args) {

    loader();
    
    $id = $args['id'];


    new controller\crud_controller(null, $id);
    
    
});


$app->get('/', function () {

    exit(json_encode([

    ]));
    
});

$app->put('/update/', function () {

    loader();
    
    new controller\crud_controller;
    
});



$app->get('/get/id/{id}/', function (Request $request, Response $response, array $args) {

    $id = $args['id'];

    loader();
    
    new controller\crud_controller(null, $id);
    
});




$app->get('/get', function (Request $request, Response $response, array $args) {

    $page = $args['page'];

    loader();
    
    new controller\crud_controller($page);
    
});


$app->get('/get/{page}', function (Request $request, Response $response, array $args) {

    $page = $args['page'];

    loader();
    
    new controller\crud_controller($page);
    
});




$app->run();
