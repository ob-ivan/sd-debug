<?php
namespace SD\Debugger;

class Debugger {
    const SERIALIZER_PRINT_R     = 'print_r';
    const SERIALIZER_VAR_EXPORT  = 'var_export';
    const SERIALIZER_SERIALIZE   = 'serialize';
    const SERIALIZER_JSON_ENCODE = 'json_encode';

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

    public function preExport(...$values) {
        if ($this->isDebug) {
            print '<pre>' . $this->makeLogString($values, self::SERIALIZER_VAR_EXPORT) . "</pre>\n";
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

    private function makeLogString(array $values, $serializerName = self::SERIALIZER_PRINT_R) {
        return implode(': ', array_filter([$this->getCallerInfo(), $this->stringify($values, $serializerName)]));
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

    private function stringify($values, $serializerName): string {
        return implode(
            ', ',
            array_map(
                $this->getSerializerMethod($serializerName),
                $values
            )
        );
    }

    private function getSerializerMethod($serializerName): callable {
        switch ($serializerName) {
            case self::SERIALIZER_PRINT_R:      return function ($value) { return print_r($value, true); };
            case self::SERIALIZER_VAR_EXPORT:   return function ($value) { return var_export($value, true); };
            case self::SERIALIZER_SERIALIZE:    return function ($value) { return serialize($value); };
            case self::SERIALIZER_JSON_ENCODE:  return function ($value) { return json_encode($value); };
        }
    }
}
