<?php

return [
    'disks' => [
        'qcloud_oss' => [
            'driver'    => 'qcloud_oss',
            'region'    => env('QCLOUDREGION', 'ap-guangzhou'),
            'secretId'  => env('QCLOUDSECRETID', ''),
            'secretKey' => env('QCLOUDSECRETKEY', ''),
            'bucket'    => env('QCLOUDBUCKET', ''),
        ],
    ],
    'ui_url' => 'qcloud',
];