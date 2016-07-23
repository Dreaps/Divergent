<?php
/**
 * Created by PhpStorm.
 * User: ManOfWind
 * Date: 7/22/2016
 * Time: 12:19 PM
 */

namespace Divergent\Kernel\Filesystem;
use Divergent\Kernel\Filesystem\Interfaces\FileInterface;

/**
 * Class File
 * @package Divergent\Kernel\Filesystem
 * @TODO : finish the functions on this class
 */
class File implements FileInterface
{

    /**
     * File constructor.
     */
    public function __construct()
    {
    }


    /**
     *
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


    /**
     *
     */
    public function create()
    {
        // TODO: Implement create() method.
    }


    /**
     * @param string $mode
     * @param bool $force
     */
    public function open($mode = 'r', $force = false)
    {
        // TODO: Implement open() method.
    }


    /**
     * @param bool $bytes
     * @param string $mode
     * @param bool $force
     */
    public function read($bytes = false, $mode = 'rb', $force = false)
    {
        // TODO: Implement read() method.
    }


    /**
     * @param $data
     * @param bool $forceWindows
     */
    public static function prepare($data, $forceWindows = false)
    {
        // TODO: Implement prepare() method.
    }


    /**
     * @param $data
     * @param string $mode
     * @param bool $force
     */
    public function write($data, $mode = 'w', $force = false)
    {
        // TODO: Implement write() method.
    }


    /**
     *
     */
    public function close()
    {
        // TODO: Implement close() method.
    }


    /**
     *
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }


    /**
     *
     */
    public function info()
    {
        // TODO: Implement info() method.
    }


    /**
     * @param int $maxsize
     */
    public function md5($maxsize = 5)
    {
        // TODO: Implement md5() method.
    }


    /**
     *
     */
    public function size()
    {
        // TODO: Implement size() method.
    }


    /**
     *
     */
    public function writable()
    {
        // TODO: Implement writable() method.
    }


    /**
     *
     */
    public function executable()
    {
        // TODO: Implement executable() method.
    }


    /**
     *
     */
    public function readable()
    {
        // TODO: Implement readable() method.
    }


    /**
     *
     */
    public function owner()
    {
        // TODO: Implement owner() method.
    }


    /**
     *
     */
    public function lastChange()
    {
        // TODO: Implement lastChange() method.
    }


    /**
     * @param $dest
     * @param bool $overwrite
     */
    public function copy($dest, $overwrite = true)
    {
        // TODO: Implement copy() method.
    }


    /**
     *
     */
    public function mime()
    {
        // TODO: Implement mime() method.
    }


    /**
     * @param $search
     * @param $replace
     */
    public function replaceText($search, $replace)
    {
        // TODO: Implement replaceText() method.
    }

}