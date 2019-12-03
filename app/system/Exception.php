<?php


namespace App\System\Exception;


class Exception {
    static $exceptions = [];

    public function add($file = "", String $msg) {
        $exceptions = [
            'file'      => $file,
            'message'   => $msg,
            'time'      => time()
        ];

        print_r($exceptions);
    }

    static function printList() {

    }
}