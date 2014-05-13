## Components

  * Silex - PHP micro framework [docs](http://silex.sensiolabs.org/)
  * Twig - PHP template engine [docs](http://twig.sensiolabs.org/)
  * LessPHP - PHP Less interpreter [docs](https://github.com/leafo/lessphp)
  * HTML5 Boilerplate - HTML starter [docs](http://html5boilerplate.com/)
  * JQuery - javascript DOM manipulation [docs](http://jquery.com/)

## Installation

Manually download webstarter or clone it. Run ``composer install`` inside the target location.

Navigate to the public directory inside your browser.

## Structure

``app/`` : contains app specific files

``public/`` : the document root and contains all public accessible files

``vendor/`` : contains composer packages, third party files

``webstarter/`` : this project files

## Configuration

The file ``app/config.php`` will be included during bootstrap. Put there any value you like.

In your template, you can use ``{{ config.value }}``.

Silex debug: http://silex.sensiolabs.org/doc/usage.html#global-configuration

## Routing

Webstarter has manual and automatic routing.

Silex docs: http://silex.sensiolabs.org/doc/usage.html#routing

### Manual routing

Manual routes are defined in ``app/routes.php``.

Example:
````
$app->get('/hello', function () use ($app){
    // any code here
});
````

Render a custom template:
````
$app->get('/hello', function () use ($app){
    return $app['twig']->render('/hello.php');
});
````

Manual routes override the automatic routing behaviour.


### Automatic routing

__If no manual route is found__, the automatic routing will look inside ``views/pages`` for existing files which match the URI.

If there is no matching URI, the request results in a 404.

__Example:__

Request: ``http://webstarter.de/my/page``
File: ``views/pages/my/page.php``

### Named routes

__Example:__

Route:
````
$app->get('/subpage/login', function () use ($app) {
	return 'Login page';
})->bind('login');
````

Template:
````
{{ url('login') }}
````

Output:
````
http://webstarter.de/subpage/login
````

Silex docs: http://silex.sensiolabs.org/doc/providers/url_generator.html

## Error handling

You can handle application errors individually in ``app/errors.php``.

Error handling is only excecuted if the debug flag is ``false``.

Silex docs: http://silex.sensiolabs.org/doc/usage.html#error-handlers

## Twig Template Engine

### Basics

Print a variable:
````
{{ version }}
````

Set a variable:
````
{% set version = "new" %}
````

Call a function:
````
{{ public() }}
````

Twig docs: http://twig.sensiolabs.org/doc/templates.html#variables

### Control structures

If:
````
{% if show === true %}
<div>show = true</div>
{% endif %}
````

For:
````
{% for i in 1..10 %}
<p>{{ i }}</p>
{% endfor %}
````

For in:
````
{% for i in items %}
<p>{{ i }}</p>
{% endfor %}
````

Twig docs: http://twig.sensiolabs.org/doc/templates.html#control-structure

#### public()

````
{{ public('folder/page2') }}
````

````
<link rel="stylesheet" href="{{ public('css/main.css') }}">
````

#### url()

Silex docs: http://silex.sensiolabs.org/doc/providers/url_generator.html

## LessPHP

Write your css definitions in ``public/css/main.less``. LessPHP will compile the file - if changed - to ``public/css/main.css``.

You can customize this behaviour in ``bootstrap.php``.