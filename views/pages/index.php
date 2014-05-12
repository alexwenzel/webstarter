{% extends "boilerplate.php" %}

{% set version = "0.1" %}

{% block body %}
<article>
    <h1>Webstarter {{ version }}</h1>
    <p>web bundle - silex, twig, less, boilerplate, jquery</p>
    <code>{{ public() }}</code>
</article>
{% endblock %}