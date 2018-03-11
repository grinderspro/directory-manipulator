<?php

namespace Grinderspro\DirectoryManipulator;

/**
 * Class DirManipulator
 *
 * @author Grigorij Miroshnichenko <grinderspro@gmail.com>
 * @package Grinderspro\DirManipulator
 */

class DirectoryManipulator
{
    /** @var string */
    protected $location;

    /** @var string */
    protected $name;

    public function __construct($location = '')
    {
        $this->location = $this->sterilizationPath($location);
    }

    /**
     * @return $this
     */
    public function create()
    {
        if (empty($this->location))
            $this->location = $this->getSystemTmpDir();

        if (empty($this->name))
            $this->name = $this->getUniqueDirName();

        if (!file_exists($this->getFullPath()))
            mkdir($this->getFullPath(), 0777, true);

            return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->deleteDirectory($this->getFullPath());

        return $this;
    }

    /**
     * @return $this
     */
    public function name($dirName)
    {
        $this->name = $dirName;

        return $this;
    }

    /**
     * @return $this
     */
    public function location($location)
    {
        $this->location = $this->sterilizationPath($location);

        return $this;
    }

    public function rename()
    {
        // TODO: implementation rename() method;
    }

    public function empty()
    {
        // TODO: implementation empty() method;
    }

    /**
     * Path
     *
     * Если есть $path - то делаем что-либо, иначе - вернем полный путь до директории. Используем, если надо получить
     * путь динамически созданной директории (когда создаем директорию, без указания параметров. см. пример)
     *
     * @example $dirName = (new DirManipulator())->create()->path();
     * @param string $path
     * @return bool|string
     */
    public function path($path = '')
    {
        // TODO: Заглушка на случай, если передан $path. Дописать, если понадобится
        if(!empty($path))
            return true;

        return $this->getFullPath();
    }

    /**
     * @return string
     */
    protected function getSystemTmpDir()
    {
        return $this->sterilizationPath(sys_get_temp_dir());
    }

    /**
     * @param $path
     * @return string
     */
    protected function sterilizationPath($path)
    {
        return trim(rtrim($path, DIRECTORY_SEPARATOR));
    }

    /**
     * @return string
     */
    protected function getFullPath()
    {
        return $this->location . ($this->name ? DIRECTORY_SEPARATOR . $this->name : '');
    }

    /**
     * @return int
     */
    protected function getUniqueDirName()
    {
        return time();
    }

    /**
     * @param $path
     * @return bool
     */
    protected function deleteDirectory($path)
    {
        if (!file_exists($path)) {
            return true;
        }

        foreach (glob($path . '/*') as $file) {
            unlink($file);
        }

        return rmdir($path);
    }
}

//var_dump((new DirectoryManipulator())->create()->path());
//(new DirectoryManipulator())->location('tmp/grinderspro')->delete();
//var_dump((new DirectoryManipulator())->location('/tmp/')->name('grinderspro')->delete()->path());
//var_dump($dir);die;