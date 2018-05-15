<?php

use CViniciusSDias\MongoDbRestApi\Controller\CidadesController;
use CViniciusSDias\MongoDbRestApi\Controller\EstadosController;

// Routes
$app->get('/estados', EstadosController::class . ':listarTodos');
$app->get('/estados/{id}', EstadosController::class . ':listarUm');
$app->post('/estados', EstadosController::class . ':inserir');
$app->patch('/estados/{id}', EstadosController::class . ':atualizar');
$app->delete('/estados/{id}', EstadosController::class . ':remover');

$app->get('/cidades', CidadesController::class . ':listarTodos');
$app->get('/cidades/{id}', CidadesController::class . ':listarUm');
$app->post('/cidades', CidadesController::class . ':inserir');
$app->patch('/cidades/{id}', CidadesController::class . ':atualizar');
$app->delete('/cidades/{id}', CidadesController::class . ':remover');
