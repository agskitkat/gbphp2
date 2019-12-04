<?php
    include_once("App/App.php");
    $App = new App\App();

    $good = new App\Models\Good;

    //$good::install();

    // Добавляет товар
    $res = $good::add([
        "code" => "A0001",
        'name' => 'New product'
    ]);

    print_r($res);

    $App->end();
