<?php
    namespace App\Models;

    use App\System\Model;

    class Good extends Model {
        const tableName = "goods";

        static function install() {
            return self::createTable(self::tableName, [
                //TODO: лучше сделать типы и обрабатывать в базовой модели
                // ТИПЫ число, строка, время и т.д.
                // Совйства Уникальный, Автозаполняемый, ключевой и т.д.
                // Пок так (
                "`code` varchar(255) NOT NULL",
                "`name` text NOT NULL"
            ]);
        }

        public static function add($fields) {
            parent::$tableName = self::tableName;
            return parent::add($fields);
        }
    }