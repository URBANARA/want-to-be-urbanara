<?php
require_once(__DIR__ . "/vendor/aura/autoload/src/Loader.php");
// instantiate
$loader = new \Aura\Autoload\Loader;
$loader->addPrefix('Garbereder\Urbanara', __DIR__ . '/src');
$loader->addPrefix('Garbereder\Urbanara', __DIR__ . '/tests');

// append to the SPL autoloader stack; use register(true) to prepend instead
$loader->register();
