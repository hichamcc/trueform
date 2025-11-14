@props(['width' => '200', 'height' => '60', 'class' => ''])

<svg width="{{ $width }}" height="{{ $height }}" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
    <!-- Geometric Icon - Transformation Symbol -->
    <g id="icon">
        <!-- Outer Circle (transformation ring) -->
        <circle cx="30" cy="30" r="22" stroke="url(#gradient1)" stroke-width="2" fill="none" opacity="0.6"/>

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

    <!-- Text -->
    <g id="text">
        <!-- TRUE FORM -->
        <text x="62" y="28" font-family="Arial, sans-serif" font-size="18" font-weight="700" fill="url(#textGradient)" letter-spacing="1">
            TRUE FORM
        </text>

        <!-- ELITE -->
        <text x="62" y="45" font-family="Arial, sans-serif" font-size="12" font-weight="600" fill="#9a9a9a" letter-spacing="2.5">
            ELITE
        </text>

        <!-- Decorative Line -->
        <line x1="62" y1="34" x2="190" y2="34" stroke="url(#lineGradient)" stroke-width="1" opacity="0.3"/>
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

        <!-- Text Gradient -->
        <linearGradient id="textGradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#f0f0f0;stop-opacity:1" />
            <stop offset="50%" style="stop-color:#e4e4e4;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#d1d1d1;stop-opacity:1" />
        </linearGradient>

        <!-- Line Gradient -->
        <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#9a9a9a;stop-opacity:0" />
            <stop offset="50%" style="stop-color:#d1d1d1;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#9a9a9a;stop-opacity:0" />
        </linearGradient>
    </defs>
</svg>
