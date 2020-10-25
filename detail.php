<?php

/**
 * @brief   一枚のノート表示
 * @version $Id: detail.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
include '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once './class/global.php';

require_once 'exForm/Form.php';    // クラスメソッドを使うために読む

// id を読んでテンプレートに渡すだけなので、
// すべてコントローラ内で書きます

$id = exAbstractActionForm::getPositive($_GET['id']);
if (!$id) {
    redirect_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}

// 記事を読む
$handler = &bxNotepad::getHandler('note');
$note = &$handler->get($id);

// 読めなければエラー
if (!is_object($note)) {
    request_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}

// 権限の確認
if (is_object($xoopsUser)) {
    if (!$xoopsUser->isAdmin() && $xoopsUser->uid != $note->getVar('uid') && !$note->getVar('public')) {
        request_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
    }
} elseif (!$note->getVar('public')) {
    redirect_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}

// View 層処理
$GLOBALS['xoopsOption']['template_main'] = 'bxnotepad_detail.html';
$xoopsTpl->assign('item', $note->getStructure());

require XOOPS_ROOT_PATH . '/footer.php';
