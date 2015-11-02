<?php

namespace Nmapx\Inidister\Utils;

/**
 * Class Parser
 * @package Nmapx\Inidister\Utils
 */
abstract class Parser
{

    /**
     * @param array $source
     * @return array
     */
    public static function parse(array $source = [])
    {
        $segment = null;
        $array = [];
        foreach ($source as $value) {
            if (1 == preg_match("|^\[.+\]|", $value)) {
                $segment = substr(trim($value), 1, -1);
            }
            if (1 == preg_match("|^[a-zA-Z0-9_]+ *= *.+|", $value)) {
                $tmp = explode('=', $value);
                $array[$segment][trim($tmp[0])] = trim($tmp[1]);
            }
        }

        return $array;
    }

}