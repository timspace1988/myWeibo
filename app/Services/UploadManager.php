<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Filesystem\Filesystem;

class UploadManager{
    protected $disk;
    //protected $filesystem;

    public function __construct(){
        $this->disk = Storage::disk();
        //$this->filesystem = new Filesystem();
    }


    public function test($folder){
        return $this->filesystem->isDirectory($folder);
    }

    /**
     * Senitize a path
     */
    protected function cleanPath($path){
        $path = str_replace('..', '', $path);
        return '/' . trim($path, '/');
    }

    /**
     * Get Mime Type of a file(the file path must be under filesystem's root directory)
     *
     * @param string $path
     * @param string
     */
    public function getMimeType($path){
        return $this->disk->mimeType($path);
        //mimeType() will only search the path under root directory
    }

    /**
     * Save a file
     *
     * @param string $path
     * @param string $content
     * @return bool/string
     */
    public function saveFile($path, $content){
        $path = $this->cleanPath($path);
        if($this->disk->exists($path)){
            return "File '$path' already exists.";
        }

        return $this->disk->put($path, $content);
    }
    /**
     * Delete a file
     *
     * @param string $path
     * @return bool/string
     */
    public function deleteFile($path){
        $path = $this->cleanPath($path);

        if(!$this->desk->exists($path)){
            return "File '$path' does not exist.";
        }

        return $this->disk->delete($path);
    }

    /**
     * Create a new directory(you can create a directory with subdirectoty)
     *
     * @param string $folder
     * @return bool/string
     */
    public function createDirectory($folder){
        $folder = $this->cleanPath($folder);

        if($this->disk->exists($folder)){
            return "Directory '$folder' already exists.";
        }

        return $this->disk->makeDirectory($folder);
        //you can create a directory with subdirectoty like '/dd/cc' in one call
    }

    /**
     * Delete a directory including all its files and folders
     *
     * @param string $folder
     * @param bool $straightaway
     * @return bool/string
     */
     public function deleteDirectory($folder, $straightaway=false){
         $folder = $this->cleanPath($folder);

         //check if the given directory exists
         if(!$this->disk->exists($folder)){
             return "Directory '$folder' does not exist.";
         }

         //check if the given directory is required to be deleted straightaway
         if(!$straightaway){
             $foldersAndFiles = array_merge(
                 $this->disk->directories($folder),
                 $this->disk->files($folder)
             );

             if(!empty($foldersAndFiles)){
                 return "Directory must be empty to delete it";
             }

             return $this->disk->deleteDirectory($folder);
         }else{
             return $this->disk->deleteDirectory($folder);
         }

     }
}
