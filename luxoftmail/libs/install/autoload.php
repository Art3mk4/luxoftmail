<?php

/**
 * Description of autoload
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:37:58 AM
 */

/**
 * luxoft_autoload
 * 
 * @param type $className
 */
function luxoft_autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';

    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName .= $className . '.php';
    $file = LUXOFTMAIL_PATH . 'libs/' . $fileName;

    if (file_exists($file)) {
        require($file);
    }
}

spl_autoload_register('luxoft_autoload');