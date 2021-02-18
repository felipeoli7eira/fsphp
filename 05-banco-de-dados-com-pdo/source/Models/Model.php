<?php

    namespace Source\Models;

    use PDOException;
    use Source\Database\Connect;

    abstract class Model
    {
        /** @var object|null $data */
        protected $data;

        /** @var PDOException $fail */
        protected $fail;

        /** @var string|null $message */
        protected $message;

        public function __set(string $name, $value)
        {
            if (is_null($this->data))
            {
                $this->data = new \stdClass();
            }

            $this->data->$name = $value;
        }

        public function __get(string $name)
        {
            return $this->data->$name ?? null;
        }

        public function __isset(string $name)
        {
            return isset($this->data->$name);
        }

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
        public function fail(): ?PDOException
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

        protected function create(string $entity, array $data): ?int
        {
            try
            {
                $columns = implode(', ', array_keys($data));
                $values = ':' . implode(', :', array_keys($data));

                $query = "INSERT INTO {$entity} ({$columns}) VALUES ({$values})";

                $stmt = Connect::getInstance()->prepare($query);

                $stmt->execute( $this->filter( $data));

                return Connect::getInstance()->lastInsertId();
            }
            catch (PDOException $exception)
            {
                $this->fail = $exception;
                return null;
            }
        }

        protected function read(string $query, string $params = null): ?\PDOStatement
        {
            try
            {
                $stmt = Connect::getInstance()->prepare($query);

                if (! is_null($params))
                {
                    parse_str($params, $params);

                    foreach ($params as $paramKey => $paramValue)
                    {
                        $bindType = is_numeric($paramValue) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                        $stmt->bindValue(":{$paramKey}", $paramValue, $bindType);
                    }
                }

                $stmt->execute();

                return $stmt;
            }
            catch (PDOException $exception)
            {
                $this->fail = $exception;
                return null;
            }
        }

        protected function update()
        {
            
        }

        protected function delete()
        {
            
        }

        protected function safe(): ?array
        {
            $arrayData = (array) $this->data;

            foreach (static::$safe as $name)
            {
                unset ( $arrayData[ $name ] );
            }

            return $arrayData;
        }

        protected function filter(array $data): ?array
        {
            $filter = [];

            foreach ($data as $key => $value)
            {
                $filter [ $key ] = is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS) ;
            }

            return $filter;
        }
    }