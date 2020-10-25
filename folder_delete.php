<?php

/**
 * @file
 * @brief   指定 FID のフォルダー削除確認 & CSRF ガード
 * @author  minahito
 * @version $Id: folder_delete.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */

// nocommon を使用することでセッションの自動スタートを防ぐ
$xoopsOption['nocommon'] = true;
require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php';
require_once './class/global.php';

// ユーザー側で使用する Confirm 画面で一番便利なコンポーネントを使用する
require_once 'exComponent/confirm/TypicalConfirm.php';

// Confirm に渡すためのレンダーモデル・ロジックが書かれたファイルを読み込む
require_once './include/FolderConfirm.php';

// セッション開始
require_once XOOPS_ROOT_PATH . '/include/common.php';
require_once XOOPS_ROOT_PATH . '/header.php';

require_once 'exConfig/ForwardConfig.php';

$fid = exAbstractActionForm::getPositive($_REQUEST['fid']);    // post でも飛んでくる
if (!$fid) {
    redirect_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}

// 記事を読む
$handler = &bxNotepad::getHandler('folder');
$folder = &$handler->get($fid);

// 読めなければエラー
if (!is_object($folder)) {
    request_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}

// 権限の確認
if (is_object($xoopsUser)) {
    if (!$xoopsUser->isAdmin() && $xoopsUser->uid != $folder->getVar('uid')) {
        request_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
    }
} else {
    redirect_header('index.php', 1, _MD_BXNOTEPAD_ERROR_REQUEST);
}
// ----------------------------------------------------------------------------

$forwards = [
    new exSuccessForwardConfig(EXFORWARD_REDIRECT, 'index.php', _MD_BXNOTEPAD_LANG_DB_SUCCESS),
    new exFailForwardConfig(EXFORWARD_REDIRECT, 'index.php', _MD_BXNOTEPAD_LANG_DB_FAIL),
];

$compo = new exTypicalConfirmComponent(
    new FolderDeleteConfirmProcessor(),
    new exConrimComponentModelRender(new FolderDeleteConfirmRenderModel()),
    'delete_folder',
    new exObjectConfirmTicketForm(),
    $forwards
);

switch ($ret = $compo->init($folder)) {
    case COMPONENT_INIT_FAIL:
        xoops_error('FATAL ERROR');
        break;
    default:
        $compo->display();
        break;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
