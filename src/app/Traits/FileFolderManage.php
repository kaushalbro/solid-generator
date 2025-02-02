<?php
namespace Devil\Solidprinciple\app\Traits;

use ZipArchive;

trait FileFolderManage
{
    public static string $warningColor= "\033[33m%s\033[0m";
    public static string $greenColor= "\033[32m%s\033[0m";
    public static string $dangerColor= "\033[31m%s\033[0m";
    public function makeDirectory($path)
    {
        try {
            $directoryPath= base_path($path);
            $path_array = explode('/', $path);
            $is_directory =  is_dir($directoryPath);
            if (!$is_directory){
                mkdir($directoryPath, 0777, true);
                error_log(sprintf(self::$greenColor,end($path_array).' Folder Created.'));
                return $directoryPath;
            }
            if (config('solid.show_folder_already_exists_warning')){
                error_log(sprintf(self::$warningColor,end($path_array).' Folder already Exists.'));
            }
            return $directoryPath;
        }catch (\Exception $e){
            error_log($e->getMessage());
        }
    }

    public function makeFile($path, $data=null)
    {
        try {
            $filePath= base_path($path);
            $path_array = explode('/', $path);
            $file_name= end($path_array);
            $is_file =  file_exists($filePath);
//            if (config('solid.override_previous_file_data')){
//                if ($is_file){
//                    unlink($filePath);
//                }
//            }
            if (!$is_file){
                file_put_contents($path, $data);
//              remove new and empty lines of file
                $newContent =file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $newContent=array_values(array_filter($newContent, function($value) {
                    return trim($value) !== '';
                }));
                file_put_contents($path, implode(PHP_EOL, $newContent));
                error_log(sprintf(self::$greenColor,$path_array[count($path_array)-2]. ' '.end($path_array).' File Created.'));
                return $filePath;
            }
            if (config('solid.show_file_already_exists_warning')){
                error_log(sprintf(self::$warningColor,sprintf(self::$warningColor," ".$file_name)." File already Exists At: $filePath"));
            }
            return $filePath;
        }catch (\Exception $e){
            error_log($e->getMessage());
        }
    }

    public function copy($source_path,$destination_path){
        $path_array = explode('/', $source_path);
        $file_name= end($path_array);
        if (!file_exists($destination_path)) {
            if (copy($source_path, $destination_path)) {
                error_log(sprintf(self::$greenColor,$file_name.' File Copied successfully.'));
                return true;
            } else {
                error_log(sprintf(self::$dangerColor, ' Failed to copy file.'. $file_name));
            }
        }
        error_log(sprintf(self::$warningColor,$file_name.' File already Exists.'));
        return false;
    }

    public function unzip($source_file_path,$file_destination,$extraction_path){
        if (!file_exists($source_file_path)){
          error_log(sprintf(self::$dangerColor, ' File No exists.'));
            return false;
        }
            $zip = new ZipArchive();
        //            sudo apt update
        //            sudo apt install php-zip
        if ($zip->open($file_destination) === true) {
            $zip->extractTo($extraction_path);
            $zip->close();
            error_log(sprintf(self::$greenColor,'File Unzipped successfully.'));
            return true ;
        } else {
            error_log(sprintf(self::$dangerColor, ' Failed to Unzip file.'));
            return false ;
        }
    }

}
