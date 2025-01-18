@props(['number', 'label', 'prefix' => '', 'suffix' => ''])

<div class="text-center">
    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400">
        {{ $prefix }}{{ $number }}{{ $suffix }}
    </div>
    <div class="mt-2 text-gray-600 dark:text-gray-400">
        {{ $label }}
    </div>
</div>