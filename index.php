<?php

/**
 * @brief   ノートの一覧表示
 * @version $Id: index.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
include '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php';
require XOOPS_ROOT_PATH . '/header.php';

// 代表的なファイルなのでチェックだけ入れておく
require_once './framechecker.php';
__exframe_version__('0.8.6');

require_once './class/global.php';

require_once 'include/ListController.php';
require_once './include/NotepadFilter.php';

// 適正なフィルターの設定
$filter = is_object($xoopsUser) ? new UserNotepadFilter() : new GuestNotepadFilter();

// ハンドラの取得
$handler = &bxNotepad::getHandler('note');

// リストコントローラの初期化
$listController = new ListController();
$listController->filter_ = &$filter;

// リストコントローラの処理
$listController->fetch($handler->getCount($listController->filter_->getCriteria()), BXNOTEPAD_PERPAGE);

// 読み込み
$objs = $handler->getObjects(
    $listController->filter_->getCriteria(),
    $listController->start_,
    $listController->perpage_
);

// フォルダーを読んでおく
$fHandler = &bxNotepad::getHandler('folder');
$folders = &$fHandler->getObjects(new Criteria('uid', $listController->filter_->uid_), null, 'priority');

// View 層処理
$GLOBALS['xoopsOption']['template_main'] = 'bxnotepad_index.html';
foreach ($objs as $obj) {
    $xoopsTpl->append('notes', $obj->getStructure());
}
foreach ($folders as $f) {
    $xoopsTpl->append('folders', $f->getStructure());
}
$listController->freeze();    // リストコントローラを確定
$xoopsTpl->assign('navi', $listController->navi_);

// Extra はリクエストの引き渡しにも使える
$xoopsTpl->assign('request', $listController->filter_->getExtra());

require XOOPS_ROOT_PATH . '/footer.php';
