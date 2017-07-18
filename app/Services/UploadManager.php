<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Filesystem\Filesystem;

class UploadManager{
    protected $disk;
    //protected $filesystem;

    public function __construct(){

        $this->disk = Storage::disk(config('upload.storage'));//config('upload.storage')
        // echo "test";
        // exit();
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
     * Return full web path to a file
     * @param string $path
     * @param string
     */
    public function getWebpath($path){
        $path = rtrim(config('upload.webpath'), '/') . '/' . ltrim($path, '/');
        return url($path);
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
     * Check if a file/directory exists
     * @param string $name
     * @return bool
     */
     public function exists($name){
         $name = $this->cleanPath($name);
         return $this->disk->exists($name);
     }

     /**
      * get all fiels in a given directory
      * @param string $folder
      * @return array $files
      */
     public function getAllFilesAt($folder, $fullPath=false){
         $folder = $this->cleanPath($folder);
         $files = $this->disk->files($folder);
         if($fullPath==true){
             $fullPathFiles = [];
             foreach($files as $file){
                 $fullPathFiles[] = $this->getWebpath($file);
             }
             //var_dump($fullPathFiles);

             return $fullPathFiles;
         }
         return $files;
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

        if(!$this->disk->exists($path)){
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

     /**
      * Move a directory(actuall rename).
      *
      * @param string $from
      * @param string $to
      * @return bool
      */
     public function moveDirectory($from, $to){
         $from = $this->cleanPath($from);
         $to = $this->cleanPath($to);

         $this->createDirectory($to);
         foreach($this->disk->files($from) as $file){

             $file = $this->cleanPath($file);
             $newFile = str_replace($from, $to, $file);
             $this->disk->move($file, $newFile);
         }
         return $this->disk->deleteDirectory($from, true);
     }
}
