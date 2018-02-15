<?php
use SD\Debugger\Debugger;

/**
 * Usage:
 *  debug()->enable(isset($_GET['debug']));
 *  debug()->pre('ids', $ids); // only print if debug is enabled
 *  debug()->log('ids', $ids);
 *  debug(true)->log('ids', $ids); // always log
**/
function debug($isDebug = false) {
    return Debugger::getInstance($isDebug);
}
