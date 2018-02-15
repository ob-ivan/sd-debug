<?php
namespace SD\Debug;

trait IsDebugAwareTrait
{
    protected $autoDeclareIsDebug = 'isDebug';
    private $isDebug;

    public function setIsDebug(bool $isDebug) {
        $this->isDebug = $isDebug;
    }

    public function getIsDebug(): bool {
        return $this->isDebug;
    }
}
