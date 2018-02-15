<?php
use SD\Debug\Debugger;

function debug($isDebug = false) {
    return Debugger::getInstance($isDebug);
}
