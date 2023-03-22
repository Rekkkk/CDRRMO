<?php

return [

    'cdn' => env('SWEET_ALERT_CDN'),

    'alwaysLoadJS' => env('SWEET_ALERT_ALWAYS_LOAD_JS', false),

    'neverLoadJS' => env('SWEET_ALERT_NEVER_LOAD_JS', false),

    'timer' => env('SWEET_ALERT_TIMER', 5000),

    'width' => env('SWEET_ALERT_WIDTH', '32rem'),

    'height_auto' => env('SWEET_ALERT_HEIGHT_AUTO', true),

    'padding' => env('SWEET_ALERT_PADDING', '1.25rem'),

    'animation' => [
        'enable' => env('SWEET_ALERT_ANIMATION_ENABLE', false),
    ],

    'animatecss' => env('SWEET_ALERT_ANIMATECSS', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'),

    'show_confirm_button' => env('SWEET_ALERT_CONFIRM_BUTTON', true),

    'show_close_button' => env('SWEET_ALERT_CLOSE_BUTTON', false),

    'toast_position' => env('SWEET_ALERT_TOAST_POSITION', 'top-end'),

    'timer_progress_bar' => env('SWEET_ALERT_TIMER_PROGRESS_BAR', false),

    'middleware' => [

        'autoClose' => env('SWEET_ALERT_MIDDLEWARE_AUTO_CLOSE', false),

        'toast_position' => env('SWEET_ALERT_MIDDLEWARE_TOAST_POSITION', 'top-end'),

        'toast_close_button' => env('SWEET_ALERT_MIDDLEWARE_TOAST_CLOSE_BUTTON', true),

        'timer' => env('SWEET_ALERT_MIDDLEWARE_ALERT_CLOSE_TIME', 6000),

        'auto_display_error_messages' => env('SWEET_ALERT_AUTO_DISPLAY_ERROR_MESSAGES', false),
    ],

    'customClass' => [

        'container' => env('SWEET_ALERT_CONTAINER_CLASS'),
        'popup' => env('SWEET_ALERT_POPUP_CLASS'),
        'header' => env('SWEET_ALERT_HEADER_CLASS'),
        'title' => env('SWEET_ALERT_TITLE_CLASS'),
        'closeButton' => env('SWEET_ALERT_CLOSE_BUTTON_CLASS'),
        'icon' => env('SWEET_ALERT_ICON_CLASS'),
        'image' => env('SWEET_ALERT_IMAGE_CLASS'),
        'content' => env('SWEET_ALERT_CONTENT_CLASS'),
        'input' => env('SWEET_ALERT_INPUT_CLASS'),
        'actions' => env('SWEET_ALERT_ACTIONS_CLASS'),
        'confirmButton' => env('SWEET_ALERT_CONFIRM_BUTTON_CLASS'),
        'cancelButton' => env('SWEET_ALERT_CANCEL_BUTTON_CLASS'),
        'footer' => env('SWEET_ALERT_FOOTER_CLASS'),
    ],

];