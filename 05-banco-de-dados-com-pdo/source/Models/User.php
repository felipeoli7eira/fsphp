<?php

    namespace Source\Models;

    use Source\Models\Model;

    class User extends Model
    {
        /** @var array $safe */
        protected static $safe = ['id', 'createed_at', 'updated_at'];

        /** @var string $entity */
        protected $entity = 'users';

        public function bootstrap()
        {

        }

        public function load(int $id)
        {
            
        }

        public function find(string $email)
        {
            
        }

        public function all(int $limit = 30, int $offset = 0)
        {
            
        }

        public function save()
        {
            
        }

        public function destroy()
        {
            
        }

        private function required()
        {
            
        }
    }