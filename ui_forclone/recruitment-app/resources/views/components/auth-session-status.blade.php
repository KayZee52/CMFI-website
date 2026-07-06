@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-sm font-semibold text-emerald-700 animate-fadeIn']) }}>
        {{ $status }}
    </div>
@endif
