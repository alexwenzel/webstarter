<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * page not found error
 */
$app->error(function (HttpException $e, $code) use ($app) {
    return $app['twig']->render('404.php');
});

/**
 * all other errors
 */
$app->error(function (Exception $e, $code) {
    return new Response('An error occoured.');
});