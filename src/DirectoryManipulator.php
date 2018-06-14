<?php

namespace Grinderspro\DirectoryManipulator;

/**
 * Class DirectoryManipulator
 *
 * @author Grigoriy Miroschnichenko <grinderspro@gmail.com>
 * @package Grinderspro\DirectoryManipulator
 */

use Grinderspro\DirectoryManipulator\Helpers\DirectoryHelper;

class DirectoryManipulator
{
    /** @var string */
    private $name;

    /** @var string */
    private $location;

    /** @var Manipulator */
    private $manipulator;

    /**
     * DirectoryManipulator constructor.
     *
     * @param string $location
     */
    public function __construct($location = '')
    {
        $this->manipulator = new Manipulator();
        $this->location = empty($this->location) ? DirectoryHelper::getSystemTmp() : DirectoryHelper::sterilizationPath($location);
    }

    /**
     * @param string $location
     * @return $this
     */
    public function location($location)
    {
        $this->location = DirectoryHelper::sterilizationPath($location);

        return $this;
    }

    /**
     * @param string $dirName
     * @return $this
     */
    public function name($dirName = '')
    {
        $this->name = $dirName ?  DirectoryHelper::sterilizationName($dirName) : DirectoryHelper::getUniqueName();

        return $this;
    }

    /**
     * Create directory
     *
     * @return $this
     */
    public function create()
    {
        $this->manipulator->create($this->getFullPath());

        return $this;
    }

    /**
     * Delete directory
     *
     * @return $this
     */
    public function delete()
    {
        $this->manipulator->delete($this->getFullPath());

        return $this;
    }

    /**
     * Clear directory
     *
     * @return $this
     */
    public function clear()
    {
        $this->manipulator->clear($this->getFullPath());

        return $this;
    }

    public function rename($name)
    {
        return rename($this->getFullPath(), $name);
    }

    /**
     * Return the full path to the directory
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
     * @return string
     */
    private function getFullPath()
    {
        return $this->location . ($this->name ? DIRECTORY_SEPARATOR . $this->name : '');
    }
}