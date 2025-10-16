<?php

namespace App\Helpers;

class AssetHelper
{
    public static function getViteAssets()
    {
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
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        if (!$manifest) {
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
    }
}
