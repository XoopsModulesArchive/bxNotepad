<?php

/**
 * @version $Id: note.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
require_once __DIR__ . '/xoops/object.php';
require_once 'xoops/user.php';

class bxNotepadNoteObject extends exXoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, 0, false);

        $this->initVar('fid', XOBJ_DTYPE_INT, 0, false);    // 宙ぶらりん(未分類)許可
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);    // 宙ぶらりん許可
        $this->initVar('update_date', XOBJ_DTYPE_INT, time(), true);

        $this->initVar('public', XOBJ_DTYPE_INT, 0, false);

        $this->initVar('priority', XOBJ_DTYPE_INT, 3, false);    // 拡張用

        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, true, 255);

        $this->initVar('contents', XOBJ_DTYPE_TXTAREA, null, false, null);    // 詳細不要

        if (is_array($id)) {
            $this->assignVars($id);
        }
    }

    public function &getStructure($type = 's')
    {
        $ret = &parent::getStructure($type);

        // Folder が 0 以上のとき、フォルダの構造体を読んでおく

        $handler = &bxNotepad::getHandler('folder');

        if ($this->getVar('fid')) {
            $folder = $handler->get($this->getVar('fid'));

            $ret['folder'] = $folder->getArray($type);
        } else {
            $ret['folder'] = null;
        }

        // User を混ぜておくことで使いやすくする

        $uHandler = xoops_getHandler('user');

        $user = new exXoopsUserObject($uHandler->get($this->getVar('uid')));

        $ret['user'] = $user->getArray($type);

        return $ret;
    }

    /**
     * このオブジェクトとデーターベースとの接続方法を返す
     */
    public function getTableInfo()
    {
        $tinfo = new exTableInfomation('bxnotepad_note', 'id');

        return ($tinfo);
    }
}
