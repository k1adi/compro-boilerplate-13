@props([
    'settings',
    'seo',
])

@include('layouts.compro', [
    'settings' => $settings,
    'seo' => $seo,
    'slot' => $slot,
])

