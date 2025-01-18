(function($) {
    'use strict';

    const PWA = {
        init: function() {
            this.registerServiceWorker();
            this.setupInstallPrompt();
            this.handleOffline();
            this.setupPushNotifications();
        },

        // Register Service Worker
        registerServiceWorker: function() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(error) {
                        console.error('ServiceWorker registration failed:', error);
                    });
            }
        },

        // Setup Install Prompt
        setupInstallPrompt: function() {
            let deferredPrompt;

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;

                // Show install button
                $('.pwa-install-button').removeClass('hidden')
                    .on('click', () => {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                console.log('User accepted the install prompt');
                            }
                            deferredPrompt = null;
                        });
                    });
            });

            // Handle installed
            window.addEventListener('appinstalled', () => {
                $('.pwa-install-button').addClass('hidden');
                console.log('PWA was installed');
            });
        },

        // Handle Offline Status
        handleOffline: function() {
            const updateOnlineStatus = () => {
                const condition = navigator.onLine ? 'online' : 'offline';
                
                if (condition === 'offline') {
                    $('.offline-indicator').removeClass('hidden');
                    this.loadOfflineContent();
                } else {
                    $('.offline-indicator').addClass('hidden');
                }
            };

            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
        },

        // Load Offline Content
        loadOfflineContent: function() {
            if ('caches' in window) {
                caches.match(window.location.href)
                    .then(function(response) {
                        if (response) {
                            return response.text();
                        }
                    })
                    .then(function(content) {
                        if (content) {
                            // Show cached content
                            $('#main-content').html(content);
                        }
                    });
            }
        },

        // Setup Push Notifications
        setupPushNotifications: function() {
            const self = this;
            
            // Check if push notifications are supported
            if (!('Notification' in window)) return;

            // Handle permission request
            $('.enable-notifications').on('click', function(e) {
                e.preventDefault();
                self.requestNotificationPermission();
            });

            // Check existing permission
            if (Notification.permission === 'granted') {
                self.subscribeUserToPush();
            }
        },

        // Request Notification Permission
        requestNotificationPermission: function() {
            const self = this;
            
            Notification.requestPermission()
                .then(function(permission) {
                    if (permission === 'granted') {
                        self.subscribeUserToPush();
                    }
                });
        },

        // Subscribe User to Push Notifications
        subscribeUserToPush: function() {
            if (!('serviceWorker' in navigator)) return;

            navigator.serviceWorker.ready.then(function(registration) {
                // Subscribe to push notifications
                registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array(cybernews.vapidPublicKey)
                })
                .then(function(subscription) {
                    // Send subscription to server
                    return fetch(cybernews.ajaxurl, {
                        method: 'POST',
                        body: JSON.stringify({
                            action: 'save_push_subscription',
                            subscription: subscription,
                            nonce: cybernews.nonce
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Failed to subscribe to push notifications:', error);
                });
            });
        },

        // Convert VAPID key to Uint8Array
        urlBase64ToUint8Array: function(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        },

        // Handle Push Notification
        handlePushNotification: function(event) {
            let notification = event.data.json();

            const options = {
                body: notification.body,
                icon: notification.icon,
                badge: notification.badge,
                image: notification.image,
                data: notification.data,
                actions: notification.actions
            };

            event.waitUntil(
                self.registration.showNotification(notification.title, options)
            );
        },

        // Cache Static Assets
        cacheStaticAssets: function() {
            const staticAssets = [
                '/',
                '/offline.html',
                '/assets/css/style.css',
                '/assets/js/main.js',
                '/assets/images/logo.png',
                '/assets/images/offline.svg'
            ];

            caches.open('cybernews-static')
                .then(cache => cache.addAll(staticAssets));
        },

        // Cache Dynamic Content
        cacheDynamicContent: function() {
            // Cache articles for offline reading
            if ('caches' in window) {
                $('.article-content').each(function() {
                    const articleUrl = $(this).data('url');
                    fetch(articleUrl)
                        .then(response => {
                            caches.open('cybernews-articles')
                                .then(cache => cache.put(articleUrl, response));
                        });
                });
            }
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        PWA.init();
    });

})(jQuery);