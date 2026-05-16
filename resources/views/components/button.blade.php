@php
    $baseClasses = "inline-flex items-center justify-center font-medium transition-all duration-200 cursor-pointer text-center whitespace-nowrap select-none scale-95 active:scale-90";
    
    $sizes = [
        'nav' => $variant === 'ghost' ? "text-label-md font-label-md py-2" : "px-6 py-2.5 rounded-full text-label-md font-label-md shadow-sm",
        'hero' => "px-8 py-4 rounded-xl text-headline-md font-headline-md shadow-lg hover:shadow-xl w-full sm:w-auto"
    ];

    $variants = [
        'primary' => "bg-accent-purple text-white hover:opacity-90",
        
        'ghost' => "text-on-surface-variant hover:text-primary bg-transparent shadow-none border-none rounded-none",
        
        'outline' => "bg-surface-container-low text-on-surface border border-outline-variant hover:bg-surface-container-high",
        'outline2' => "bg-transparent text-white border border-white/30 hover:bg-white/10",
        'inverse' => "bg-white text-accent-purple hover:bg-surface-container-low"
    ];

    $classes = $baseClasses . " " . ($sizes[$size] ?? $sizes['nav']) . " " . ($variants[$variant] ?? $variants['primary']);
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>