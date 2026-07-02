<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 border-0 rounded-full font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 shadow-sm', 'style' => 'background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);']) }}>
    {{ $slot }}
</button>
