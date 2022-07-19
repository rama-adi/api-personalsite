<?php

return [
    'model' => \FilamentCurator\Models\Media::class,
    'disk' => 'r2',
    'visibility' => 'private',
    'directory' => 'site-media',
    'preserve_file_names' => false,
    'accepted_file_types' => ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'],
    'max_width' => 5000,
    'min_size' => null,
    'max_size' => 5000,
    'rules' => [],
    'cloud_disks' => ['cloudinary', 's3', 'r2'],
    'sizes' => [

    ],
];
