<?php
    namespace App\System\DataBase;

    class MySQL implements DataBase {
        protected $link;
        /**
         * Вызов соединения с базой данных
         * @param string $server
         * @param string $databsae
         * @param string $user
         * @param string $password
         * @return void
         */
        public function connection($server = 'localhost', $databsae = 'mysql',  $user = 'user',  $password = 'password') {
            $this->link = mysql_connect($server, $user, $password);
            if (!$this->link) {
                die('Ошибка соединения: ' . mysql_error());
            }


        }

        /**
         * Делаем запрос к базе
         * @return DataBase
         */
        public function query() {
            // TODO: Implement query() method.
        }

        /**
         *
         */
        public function fetchToArray() {
            // TODO: Implement fetchToArray() method.
        }
    }