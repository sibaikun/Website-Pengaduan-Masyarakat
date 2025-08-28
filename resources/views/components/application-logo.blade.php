<img src="{{ asset('images/Lambang_Kota_Semarang.png') }}" 
     alt="{{ config('app.name', 'Laravel') }}" 
     {{ $attributes->merge(['class' => 'application-logo']) }}>

<style>
.application-logo {
    max-height: 40px;
    max-width: 120px;
    object-fit: contain;
    height: auto;
    width: auto;
}

/* Untuk responsive */
@media (max-width: 768px) {
    .application-logo {
        max-height: 32px;
        max-width: 100px;
    }
}

/* Untuk dark mode jika diperlukan */
@media (prefers-color-scheme: dark) {
    .application-logo {
        filter: brightness(1.1);
    }
}
</style>