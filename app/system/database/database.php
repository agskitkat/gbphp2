<?php
    namespace App\System\DataBase;

    interface DataBase {
        public function __construct();

        public function create($model, array $fields);

        public function getById($model, $id);

        public function getList($model, array $fields);

        public function update($model, $id, array $fields);

        public function remove($model, $id);

        public function destroy();
    }