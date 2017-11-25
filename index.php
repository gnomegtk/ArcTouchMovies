<?php

/**
 * Front controller of the application
 * SPL autoloader taken from web
 */

define('__ROOT_DIR__', __DIR__ . DIRECTORY_SEPARATOR);
define('__VIEWS_DIR__', __ROOT_DIR__ . 'views' . DIRECTORY_SEPARATOR);
define('__CONFIG_DIR__', __ROOT_DIR__ . 'config' . DIRECTORY_SEPARATOR);

/**
 * An example of a project-specific implementation.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = '';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Reading the config dir
if ($handle = opendir(__CONFIG_DIR__)) {
    while (false !== ($file = readdir($handle))) {
        if (substr($file, -4) == '.php') {
            include __CONFIG_DIR__ . $file;
        }
    }
}

$controller = ucfirst(filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_SPECIAL_CHARS));
if (!$controller) {
    $controller = 'Main';
}

$method = ucfirst(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_SPECIAL_CHARS));
if (!$method) {
    $method = 'index';
}

try {
    $class = new ReflectionClass('controllers\\' . $controller);
    $instance = $class->newInstanceArgs(array());
} catch (ReflectionException $e) {
    throw new Exception("Method $method not found");
}

try {
    $class->getMethod($method)->invoke($instance);
} catch (ReflectionException $e) {
    throw new Exception("Method $method in controller $controller not found");
}