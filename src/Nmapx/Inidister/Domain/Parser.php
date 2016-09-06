<?php

namespace Nmapx\Inidister\Domain;

class Parser
{
    public function parse(string $filepath): array
    {
        if (!file_exists($filepath)) {
            return [];
        }

        return parse_ini_file($filepath, true);
    }

    public function create(array $data): string
    {
        $string = "";
        $count = count($data);
        $i = 1;
        foreach ($data as $group => $content) {
            $string .= "[{$group}]\n";
            foreach ($content as $key => $value) {
                $string .= "{$key}={$value}\n";
            }
            if ($i < $count) {
                $string .= "\n";
            }
            $i++;
        }

        return $string;
    }
}