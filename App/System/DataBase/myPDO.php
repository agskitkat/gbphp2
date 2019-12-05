<?php


namespace App\System\DataBase;
use App\System\Exception;
use PDO;

class myPDO extends PDO implements DataBase {

    /**
     * DataBase constructor.
     * @param string $server
     * @param string $database
     * @param string $user
     * @param string $password
     */
    public function __construct($server = 'localhost', $database = 'mysql',  $user = 'user',  $password = 'password') {
        return false;
    }

    /**
     * Метод создания записи модели
     * @param $model :название модели (таблица SQL или имя файла)
     * @param array $fields :ассоциативный массив данных модели
     * @return mixed
     */
    public function create($model, array $fields) {
        // TODO: Implement create() method.
    }

    /**
     * Получить запись модели по уникальному значению
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     */
    public function getById($model, $id) {
        // TODO: Implement getById() method.
    }

    /**
     * @param $model :название модели (таблица SQL или имя файла)
     * @param array $fields :поля для назначения условий поиска(фильтр)
     * где ключ "оператор" . "код_значения" => "значение"
     * TODO: реализовать операторы
     * Для начала можно реализовать операторы =, !=, <, >
     * Потом доработать сложные, например BETWEEN или `Частичное вхождение`
     */
    public function getList($model, array $fields) {
        // TODO: Implement getList() method.
    }

    /**
     * Обновление определённой записи
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     * @param array $fields :ассоциативный массив данных модели
     */
    public function update($model, $id, array $fields) {
        // TODO: Implement update() method.
    }

    /**
     * Удаление записи
     * @param $model :название модели (таблица SQL или имя файла)
     * @param $id :уникальный идентификатор записи
     */
    public function remove($model, $id) {
        // TODO: Implement remove() method.
    }

    /**
     *  Метод завершения работы с моделью
     *  Например закрытие файлов или сессий баз данных
     *  Вызывается в конце приложения
     */
    public function destroy() {
        // TODO: Implement destroy() method.
    }
}