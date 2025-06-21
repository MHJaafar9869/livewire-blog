@props(['bgColor', 'textColor'])

@php
    $bgColor = match ($bgColor) {
        'red' => 'bg-red-100',
        'blue' => 'bg-blue-100',
        'green' => 'bg-green-100',
        'yellow' => 'bg-yellow-100',
        default => 'bg-gray-100',
    };

    $textColor = match ($textColor) {
        'red' => 'text-red-800',
        'blue' => 'text-blue-800',
        'green' => 'text-green-800',
        'yellow' => 'text-yellow-800',
        default => 'text-gray-800',
    };
@endphp

<button {{ $attributes }} class="{{ implode(' ', [$bgColor, $textColor]) }} rounded-xl px-3 py-1 text-base">
    {{ $slot }}
</button>
