@props(['size' => '48', 'class' => ''])

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
    <!-- Geometric Icon - Transformation Symbol -->
    <g id="icon">
        <!-- Outer Circle (transformation ring) -->
        <circle cx="30" cy="30" r="22" stroke="url(#gradient1)" stroke-width="2.5" fill="none" opacity="0.6"/>

        <!-- Inner Triangular Form (upward growth) -->
        <path d="M30 12 L42 36 L18 36 Z" fill="url(#gradient2)" opacity="0.9"/>

        <!-- Central Diamond (core strength) -->
        <path d="M30 20 L36 30 L30 40 L24 30 Z" fill="url(#gradient3)"/>

        <!-- Energy Pulses -->
        <circle cx="30" cy="30" r="28" stroke="url(#gradient1)" stroke-width="1" fill="none" opacity="0.2">
            <animate attributeName="r" values="28;32;28" dur="3s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values="0.2;0;0.2" dur="3s" repeatCount="indefinite"/>
        </circle>
    </g>

    <!-- Gradients -->
    <defs>
        <!-- Icon Gradients -->
        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#e4e4e4;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#b4b4b4;stop-opacity:1" />
        </linearGradient>

        <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#f0f0f0;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#d1d1d1;stop-opacity:1" />
        </linearGradient>

        <linearGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.9" />
            <stop offset="50%" style="stop-color:#e4e4e4;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#b4b4b4;stop-opacity:1" />
        </linearGradient>
    </defs>
</svg>
