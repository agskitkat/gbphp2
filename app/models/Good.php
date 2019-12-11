<?php
    namespace App\Models;

    use App\System\Model;

    class Good extends Model {

        public $id;
        public $code;
        public $name;

        /**
         * Возвращает имя таблицы в базе данных
         * @return string
         */
        public function getTableName(): string  {
            return 'goods';
        }
        
        function install() {
            return self::createTable([
                "`code` varchar(255) NOT NULL",
                "`name` text NOT NULL"
            ]);
        }
    }