<?php

/**
 * @brief   フォルダの登録・削除確認に関する定義
 * @version $Id: FolderConfirm.php,v 1.1 2006/02/22 15:35:02 mikhail Exp $
 */
require_once 'exComponent/confirm/TypicalConfirm.php';
require_once 'exComponent/render/ConfirmModelRender.php';

class FolderConfirmRenderModel extends exConfirmRenderModel
{
    public $caption_ = _MD_BXNOTEPAD_LANG_CONFIRM;

    public $headmessage_ = _MD_BXNOTEPAD_MESSAGE_INSERT_CONFIRM;

    public $filter_ = ['uid', 'priority'];
}

class FolderDeleteConfirmRenderModel extends FolderConfirmRenderModel
{
    public $headmessage_ = _MD_BXNOTEPAD_MESSAGE_DELETE_CONFIRM;
}

class FolderDeleteConfirmProcessor extends exTypicalConfirmComponentProcessor
{
    public function _processPost($component)
    {
        $handler = &bxNotepad::getHandler('folder');

        if (!$handler->delete($component->data_)) {
            return false;
        }      // 所属する記事をすべて動かす

        $handler = &bxNotepad::getHandler('note');

        $notes = &$handler->getObjects(new Criteria('fid', $component->data_->getVar('fid')));

        foreach ($notes as $note) {    // ふつうは SQL だな……
            $note->setVar('fid', 0);

            $handler->insert($note);
        }

        return true;
    }
}
