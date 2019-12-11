<?php


namespace App\System\DataBase;
use App\System\Exception;
use PDO;
use PDOException;

class myPDO implements DataBase {
    /**
     * @var PDO
     */
    private $db;

    /**
     * DataBase constructor.
     * @param string $server
     * @param string $database
     * @param string $user
     * @param string $password
     */
    public function __construct($server = 'localhost', $database = 'mysql',  $user = 'user',  $password = 'password') {
        $dsn = 'mysql:dbname='.$database.';host='.$server;
        try {
            $this->db = new PDO($dsn, $user, $password);
            $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            Exception::fail(__FILE__, 'Подключение не удалось: ' . $e->getMessage());
        }
    }

    /**
     * Метод создания записи модели
     * @param $model :название модели (таблица SQL или имя файла)
     * @param array $fields :ассоциативный массив данных модели
     * @return mixed false or new id
     */
    public function insert($model, array $fields) {
        $query = "INSERT INTO `" . $model. "`";

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

        return $this->db->lastInsertId();
    }

    /**
     * Получить запись модели по уникальному значению
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     * @return bool
     */
    public function getById($model, $id) {
        $query = "SELECT * FROM `" . $model. "` WHERE `id` = :id;";
        if(!$result = $this->query($query, [':id'=>$id])) {
            return  $query;
        }
        return $result->fetch();
    }

    /**
     * @param $model :название модели (таблица SQL или имя файла)
     * @param array $fields :поля для назначения условий поиска(фильтр)
     * где ключ "оператор" . "код_значения" => "значение"
     * TODO: реализовать операторы
     * Для начала можно реализовать операторы =, !=, <, >
     * Потом доработать сложные, например BETWEEN или `Частичное вхождение`
     * @return mixed
     */
    public function find($model, array $fields) {
        $query = "SELECT * FROM `".$model."` ";

        if(count($fields)) {
            $WHERE = [];
            foreach($fields as $field) {
                $value = $field[key($field)];
                $arKeyAndOperator = explode(":", key($field));
                if(count($arKeyAndOperator) == 2) {
                    $operator = $arKeyAndOperator[1];
                    $key = $arKeyAndOperator[0];
                } else {
                    $operator = "=";
                    $key = key($field);
                }

                $WHERE[] = "`$key` " .  $operator . " '" . $value ."'";
            }
            $query .= "WHERE " . implode(",", $WHERE) . ";";
        }

        if(!$result = $this->db->query($query)) {
            return false;
        }

        if($result->rowCount() > 1) {
            return ["ITEMS" => $result->fetchAll(PDO::FETCH_ASSOC)];
        } else {
            return  ["ITEMS" => [$result->fetch()]];
        }
    }

    /**
     * Обновление определённой записи
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     * @param array $fields :ассоциативный массив данных модели
     * @return bool
     */
    public function update($model, $id, array $fields) {
        $arSet = [];
        foreach($fields as $key => $val) {
            $arSet[] = "$key = '$val'";
        }
        $set = implode(', ', $arSet);

        $query = "UPDATE `{$model}` SET {$set} WHERE id = {$id};";

        if(!$result = $this->db->query($query)) {
            return false;
        }

        return $this->getById($model, $id);
    }

    /**
     * Удаление записи
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     * @return bool
     */
    public function remove($model, $id) {
        if(!$id) {
            return false;
        }
        $query = "DELETE FROM `{$model}` WHERE id = {$id};";
        if( !$result = $this->db->query($query) ) {
            return false;
        }
        return true;
    }

    /**
     *  Метод завершения работы с моделью
     *  Например закрытие файлов или сессий баз данных
     *  Вызывается в конце приложения
     */
    public function destroy() {
        return true;
    }

    /**
     *  Делаем запрос
     */
    private function query($query, $params = []) {
        try {
            $sth = $this->db->prepare($query);
            $sth->execute($params);
            return $sth;
        } catch(PDOException $e) {
            Exception::add(__FILE__, 'Запрос не удался: ' . $e->getMessage());
            return false;
        }
    }

    /**
     *  Создаёт хранилище или таблицу
     * @param $model
     * @param array $fields
     * @return bool
     */
    public function createTable($model, array $fields) {
        $query = "IF EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = N'$model')";

        if(!$this->query($query)) {
            $query = "CREATE TABLE `{$model}` (";
            $query .= '`id` int(255) NOT NULL,';
            $query .= '`create_at` datetime NOT NULL DEFAULT current_timestamp(),';
            $query .= '`updete_at` datetime NOT NULL DEFAULT current_timestamp(),';
            $query .= implode(",", $fields);
            $query .= ");";

            if(!$result = $this->query($query)) {
                Exception::add(__FILE__, 'Таблица '.$model.' не создана');
                return false;
            }

            // Add primary key
            if(!$result =  $this->query("ALTER TABLE `{$model}` ADD PRIMARY KEY (`id`);")) {
                Exception::add(__FILE__, 'Не создан ключ');
                return false;
            };

            // ID auto increment
            if(!$result =  $this->query("ALTER TABLE `{$model}` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;")) {
                Exception::add(__FILE__, 'Не добавлен автоинкремент');
                return false;
            };
        }
        return true;
    }
}