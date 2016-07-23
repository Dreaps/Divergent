<?php
/**
 * Created by PhpStorm.
 * User: ManOfWind
 * Date: 7/22/2016
 * Time: 12:33 PM
 */

namespace Divergent\Kernel\Filesystem\Interfaces;


/**
 * Interface FileInterface
 * @package Divergent\Kernel\Filesystem\Interfaces
 */
interface FileInterface
{
    /**
     * FileInterface constructor.
     */
    public function __construct();

    /**
     *
     */
    public function __destruct();

    /**
     * @return mixed
     */
    public function create();

    /**
     * @param string $mode
     * @param bool $force
     * @return mixed
     */
    public function open($mode = 'r', $force = false);

    /**
     * @param bool $bytes
     * @param string $mode
     * @param bool $force
     * @return mixed
     */
    public function read($bytes = false, $mode = 'rb', $force = false);

    /**
     * @param $data
     * @param bool $forceWindows
     * @return mixed
     */
    public static function prepare($data, $forceWindows = false);

    /**
     * @param $data
     * @param string $mode
     * @param bool $force
     * @return mixed
     */
    public function write($data, $mode = 'w', $force = false);

    /**
     * @return mixed
     */
    public function close();

    /**
     * @return mixed
     */
    public function delete();

    /**
     * @return mixed
     */
    public function info();

    /**
     * @param int $maxsize
     * @return mixed
     */
    public function md5($maxsize = 5);

    /**
     * @return mixed
     */
    public function size();

    /**
     * @return mixed
     */
    public function writable();

    /**
     * @return mixed
     */
    public function executable();

    /**
     * @return mixed
     */
    public function readable();

    /**
     * @return mixed
     */
    public function owner();

    /**
     * @return mixed
     */
    public function lastChange();

    /**
     * @param $dest
     * @param bool $overwrite
     * @return mixed
     */
    public function copy($dest, $overwrite = true);

    /**
     * @return mixed
     */
    public function mime();

    /**
     * @param $search
     * @param $replace
     * @return mixed
     */
    public function replaceText($search, $replace);

}