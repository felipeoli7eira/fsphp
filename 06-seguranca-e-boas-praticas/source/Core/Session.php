<?php

    namespace Source\Core;

    class Session
    {
        public function __construct()
        {
            if (! session_id())
            {
                session_save_path(CONF_SESSION_PATH);
                session_start();
            }
        }

        /**
         * @return null|mixed
        */
        public function __get(string $name)
        {
            if (!empty($_SESSION[$name]))
            {
                return $_SESSION[$name];
            }

            return null;
        }

        public function __isset(string $name): bool
        {
            return $this->has($name);
        }

        public function all(): ?object
        {
            return (object) $_SESSION;
        }

        public function set(string $keySession, $valueSession): Session
        {
            $_SESSION[ $keySession ] = (
                is_array($valueSession) ?
                    (object) $valueSession
                :
                    $valueSession
            );

            return $this;
        }

        public function unset(string $key): Session
        {
            unset($_SESSION[ $key ]);
            return $this;
        }

        public function has(string $key): bool
        {
            return isset($_SESSION[$key]);
        }

        public function regenerate(): Session
        {
            session_regenerate_id(true);
            return $this;
        }

        public function destroy(): Session
        {
            session_destroy();

            return $this;
        }

        public function flash(): ?Message
        {
            if ($this->has('flash'))
            {
                $saveFlash = $this->flash;
                $this->unset('flash');

                return $saveFlash;
            }

            return null;
        }
    }