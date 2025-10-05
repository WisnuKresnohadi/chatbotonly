<style>
    .on-active-dark::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 163, 95, 0.7); 
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1; 
        border-radius: 0.375rem;
    }

    .on-active-dark:active::after {
        opacity: 1; 
    }

    .on-active-dark:active .bookmark i {
        color: white;
    }
</style>