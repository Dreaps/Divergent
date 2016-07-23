<?php
/**
 * Created by PhpStorm.
 * User: ManOfWind
 * Date: 7/22/2016
 * Time: 12:21 PM
 */

namespace Divergent\Kernel\Filesystem;
use Divergent\Kernel\Filesystem\Interfaces\DirectoryInterface;


/**
 * Class Directory
 * @package Divergent\Kernel\Filesystem
 * @todo finish the functions on this class
 */
class Directory implements DirectoryInterface
{

    /**
     * @var null|string
     */
    protected $path = null;

    /**
     * @var bool|int
     */
    protected $mode = 0755;

    /**
     * @var array
     */
    protected $Contents = array();


    /**
     * Directory constructor.
     * @param null $path
     * @param bool $create
     * @param bool $mode
     */
    public function __construct($path = null , $create = false , $mode = false)
    {
        if (empty($path)) {
            // TODO: Implement TMP.
            $path = TMP;
        }

        $this->path = $path;

        if ($mode) {
            $this->mode = $mode;
        }

        if (!file_exists($this->path) && $create === true) {
            $this->create($this->path, $this->mode);
        }

        $this->path = realpath($this->path);

        if (!empty($this->path)) {
            $this->cd($this->path);
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


    /**
     * @return null|string
     */
    public function pwd()
    {
        return $this->path;
    }


    /**
     * @param $path
     * @return bool
     */
    public function cd($path)
    {
        $path = realpath($path);
        if (is_dir($path)) {
            $this->Contents();
            return $this->path = $path;
        }
        return false;
    }


    /**
     * @return array
     */
    public function Contents()
    {
        $this->Contents['All'] = scandir($this->path, 1);
        foreach ($this->Contents['All'] as $Content) {
            if(is_file($this->path . DIRECTORY_SEPARATOR . $Content)){
                $this->Contents['Files'][] = $Content;
            }else{
                $this->Contents['Dir'][] = $Content;
            }
        }
        return [ $this->Contents['Files'] , $this->Contents['Dir'] ];
    }


    /**
     * @param string $regexpPattern
     * @return array
     */
    public function find($regexpPattern = '.*')
    {
        return array_values(preg_grep('/^' . $regexpPattern . '$/i', $this->Contents));
    }


    /**
     * @param $path
     * @return bool
     */
    public static function isWindowsPath($path)
    {
        return (preg_match('/^[A-Z]:\\\\/i', $path) || substr($path, 0, 2) === '\\\\');
    }


    /**
     * @param $path
     * @param bool $mode
     * @param bool $recursive
     * @param array $exceptions
     * @return mixed
     */
    public function chmod($path, $mode = false, $recursive = true, array $exceptions = [])
    {
        // TODO: Implement chmod() method.
    }

    /**
     * @param null $path
     * @return mixed
     */
    public function subdirectories($path = null)
    {
        // TODO: Implement subdirectories() method.
    }

    /**
     * @param null $path
     * @param bool $exceptions
     * @return mixed
     */
    public function tree($path = null, $exceptions = false)
    {
        // TODO: Implement tree() method.
    }

    /**
     * @param $pathname
     * @param bool $mode
     * @return mixed
     */
    public function create($pathname, $mode = false)
    {
        // TODO: Implement create() method.
    }

    /**
     * @return mixed
     */
    public function size()
    {
        // TODO: Implement size() method.
    }

    /**
     * @param null $path
     * @return mixed
     */
    public function delete($path = null)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $options
     * @return mixed
     */
    public function copy($options)
    {
        // TODO: Implement copy() method.
    }

    /**
     * @param $options
     * @return mixed
     */
    public function move($options)
    {
        // TODO: Implement move() method.
    }

}