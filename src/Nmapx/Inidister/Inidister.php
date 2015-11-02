<?php

namespace Nmapx\Inidister;

use Nmapx\Inidister\Exceptions\ElementAlreadyExistException;
use Nmapx\Inidister\Exceptions\ElementUnavailableException;
use Nmapx\Inidister\Exceptions\FileNotCopiedException;
use Nmapx\Inidister\Exceptions\NameAlreadyDistedException;
use Nmapx\Inidister\Exceptions\NameAlreadyUndistedException;
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
        foreach ($dirs as $dir) {
            $this->add($dir);
        }
    }

    /**
     * @param string $dir
     * @return $this
     * @throws ElementAlreadyExistException
     */
    public function add($dir)
    {
        if (array_key_exists($dir, $this->collection)) {
            throw new ElementAlreadyExistException;
        }

        $this->collection[$dir] = null;

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
        foreach ($this->collection as $file => $value) {
            if (!file_exists($this->nameWithoutDist($file))) {
                $this->copyFromDist($file);
                continue;
            }

            $dist = Parser::parse(file($file));
            $no_dist = Parser::parse(file($this->nameWithoutDist($file)));

            $this->clean($dist, $no_dist)
                 ->update($dist, $no_dist)
                 ->save($this->nameWithoutDist($file), $no_dist);
        }
    }

    /**
     * @param string $dir
     * @throws FileNotCopiedException
     * @throws NameAlreadyUndistedException
     */
    protected function copyFromDist($dir)
    {
        if (true !== copy($dir, $this->nameWithoutDist($dir))) {
            throw new FileNotCopiedException;
        }
    }

    /**
     * @param string $name
     * @return string
     * @throws NameAlreadyUndistedException
     */
    protected function nameWithoutDist($name)
    {
        if (false === strpos($name, '.dist')) {
            throw new NameAlreadyUndistedException;
        }

        return str_replace('.dist', '', $name);
    }

    /**
     * @param string $name
     * @return string
     * @throws NameAlreadyDistedException
     */
    protected function nameWithDist($name)
    {
        if (false !== strpos($name, '.dist')) {
            throw new NameAlreadyDistedException;
        }

        return $name . '.dist';
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