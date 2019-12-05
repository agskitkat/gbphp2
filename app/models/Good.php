<?php
    namespace App\Models;

    use App\System\Model;

    class Good extends Model {
        const tableName = "goods";

        static function install() {
            return self::createTable(self::tableName, [
                "`code` varchar(255) NOT NULL",
                "`name` text NOT NULL"
            ]);
        }

        public static function add($fields) {
            parent::$tableName = self::tableName;
            return parent::add($fields);
        }

        public static function find($fields) {
            parent::$tableName = self::tableName;
            return parent::find($fields);
        }
    }