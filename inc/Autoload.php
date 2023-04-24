<?php
    /**
     * Class Autoload
     */
    class Autoload {

        /**
         * Autoload constructor.
         */
        public function __construct() {
            spl_autoload_extensions('.class.php,.trait.php');
            spl_autoload_register(array($this, 'load'));
        }

        /**
         * @param $className
         */
        private function load($className) {
            $extensions = explode(',', spl_autoload_extensions());
            if(isset($extensions) && is_array($extensions)){
                foreach ($extensions as $ext){
                    if(file_exists(CustomerPATH . '/inc/' . $className . $ext)){
                        require_once (CustomerPATH . '/inc/' . $className . $ext);
                    }
                }
            }
        }

    }