<?php

namespace App\System;

class Exception {
    /**
     * Добавляет в список исключений новое исключение и возвращает результат
     * @param $file
     * @param $msg
     * @return array
     */
    static function add($file,  $msg) {
        static $exceptions = [];
        if($file && $msg) {
            $exceptions[] = [
                'file' => $file,
                'message' => $msg,
                'time' => time()
            ];
        }
        return $exceptions;
    }

    /**
     * Листинг исключений
     */
    static function printList() {
        foreach(self::add(false,false) as $exception) {
            print_r($exception);
        }
    }

    static function fail($file,  $msg) {
        self::printList();

        echo "<hr>В файле: " . $file  . "<br>";
        echo "Невозможно продолжить выполнение приложения.<br>";
        echo  $msg  . "<br>";
        exit();
    }
}