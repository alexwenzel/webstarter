<?php namespace Webstarter;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Webstarter {

	private $settings = array();

	public function __construct($app, array $settings)
	{
		$app['debug'] = $settings['debug'];
	}

	public function twig($app, array $config)
	{
		$app->register(new \Silex\Provider\TwigServiceProvider(), array(
		    'twig.path' => $config['twig.path'],
		));

		$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

		$app['twig']->addFunction(new \Twig_SimpleFunction('public', function ($uri = '') use ($app) {
			return $app['request']->getUriForPath('/').trim($uri, '/');
		}));
	}

	public function lessphp($app, array $config)
	{
		if ( $config['lessphp.active'] ) {

			$app->before(function($request) use ($config) {

				$less = new \lessc();
				$less->setFormatter($config['lessphp.formatter']);
				$less->checkedCompile($config['lessphp.path'].".less", $config['lessphp.path'].".css");

			}, \Silex\Application::EARLY_EVENT);
		}
	}

	public function routes($app, array $config)
	{
		include_once $config['file'];
	}

	public function errors($app, array $config)
	{
		if ( ! $app['debug'] ) {

			include_once $config['file'];
		}
	}

	public function routing($app, array $config)
	{
		$app->get('{url}', function(Request $request, Application $app) use ($config)
		{
			// request
			$uri = trim($request->getPathInfo(), '/');

			if ( empty($uri) ) {
				$uri = 'index';
			}

			// check for pages
			if ( file_exists($config['pagedir'].'/'.$uri.'.php') )
			{
				return $app['twig']->render('/pages/'.$uri.'.php', array());
			}

			throw new NotFoundHttpException("Page not found");
		})->assert('url', '.*');
	}
}