<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('trace_app_name')) {
    function trace_app_name(): string
    {
        return 'TRACE';
    }
}

if (! function_exists('trace_app_tagline')) {
    function trace_app_tagline(): string
    {
        return 'Tracking Report & Activity Control Engine';
    }
}

if (! function_exists('trace_app_brand')) {
    function trace_app_brand(): string
    {
        return trace_app_name() . ' — ' . trace_app_tagline();
    }
}

if (! function_exists('trace_logo_path')) {
    function trace_logo_path(): string
    {
        return FCPATH . 'Assets/Image/logo.png';
    }
}

if (! function_exists('trace_logo_url')) {
    function trace_logo_url(): string
    {
        return base_url('Assets/Image/logo.png');
    }
}

if (! function_exists('trace_icon')) {
    function trace_icon(string $name): string
    {
        return match ($name) {
            'logout' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 8l4 4-4 4"/><path d="M19 12H9"/><path d="M13 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/></svg>',
            'profile' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.8-3.4 5-5 8-5s6.2 1.6 8 5"/></svg>',
            'home', 'house' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10.5V20h13V10.5"/></svg>',
            'document' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 3.5h6l4 4V20H8z"/><path d="M14 3.5V8h4"/></svg>',
            'user' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.8-3.4 5-5 8-5s6.2 1.6 8 5"/></svg>',
            'chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 18V9"/><path d="M12 18V5"/><path d="M19 18v-7"/><path d="M3.5 20h17"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 5 6v5c0 4.6 2.9 8.9 7 10 4.1-1.1 7-5.4 7-10V6l-7-3Z"/><path d="m9.5 12 1.8 1.8L14.8 10"/></svg>',
            'analytics' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16"/><path d="M7 16V9"/><path d="M12 16V5"/><path d="M17 16v-4"/></svg>',
            'edit' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1 9.7-9.7a2.1 2.1 0 0 0-3-3L5.5 16 4 20Z"/><path d="m13.5 6.5 4 4"/></svg>',
            'detail' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.6-6 9.5-6 9.5 6 9.5 6-3.6 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.7"/></svg>',
            'pdf' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 3.5h6l4 4V20H8z"/><path d="M14 3.5V8h4"/><path d="M10 14h4"/><path d="M10 17h4"/></svg>',
            'toggle' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="8" width="18" height="8" rx="4"/><circle cx="15.5" cy="12" r="2.5"/></svg>',
            'copy' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="9" y="9" width="10" height="10" rx="2"/><path d="M6 15H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1"/></svg>',
            'install' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v10"/><path d="m8.5 10.5 3.5 3.5 3.5-3.5"/><path d="M5 19h14"/></svg>',
            'close' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12"/><path d="M18 6 6 18"/></svg>',
            'next' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>',
            'back' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 6-6 6 6 6"/></svg>',
            default => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/></svg>',
        };
    }
}
