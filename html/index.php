<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;
$app->post('/countable/{name}', function (Request $request, Response $response) {
    return $response->withStatus(501);
});
$app->run();
