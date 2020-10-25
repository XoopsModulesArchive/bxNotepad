<?php

require_once 'exComponent/confirm/TypicalConfirm.php';
require_once 'exComponent/render/ConfirmModelRender.php';

class NotepadConfirmRenderModel extends exConfirmRenderModel
{
    public $caption_ = _MD_BXNOTEPAD_LANG_CONFIRM;

    public $headmessage_ = _MD_BXNOTEPAD_MESSAGE_INSERT_CONFIRM;

    public $filter_ = ['uid', 'priority'];

    public $ts_;

    public function __construct()
    {
        $this->ts_ = MyTextSanitizer::getInstance();
    }

    public function getValueAtContents($key)
    {
        return $this->ts_->displayTarea($this->_array_[$key]);
    }

    public function getValueAtUpdate_date($key)
    {
        return formatTimestamp($this->_array_[$key]);
    }
}

class NotepadDeleteConfirmRenderModel extends NotepadConfirmRenderModel
{
    public $headmessage_ = _MD_BXNOTEPAD_MESSAGE_DELETE_CONFIRM;
}
