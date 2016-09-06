<?php

namespace Nmapx\Inidister\Domain;

class Writer
{
    public function write(string $filepath, string $content): self
    {
        file_put_contents($filepath, $content);

        return $this;
    }
}