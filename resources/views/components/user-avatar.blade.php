@props(['user', 'size' => 'md'])

@php
    $classes = match ($size) {
        'sm' => 'w-6 h-6 text-[10px]',
        'lg' => 'w-10 h-10 text-sm',
        default => 'w-8 h-8 text-xs',
    };
@endphp

@if ($user?->avatar)
    <img src="{{ $user->avatar }}"
         alt="{{ $user->name }}"
         {{ $attributes->merge(['class' => $classes . ' rounded-full object-cover shrink-0']) }}>
@else
    <span {{ $attributes->merge([
        'class' => $classes . ' rounded-full bg-[#F0EEE6] text-[#1C2333] flex items-center justify-center font-semibold shrink-0'
    ]) }}>
        {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
    </span>
@endif
