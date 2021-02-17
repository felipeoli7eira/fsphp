<?php

    namespace Source\Models;

    use PDOException;

    abstract class Model
    {
        /** @var object|null $data */
        protected $data;

        /** @var PDOException $fail */
        protected $fail;

        /** @var string|null $message */
        protected $message;

        /**
         * Get the value of data
         * @return null|object
         */
        public function data(): ?object
        {
            return $this->data;
        }

        /**
         * Get the value of fail
         * @return PDOException
         */
        public function fail(): PDOException
        {
            return $this->fail;
        }

        /**
         * Get the value of message
         * @return null|string
         */
        public function message(): ?string
        {
            return $this->message;
        }

        protected function create()
        {

        }

        protected function read()
        {
            
        }

        protected function update()
        {
            
        }

        protected function delete()
        {
            
        }

        protected function safe(): ?array
        {

        }

        private function filter()
        {
            
        }
    }