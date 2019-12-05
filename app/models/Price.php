<?php
    namespace App\Models;

    use App\System\Model;

    /**
     * Реализация цены (один товар может иметь несколько цен)
     */
    class Price extends Model {
        const tableName = "prices";

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
    }