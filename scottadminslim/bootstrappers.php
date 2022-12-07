<?php
use LocalHalPH35\ScottAdminSlim\Classes\exceptions\CustomErrorRenderer;

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer("text/html", CustomErrorRenderer::class);
?>