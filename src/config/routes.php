<?php

use CViniciusSDias\MongoDbRestApi\Controller\EstadosController;

// Routes
$app->get('/estados', EstadosController::class . ':listarTodos');
$app->post('/estados', EstadosController::class . ':inserir');
