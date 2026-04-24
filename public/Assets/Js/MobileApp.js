(function () {
    let deferredInstallPrompt = null;

    const registerServiceWorker = async () => {
        if (!('serviceWorker' in navigator)) {
            return;
        }

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
    };

    const initAos = () => {
        const animatedSelectors = [
            '.PageHeader',
            '.WelcomeBanner',
            '.InfoCard',
            '.FormSectionCard',
            '.GlassCard',
            '.AuthFooterCard',
            '.SuccessCard',
            '.CarouselSection',
            '.MetricCard',
            '.MiniMetricCard',
            '.ProfileHeroCard',
            '.AuthBrand',
        ];

        animatedSelectors.forEach((selector) => {
            document.querySelectorAll(selector).forEach((element, index) => {
                if (!element.hasAttribute('data-aos')) {
                    element.setAttribute('data-aos', 'fade-up');
                    element.setAttribute('data-aos-delay', String(Math.min(index * 50, 220)));
                }
            });
        });

        if (window.AOS) {
            window.AOS.init({
                duration: 650,
                once: true,
                offset: 16,
                easing: 'ease-out-cubic',
            });
        }
    };

    const initSplashScreen = () => {
        const splash = document.getElementById('AppSplashScreen');

        if (!splash) {
            return;
        }

        window.setTimeout(() => {
            splash.classList.add('isHidden');
        }, 1450);
    };

    const updateInstallPromptVisibility = (visible) => {
        const prompt = document.getElementById('PwaInstallPrompt');

        if (!prompt) {
            return;
        }

        prompt.hidden = !visible;
    };

    const isStandaloneMode = () =>
        window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

    const isMobileViewport = () => window.matchMedia('(max-width: 820px)').matches;

    const showManualInstallHint = () => {
        const isIos = /iphone|ipad|ipod/i.test(window.navigator.userAgent);
        const message = isIos
            ? 'Untuk install TRACE di iPhone/iPad, buka menu Share lalu pilih Add to Home Screen.'
            : 'Untuk install TRACE, buka menu browser lalu pilih Install App atau Tambahkan ke layar utama.';

        window.alert(message);
    };

    const initInstallPrompt = () => {
        const installButton = document.getElementById('InstallAppButton');
        const dismissButton = document.getElementById('DismissInstallPrompt');

        if (!installButton || !dismissButton || isStandaloneMode()) {
            updateInstallPromptVisibility(false);
            return;
        }

        const dismissedKey = 'trace-install-dismissed';

        if (window.localStorage.getItem(dismissedKey) === '1') {
            updateInstallPromptVisibility(false);
        }

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredInstallPrompt = event;

            if (window.localStorage.getItem(dismissedKey) !== '1') {
                updateInstallPromptVisibility(true);
            }
        });

        installButton.addEventListener('click', async () => {
            if (!deferredInstallPrompt) {
                showManualInstallHint();
                return;
            }

            deferredInstallPrompt.prompt();
            await deferredInstallPrompt.userChoice;
            deferredInstallPrompt = null;
            updateInstallPromptVisibility(false);
        });

        dismissButton.addEventListener('click', () => {
            window.localStorage.setItem(dismissedKey, '1');
            updateInstallPromptVisibility(false);
        });

        window.addEventListener('appinstalled', () => {
            deferredInstallPrompt = null;
            updateInstallPromptVisibility(false);
            window.localStorage.removeItem(dismissedKey);
        });

        window.setTimeout(() => {
            if (!deferredInstallPrompt && !isStandaloneMode() && isMobileViewport() && window.localStorage.getItem(dismissedKey) !== '1') {
                updateInstallPromptVisibility(true);
            }
        }, 1800);
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

                const defaultLabel = button.getAttribute('data-copy-default-label') || 'Salin';
                const successLabel = button.getAttribute('data-copy-success-label') || 'Tersalin';

                try {
                    await navigator.clipboard.writeText(target.textContent || '');
                    button.classList.add('CopySuccess');
                    button.setAttribute('aria-label', successLabel);
                    button.setAttribute('title', successLabel);

                    window.setTimeout(() => {
                        button.classList.remove('CopySuccess');
                        button.setAttribute('aria-label', defaultLabel);
                        button.setAttribute('title', defaultLabel);
                    }, 1600);
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

        if (slides.length === 0 || dots.length === 0) {
            return;
        }

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

    const initViewportAssist = () => {
        const root = document.documentElement;
        const focusSelector = 'input, textarea, select';

        const scrollFocusedFieldIntoView = () => {
            const activeElement = document.activeElement;

            if (!(activeElement instanceof HTMLElement) || !activeElement.matches(focusSelector)) {
                return;
            }

            window.setTimeout(() => {
                activeElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest',
                });
            }, 260);
        };

        document.addEventListener('focusin', (event) => {
            if (event.target instanceof HTMLElement && event.target.matches(focusSelector)) {
                scrollFocusedFieldIntoView();
            }
        });

        const syncViewportState = () => {
            if (!window.visualViewport) {
                return;
            }

            const keyboardHeight = window.innerHeight - window.visualViewport.height;
            const isKeyboardOpen = keyboardHeight > 140;

            document.body.classList.toggle('KeyboardOpen', isKeyboardOpen);
            root.style.setProperty('--KeyboardInset', isKeyboardOpen ? '0px' : '0px');

            if (isKeyboardOpen) {
                scrollFocusedFieldIntoView();
            }
        };

        if (window.visualViewport) {
            window.visualViewport.addEventListener('resize', syncViewportState);
            window.visualViewport.addEventListener('scroll', syncViewportState);
            syncViewportState();
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        registerServiceWorker();
        initAos();
        initSplashScreen();
        initInstallPrompt();
        initPhotoPreview();
        initCopyButtons();
        initOvertimeToggle();
        initBannerCarousel();
        initReportWizard();
        initViewportAssist();
    });
})();
