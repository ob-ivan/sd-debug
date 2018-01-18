<?php
namespace SD\Debugger;

trait IsDebugAwareTrait {
    private $autoDeclareIsDebug = 'isDebug';
    private $isDebug;

    public function setIsDebug(bool $isDebug) {
        $this->isDebug = $isDebug;
    }

    public function getIsDebug(): bool {
        return $this->isDebug;
    }
}
