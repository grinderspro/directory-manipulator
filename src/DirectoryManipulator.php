<?php

namespace Grinderspro\DirectoryManipulator;

/**
 * Class DirectoryManipulator
 *
 * @author Grigoriy Miroschnichenko <grinderspro@gmail.com>
 * @package Grinderspro\DirManipulator
 */

class DirectoryManipulator
{
    /** @var string */
    private $location;

    /** @var string */
    private $name;

    public function __construct($location = '')
    {
        $this->location = $this->sterilizationPath($location);
    }

    /**
     * Creates a directory
     *
     * @return $this
     */
    public function create()
    {
        if (empty($this->location))
            $this->location = $this->getSystemTmpDir();

        if (!file_exists($this->getFullPath()))
            mkdir($this->getFullPath(), 0777, true);

        return $this;
    }

    /**
     * Deletes the directory
     *
     * @return $this
     */
    public function delete()
    {
        $this->deleteDirectory($this->getFullPath());

        return $this;
    }

    /**
     * Clears the directory
     *
     * @return $this
     */
    public function clear()
    {
        $this->clearDirectory($this->getFullPath());

        return $this;
    }


    /**
     * @param string $dirName
     * @return $this
     */
    public function name($dirName = '')
    {
        $this->name = $dirName ? $this->sterilizationName($dirName) : $this->getUniqueDirName();

        return $this;
    }

    public function rename()
    {
        // TODO: implementation rename() method;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function location($location)
    {
        $this->location = $this->sterilizationPath($location);

        return $this;
    }

    /**
     * Path
     *
     * Вернет полный путь до директории.
     *
     * @example $dirName = (new DirManipulator())->create()->path();
     * @return bool|string
     */
    public function path()
    {
        return $this->getFullPath();
    }

    /**
     * Returns the full path to our directory
     *
     * Implementation
     *
     * @return string
     */
    private function getFullPath()
    {
        return $this->location . ($this->name ? DIRECTORY_SEPARATOR . $this->name : '');
    }

    /**
     * Returns the full path of the system tmp folder
     *
     * @return string
     */
    private function getSystemTmpDir()
    {
        return $this->sterilizationPath(sys_get_temp_dir());
    }

    /**
     * Clearing the path to the directory
     *
     * @param $path
     * @return string
     */
    private function sterilizationPath($path)
    {
        return trim(rtrim($path, DIRECTORY_SEPARATOR));
    }

    private function sterilizationName($name = '')
    {
        return trim($name, DIRECTORY_SEPARATOR);
    }


    /**
     * @return int
     */
    private function getUniqueDirName()
    {
        return time();
    }

    /**
     * @param $path
     * @return bool
     */
    private function deleteDirectory($path)
    {
        if (!$this->clearDirectory($path))
            return false;

        return rmdir($path);
    }

    /**
     * @param $path
     * @return bool|void
     */
    private function clearDirectory($path)
    {
        if (!file_exists($path))
            return;

        $it = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        $it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($it as $file) {
            if ($file->isDir()) rmdir($file->getPathname());
            else unlink($file->getPathname());
        }

        return !$it->valid() ? true : false;
    }
}