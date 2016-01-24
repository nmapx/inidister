<?php

namespace Nmapx\Inidister\Interfaces;

interface InidisterInterface
{

    public function execute();

    public function add($dir, $dest);

    public function remove($dir);

}