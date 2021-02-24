<?php

    namespace Source\Models;

    use Source\Core\Model;

    class User extends Model
    {
        /** @var array $safe */
        protected static $safe = ['id', 'created_at', 'updated_at'];

        /** @var string $entity */
        protected static $entity = 'users';

        public function bootstrap(string $firstName, string $lastName, string $email, string $document = null): ?User
        {
            $this->first_name = $firstName;
            $this->last_name = $lastName;
            $this->email = $email;
            $this->document = $document;

            return $this;
        }

        public function load(int $id, string $columns = '*'): ?User
        {
            $load = $this->read("SELECT {$columns} FROM ". self::$entity ." WHERE id = :id", "id={$id}");

            if ($this->fail || ! $load->rowCount())
            {
                $this->message = "Nenhum resultado encontrado para o ID informado";
                return null;
            }

            return $load->fetchObject(__CLASS__);
        }

        public function find(string $email, string $columns = '*'): ?User
        {
            $find = $this->read("SELECT {$columns} FROM ". self::$entity ." WHERE email = :email", "email={$email}");

            if ($this->fail || !$find->rowCount())
            {
                $this->message = "Nenhum resultado encontrado para o e-mail informado";
                return null;
            }

            return $find->fetchObject(__CLASS__);
        }

        public function all(int $limit = 30, int $offset = 0, string $columns = '*'): ?array
        {
            $all = $this->read("SELECT {$columns} FROM ". self::$entity ." LIMIT :limit OFFSET :offset", "limit={$limit}&offset={$offset}");

            if ($this->fail || !$all->rowCount())
            {
                $this->message = "Nenhum resultado retornado";
                return null;
            }

            return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        }

        public function save(): ?User
        {
            if (! $this->required())
            {
                return null;
            }

            if ( !empty($this->id)) # Update
            {
                $userID = $this->id;

                $emailExists = $this->read("SELECT id from " . self::$entity . " WHERE email = :email AND id != :id", "email={$this->email}&id={$userID}");

                if ($emailExists->rowCount())
                {
                    $this->message = 'O e-mail informado já está cadastrado';
                    return null;
                }

                $this->update(self::$entity, $this->safe(), "id = :id", "id={$userID}");

                if ($this->fail())
                {
                    $this->message = 'Erro ao atualizar, verifique os dados';
                }

                $this->message = 'Recurso atualizado';
            }


            if (empty($this->id)) # create
            {
                if ( $this->find ($this->email)) # email exists
                {
                    $this->message = 'O e-mail informado já está cadastrado';
                    return null;
                }

                $userID = $this->create(self::$entity, $this->safe());

                if ($this->fail())
                {
                    $this->message = 'Erro ao cadastrar, verifique os dados';
                }

                $this->message = 'Registro criado';
            }

            $this->data = $this->read('SELECT * FROM ' . self::$entity . ' WHERE id = :id', "id={$userID}")->fetch();

            return $this;
        }

        public function destroy(): ?User
        {
            if (! empty($this->id))
            {
                $this->delete(self::$entity, 'id = :id', "id={$this->id}");
            }

            if ($this->fail())
            {
                $this->message = 'Erro ao deletar recurso';
                return null;
            }

            $this->message = 'Recurso deletado';
            $this->data = null;

            return $this;
        }

        private function required(): bool
        {
            if (empty( $this->first_name) || empty( $this->last_name) ||empty( $this->email))
            {
                $this->message = 'Nome, Sobrenome e e-mail são obrigatórios';
                return false;
            }

            if (! filter_var($this->email, FILTER_VALIDATE_EMAIL))
            {
                $this->message = 'O e-mail não está em um formato válido';
                return false;
            }

            return true;
        }
    }