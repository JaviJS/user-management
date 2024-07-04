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
        // Inicializa un objeto stdClass para almacenar los datos del archivo subido
        $file = new stdClass();
        $file->url = '';
        $file->url_name = '';

        // Define la ruta completa en el servidor donde se almacenará el archivo
        $directory_root = public_path($base_path);
        $path = $base_path;

        // Obtiene los datos del archivo subido
        $file_data = $uploaded_file;

        // Obtiene la fecha y hora actual
        $now = Carbon::now();

        // Genera un nombre único para el archivo basado en el timestamp actual y el nombre original del archivo
        $name = md5($now->timestamp . $file_data->getClientOriginalName());
        $file_extension = strtolower($file_data->getClientOriginalExtension());
        $file_name = $name . "." . $file_extension;

        // Mueve el archivo subido al directorio especificado
        $file_data->move($directory_root, $file_name);

        // Genera un nombre para el archivo basado en su nombre original
        $nameFile = Str::slug(pathinfo($file_data->getClientOriginalName(), PATHINFO_FILENAME));
        $nameDownload = $nameFile . '.' . $file_extension;

        // Asigna la URL y el nombre del archivo al objeto stdClass
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

        // Define la ruta completa en el servidor del archivo a eliminar
        $root = public_path($base_path);

        // Verifica si la ruta del archivo no es nula
        if (!is_null($path)) {
            // Obtiene la ruta completa del archivo
            $file = $root . basename($path);

            // Verifica si el archivo existe en el servidor
            if (File::exists($file)) {
                // Intenta eliminar el archivo y actualiza la variable $deleted
                $deleted = File::delete($file);
            }
        }
        return $deleted;
    }
}