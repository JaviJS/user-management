<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str as Str;
use Carbon\Carbon;
use stdClass;

trait FileTrait
{
    /**
     * It takes a file, moves it to a directory, and returns an object with the file's URL and the
     * file's name
     * 
     * @param base_path The path to the folder where the file will be stored.
     * @param UploadedFile file The file to be uploaded.
     */
    protected function file_upload($base_path, UploadedFile $uploaded_file)
    {
        $file = new stdClass();
        $file->url = '';
        $file->url_name = '';

        $directory_root = public_path($base_path);
        $path = $base_path;

        $file_data = $uploaded_file;

        $now = Carbon::now();

        $name = md5($now->timestamp . $file_data->getClientOriginalName());
        $file_extension = strtolower($file_data->getClientOriginalExtension());
        $file_name = $name . "." . $file_extension;
        $file_data->move($directory_root, $file_name);

        $nameFile = Str::slug(pathinfo($file_data->getClientOriginalName(), PATHINFO_FILENAME));
        $nameDownload = $nameFile . '.' . $file_extension;
        $file->url = $path . $file_name;
        $file->url_name = $nameDownload;
        return $file;
    }

    /**
     * It deletes a file from the server
     * 
     * @param base_path The base path of the file.
     * @param path The path to the file you want to delete.
     * 
     * @return boolean value.
     */
    protected function file_delete($base_path, $path)
    {
        $deleted = false;
        $root = public_path($base_path);
        if (!is_null($path)) {
            $file = $root . basename($path);
            if (File::exists($file)) {
                $deleted = File::delete($file);
            }
        }
        return $deleted;
    }
}