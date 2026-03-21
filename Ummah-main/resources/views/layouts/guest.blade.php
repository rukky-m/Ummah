<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NSUK Ummah Multi-Purpose Cooperative Society (NUMCSU)</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-logo-pattern {
                background-color: #f9fafb;
                background-image: url("{{ asset('images/logo-transparent.png') }}");
                background-repeat: repeat;
                background-size: 80px;
                background-position: center;
                opacity: 0.04;
                pointer-events: none;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Guest Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-3 group">
                             <x-application-logo class="h-10 w-auto transition-transform group-hover:scale-105" />
                            <span class="text-emerald-600 dark:text-emerald-500 font-black text-lg tracking-tighter">UMMAH</span>
                        </a>
                    </div>
                    <!-- Navigation Arrows -->
                    <div class="flex items-center gap-2 px-4 border-x border-gray-100 dark:border-white/5 mx-4">
                        <button onclick="window.history.back()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-emerald-500 dark:hover:bg-emerald-600 hover:text-white transition-all active:scale-90" title="Back">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                        </button>
                        <button onclick="window.history.forward()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-emerald-500 dark:hover:bg-emerald-600 hover:text-white transition-all active:scale-90" title="Forward">
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                    <div class="flex items-center">
                        <a href="/" class="text-sm font-bold text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-500 transition-colors flex items-center gap-2">
                             <i class="fas fa-arrow-left"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-950 relative overflow-hidden transition-colors duration-500">
            <!-- Background Logo Pattern Overlay -->
            <div class="absolute inset-0 bg-logo-pattern opacity-[0.03] dark:opacity-[0.01]"></div>
            
            <!-- Global Enterprise Background Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkU4RjAiIGZpbGwtb3BhY2l0eT0iMC40Ii8+PC9zdmc+')] dark:bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzMzQxNTUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+PC9zdmc+')] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>

            <!-- Enhanced Background Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -left-24 w-[30rem] h-[30rem] bg-emerald-500/10 dark:bg-emerald-600/15 blur-[120px] rounded-full animate-pulse-slow"></div>
                <div class="absolute top-1/2 -right-24 w-96 h-96 bg-amber-400/10 dark:bg-amber-500/15 blur-[100px] rounded-full"></div>
                <div class="absolute -bottom-24 left-1/4 w-[40rem] h-[40rem] bg-blue-500/10 dark:bg-blue-600/10 blur-[150px] rounded-full animate-float"></div>
            </div>

            <div class="z-10 mb-8 transform hover:scale-105 transition-all duration-500">
                <a href="/">
                    <x-application-logo class="w-32 h-32 drop-shadow-2xl" />
                </a>
            </div>

            <div class="z-10 w-full sm:max-w-md mt-6 px-10 py-12 bg-white/70 dark:bg-gray-900/40 backdrop-blur-2xl border border-gray-100/50 dark:border-white/10 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] overflow-hidden sm:rounded-[2.5rem] transition-all duration-500 hover:border-emerald-500/30 group">
                {{ $slot }}
            </div>
            
            <x-footer />
        </div>

        <!-- Global Notifications -->
        <div class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 pointer-events-none"
             x-data="{ 
                notifications: [],
                add(message, type = 'success') {
                    this.notifications.push({ id: Date.now(), message, type });
                    setTimeout(() => { this.remove(this.notifications[this.notifications.length - 1].id) }, 5000);
                },
                remove(id) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }
             }"
             @notify.window="add($event.detail.message, $event.detail.type)"
             x-init='
                @if(session("success")) add(@json(session("success")), "success"); @endif
                @if(session("error")) add(@json(session("error")), "error"); @endif
             '>
            <template x-for="notification in notifications" :key="notification.id">
                <div x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="pointer-events-auto px-6 py-4 rounded-xl shadow-xl flex items-center gap-3 min-w-[300px] border border-gray-100"
                     :class="{
                        'bg-white border-l-4 border-green-500 text-gray-800': notification.type === 'success',
                        'bg-white border-l-4 border-red-500 text-gray-800': notification.type === 'error'
                     }">
                     <div class="h-8 w-8 rounded-full flex items-center justify-center shrink-0"
                          :class="{
                              'bg-green-100 text-green-600': notification.type === 'success',
                              'bg-red-100 text-red-600': notification.type === 'error'
                          }">
                        <i class="fas" :class="{
                            'fa-check': notification.type === 'success',
                            'fa-exclamation': notification.type === 'error'
                        }"></i>
                     </div>
                     <div>
                        <p class="font-black text-xs uppercase tracking-widest opacity-50" x-text="notification.type"></p>
                        <p class="font-bold text-sm" x-text="notification.message"></p>
                     </div>
                </div>
            </template>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Global Loading State (Safer implementation)
                document.body.addEventListener('submit', function(e) {
                    const form = e.target;
                    if (!form.checkValidity()) return;

                    const btn = form.querySelector('button[type="submit"]');
                    if (btn && !btn.classList.contains('no-loading')) {
                        // Prevent double-click via a data attribute instead of immediate disabling
                        if (btn.dataset.loading === 'true') {
                            e.preventDefault();
                            return;
                        }
                        btn.dataset.loading = 'true';

                        // Subtle visual feedback instead of removing original content immediately
                        const originalHtml = btn.innerHTML;
                        btn.innerHTML = `<span class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                            <span>Processing...</span>
                        </span>`;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                        
                        // If it takes more than 500ms, keep the disabled state
                        setTimeout(() => {
                            if (btn) btn.style.pointerEvents = 'none';
                        }, 50);
                    }
                }, true);
            });
        </script>
    </body>
</html>
