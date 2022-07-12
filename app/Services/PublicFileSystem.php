<?php

namespace App\Services;

use _PHPStan_59fb0a3b2\Nette\Neon\Exception;
use App\Contracts\FileSystem;

class PublicFileSystem implements FileSystem
{
    /**
     * @throws Exception
     */
    public function store($file, $directory, $fileName): string
    {
        $target_file = $directory . $fileName;
        if (! move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception('File Not uploaded');
        }
    }

    public function delete($path)
    {
        if($this->exists($path)){
            unlink($path);
        }
    }

    public function exists($path): bool
    {
        return file_exists($path);
    }
}