<?php

/**
 * @file
 * @brief   フォルダー投稿時の確認 & CSRF ガード
 * @author  minahito
 * @version $Id: folder_confirm.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */

// nocommon を使用することでセッションの自動スタートを防ぐ
$xoopsOption['nocommon'] = true;
require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php';
require_once './class/global.php';

// ユーザー側で使用する Confirm 画面で一番便利なコンポーネントを使用する
require_once 'exComponent/confirm/TypicalConfirm.php';
// 典型的なインサートプロセッサーを使用する
require_once 'exComponent/confirm/processor/TypicalConfirmInsertProcessor.php';

// セッションから復元するための Form 等を読み込む
require_once './include/FolderEditForm.php';
require_once './class/folder.php';

// Confirm に渡すためのレンダーモデル・ロジックが書かれたファイルを読み込む
require_once './include/FolderConfirm.php';

// セッション開始
require_once XOOPS_ROOT_PATH . '/include/common.php';
require_once XOOPS_ROOT_PATH . '/header.php';

require_once 'exConfig/ForwardConfig.php';

$forwards = [
    new exSuccessForwardConfig(EXFORWARD_REDIRECT, 'index.php', _MD_BXNOTEPAD_LANG_DB_SUCCESS),
    new exFailForwardConfig(EXFORWARD_REDIRECT, 'index.php', _MD_BXNOTEPAD_LANG_DB_FAIL),
];

$compo = new exTypicalConfirmComponent(
    new TypicalConfirmFormInsertProcessor(),
    new exConrimComponentModelRender(new FolderConfirmRenderModel()),
    'edit_folder',
    new exBeanConfirmTicketForm(),
    $forwards
);

switch ($ret = $compo->init(session::postPop('edit_folder'), $handler = bxNotepad::getHandler('folder'))) {
    case COMPONENT_INIT_FAIL:
        xoops_error('FATAL ERROR');
        break;
    default:
        $compo->display();
        break;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
