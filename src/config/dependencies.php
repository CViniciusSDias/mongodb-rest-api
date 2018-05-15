<?php
// DIC configuration

use CViniciusSDias\MongoDbRestApi\Controller\EstadosController;
use CViniciusSDias\MongoDbRestApi\Controller\CidadesController;
use CViniciusSDias\MongoDbRestApi\Repository\EstadosRepository;
use CViniciusSDias\MongoDbRestApi\Repository\CidadesRepository;
use MongoDB\Client;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['mongo'] = function ($c) {
    $settings = $c->get('settings')['mongo'];
    $mongo = new Client("mongodb://{$settings['host']}:{$settings['port']}");
    return $mongo->selectDatabase($settings['base']);
};

$container['cache'] = function (ContainerInterface $c) {
    return new FilesystemCache();
};

$container[EstadosRepository::class] = function (ContainerInterface  $c) {
    return new EstadosRepository($c->get('mongo'), $c->get('cache'));
};

$container[CidadesRepository::class] = function (ContainerInterface  $c) {
    return new CidadesRepository($c->get('mongo'), $c->get('cache'));
};

$container[EstadosController::class] = function (ContainerInterface $c) {
    return new EstadosController($c->get(EstadosRepository::class));
};

$container[CidadesController::class] = function (ContainerInterface $c) {
    return new CidadesController($c->get(CidadesRepository::class));
};
