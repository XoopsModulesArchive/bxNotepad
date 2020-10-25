<?php

/**
 * @brief   ノートの編集
 * @version $Id: submit.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';

require_once XOOPS_ROOT_PATH . '/modules/exFrame/frameloader.php';
require_once './class/global.php';

require_once 'exComponent/Input.php';
require_once './include/NotepadEditForm.php';

// コンポーネントを初期化
$compo = new exInputComponent(
    null,
    new NotepadInputComponentRender(),
    'edit_notepad',
    new NotepadEditForm(),
    new exSuccessForwardConfig(EXFORWARD_LOCATION, 'submit_confirm.php')
);

switch ($ret = $compo->init()) {
    case COMPONENT_INIT_FAIL:
        die;
        break;
    case ACTIONFORM_INIT_FAIL:
        print $compo->form_->getHtmlErrors();
        $compo->display();
        break;
    case COMPONENT_INIT_SUCCESS:
        $compo->display();
        break;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
