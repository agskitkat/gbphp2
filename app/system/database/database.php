<?php
    namespace App\System\DataBase;
    /**
     * Методы работы с хранилищем находятся тут, так как
     * хотелось отделить язык запросов от модели данных.
     * Напиример если будем хранить данные в файле а не БД
     * Просто создадим класс с интерфейсом и реализуем методы.
     */
    interface DataBase {
        /**
         * DataBase constructor.
         */
        public function __construct();

        /**
         *  Создаёт хранилище или таблицу
         * @param $model
         * @param array $fields
         */
        public function createTable($model, array $fields);

        /**
         * Метод создания записи модели
         * @param $model :название модели (таблица SQL или имя файла)
         * @param array $fields :ассоциативный массив данных модели
         * @return mixed false or new id
         */
        public function insert($model, array $fields);

        /**
         * Получить запись модели по уникальному значению
         * @param $model :название модели (таблица SQL или имя файла)
         * @param $id :уникальный идентификатор записи
         */
        public function getById($model, $id);

        /**
         * @param $model :название модели (таблица SQL или имя файла)
         * @param array $fields :поля для назначения условий поиска(фильтр)
         * где ключ "оператор" . "код_значения" => "значение"
         * TODO: реализовать операторы
         * Для начала можно реализовать операторы =, !=, <, >
         * Потом доработать сложные, например BETWEEN или `Частичное вхождение`
         */
        public function find($model, array $fields);


        /**
         * Обновление определённой записи
         * @param $model :название модели (таблица SQL или имя файла)
         * @param $id :уникальный идентификатор записи
         * @param array $fields :ассоциативный массив данных модели
         */
        public function update($model, $id, array $fields);

        /**
         * Удаление записи
         * @param $model :название модели (таблица SQL или имя файла)
         * @param $id :уникальный идентификатор записи
         */
        public function remove($model, $id);

        /**
         *  Метод завершения работы с моделью
         *  Например закрытие файлов или сессий баз данных
         *  Вызывается в конце приложения
         */
        public function destroy();
    }