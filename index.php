<?php
    include_once("App/App.php");
    $App = new App\App();

    $good = new App\Models\Good;

    //$good::install(); Установили таблицу

    // Добавляет товар
    $res = $good::add([
        "code" => "A0001",
        'name' => 'New product'
    ]);

    var_dump($res);

    $App->end();
