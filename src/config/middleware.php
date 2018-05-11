<?php
// Application middleware

$app->add(new \CViniciusSDias\MongoDbRestApi\Pipe\ErrorHandlerMiddleware());
$app->add(new \CViniciusSDias\MongoDbRestApi\Pipe\ContentTypeMiddleware());
