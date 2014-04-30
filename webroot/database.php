<?php

require __DIR__.'/config_with_app.php';

date_default_timezone_set("Europe/Stockholm");

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});




$app->router->add('', function() use ($app) {

    $app->theme->setTitle('Databas test');


});


$app->router->handle();
$app->theme->render();