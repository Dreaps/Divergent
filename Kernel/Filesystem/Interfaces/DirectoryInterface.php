<?php
/**
 * Created by PhpStorm.
 * User: ManOfWind
 * Date: 7/22/2016
 * Time: 3:49 PM
 */

namespace Divergent\Kernel\Filesystem\Interfaces;


/**
 * Interface DirectoryInterface
 * @package Divergent\Kernel\Filesystem\Interfaces
 */
/**
 * Interface DirectoryInterface
 * @package Divergent\Kernel\Filesystem\Interfaces
 */
interface DirectoryInterface
{
    /**
     * DirectoryInterface constructor.
     */
    public function __construct($path);

    /**
     *
     */
    public function __destruct();

    /**
     * @return mixed
     */
    public function pwd();

    /**
     * @param $path
     * @return mixed
     */
    public function cd($path);

    /**
     * @return mixed
     */
    public function find();

    /**
     * @param $path
     * @return mixed
     */
    public static function isWindowsPath($path);

    /**
     * @param $path
     * @param bool $mode
     * @param bool $recursive
     * @param array $exceptions
     * @return mixed
     */
    public function chmod($path, $mode = false, $recursive = true, array $exceptions = []);

    /**
     * @param $pathname
     * @param bool $mode
     * @return mixed
     */
    public function create($pathname, $mode = false);

    /**
     * @return mixed
     */
    public function size();

    /**
     * @param null $path
     * @return mixed
     */
    public function delete($path = null);

    /**
     * @param $options
     * @return mixed
     */
    public function copy($options);

    /**
     * @param $options
     * @return mixed
     */
    public function move($options);

}