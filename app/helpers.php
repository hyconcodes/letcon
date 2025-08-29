<?php

if (!function_exists('storage_asset')) {
    function storage_asset($path) {
        // For your specific production setup
        if (config('app.env') === 'production') {
            return asset('storage/app/public/' . $path);
        }
        
        // Standard for local/other environments
        return asset('storage/' . $path);
    }
}