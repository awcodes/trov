<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profiles
    |--------------------------------------------------------------------------
    |
    | You can add as many as you want of profiles to use it in your application.
    |
    */

    'profiles' => [

        'default' => [
            'plugins' => 'advlist autoresize codesample directionality emoticons fullscreen hr image imagetools link lists media table toc wordcount',
            'toolbar' => 'undo redo removeformat | formatselect fontsizeselect | bold italic | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
        ],

        'simple' => [
            'plugins' => 'autoresize directionality emoticons link wordcount',
            'toolbar' => 'removeformat | bold italic | rtl ltr | link emoticons',
        ],

        'custom' => [
            'plugins' => 'autoresize link hr fullscreen lists table code',
            'toolbar' => 'undo redo removeformat | formatselect | bold italic | numlist bullist | link table hr | code fullscreen',
        ],

        'barebone' => [
            'plugins' => 'autoresize link',
            'toolbar' => 'undo redo removeformat | bold italic | link',
        ],

    ],
];
