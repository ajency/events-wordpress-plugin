<?php

class Ajency_Events_Render_Shortcode_Template {

        private $args;
        private $file;

        public function __get($name) {
            return $this->args[$name];
        }

        public function __construct($file, $args = array()) {
            $this->file = $file;
            $this->args = $args;
        }

        public function __isset($name){
            return isset( $this->args[$name] );
        }

        public function render() {

                //Better way of not hardcoding path?
                $template = plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/templates/'.$this->file;
                include( $template );
        }
}