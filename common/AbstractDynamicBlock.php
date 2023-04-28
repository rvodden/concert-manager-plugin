<?php

namespace uk\org\brentso\concertmanagement\common;

abstract class AbstractDynamicBlock {

    protected $namespace;

    function __construct($namespace)
    {
        $this->namespace = $namespace;   
    }

    public function register() {
        $class_name = $this->class_name();
        $dir = __DIR__ . "/blocks/" . $class_name;
        $asset_file = include($dir . "/" . $class_name . ".asset.php");

        $block_name = $this->namespace . "/" . str_replace('_', '-', $class_name);

        error_log("Registering " . $block_name . " : " . $dir);
        $block = register_block_type($dir, array(
            'render_callback' => [$this, 'render']
        ));
        if (! $block) {
            error_log("Registration failed.");
        }
        // print_r($block);
    }

    protected function class_name() : string {
        $class_name = (new \ReflectionClass($this))->getShortName();
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class_name));
    }

    abstract protected function render( $block_attributes );
}

?>