<?php

namespace AppBundle\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ImageRemove
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function removeFile($filename)
    {
        $fs = new Filesystem();
        $image = $this->targetDir . '/' . $filename;

        try {
            if ($fs->exists($image)){
                $fs->remove($image);

                return true;
            }

            return false;
        } catch (IOExceptionInterface $e) {
            echo 'Error storage file ' . $e->getPath();
        }
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}