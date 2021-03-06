<?php

namespace Grinderspro\DirectoryManipulator;

/**
 * Class Manipulator
 *
 * @author Grigoriy Miroschnichenko <grinderspro@gmail.com>
 * @package Grinderspro\DirectoryManipulator
 */

class Manipulator
{
    public function create($path)
    {
        if (file_exists($path))
            return true;

        return mkdir($path, 0777, true);
    }

    public function delete($path)
    {
        if (!$this->clear($path))
            return false;

        return rmdir($path);
    }

    public function clear($path)
    {
        if (!file_exists($path))
            return false;

        $it = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        $it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($it as $file) {
            if ($file->isDir()) rmdir($file->getPathname());
            else unlink($file->getPathname());
        }

        return !$it->valid() ? true : false;
    }
}