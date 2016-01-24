<?php

namespace Nmapx\Inidister;

use Nmapx\Inidister\Exceptions\ElementAlreadyExistException;
use Nmapx\Inidister\Exceptions\ElementUnavailableException;
use Nmapx\Inidister\Exceptions\FileNotCopiedException;
use Nmapx\Inidister\Interfaces\InidisterInterface;
use Nmapx\Inidister\Utils\Parser;

/**
 * Class Inidister
 * @package Nmapx\Inidister
 */
class Inidister implements InidisterInterface
{

    /** @var array */
    protected $collection = [];

    /**
     * @param array $dirs
     * @throws ElementAlreadyExistException
     */
    public function __construct(array $dirs = [])
    {
        foreach ($dirs as $dir => $dest) {
            $this->add($dir, $dest);
        }
    }

    /**
     * @param string $dir
     * @param string $dest
     * @return $this
     * @throws ElementAlreadyExistException
     */
    public function add($dir, $dest)
    {
        if (array_key_exists($dir, $this->collection)) {
            throw new ElementAlreadyExistException;
        }

        $this->collection[$dir] = $dest;

        return $this;
    }

    /**
     * @param string $dir
     * @return $this
     * @throws ElementUnavailableException
     */
    public function remove($dir)
    {
        if (!array_key_exists($dir, $this->collection)) {
            throw new ElementUnavailableException;
        }

        unset($this->collection[$dir]);

        return $this;
    }

    public function execute()
    {
        foreach ($this->collection as $file => $dest) {
            if (!file_exists($dest)) {
                $this->copyFromDist($file, $dest);
                continue;
            }

            $dist = Parser::parse(file($file));
            $no_dist = Parser::parse(file($dest));

            $this->clean($dist, $no_dist)
                 ->update($dist, $no_dist)
                 ->save($dest, $no_dist);
        }
    }

    /**
     * @param $dir
     * @param $dest
     * @throws FileNotCopiedException
     */
    protected function copyFromDist($dir, $dest)
    {
        if (true !== copy($dir, $dest)) {
            throw new FileNotCopiedException;
        }
    }

    /**
     * @param array $dist
     * @param array $no_dist
     * @return $this
     */
    protected function clean(&$dist, &$no_dist)
    {
        foreach ($no_dist as $segment => $array) {
            if (!array_key_exists($segment, $dist)) {
                unset($no_dist[$segment]);
            } else {
                foreach ($array as $key => $value) {
                    if (!array_key_exists($key, $dist[$segment])) {
                        unset($no_dist[$segment][$key]);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param array $dist
     * @param array $no_dist
     * @return $this
     */
    protected function update(&$dist, &$no_dist)
    {
        foreach ($dist as $segment => $array) {
            if (!array_key_exists($segment, $no_dist)) {
                $no_dist[$segment] = $array;
            } else {
                foreach ($array as $key => $value) {
                    if (!array_key_exists($key, $no_dist[$segment])) {
                        $no_dist[$segment][$key] = $value;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param string $dir
     * @param array $content
     * @return $this
     */
    protected function save($dir, array $content = [])
    {
        unlink($dir);

        foreach ($content as $segment => $array) {
            file_put_contents($dir, "[{$segment}]\n", FILE_APPEND);
            foreach ($array as $key => $value) {
                file_put_contents($dir, "{$key} = {$value}\n", FILE_APPEND);
            }
        }

        return $this;
    }

}