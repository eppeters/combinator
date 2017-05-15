<?php

use Combinator\DAO\CountableSQLDAO;
use Combinator\Handler\CreateCountableHandler;
use Combinator\Handler\ReadCountableByNameHandler;
use Combinator\Transformer\CountableJsonTransformer;
use Combinator\Transformer\JsonCountableTransformer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;

require '../bootstrap.php';

$app = new \Slim\App;

$app->post('/countable', function (Request $request, Response $response) use ($container) {
    /** @var PDO $pdo */
    $pdo = $container['db'];
    $transformer = new JsonCountableTransformer();
    $dao = new CountableSQLDAO($pdo);

    $handler = new CreateCountableHandler($transformer, $dao);
    $response = $handler->create($request);
    return $response;
});

$app->get('/countable/{name}', function (ServerRequestInterface $request, Response $response) use ($container) {
    $pdo = $container['db'];
    $dao = new CountableSQLDAO($pdo);
    $transformer = new CountableJsonTransformer();

    $handler = new ReadCountableByNameHandler($transformer, $dao);
    $response = $handler->read($request);
    return $response;
});

$app->run();
