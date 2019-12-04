<?php
    namespace App\System\DataBase;

    use App\System\Exception;

    class MySQL implements DataBase {
        protected $link, $result;

        public function __construct($server = 'localhost', $database = 'mysql',  $user = 'user',  $password = 'password') {
            if($this->connection($server, $database,  $user,  $password)) {
                return $this;
            } else {
                return false;
            }
        }

        /**
         * Вызов соединения с базой данных
         * @param string $server
         * @param string $database
         * @param string $user
         * @param string $password
         * @return boolean
         */
        public function connection($server = 'localhost', $database = 'mysql',  $user = 'user',  $password = 'password') {

            if(!function_exists('mysqli_connect')) {
                Exception::add(__FILE__, "MySQL не доступна на сервере !");
                return false;
            }

            $this->link = mysqli_connect($server, $user, $password);
            if (!$this->link) {
                Exception::add(__FILE__, "Не удалось подключиться к сервису MySQL !");
                return false;
            }

            $selected =  mysqli_select_db($this->link,$database);
            if (!$selected) {
                Exception::add(__FILE__, "Не удалось подключиться к базе данных $database !");
                return false;
            }

            return true;
        }

        /**
         * Делаем запрос к базе
         * @param $queryStirng
         * @return bool
         */
        public function query( $queryStirng ) {
            // TODO: Implement query() method.
            if($this->link && !empty($queryStirng)) {
                if(!$this->result = mysqli_query($this->link, $queryStirng))  {
                    Exception::add(__FILE__, "Ошибка запроса " . PHP_EOL . $queryStirng . PHP_EOL . $this->link->error);
                    return false;
                }
                return true;
            } else {
                Exception::add(__FILE__, "База не подключена или запрос пуст.");
                return false;
            }
        }


        /**
         * @param $tableName
         * @param $fields
         * @return mixed
         */
        public function createTable($tableName, $fields) {
            $query = "IF EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = N'$tableName')";

            if(!$this->query($query)) {

                $query = "CREATE TABLE `{$tableName}` (";
                $query .= '`id` int(255) NOT NULL,';
                $query .= '`create_at` datetime NOT NULL DEFAULT current_timestamp(),';
                $query .= '`updete_at` datetime NOT NULL DEFAULT current_timestamp(),';
                $query .= implode(",",  $fields);
                $query .= ");";

                if(!$result = $this->query($query)) {
                    return false;
                };

                // Add primary key
                if(!$result =  $this->query("ALTER TABLE `{$tableName}` ADD PRIMARY KEY (`id`);")) {
                    return false;
                };

                // ID auto increment
                if(!$result =  $this->query("ALTER TABLE `{$tableName}` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;")) {
                    return false;
                };
            }
            return true;
        }

        public function create($tableName, array $fields) {
            global $App;

            $query = "INSERT INTO `" . $tableName. "`";

            $query_fields = [];
            $query_values = [];

            foreach($fields as $key => $field) {
                $query_fields[] = "`$key`";
                $query_values[] = "'$field'";
            }

            $query .= " (" . implode(",", $query_fields) . ")";
            $query .= " VALUES (" . implode(",", $query_values) . ");";

            if(!$result = $this->query($query)) {
                return false;
            }

            return $result;
        }

        public function getById($tableName, $id)
        {
            // TODO: Implement getById() method.
        }

        public function getList($tableName, array $fields)
        {
            // TODO: Implement getList() method.
        }

        public function update($tableName, $id, array $fields)
        {
            // TODO: Implement update() method.
        }

        public function remove($tableName, $id)
        {
            // TODO: Implement remove() method.
        }

        public function destroy() {
            mysqli_close( $this->link );
        }
    }