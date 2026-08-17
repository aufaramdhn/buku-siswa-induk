<div class="w-full overflow-x-auto border border-neutral-200 rounded-xl bg-white shadow-sm">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse']) }}>
        {{ $slot }}
    </table>
</div>
