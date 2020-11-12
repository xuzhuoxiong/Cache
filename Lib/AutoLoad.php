<?php
/*
 * 自动加载类
 * */

namespace Lib;


class AutoLoad
{
    public static function loadClass($className)
    {
        $class = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if (is_file($class)) {
            require_once $class;
        } else {
            echo sprintf("%s类未找到", $class);
        }
    }
}

spl_autoload_register("Lib\\AutoLoad::loadClass", true, true);
