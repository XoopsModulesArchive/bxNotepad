<?php

/**
 * @version $Id: folder.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
require_once __DIR__ . '/xoops/object.php';
require_once 'xoops/user.php';

class bxNotepadFolderObject extends exXoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('fid', XOBJ_DTYPE_INT, 0, false);

        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('priority', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 64);

        if (is_array($id)) {
            $this->assignVars($id);
        }
    }

    public function &getStructure($type = 's')
    {
        $ret = &parent::getStructure($type);

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
        $tinfo = new exTableInfomation('bxnotepad_folder', 'fid');

        return ($tinfo);
    }
}
