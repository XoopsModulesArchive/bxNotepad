<?php

if (!file_exists(XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php')) {
    print 'FATAL ERROR : exFrame not installed';

    die;
} elseif (!file_exists(XOOPS_ROOT_PATH . '/modules/exFrame/version.php')) {
    print 'FATAL ERROR : exFrame version error';

    die;
}
    require_once XOOPS_ROOT_PATH . '/modules/exFrame/version.php';
