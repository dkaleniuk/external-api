<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Caller;

try {
    $caller = new Caller;
    $caller->make('https://api.github.com/users', 'GET')
        ->where('site_admin','=', false)
        ->where('login','=', 'atmos')
        ->sort('login', 'DESC');
    var_dump($caller->get());
    var_dump($caller->only(['login', 'node_id']));
} catch (\Exception | \Error $e) {
    echo $e->getMessage();
}