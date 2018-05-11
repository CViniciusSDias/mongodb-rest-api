<?php
// DIC configuration

use CViniciusSDias\MongoDbRestApi\Controller\EstadosController;
use CViniciusSDias\MongoDbRestApi\Repository\EstadosRepository;
use MongoDB\Client;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['mongo'] = function () {
    $mongo = new Client('mongodb://localhost:27017');
    return $mongo->selectDatabase('prova');
};

$container[EstadosRepository::class] = function (ContainerInterface  $c) {
    return new EstadosRepository($c->get('mongo'));
};

$container[EstadosController::class] = function (ContainerInterface $c) {
    return new EstadosController($c->get(EstadosRepository::class));
};
