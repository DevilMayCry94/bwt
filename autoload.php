<?php
// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

spl_autoload_register( function ($className) {
    $classPath = str_replace(['\\', 'BWT/'], ['/', ''], $className);
    $file =  __DIR__ . '/lib/' . $classPath . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

