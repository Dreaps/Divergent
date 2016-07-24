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
            $path = DIVERGENT_DIR_TMP;
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
        unset($this->path);
        unset($this->mode);
        unset($this->Contents);
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
        if (!$mode) {
            $mode = $this->mode;
        }

        if ($recursive === false && is_dir($path)) {

            if (chmod($path, intval($mode, 8))) {
                return true;
            }

            return false;
        }

        if (is_dir($path)) {
            $paths = $this->Contents['Dir'];

            foreach ($paths as $type) {
                foreach ($type as $fullpath) {
                    $check = explode(DIRECTORY_SEPARATOR, $fullpath);
                    $count = count($check);

                    if (in_array($check[$count - 1], $exceptions)) {
                        continue;
                    }

                    if (!chmod($fullpath, intval($mode, 8))) {
                        $errors[] = sprintf('%s NOT changed to %s', $fullpath, $mode);
                    }
                }
            }

            if (empty($errors) || !isset($errors)) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param $path
     * @param bool $mode
     * @return bool
     */
    public function create($path, $mode = false)
    {
        if (is_dir($path) || empty($pathname)) {
            return true;
        }

        $path = realpath($path);


        if (!$mode) {
            $mode = $this->mode;
        }

        if (is_file($path)) {
            return false;
        }

        $path = rtrim($path, DS);
        $nextPath = substr($path, 0, strrpos($path, DS));

        if ($this->create($nextPath, $mode)) {
            if (!file_exists($path)) {
                $old = umask(0);
                if (mkdir($path, $mode, true)) {
                    umask($old);
                    return true;
                }
                umask($old);
                return false;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function size()
    {
        $size = 0;
        $directory = $this->path;
        $lastChar = $directory[strlen($directory) - 1];
        if($lastChar != '/' || $lastChar != '\\'){
            $directory = $directory . DS ;
        }
        $stack = [$directory];
        $count = count($stack);
        for ($i = 0, $j = $count; $i < $j; ++$i) {
            if (is_file($stack[$i])) {
                $size += filesize($stack[$i]);
            } elseif (is_dir($stack[$i])) {
                $dir = dir($stack[$i]);
                if ($dir) {
                    while (($entry = $dir->read()) !== false) {
                        if ($entry === '.' || $entry === '..') {
                            continue;
                        }
                        $add = $stack[$i] . $entry;

                        if (is_dir($stack[$i] . $entry)) {
                            $lastChar = $add[strlen($add) - 1];
                            if($lastChar != '/' || $lastChar != '\\'){
                                $add = $add . DS ;
                            }
                        }
                        $stack[] = $add;
                    }
                    $dir->close();
                }
            }
            $j = count($stack);
        }
        return $size;
    }

    /**
     * @param null $path
     * @return mixed
     */
    public function delete($path = null)
    {
        if (!$path) {
            $path = $this->pwd();
        }

        if (!$path) {
            return false;
        }

        $lastChar = $path[strlen($path) - 1];
        if($lastChar != '/' || $lastChar != '\\'){
            $path = $path . DS ;
        }

        $files = glob($path . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->delete($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($path);
    }

    /**
     * @param $options
     * @return mixed
     */
    public function copy($options)
    {
        if (!$this->pwd()) {
            return false;
        }

        $to = null;

        if (is_string($options)) {
            $to = $options;
            $options = [];
        }

        $options += [
            'to' => $to,
            'from' => $this->path,
            'mode' => $this->mode,
            'skip' => [],
            'scheme' => 'merge',
            'recursive' => true
        ];

        $fromDir = $options['from'];
        $toDir = $options['to'];
        $mode = $options['mode'];

        if (!$this->cd($fromDir)) {
            return false;
        }

        if (!is_dir($toDir)) {
            $this->create($toDir, $mode);
        }

        if (!is_writable($toDir)) {
            return false;
        }

        $exceptions = array_merge(['.', '..', '.svn'], $options['skip']);
        if ($handle = opendir($fromDir)) {
            while (($item = readdir($handle)) !== false){

                array_unshift($item , rtrim($toDir, DS));
                $to = implode(DS, $item);

                if (($options['scheme'] != 'skip' || !is_dir($to)) && !in_array($item, $exceptions)) {
                    array_unshift($item , rtrim($fromDir, DS));
                    $from = implode(DS, $item);

                    if (is_file($from) && (!is_file($to) || $options['scheme'] != 'skip')) {
                        if (copy($from, $to)) {
                            chmod($to, intval($mode, 8));
                            touch($to, filemtime($from));

                        } else {
                            $errors[] = sprintf('%s NOT copied to %s', $from, $to);
                        }
                    }

                    if (is_dir($from) && file_exists($to) && $options['scheme'] === 'overwrite') {
                        $this->delete($to);
                    }

                    if (is_dir($from) && $options['recursive'] === false) {
                        continue;
                    }

                    if (is_dir($from) && !file_exists($to)) {
                        $old = umask(0);
                        if (mkdir($to, $mode, true)) {
                            umask($old);
                            $old = umask(0);
                            chmod($to, $mode);
                            umask($old);
                            $options = ['to' => $to, 'from' => $from] + $options;
                            $this->copy($options);
                        } else {
                            $errors[] = sprintf('%s not created', $to);
                        }
                    } elseif (is_dir($from) && $options['scheme'] === 'merge') {
                        $options = ['to' => $to, 'from' => $from] + $options;
                        $this->copy($options);
                    }
                }
            }
            closedir($handle);
        }else{
            return false;
        }

        return empty($errors);
    }

    /**
     * @param $options
     * @return mixed
     */
    public function move($options)
    {
        $to = null;

        if (is_string($options)) {
            $to = $options;
            $options = (array)$options;
        }

        $options += ['to' => $to, 'from' => $this->path, 'mode' => $this->mode, 'skip' => [], 'recursive' => true];

        if ($this->copy($options)) {
            if ($this->delete($options['from'])) {
                return (bool)$this->cd($options['to']);
            }
        }
        return false;
    }

}