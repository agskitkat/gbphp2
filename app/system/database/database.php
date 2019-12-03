<?php
    namespace App\System\DataBase;

    interface DataBase {
        /**
         * Вызов соединения с базой данных
         * @return DataBase
         */
        public function connection();

        /**
         * Делаем запрос к базе
         * @return DataBase
         */
        public function query();

        /**
         *
         */
        public function fetchToArray();
    }