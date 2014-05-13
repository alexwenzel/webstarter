<?php

/**
 * constants
 */
define('BASEPATH', __DIR__);

/**
 * autoloader
 */
require_once __DIR__.'/vendor/autoload.php';

/**
 * silex
 */
$app = new Silex\Application();

/**
 * init
 */
$app['webstarter'] = $app->share(function ($app) {

    return new webstarter\Webstarter($app, array(
		'apppath' 	=> BASEPATH.'/app',
	));
});

/**
 * load twig + url generator
 */
$app['webstarter']->twig($app, array(
	'twig.path' => BASEPATH.'/views',
));

/**
 * less to css
 */
$app['webstarter']->lessphp($app, array(
	'lessphp.active' 	=> true,
	'lessphp.formatter' => 'compressed',
	'lessphp.path' 		=> BASEPATH.'/public/css/main',
));

/**
 * include custom routes
 */
$app['webstarter']->errors($app, array(
	'file' => BASEPATH.'/app/errors.php',
));

/**
 * include custom routes
 */
$app['webstarter']->routes($app, array(
	'file' => BASEPATH.'/app/routes.php',
));

/**
 * automatic routing
 */
$app['webstarter']->routing($app, array(
	'pagedir' => BASEPATH.'/views/pages',
));

/**
 * app ...
 */
$app->run();