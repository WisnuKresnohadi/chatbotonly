<style>
    .on-hover-dark::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); 
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1; 
        border-radius: 0.375rem;
    }

    .on-hover-dark:hover::after {
        opacity: 1; 
    }

    .on-hover-dark::before {
        content: "Tampilkan Rincian";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
        font-family: var(--bs-body-font-family);
        font-weight: var(--bs-body-font-weight);
    }

    .on-hover-dark:hover::before {
        opacity: 1;
    }

    .bookmark {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 3;
    }

    .on-hover-dark:hover .bookmark i {
        color: white;
    }
</style>