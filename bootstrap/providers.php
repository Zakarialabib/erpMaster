<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\GoogleDriveServiceProvider::class, 
    Spatie\Permission\PermissionServiceProvider::class,
    // Intervention\Image\ImageServiceProvider::class,
    Milon\Barcode\BarcodeServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
    Mccarlosen\LaravelMpdf\LaravelMpdfServiceProvider::class,
];