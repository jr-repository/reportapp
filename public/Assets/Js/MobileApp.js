(function () {
    const registerServiceWorker = async () => {
        if ('serviceWorker' in navigator) {
            try {
                await navigator.serviceWorker.register(window.baseUrl + 'service-worker.js?v=' + window.appAssetVersion);
                if (navigator.serviceWorker.controller) {
                    navigator.serviceWorker.controller.postMessage({
                        type: 'APP_VERSION',
                        version: window.appAssetVersion,
                    });
                }
            } catch (error) {
                console.warn('Service worker gagal didaftarkan', error);
            }
        }
    };

    const initPhotoPreview = () => {
        const input = document.getElementById('PhotoInput');
        const preview = document.getElementById('PhotoPreview');

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', () => {
            preview.innerHTML = '';
            Array.from(input.files || []).forEach((file) => {
                const image = document.createElement('img');
                image.src = URL.createObjectURL(file);
                image.alt = file.name;
                preview.appendChild(image);
            });
        });
    };

    const initCopyButtons = () => {
        document.querySelectorAll('[data-copy-target]').forEach((button) => {
            button.addEventListener('click', async () => {
                const targetId = button.getAttribute('data-copy-target');
                const target = document.getElementById(targetId);

                if (!target) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(target.textContent || '');
                    button.textContent = 'Tersalin';
                    setTimeout(() => {
                        button.textContent = 'Copy';
                    }, 1500);
                } catch (error) {
                    console.warn('Gagal copy teks', error);
                }
            });
        });
    };

    const initOvertimeToggle = () => {
        const toggle = document.getElementById('OvertimeToggle');
        const fields = document.getElementById('OvertimeFields');

        if (!toggle || !fields) {
            return;
        }

        const sync = () => {
            fields.style.display = toggle.value === '1' ? 'grid' : 'none';
        };

        toggle.addEventListener('change', sync);
        sync();
    };

    const initBannerCarousel = () => {
        const carousel = document.getElementById('BannerCarousel');
        const dotsWrap = document.getElementById('CarouselDots');

        if (!carousel || !dotsWrap) {
            return;
        }

        const slides = Array.from(carousel.children);
        const dots = Array.from(dotsWrap.children);

        const getActiveIndex = () => {
            let nearestIndex = 0;
            let nearestDistance = Number.POSITIVE_INFINITY;

            slides.forEach((slide, index) => {
                const distance = Math.abs(carousel.scrollLeft - slide.offsetLeft);
                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestIndex = index;
                }
            });

            return nearestIndex;
        };

        const syncDots = () => {
            const index = getActiveIndex();
            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('isActive', dotIndex === index);
            });
        };

        let activeIndex = 0;
        window.setInterval(() => {
            activeIndex = (activeIndex + 1) % slides.length;
            carousel.scrollTo({
                left: slides[activeIndex].offsetLeft,
                behavior: 'smooth',
            });
            syncDots();
        }, 3500);

        carousel.addEventListener('scroll', syncDots, { passive: true });
        syncDots();
    };

    const initReportWizard = () => {
        const form = document.getElementById('ReportWizardForm');
        if (!form) {
            return;
        }

        const steps = Array.from(form.querySelectorAll('.WizardStep'));
        const chips = Array.from(form.querySelectorAll('.WizardChip'));
        const currentStepInput = document.getElementById('CurrentStepInput');
        let currentStep = Number(form.dataset.step || currentStepInput?.value || 1);

        const totalSteps = steps.length;

        const syncStep = () => {
            currentStep = Math.max(1, Math.min(totalSteps, currentStep));

            steps.forEach((step) => {
                const stepNumber = Number(step.getAttribute('data-wizard-step'));
                step.style.display = stepNumber === currentStep ? 'block' : 'none';
            });

            chips.forEach((chip) => {
                const stepNumber = Number(chip.getAttribute('data-wizard-jump'));
                chip.classList.toggle('isActive', stepNumber === currentStep);
            });

            if (currentStepInput) {
                currentStepInput.value = String(currentStep);
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        form.querySelectorAll('[data-wizard-next]').forEach((button) => {
            button.addEventListener('click', () => {
                currentStep += 1;
                syncStep();
            });
        });

        form.querySelectorAll('[data-wizard-prev]').forEach((button) => {
            button.addEventListener('click', () => {
                currentStep -= 1;
                syncStep();
            });
        });

        chips.forEach((chip) => {
            chip.addEventListener('click', () => {
                currentStep = Number(chip.getAttribute('data-wizard-jump'));
                syncStep();
            });
        });

        syncStep();
    };

    document.addEventListener('DOMContentLoaded', () => {
        registerServiceWorker();
        initPhotoPreview();
        initCopyButtons();
        initOvertimeToggle();
        initBannerCarousel();
        initReportWizard();
    });
})();
