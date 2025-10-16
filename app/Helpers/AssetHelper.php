<?php

namespace App\Helpers;

class AssetHelper
{
    public static function getViteAssets()
    {
        try {
            // In local development, always return null to use @vite directive
            if (app()->environment('local', 'development')) {
                return [
                    'css' => null,
                    'js' => null
                ];
            }
            
            $manifestPath = public_path('build/manifest.json');
            
            if (!file_exists($manifestPath)) {
                return [
                    'css' => null,
                    'js' => null
                ];
            }
            
            $manifestContent = file_get_contents($manifestPath);
            if (!$manifestContent) {
                return [
                    'css' => null,
                    'js' => null
                ];
            }
            
            $manifest = json_decode($manifestContent, true);
            
            if (!$manifest || json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'css' => null,
                    'js' => null
                ];
            }
            
            return [
                'css' => isset($manifest['resources/css/app.css']) ? 
                    secure_asset('build/' . $manifest['resources/css/app.css']['file']) : null,
                'js' => isset($manifest['resources/js/app.js']) ? 
                    secure_asset('build/' . $manifest['resources/js/app.js']['file']) : null,
            ];
        } catch (\Exception $e) {
            // If any error occurs, return null to fall back to @vite directive
            return [
                'css' => null,
                'js' => null
            ];
        }
    }
}
