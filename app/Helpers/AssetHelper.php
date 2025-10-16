<?php

namespace App\Helpers;

class AssetHelper
{
    public static function getViteAssets()
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (!file_exists($manifestPath)) {
            return [
                'css' => null,
                'js' => null
            ];
        }
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        return [
            'css' => isset($manifest['resources/css/app.css']) ? 
                secure_asset('build/' . $manifest['resources/css/app.css']['file']) : null,
            'js' => isset($manifest['resources/js/app.js']) ? 
                secure_asset('build/' . $manifest['resources/js/app.js']['file']) : null,
        ];
    }
}
