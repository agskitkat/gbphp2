<?php
    namespace App;

    use App\System\Exception;
    use App\System\Autoload;
    use App\System\DataBase;

    class App {
        /**
         * Настройки
         */
        const sittings = [
            'DataBase' => [
                //'driver'    => 'App\System\DataBase\MySQL',
                'driver'    => 'App\System\DataBase\myPDO',
                'server'    => 'localhost',
                'base'      => 'mysqitedb',
                'user'      => 'mysql',
                'password'  => 'mysql',
                'ENGINE'    => 'InnoDB',
                'CHARSET'   => 'utf8'
            ]
        ];

        /**
         *  Объект драйвера базы данных
         */
        public $DB;
        private $start;

        /**
         *  App constructor. Инициализация приложения
         */
        public function __construct() {
            $this->start = microtime(true);
            self::autoload(); // Загрузчик классов

            /*
            Exception::add(__FILE__, "Новое исключение 1");
            Exception::add(__FILE__, "Новое исключение 2");
            Exception::printList();
            */

            // Подключение к базе данных
            $dataBaseDriver = self::sittings['DataBase']['driver'];
            $this->DB = new $dataBaseDriver(
                self::sittings['DataBase']['server'],
                self::sittings['DataBase']['base'],
                self::sittings['DataBase']['user'],
                self::sittings['DataBase']['password']
            );

            if(!$this->DB) {
                Exception::fail(__FILE__, "Неполадки с драйвером данных");
            };
        }

        /**
         *  Инициализируем загрузчик классов
         */
        protected static function autoload() {
            include __DIR__ . "/System/Autoload.php";
            spl_autoload_register([new Autoload(), 'loadClass']);
        }


        public function end() {
            $this->DB->destroy();
            echo "Выполнено за " . round(microtime(true) - $this->start, 4) . " сек.";
        }
    }