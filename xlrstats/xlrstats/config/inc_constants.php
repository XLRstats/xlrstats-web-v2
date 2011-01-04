<?php
if (DIRECTORY_SEPARATOR == '/') {
    $tmp = dirname(dirname(__FILE__)) . '/';
    } else {
    $tmp = str_replace('\\', '/', dirname(dirname(__FILE__))) . '/';
}
define('XLRSTATS_ROOT_DIR', $tmp);
?>