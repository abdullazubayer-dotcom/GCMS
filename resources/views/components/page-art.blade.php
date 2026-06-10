@props(['type' => 'dashboard'])

@php
    $palette = [
        'dashboard' => ['#0f766e', '#b7791f', '#172033'],
        'members' => ['#2563eb', '#0f766e', '#172033'],
        'member-form' => ['#7c3aed', '#0f766e', '#172033'],
        'member-detail' => ['#0891b2', '#b7791f', '#172033'],
        'events' => ['#dc2626', '#b7791f', '#172033'],
        'event-form' => ['#ea580c', '#0f766e', '#172033'],
        'payments' => ['#16a34a', '#b7791f', '#172033'],
        'payment-form' => ['#059669', '#2563eb', '#172033'],
        'reports' => ['#4f46e5', '#0f766e', '#172033'],
        'notifications' => ['#be123c', '#2563eb', '#172033'],
        'member-dashboard' => ['#0f766e', '#2563eb', '#172033'],
        'profile' => ['#0891b2', '#7c3aed', '#172033'],
        'member-events' => ['#dc2626', '#ea580c', '#172033'],
        'member-payments' => ['#16a34a', '#059669', '#172033'],
        'member-notifications' => ['#be123c', '#b7791f', '#172033'],
        'login' => ['#0f766e', '#2563eb', '#172033'],
        'password' => ['#7c3aed', '#be123c', '#172033'],
    ][$type] ?? ['#0f766e', '#b7791f', '#172033'];

    [$primary, $accent, $ink] = $palette;
    $membersArt = in_array($type, ['members', 'member-form', 'member-detail'], true);
    $eventsArt = in_array($type, ['events', 'event-form', 'member-events'], true);
    $paymentsArt = in_array($type, ['payments', 'payment-form', 'member-payments'], true);
    $notificationsArt = in_array($type, ['notifications', 'member-notifications'], true);
    $dashboardArt = in_array($type, ['dashboard', 'member-dashboard', 'profile'], true);
    $authArt = in_array($type, ['login', 'password'], true);
@endphp

<svg {{ $attributes->merge(['class' => 'page-art-svg']) }} viewBox="0 0 520 300" role="img" aria-label="Page artwork">
    <defs>
        <linearGradient id="artGradient-{{ $type }}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="{{ $primary }}" stop-opacity=".95" />
            <stop offset="100%" stop-color="{{ $accent }}" stop-opacity=".82" />
        </linearGradient>
        <filter id="softShadow-{{ $type }}" x="-20%" y="-20%" width="140%" height="140%">
            <feDropShadow dx="0" dy="14" stdDeviation="16" flood-color="#0f172a" flood-opacity=".18" />
        </filter>
    </defs>

    <rect x="16" y="18" width="488" height="264" rx="28" fill="#ffffff" opacity=".92" filter="url(#softShadow-{{ $type }})" />
    <path d="M44 238 C122 192, 176 260, 246 214 S372 142, 478 198" fill="none" stroke="{{ $primary }}" stroke-width="3" stroke-linecap="round" stroke-dasharray="8 10" opacity=".35" />
    <circle cx="442" cy="64" r="32" fill="url(#artGradient-{{ $type }})" opacity=".16" />
    <circle cx="84" cy="72" r="24" fill="{{ $accent }}" opacity=".16" />

    @if ($membersArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="176" cy="104" r="34" />
            <path d="M118 204 C126 158, 151 138, 176 138 C201 138, 226 158, 234 204" />
            <circle cx="310" cy="118" r="28" />
            <path d="M262 210 C268 170, 290 152, 310 152 C332 152, 354 170, 360 210" />
            <rect x="378" y="92" width="68" height="96" rx="10" stroke="{{ $primary }}" />
            <path d="M394 120 H430 M394 144 H420 M394 168 H434" stroke="{{ $accent }}" stroke-width="4" />
        </g>
    @elseif ($eventsArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="118" y="76" width="260" height="164" rx="18" />
            <path d="M118 124 H378 M172 58 V96 M324 58 V96" />
            <path d="M168 162 H204 M232 162 H268 M296 162 H332 M168 200 H204 M232 200 H268" stroke="{{ $primary }}" />
            <path d="M406 154 L446 178 L406 202 Z" stroke="{{ $accent }}" />
        </g>
    @elseif ($paymentsArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="112" y="84" width="296" height="156" rx="20" />
            <path d="M112 132 H408" />
            <path d="M154 178 H242 M154 208 H214" stroke="{{ $primary }}" />
            <circle cx="336" cy="194" r="38" stroke="{{ $accent }}" />
            <path d="M336 168 V220 M318 182 C330 170, 356 174, 352 194 C350 210, 322 204, 318 218" />
        </g>
    @elseif ($type === 'reports')
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="112" y="70" width="286" height="176" rx="18" />
            <path d="M152 204 V160 M218 204 V126 M284 204 V146 M350 204 V106" stroke="{{ $primary }}" />
            <path d="M144 110 H236 M144 132 H206" stroke="{{ $accent }}" />
            <path d="M144 220 H364" />
        </g>
    @elseif ($notificationsArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M150 114 C150 82, 176 58, 210 58 H312 C346 58, 372 82, 372 114 V186 C372 218, 346 242, 312 242 H210 C176 242, 150 218, 150 186 Z" />
            <path d="M164 104 L260 166 L358 104" stroke="{{ $primary }}" />
            <path d="M394 70 C430 92, 446 128, 438 166 M416 58 C462 88, 480 138, 466 190" stroke="{{ $accent }}" />
        </g>
    @elseif ($dashboardArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="94" y="84" width="140" height="118" rx="18" />
            <rect x="268" y="64" width="158" height="158" rx="20" />
            <circle cx="164" cy="126" r="22" stroke="{{ $primary }}" />
            <path d="M126 174 C134 150, 150 140, 164 140 C180 140, 196 150, 202 174" stroke="{{ $primary }}" />
            <path d="M300 112 H388 M300 148 H364 M300 184 H392" stroke="{{ $accent }}" />
        </g>
    @elseif ($authArt)
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="160" y="128" width="200" height="112" rx="18" />
            <path d="M198 128 V98 C198 64, 224 42, 260 42 C296 42, 322 64, 322 98 V128" stroke="{{ $primary }}" />
            <circle cx="260" cy="180" r="15" stroke="{{ $accent }}" />
            <path d="M260 196 V214" stroke="{{ $accent }}" />
        </g>
    @else
        <g fill="none" stroke="{{ $ink }}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="110" y="84" width="300" height="156" rx="22" />
            <path d="M150 132 H370 M150 172 H306 M150 212 H338" stroke="{{ $primary }}" />
            <circle cx="390" cy="88" r="34" stroke="{{ $accent }}" />
        </g>
    @endif
</svg>
