<?php

namespace Grinderspro\DirectoryManipulator\Helpers;

/**
 * DirectoryHelper
 *
 * @author Grigoriy Miroschnichenko <grinderspro@gmail.com>
 */

class DirectoryHelper
{
    public static function getUniqueName()
    {
        return time();
    }

    /**
     * Returns the full path of the system tmp folder
     *
     * @return string
     */
    public static function getSystemTmp()
    {
        return self::sterilizationPath(sys_get_temp_dir());
    }

    /**
     * Clears the path to the directory
     *
     * @param $path
     * @return string
     */
    public static function sterilizationPath($path = '')
    {
        return trim(rtrim($path, DIRECTORY_SEPARATOR));
    }

    /**
     * Clears the directory name string
     *
     * @param string $name
     * @return string
     */
    public static function sterilizationName($name = '')
    {
        return trim($name, DIRECTORY_SEPARATOR);
    }
}