<?php

use CViniciusSDias\MongoDbRestApi\Controller\EstadosController;

// Routes
$app->get('/estados', EstadosController::class . ':listarTodos');
$app->get('/estados/{id}', EstadosController::class . ':listarUm');
$app->post('/estados', EstadosController::class . ':inserir');
$app->patch('/estados/{id}', EstadosController::class . ':atualizar');
$app->delete('/estados/{id}', EstadosController::class . ':remover');
