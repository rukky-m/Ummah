import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// --- PWA Service Worker Registration ---
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').then((registration) => {
            console.log('SW registered:', registration);
        }).catch((error) => {
            console.log('SW registration failed:', error);
        });
    });
}

// --- PWA Installation Logic ---
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the default browser prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    
    // Check if user has already dismissed it completely OR is in standalone mode
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
    const isDismissed = localStorage.getItem('pwa_install_dismissed') === 'true';

    if (!isStandalone && !isDismissed) {
        // Dispatch an Alpine event to show the popup
        window.dispatchEvent(new CustomEvent('show-pwa-prompt'));
    }
});

window.addEventListener('appinstalled', () => {
    // Log installation and hide prompt
    console.log('PWA was installed');
    deferredPrompt = null;
    window.dispatchEvent(new CustomEvent('hide-pwa-prompt'));
});

// Expose install function globally for Alpine and Profile page
window.installPWA = async () => {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    const { outcome } = await deferredPrompt.userChoice;
    if (outcome === 'accepted') {
        console.log('User accepted the install prompt');
    } else {
        console.log('User dismissed the install prompt');
    }
    deferredPrompt = null;
};

window.dismissPWA = (permanent = false) => {
    if (permanent) {
        localStorage.setItem('pwa_install_dismissed', 'true');
    }
    window.dispatchEvent(new CustomEvent('hide-pwa-prompt'));
};

// Reset dismissal (used on profile page)
window.resetPWADismissal = () => {
    localStorage.removeItem('pwa_install_dismissed');
};

Alpine.start();
