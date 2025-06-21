@props(['author', 'size'])

@php
  $imageSize = match ($size ?? null) {
      'xs' => 'w-7 h-7',
      'sm' => 'w-9 h-9',
      'md' => 'w-11 h-11',
      'lg' => 'w-13 h-13',
      default => 'w-10 h-10',
  };

  $textSize = match ($size ?? null) {
      'xs' => 'text-xs',
      'sm' => 'text-sm',
      'md' => 'text-base',
      'lg' => 'text-lg',
      default => 'text-base',
  };
@endphp

<img class="{{ $imageSize }} rounded-full mr-2 text-black" src="{{ $author->profile_photo_url }}" alt="avatar">
<span class="{{ $textSize }} mr-1 text-black">{{ $author->name }}</span>
