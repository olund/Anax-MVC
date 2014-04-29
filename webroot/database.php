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


// Setup route

$app->router->add('setup', function () use ($app) {
    $app->theme->setTitle('Setup db');
    $app->db->setVerbose(true);

    // Drop table if exist
    $app->db->dropTableIfExists('user')->execute();

    // Create a user table
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();


    // Add 2 users
    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );

    // Get the date?
    $now = date(DATE_RFC2822);

    // Execute the query
    $app->db->execute([
        'admin',
        'admin@test.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);

    $app->db->execute([
        'doe',
        'doe@test.se',
        'John Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);

});

$app->router->add('', function() use ($app) {

    $app->theme->setTitle('Databas test');


});


$app->router->handle();
$app->theme->render();