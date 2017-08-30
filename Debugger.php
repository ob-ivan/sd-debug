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
            print '<pre>' . $this->makeLogString($values) . "</pre>\n";
        }
    }

    public function log(...$values) {
        if ($this->isDebug) {
            error_log($this->makeLogString($values));
        }
    }

    public function printTrace(...$values) {
        if ($this->isDebug) {
            print new \Exception($this->stringify($values));
        }
    }

    private function makeLogString(array $values) {
        return implode(': ', array_filter([$this->getCallerInfo(), $this->stringify($values)]));
    }

    private function getCallerInfo(): string {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
        $functionInfo = array_pop($backtrace);
        $fileInfo = array_pop($backtrace);
        return implode(':', [
            $fileInfo['file'],
            $fileInfo['line'],
            (isset($functionInfo['class'])
                ? $functionInfo['class'] . $functionInfo['type']
                : ''
            ) . $functionInfo['function']
        ]);
    }

    private function stringify($values): string {
        return implode(
            ', ',
            array_map(
                function ($value) { return print_r($value, true); },
                $values
            )
        );
    }
}
