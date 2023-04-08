<?php
    /**
     * Class Autoload
     */
    class Autoload {

        /**
         * Autoload constructor.
         */
        public function __construct() {
            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));
        }

        /**
         * @param $className
         */
        private function load($className) {
            $extension = spl_autoload_extensions();
            if(file_exists(CustomerPATH . '/inc/' . $className . $extension)){
                require_once (CustomerPATH . '/inc/' . $className . $extension);
            }
        }

    }