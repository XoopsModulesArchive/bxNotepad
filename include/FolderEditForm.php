<?php

/**
 * @brief   Folder投稿用アクションフォーム
 * @version $Id: FolderEditForm.php,v 1.1 2006/02/22 15:35:02 mikhail Exp $
 */

// まず基底を読む
require_once 'exForm/Form.php';

// インプットコンポーネントも読んでおく
// 先に読み込まれていることが多いので require_once しておく
require_once 'exComponent/Input.php';

// たいていこれをつかうことになるので、XoopsForm をロードする
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

class FolderEditForm extends exAbstractActionForm
{
    public function load($data = null)
    {
        global $xoopsUser;

        // 会員以外の入力を拒否

        if (!is_object($xoopsUser)) {
            $this->msg_[] = _MD_BXNOTEPAD_MESSAGE_GUESTCANCEL;

            return;
        }

        $handler = &bxNotepad::getHandler('folder');

        $fid = isset($_REQUEST['fid']) ? $this->getPositive($_REQUEST['fid']) : 0;

        // ロードを試す

        if ($fid > 0) {
            $this->data_ = &$handler->get($fid);
        }

        // 失敗したなら、 create でインスタンスを初期化する

        if (!is_object($this->data_)) {
            $this->data_ = $handler->create();

            // ユーザーID のセット

            $this->data_->setVar('uid', is_object($xoopsUser) ? $xoopsUser->uid() : 0);
        }
    }

    public function doGet($data)
    {
        $this->load();
    }

    public function doPost($data)
    {
        global $xoopsUser;

        // ロードもしくはインスタンスの作成

        $this->load();

        // priority は拡張予備なのでパス

        // XoopsObject に任せてしまうもの

        $this->data_->setVar('name', $_POST['name']);

        // XoopObject にも cleanVars をかける

        if (!$this->data_->cleanVars()) {
            // もしエラーが起こったなら、扱いにくいので、$this->msg_ にマージする

            $this->msg_ = array_merge($this->msg_, $this->data_->getErrors());
        }
    }
}

class FolderInputComponentRender extends exInputComponentRender
{
    public function render()
    {
        $form = new XoopsThemeForm('FOLDER', 'folder', $_SERVER['SCRIPT_NAME'], 'POST');

        $form->addElement(new XoopsFormHidden('fid', $this->component_->form_->data_->getVar('fid')));

        $form->addElement(new XoopsFormText(_MD_BXNOTEPAD_LANG_TITLE, 'name', 35, 35, $this->component_->form_->data_->getVar('name')));

        $form->addElement(new XoopsFormButton('SAVE', 'submit', 'submit', 'submit'));

        $form->addElement($tray);

        $form->display();
    }
}
