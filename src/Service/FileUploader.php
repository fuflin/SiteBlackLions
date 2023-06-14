<?php

// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private $imagesDirectory,
        private $videosDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            if($file->guessExtension() == 'mp4') //condition pour séparé les fichiers vidéos des images
            {
                $file->move($this->getVideosDirectory(), $fileName);
            } else {
                $file->move($this->getImagesDirectory(), $fileName);
            }
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getImagesDirectory(): string
    {
        return $this->imagesDirectory;
    }

    public function getVideosDirectory(): string
    {
        return $this->videosDirectory;
    }
}
