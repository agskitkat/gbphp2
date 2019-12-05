<?php
    namespace App\System;

    /**
     * CRUD model base
    */
    class Model {
        protected static $tableName;

        /**
         * Создание таблицы для модели
         * TODO: Сделать миграции
         * @param $tableName
         * @param array $tableFields Массив SQL строк полей таблицы
         * @return bool
         * @example createTable('User', [
         * "PersonID int",
         * "LastName varchar(255)",
         * "FirstName varchar(255)',
         * "Address varchar(255)",
         * "City varchar(255)"
         * ])
         */
        static function createTable($tableName, Array $tableFields = []) {
            global $App;
            return $App->DB->createTable($tableName, $tableFields);
        }


        /**
         * Добавляет запись модели
         * @param array $fields
         * @return bool
         */
        static function add($fields) {
            global $App;
            $goodId = $App->DB->create(self::$tableName, $fields);
            return self::find(array(["ID:=" => $goodId]));
        }


        /**
         * Реализация save
         * @param array $fields
         * @return bool
         */
        static function find($fields) {
            global $App;
            return $App->DB->find(self::$tableName, $fields);
        }

        /**
         * Реализация save
         * @param array $fields
         * @return bool
         */
        static function save($fields) {
            global $App;
            if(!$fields['ID']) {
                $App->DB->create(self::$tableName, $fields);
            } else {
                $App->DB->update(self::$tableName, $fields['ID'], $fields);
            }
        }
    }