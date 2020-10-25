<?php

/**
 * @file
 * @brief  xoops 用 module 設定ファイル
 * @author minahito
 */
$modversion['name'] = _MI_BXNOTEPAD_NAME;
$modversion['version'] = 0.01;
$modversion['description'] = _MI_BXNOTEPAD_DESC;

$modversion['credits'] = 'minahito';
$modversion['author'] = 'minahito';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'images/bxNotepad.gif';
$modversion['dirname'] = 'bxNotepad';

// Sql
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Table
$modversion['tables'][0] = 'bxnotepad_note';
$modversion['tables'][1] = 'bxnotepad_folder';

// Template
$modversion['use_smarty'] = 1;
$modversion['templates'][0]['file'] = 'bxnotepad_index.html';
$modversion['templates'][0]['description'] = '';
$modversion['templates'][1]['file'] = 'bxnotepad_detail.html';
$modversion['templates'][1]['description'] = '';

// Admin
$modversion['hasAdmin'] = 0;

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][0]['name'] = _MI_BXNOTEPAD_SUBMENU1;
$modversion['sub'][0]['url'] = 'submit.php';
$modversion['sub'][1]['name'] = _MI_BXNOTEPAD_SUBMENU2;
$modversion['sub'][1]['url'] = 'folder.php';
