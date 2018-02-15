<?php
use SD\Debugger\Debugger;

function debug($isDebug = false) {
    return Debugger::getInstance($isDebug);
}
