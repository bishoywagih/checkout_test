<?php

namespace App\Contracts;

interface FileSystem
{
    public function store($file, $directory, $fileName): string;
    public function delete($file);
    public function exists($path): bool;
}