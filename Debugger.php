<?php
namespace SD\Debugger;

class Debugger {
    private static $instance;
    private $isDebug = false;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

    public function enable(bool $isDebug) {
        $this->isDebug = $isDebug;
        if ($isDebug) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        }
    }

    public function pre(...$values) {
        if ($this->isDebug) {
            print '<pre>' . $this->stringify($values) . "</pre>\n";
        }
    }

    public function log(...$values) {
        if ($this->isDebug) {
            error_log($this->stringify($values));
        }
    }

    private function stringify($values) {
        return implode(
            ', ',
            array_map(
                function ($value) { return print_r($value, true); },
                $values
            )
        );
    }
}
