<?php

/**
 * @brief   シングルトン的な動きを期待するクラスメソッド
 * @version $Id: global.php,v 1.1 2006/02/22 15:35:01 mikhail Exp $
 */
define('BXNOTEPAD_PERPAGE', 20);

require_once __DIR__ . '/xoops/global.php';

// 新しい exFrame にあるのでそれを使用すると楽
class bxNotepad
{
    public function &getHandler($name)
    {
        global $xoopsModule;

        global $__modulenameHandlers_cache__;

        global $xoopsDB;

        // 先に名前（キャッシュ名）を取得

        $name = mb_strtolower(trim($name));

        $class = 'bxNotepad' . ucfirst($name) . 'Object';

        if (!isset($__modulename_handelrs_cache__[$class])) {
            if (!class_exists($class) && is_object($xoopsModule)) { // １回だけ読み込む
                $filename = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/' . $name . '.php';

                if (file_exists($filename)) {
                    require_once $filename;
                }
            }

            $handler_class = $class . 'Handler';

            if (class_exists($handler_class)) {
                $__modulename_handelers_cache__[$class] = new $handler_class($xoopsDB, $class);
            } else {
                $__modulename_handelers_cache__[$class] = new exXoopsObjectHandler($xoopsDB, $class);
            }

            return $__modulename_handelers_cache__[$class];
        }

        return $__modulename_handelers_cache__[$class];
    }
}
