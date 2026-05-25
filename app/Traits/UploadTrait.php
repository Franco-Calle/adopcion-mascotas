<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;

trait UploadTrait
{
    /**
     * Subir imagen a Cloudinary
     */
    public function uploadToCloudinary(UploadedFile $file, $folder = 'mascotas')
    {
        try {
            // Instanciar Cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => [
                    'secure' => true
                ]
            ]);

            // Subir el archivo
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $folder,
                'public_id' => uniqid(),
                'transformation' => [
                    'width' => 1024,
                    'height' => 1024,
                    'crop' => 'limit',
                    'quality' => 'auto'
                ]
            ]);

            // Retornar la URL segura
            return $result['secure_url'];
            
        } catch (\Exception $e) {
            Log::error('Error en Cloudinary: ' . $e->getMessage());
            throw new \Exception('Error al subir la imagen: ' . $e->getMessage());
        }
    }

    /**
     * Subir múltiples imágenes
     */
    public function uploadMultipleToCloudinary(array $files, $folder = 'mascotas')
    {
        $urls = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $urls[] = $this->uploadToCloudinary($file, $folder);
            }
        }
        
        return $urls;
    }
}