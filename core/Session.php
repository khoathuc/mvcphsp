<?php 
    namespace app\core;
    /**
     * class Session
     * @package app\core
     */
    class Session{
        protected const FLASH_KEY = 'flash_message';
        public function __construct()
        {
            session_start();
        }
        public function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        public function get($key)
        {
            return $_SESSION[$key] ?? false;
        }

        public function remove($key)
        {
            unset($_SESSION[$key]);
        }

    }