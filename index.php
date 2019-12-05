<?php
    include_once("App/App.php");
    $App = new App\App();


    //$good::install(); //Установили таблицу

    // Добавляет товар
    $good =  App\Models\Good::add([
        "code" => "A000".rand(0,99),
        'name' => 'New product'
    ]);

    var_dump($good);

    // Поиск товаров
    $goods = App\Models\Good::find( Array(["ID"=>"1"]) );
    var_dump($goods);

    $goods = App\Models\Good::find( Array(["create_at:>"=>"2019-12-05 16:46:42"]) );
    var_dump($goods);


    $App->end();