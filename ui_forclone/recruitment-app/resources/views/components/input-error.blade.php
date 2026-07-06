@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[13px] font-bold text-rose-500 space-y-1 animate-fadeIn']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
