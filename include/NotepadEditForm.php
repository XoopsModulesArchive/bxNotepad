<?php

/**
 * @brief   Notepad投稿用アクションフォーム
 * @version $Id: NotepadEditForm.php,v 1.1 2006/02/22 15:35:02 mikhail Exp $
 */

// まず基底を読む
require_once 'exForm/Form.php';

// インプットコンポーネントも読んでおく
// 先に読み込まれていることが多いので require_once しておく
require_once 'exComponent/Input.php';

// たいていこれをつかうことになるので、XoopsForm をロードする
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

class NotepadEditForm extends exAbstractActionForm
{
    public function load($data = null)
    {
        global $xoopsUser;

        // 会員以外の入力を拒否

        if (!is_object($xoopsUser)) {
            $this->msg_[] = _MD_BXNOTEPAD_MESSAGE_GUESTCANCEL;

            return;
        }

        $handler = &bxNotepad::getHandler('note');

        $id = isset($_REQUEST['id']) ? $this->getPositive($_REQUEST['id']) : 0;

        // ロードを試す

        if ($id > 0) {
            $this->data_ = &$handler->get($id);
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

        // fid

        $fid = $this->getPositive($_POST['fid']);

        if ($fid > 0) {    // 検査
            $handler = &bxNotepad::getHandler('folder');

            $folder = &$handler->get($fid);

            if (!is_object($folder)) {
                $this->msg_[] = '_MD_BXNOTEPAD_ERROR_FOLDER_NOEXISTS';
            } else {    // 自分のフォルダーかどうかを検査します
                if (!$xoopsUser->isAdmin() and $xoopsUser->uid() != $folder->getVar('uid')) {
                    $this->msg_[] = _MD_BXNOTEPAD_ERROR_FOLDER_DENY;
                }
            }
        }

        $this->data_->setVar('fid', $fid);

        // update_date は必ず変更

        $this->data_->setVar('update_date', time());

        // public には 0 か 1 しかない

        $this->data_->setVar('public', ($_POST['public']) ? 1 : 0);

        // priority は拡張予備なのでパス

        // XoopsObject に任せてしまうもの

        $this->data_->setVar('title', $_POST['title']);

        $this->data_->setVar('contents', $_POST['contents']);

        // XoopObject にも cleanVars をかける

        if (!$this->data_->cleanVars()) {
            // もしエラーが起こったなら、扱いにくいので、$this->msg_ にマージする

            $this->msg_ = array_merge($this->msg_, $this->data_->getErrors());
        }
    }
}

class NotepadInputComponentRender extends exInputComponentRender
{
    public function render()
    {
        global $xoopsUser;

        $form = new XoopsThemeForm('NOTEPAD', 'notepad', $_SERVER['SCRIPT_NAME'], 'POST');

        $form->addElement(new XoopsFormHidden('id', $this->component_->form_->data_->getVar('id')));

        $form->addElement(new XoopsFormText(_MD_BXNOTEPAD_LANG_TITLE, 'title', 35, 35, $this->component_->form_->data_->getVar('title')));

        $folder = new XoopsFormSelect(_MD_BXNOTEPAD_LANG_FOLDER, 'fid', $this->component_->form_->data_->getVar('fid'));

        $folder->addOption(0, _MD_BXNOTEPAD_LANG_DEF_FOLDER);

        // フォルダーを読んでセット

        $handler = &bxNotepad::getHandler('folder');

        $criteria = new Criteria('uid', $xoopsUser->uid());

        $criteria->setSort('priority');

        $folders = &$handler->getObjects($criteria);

        foreach ($folders as $f) {
            $folder->addOption($f->getVar('fid'), $f->getVar('name'));
        }

        $form->addElement($folder);

        $public = new XoopsFormSelect(_MD_BXNOTEPAD_LANG_PUBLIC, 'public', $this->component_->form_->data_->getVar('public'));

        $public->addOption(0, _MD_BXNOTEPAD_LANG_PRIVATE);

        $public->addOption(1, _MD_BXNOTEPAD_LANG_PUBLIC);

        $form->addElement($public);

        $form->addElement(new XoopsFormDhtmlTextArea(_MD_BXNOTEPAD_LANG_CONTENTS, 'contents', $this->component_->form_->data_->getVar('contents', 'e'), 20));

        $form->addElement(new XoopsFormButton('SAVE', 'submit', 'submit', 'submit'));

        $form->addElement($tray);

        $form->display();
    }
}
