<?php
    include_once("App/App.php");
    $App = new App\App();

    $good = new App\Models\Good();

    //$good->install(); //Установили таблицу

    // LESSON 3
    $rand = rand(0,999);
    $good->name = "Товар - ".$rand;
    $good->code = "A".$rand;
    $good->save();
    var_dump($good);

    $goods = $good->find(Array(["create_at:>"=>"2019-12-11 16:50:10"]));
    var_dump($goods);
    $good->remove($goods[0]->id);

    $goods[1]->name = "TEST 123";
    $goods[1]->update();
    var_dump($goods[1]);

    $App->end();