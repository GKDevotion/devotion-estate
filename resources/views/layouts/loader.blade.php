<div id="page-loader" class="loader-overlay">
    <div class="loader-content">
        <img src="{{ asset('public\img\devotion-trusted-real-estate.png') }}" alt="Devotion Loader Logo" class="loader-logo">
    </div>
</div>
<style>
    /* Loader Styles */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
}

.loader-content {
    text-align: center;
}

.loader-logo {
    width: 250px;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.05); }
}

.loader-overlay.hidden {
    opacity: 0;
    pointer-events: none;
    visibility: hidden;
}

</style>

