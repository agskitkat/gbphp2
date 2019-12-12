<?php
    namespace App\System;

    /**
     * CRUD model base
    */
    abstract class Model {
        protected static $tableName;

        abstract public function getTableName(): string;

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
        function createTable(Array $tableFields = []) {
            global $App;
            return $App->DB->createTable($this->getTableName(), $tableFields);
        }

        /**
         * Добавляет запись модели
         * @return bool
         */
        function insert() {
            global $App;
            $fields = $this->getData();
            $goodId = $App->DB->insert($this->getTableName(), $fields);
            return self::find(array(["ID:=" => $goodId]));
        }

        /**
         * Обновить по ID
         * @return bool
         */
        function update() {
            global $App;
            $fields = $this->getData();
            $goodId = $App->DB->update($this->getTableName(), $this->id, $fields);

            $this->setData(
                $App->DB->getById($this->getTableName(), $goodId)
            );

            return true;
        }

        /**
         * Реализация save
         * @param array $fields
         * @return array
         */
        function find($fields) {
            global $App;
            $items = $App->DB->find($this->getTableName(), $fields);
            $items =  $items['ITEMS'];
            if(count($items) > 1) {
                $return = [];
                foreach($items as $item) {
                    $this->setData($item);
                    $return[] = clone $this;
                }
                return $return;
            }
            $this->setData($items);
        }

        /**
         * Реализация save
         * @param array $fields
         * @return bool
         */
        function getById($id) {
            global $App;
            $this->setData($App->DB->getById($id));
        }

        /**
         * Реализация save
         * @return bool
         */
        function save() {
            global $App;
            $fields = $this->getData();
            if(!$this->id) {
                $goodId = $App->DB->insert($this->getTableName(), $fields);
                $this->setData(
                    $App->DB->getById($this->getTableName(),  $goodId)
                );
                return true;
            } else {
                $goodId = $App->DB->update($this->getTableName(), $this->id, $fields);
                $this->setData(
                    $App->DB->getById($this->getTableName(), $goodId)
                );
                return true;
            }
        }

        /**
         * Свойства объекта в массив
         * @return array
         */
        function getData() {
            $fields = [];
            foreach($this as $key => $val) {
                if( $key != "id") {
                    $fields[$key] = $val;
                }
            }
            return $fields;
        }

        /**
         * Устанавливаем состояние объекта из массива
         * @param $fields
         * @return void
         */
        function setData($fields) {
            if($fields) {
                foreach ($fields as $key => $val) {
                    $this->{$key} = $val;
                }
            }
        }

        /**
         * Удаление
         */
        function remove($id) {
            global $App;
            return $App->DB->remove($this->getTableName(), $id);
        }
    }