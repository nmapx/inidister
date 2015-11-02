<?php

namespace Nmapx\Inidister\Interfaces;

interface InidisterInterface
{

    public function execute();

    public function add($dir);

    public function remove($dir);

}