<?php

    namespace Source\Core;

    use PDOException;

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
        
        /**
         * @param string $entity [table name]
         * @param array $data [values for insert on the table]
         *
         * @return null|int
         */
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
        
        /**
         * @param string $query [SELECT query]
         * @param string $params [params for mout the query]
         *
         * @return null|PDOStatement
         */
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
        
        /**
         * @param string $entity [table name]
         * @param array $data [values for update]
         * @param string $terms [WHERE clousure]
         * @param string $params [bind values]
         *
         * @return null|int
         */
        protected function update(string $entity, array $data, string $terms, string $params): ?int
        {
            try
            {
                $arrayLinks = [];

                foreach ($data as $columnName => $value)
                {
                    $arrayLinks[] = "{$columnName} = :{$columnName}";
                }

                $strLinks = implode(", ", $arrayLinks);

                $updateQueryString = "UPDATE {$entity} SET {$strLinks} WHERE {$terms}";

                parse_str($params, $params);

                $stmt = Connect::getInstance()->prepare($updateQueryString);

                $stmt->execute(
                    $this->filter(
                        array_merge($data, $params)
                    )
                );

                return $stmt->rowCount() ?? 1;
            }
            catch (PDOException $exception)
            {
                $this->fail = $exception;
                return null;
            }
        }
        
        /**
         * @param string $entity []
         * @param string $terms []
         * @param string $params []
         *
         * @return null|int
         */
        protected function delete(string $entity, string $terms, string $params): ?int
        {
            try
            {
                $stmt = Connect::getInstance()->prepare("DELETE FROM {$entity} WHERE {$terms}");
                parse_str($params, $params);
                $stmt->execute($params);

                return $stmt->rowCount() ?? 1;
            }
            catch (PDOException $exception)
            {
                $this->fail = $exception;
                return null;
            }
        }
        
        /**
         * @return null|array
         */
        protected function safe(): ?array
        {
            $arrayData = (array) $this->data;

            foreach (static::$safe as $name)
            {
                unset ( $arrayData[ $name ] );
            }

            return $arrayData;
        }

        /**
         * @return null|array
         */
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