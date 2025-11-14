@props(['size' => 'base', 'class' => ''])

@php
$sizeClasses = [
    'xs' => 'text-xs',
    'sm' => 'text-sm',
    'base' => 'text-base',
    'lg' => 'text-lg',
    'xl' => 'text-xl',
    '2xl' => 'text-2xl',
    '3xl' => 'text-3xl',
];

$fontSize = $sizeClasses[$size] ?? $sizeClasses['base'];
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="{{ $fontSize }} font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent tracking-wide">
        TRUE FORM
    </div>
    <div class="text-xs text-silver-500 tracking-[0.2em] font-semibold mt-0.5">
        ELITE
    </div>
</div>
