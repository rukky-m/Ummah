<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NSUK Ummah Multi-Purpose Cooperative Society (NUMCSU)</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        [x-cloak] { 
            display: none !important; 
        }
        .gradient-bg {
            background: linear-gradient(135deg, #006B54 0%, #C9A961 100%);
        }
        .text-gold {
            color: #C9A961;
        }
        .bg-army-green {
            background-color: #006B54;
        }
        .text-army-green {
            color: #006B54;
        }
        .border-gold {
            border-color: #C9A961;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        /* Reveal Animation Classes */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Section Headings */
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #C9A961;
            border-radius: 2px;
        }
        /* Nav Link Hover Effect */
        .nav-link {
            position: relative;
            color: #006B54;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.8rem;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 50%;
            width: 0;
            height: 3px;
            background: #C9A961;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link:hover {
            color: #C9A961;
            transform: translateY(-1px);
        }
        .nav-link:hover::after {
            width: 100%;
        }
        /* Logo Pattern Background Fallback */
        .bg-logo-pattern {
            background-color: #ffffff;
            background-image: 
                radial-gradient(#006B54 0.5px, transparent 0.5px),
                radial-gradient(#006B54 0.5px, #ffffff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0,10px 10px;
            opacity: 0.05;
            pointer-events: none;
        }

        /* Audio Toggle Button styles */
        .audio-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #006B54;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid #C9A961;
        }
        .audio-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(201, 169, 97, 0.4);
        }
        .audio-toggle.playing {
            background: #C9A961;
            color: #006B54;
        }
        .audio-toggle .ripple {
            position: absolute;
            width: 100%;
            height: 100%;
            background: inherit;
            border-radius: 50%;
            opacity: 0.6;
            animation: ripple 2s infinite;
            z-index: -1;
        }
        @keyframes ripple {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 transition-colors duration-200">
    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 10000)" 
             class="fixed top-24 left-1/2 -translate-x-1/2 z-[60] w-full max-w-lg px-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-12">
            <div class="bg-white dark:bg-gray-800 border-l-4 border-army-green p-6 rounded-2xl shadow-2xl flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-green-50/30 dark:bg-army-green/5 -z-10 group-hover:scale-105 transition-transform"></div>
                
                <div class="w-12 h-12 bg-army-green rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-green-900/20">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                
                <div class="flex-1">
                    <p class="text-army-green dark:text-gold font-black text-[10px] uppercase tracking-widest mb-1">Success</p>
                    <p class="text-gray-800 dark:text-white font-bold text-sm leading-tight italic">{{ session('success') }}</p>
                </div>

                <button @click="show = false" class="text-gray-400 hover:text-army-green transition-colors p-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/ummah-logo.png') }}" alt="NUMCSU Logo" class="h-14 sm:h-16">
                    <div class="hidden sm:block">
                        <span class="block text-army-green font-black text-xl leading-none">NUMCSU</span>
                        <span class="block text-gold font-bold text-[10px] tracking-widest uppercase">Digital Cooperative</span>
                    </div>
                </div>
                
                <!-- Nav Links (Desktop) -->
                <div class="hidden lg:flex items-center gap-8 xl:gap-12">
                    <a href="#home" class="nav-link">HOME</a>
                    <a href="#why-us" class="nav-link">WHY CHOOSE US</a>
                    <a href="#how-it-works" class="nav-link">HOW IT WORKS</a>
                    <a href="#about" class="nav-link">ABOUT</a>
                    <a href="#mission" class="nav-link">MISSION</a>
                    <a href="{{ route('bye-laws') }}" class="nav-link">BYE-LAWS</a>
                </div>

                <!-- Action Buttons (Desktop) -->
                <div class="hidden lg:flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('login') }}" class="px-4 sm:px-6 py-2 border-2 border-army-green text-army-green font-bold rounded-lg hover:bg-army-green hover:text-white transition duration-300 text-sm sm:text-base">Login</a>
                    <a href="{{ route('register') }}" class="px-4 sm:px-6 py-2 bg-gold text-white font-bold rounded-lg hover:bg-opacity-90 transition duration-300 shadow-md text-sm sm:text-base">Join Now</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-army-green hover:text-gold focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="fa-solid fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-xl">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#home" @click="mobileMenuOpen = false" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">HOME</a>
                <a href="#why-us" @click="mobileMenuOpen = false" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">WHY CHOOSE US</a>
                <a href="#how-it-works" @click="mobileMenuOpen = false" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">HOW IT WORKS</a>
                <a href="#about" @click="mobileMenuOpen = false" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">ABOUT</a>
                <a href="#mission" @click="mobileMenuOpen = false" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">MISSION</a>
                <a href="{{ route('bye-laws') }}" class="block px-3 py-3 text-army-green font-bold hover:bg-gray-50 rounded-lg">BYE-LAWS</a>
                <div class="pt-4 flex flex-col gap-3">
                    <a href="{{ route('login') }}" class="block text-center px-4 py-3 border-2 border-army-green text-army-green font-bold rounded-lg hover:bg-army-green hover:text-white transition duration-300">Login</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-3 bg-gold text-white font-bold rounded-lg hover:bg-opacity-90 transition duration-300 shadow-md">Join Now</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Clean Entry) -->
    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1577415124269-fc1140a69e91?auto=format&fit=crop&q=80&w=2000" alt="Cooperative Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-army-green bg-opacity-80 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-army-green/50"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
            <!-- Floating Decorative Element -->
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-64 h-64 bg-gold opacity-10 blur-[100px] rounded-full animate-pulse"></div>
            
            <div class="glass p-10 md:p-16 rounded-[40px] shadow-2xl inline-block relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50"></div>
                
                <h1 class="text-5xl md:text-8xl font-black text-white mb-6 leading-tight drop-shadow-2xl relative">
                    Empowering the<br><span class="text-gold mt-4 block md:mt-6">NSUK Community</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-100 max-w-2xl mx-auto mb-12 font-medium drop-shadow-lg relative">
                    Join the NSUK Ummah Multi-Purpose Cooperative Society today and secure your financial future with trusted community support.
                </p>
                
                <div class="flex flex-wrap justify-center gap-6 relative">
                    <a href="{{ route('register') }}" class="group relative px-10 py-5 bg-gold text-white font-black rounded-2xl hover:bg-opacity-90 transition duration-300 shadow-[0_10px_30px_rgba(201,169,97,0.4)] flex items-center gap-3 overflow-hidden">
                        <span class="relative z-10">Get Started Now</span>
                        <i class="fa-solid fa-arrow-right relative z-10 group-hover:translate-x-2 transition-transform"></i>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </a>
                </div>
            </div>
            
            <!-- Professional Scroll Indicator -->
            <div class="flex justify-center mt-12">
                <a href="#why-us" class="group flex flex-col items-center gap-4">
                    <span class="text-white text-xs font-bold tracking-[0.3em] uppercase opacity-70 group-hover:opacity-100 transition-opacity">Scroll to Explore</span>
                    <div class="w-8 h-12 border-2 border-white/30 rounded-full flex justify-center p-2">
                        <div class="w-1.5 h-1.5 bg-gold rounded-full animate-bounce"></div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why-us" class="py-16 bg-white reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-black text-center text-army-green mb-12 underline decoration-gold decoration-4 underline-offset-8">WHY CHOOSE NUMCSU?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1: Low Rates -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-gold/10 rounded-[32px] rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-gold/5 rounded-[32px] -rotate-3 group-hover:-rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-gold/20 overflow-hidden">
                            <i class="fa-solid fa-hand-holding-dollar text-3xl text-gold/30 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-percent text-4xl text-gold group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Low Rates</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Afforable interest rates designed to help your finances breathe and grow sustainably.</p>
                </div>

                <!-- Feature 2: Secure -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-army-green/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-army-green/10 rounded-[32px] -rotate-6 group-hover:-rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-army-green/5 rounded-[32px] rotate-3 group-hover:rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-army-green/20 overflow-hidden">
                            <i class="fa-solid fa-shield-halved text-3xl text-army-green/20 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-user-shield text-4xl text-army-green group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Highly Secure</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Institutional-grade security protocols ensuring your community wealth is guarded 24/7.</p>
                </div>

                <!-- Feature 3: Growth -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-gold/10 rounded-[32px] rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-gold/5 rounded-[32px] -rotate-3 group-hover:-rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-gold/20 overflow-hidden">
                            <i class="fa-solid fa-seedling text-3xl text-gold/30 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-chart-line text-4xl text-gold group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Mutual Growth</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">We grow as you grow. Our cooperative model ensures benefits are shared across the whole community.</p>
                </div>

                <!-- Feature 4: Community -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-army-green/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-army-green/10 rounded-[32px] -rotate-6 group-hover:-rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-army-green/5 rounded-[32px] rotate-3 group-hover:rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-army-green/20 overflow-hidden">
                            <i class="fa-solid fa-handshake text-3xl text-army-green/20 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-people-group text-4xl text-army-green group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Community</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Built by the NSUK Ummah, for the NSUK Ummah. Personalized support in every interaction.</p>
                </div>

                <!-- Feature 5: Trusted -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-gold/10 rounded-[32px] rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-gold/5 rounded-[32px] -rotate-3 group-hover:-rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-gold/20 overflow-hidden">
                            <i class="fa-solid fa-star text-3xl text-gold/30 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-handshake-angle text-4xl text-gold group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Trusted</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">A decade of integrity and transparent stewardship for our members' collective interest.</p>
                </div>

                <!-- Feature 6: Services -->
                <div class="group bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-army-green/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative w-28 h-28 mb-8">
                        <div class="absolute inset-0 bg-army-green/10 rounded-[32px] -rotate-6 group-hover:-rotate-12 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-army-green/5 rounded-[32px] rotate-3 group-hover:rotate-6 transition-transform duration-500"></div>
                        <div class="relative w-full h-full bg-white rounded-[32px] shadow-xl flex items-center justify-center border border-army-green/20 overflow-hidden">
                            <i class="fa-solid fa-plus text-3xl text-army-green/30 absolute -bottom-2 -right-2 transform rotate-12"></i>
                            <i class="fa-solid fa-boxes-stacked text-4xl text-army-green group-hover:scale-110 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-army-green mb-4">Services</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">From savings to project financing, we offer a versatile suite of services for your journey.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#how-it-works" class="group inline-flex flex-col items-center gap-4">
                    <span class="text-army-green text-xs font-black tracking-[0.4em] uppercase opacity-60 group-hover:opacity-100 transition-opacity">Explore Flow</span>
                    <div class="relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gold/20 rounded-full blur-xl group-hover:bg-gold/40 transition-colors animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                            <i class="fa-solid fa-chevron-down text-gold animate-bounce"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-gray-50 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-black text-center text-army-green mb-12 underline decoration-gold decoration-4 underline-offset-8">HOW IT WORKS</h2>
            
            <div class="relative grid grid-cols-1 md:grid-cols-4 gap-12 text-center">
                <!-- Step 1 -->
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 bg-gold rounded-3xl flex items-center justify-center shadow-xl mb-6 relative z-10 transform group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-user-plus text-4xl text-white"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-army-green text-white rounded-full flex items-center justify-center font-black border-2 border-white">1</div>
                    </div>
                    <h3 class="text-xl font-bold text-army-green mb-4">Register</h3>
                    <p class="text-gray-600">Register as a member by filling the simple registration form</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 bg-army-green rounded-3xl flex items-center justify-center shadow-xl mb-6 relative z-10 transform group-hover:-rotate-6 transition-transform">
                        <i class="fa-solid fa-piggy-bank text-4xl text-white"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-gold text-white rounded-full flex items-center justify-center font-black border-2 border-white">2</div>
                    </div>
                    <h3 class="text-xl font-bold text-army-green mb-4">Save</h3>
                    <p class="text-gray-600">Make your first savings deposit and start growing your wealth</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 bg-gold rounded-3xl flex items-center justify-center shadow-xl mb-6 relative z-10 transform group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-file-invoice-dollar text-4xl text-white"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-army-green text-white rounded-full flex items-center justify-center font-black border-2 border-white">3</div>
                    </div>
                    <h3 class="text-xl font-bold text-army-green mb-4">Apply</h3>
                    <p class="text-gray-600">Apply for community-focused loans with low interest rates</p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center group">
                    <div class="w-24 h-24 bg-army-green rounded-3xl flex items-center justify-center shadow-xl mb-6 relative z-10 transform group-hover:-rotate-6 transition-transform">
                        <i class="fa-solid fa-chart-line text-4xl text-white"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-gold text-white rounded-full flex items-center justify-center font-black border-2 border-white">4</div>
                    </div>
                    <h3 class="text-xl font-bold text-army-green mb-4">Grow</h3>
                    <p class="text-gray-600">Grow with the community through mutual support and success</p>
                </div>

                <!-- Connecting Line (Desktop Only) -->
                <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-1 bg-gradient-to-r from-gold/30 via-army-green/30 to-gold/30 -z-0"></div>
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('register') }}" class="inline-block bg-gold hover:bg-opacity-90 text-white font-black py-5 px-14 rounded-xl text-xl transition duration-300 shadow-xl transform hover:scale-105">
                    Join Now
                </a>
            </div>

            <div class="text-center mt-12">
                <a href="#about" class="group inline-flex flex-col items-center gap-4">
                    <span class="text-army-green text-xs font-black tracking-[0.4em] uppercase opacity-60 group-hover:opacity-100 transition-opacity">Discover Story</span>
                    <div class="relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gold/20 rounded-full blur-xl group-hover:bg-gold/40 transition-colors animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                            <i class="fa-solid fa-chevron-down text-gold animate-bounce"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- About NUMCSU Section -->
    <section id="about" class="relative py-16 bg-white overflow-hidden">
        <!-- Background Logo Pattern Overlay -->
        <div class="absolute inset-0 bg-logo-pattern"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-center text-army-green mb-12 underline decoration-gold decoration-4 underline-offset-8">ABOUT NUMCSU</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-20">
                <div class="relative min-h-[400px] flex items-center justify-center">
                    <!-- Background Accent Box -->
                    <div class="absolute inset-0 bg-army-green/5 rounded-[40px] -z-10 transform scale-110"></div>
                    
                    <!-- Decorative Background Logo (Larger Subtle Watermark) -->
                    <div class="absolute -left-10 top-0 opacity-[0.05] -z-10">
                        <img src="{{ asset('images/ummah-logo.png') }}" alt="" class="w-64 h-64 object-contain grayscale">
                    </div>

                    <!-- Central Logo Display -->
                    <div class="absolute inset-0 z-10 w-full h-full">
                        <div class="relative w-full h-full overflow-hidden rounded-[40px] shadow-[0_30px_60px_rgba(0,0,0,0.15)] border-8 border-white bg-white flex items-center justify-center p-12 hover:scale-[1.02] transition-transform duration-700 group">
                            <img src="{{ asset('images/ummah-logo.png') }}" alt="NUMCSU Logo" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700">
                            
                            <!-- Subtle Glow Effect -->
                            <div class="absolute inset-0 bg-gold/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                        </div>
                        
                        <!-- Decorative Floating Elements -->
                        <div class="absolute -top-6 -right-6 w-20 h-20 bg-gold/10 rounded-full blur-xl animate-pulse -z-10"></div>
                        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-army-green/10 rounded-full blur-xl animate-pulse delay-700 -z-10"></div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-3xl font-black text-army-green mb-6">Our Journey & Official Registration</h3>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        The Cooperative began its lawful operations on <strong class="text-army-green">March 1, 2019</strong>, under the Nasarawa State University Muslim Community. On <strong class="text-army-green">August 25, 2020</strong>, it was officially registered with the Nasarawa State Ministry of Trade, Industry, and Investment as <strong class="text-army-green">NSUK Ummah Multi-Purpose Co-operative Society Limited</strong> under Section 5(1) of the Nigerian Co-operative Societies Act (Amended) 2004, with registration number <strong class="text-army-green">CODAS NO: 26/06/08/0048</strong>.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed mb-8">
                        We serve our members by helping them achieve their financial goals through:
                    </p>
                    <ul class="space-y-4 text-gray-700 font-bold mb-8">
                        <li class="flex items-center group/item">
                            <span class="w-3 h-3 bg-gold rounded-full mr-4 group-hover/item:scale-125 transition-transform"></span>
                            Collective savings programs
                        </li>
                        <li class="flex items-center group/item">
                            <span class="w-3 h-3 bg-gold rounded-full mr-4 group-hover/item:scale-125 transition-transform"></span>
                            Affordable loan facilities
                        </li>
                        <li class="flex items-center group/item">
                            <span class="w-3 h-3 bg-gold rounded-full mr-4 group-hover/item:scale-125 transition-transform"></span>
                            Investment opportunities
                        </li>
                        <li class="flex items-center group/item">
                            <span class="w-3 h-3 bg-gold rounded-full mr-4 group-hover/item:scale-125 transition-transform"></span>
                            Financial literacy training
                        </li>
                    </ul>

                    <!-- Trusted By / Community Tag -->
                    <div class="pt-8 border-t border-gray-100 flex items-center gap-6">
                        <div class="bg-gray-50 px-6 py-4 rounded-2xl border border-gray-100 flex items-center gap-4 group hover:border-army-green/50 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-md">
                            <div class="w-12 h-12 bg-army-green/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-university text-xl text-army-green"></i>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-black mb-0.5">Established At</p>
                                <span class="text-sm font-black text-army-green">NSUK Community</span>
                            </div>
                        </div>
                        <div class="flex-1 h-[1px] bg-gradient-to-r from-gray-100 to-transparent"></div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#mission" class="group inline-flex flex-col items-center gap-4">
                    <span class="text-army-green text-xs font-black tracking-[0.4em] uppercase opacity-60 group-hover:opacity-100 transition-opacity">Our Roadmap</span>
                    <div class="relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gold/20 rounded-full blur-xl group-hover:bg-gold/40 transition-colors animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                            <i class="fa-solid fa-chevron-down text-gold animate-bounce"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section id="mission" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-black text-center text-army-green mb-12 underline decoration-gold decoration-4 underline-offset-8">OUR MISSION & VALUES</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Vision -->
                <div class="bg-white overflow-hidden rounded-[32px] shadow-xl border border-gray-100 text-center group hover:border-gold/50 transition-all duration-500">
                    <div class="h-72 overflow-hidden relative">
                        <img src="{{ asset('images/admins/our_vision.jpeg') }}" alt="Vision" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <i class="fa-solid fa-eye text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-10">
                        <div class="w-16 h-1 bg-gold mx-auto mb-6 rounded-full group-hover:w-24 transition-all duration-500"></div>
                        <h3 class="text-2xl font-black text-army-green mb-6 uppercase tracking-tight">Our Vision</h3>
                        <p class="text-gray-600 text-lg italic leading-relaxed">
                            "To be the leading cooperative society empowering the NSUK community towards financial independence and sustainable development."
                        </p>
                    </div>
                </div>

                <!-- Mission -->
                <div class="bg-white overflow-hidden rounded-[32px] shadow-xl border border-gray-100 text-center group hover:border-army-green/50 transition-all duration-500">
                    <div class="h-72 overflow-hidden relative">
                        <img src="{{ asset('images/admins/our_mission.jpeg') }}" alt="Mission" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <i class="fa-solid fa-bullseye text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-10">
                        <div class="w-16 h-1 bg-army-green mx-auto mb-6 rounded-full group-hover:w-24 transition-all duration-500"></div>
                        <h3 class="text-2xl font-black text-army-green mb-6 uppercase tracking-tight">Our Mission</h3>
                        <p class="text-gray-600 text-lg italic leading-relaxed">
                            "To provide accessible financial services, promote savings culture, and foster economic growth through cooperative principles and mutual support."
                        </p>
                    </div>
                </div>

                <!-- Values -->
                <div class="bg-white overflow-hidden rounded-[32px] shadow-xl border border-gray-100 group hover:border-gold/50 transition-all duration-500">
                    <div class="h-72 overflow-hidden relative">
                        <img src="{{ asset('images/admins/our_value.jpeg') }}" alt="Values" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <i class="fa-solid fa-gem text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-10">
                        <div class="w-16 h-1 bg-gold mx-auto mb-6 rounded-full group-hover:w-24 transition-all duration-500"></div>
                        <h3 class="text-2xl font-black text-army-green mb-6 uppercase tracking-tight text-center">Our Values</h3>
                        <ul class="space-y-4 text-gray-700 font-bold">
                            <li class="flex items-center group/item">
                                <span class="w-2 h-2 bg-army-green rounded-full mr-3 group-hover/item:scale-150 transition-transform"></span>
                                Transparency & Accountability
                            </li>
                            <li class="flex items-center group/item">
                                <span class="w-2 h-2 bg-army-green rounded-full mr-3 group-hover/item:scale-150 transition-transform"></span>
                                Member Empowerment
                            </li>
                            <li class="flex items-center group/item">
                                <span class="w-2 h-2 bg-army-green rounded-full mr-3 group-hover/item:scale-150 transition-transform"></span>
                                Community Development
                            </li>
                            <li class="flex items-center group/item">
                                <span class="w-2 h-2 bg-army-green rounded-full mr-3 group-hover/item:scale-150 transition-transform"></span>
                                Financial Inclusion
                            </li>
                            <li class="flex items-center group/item">
                                <span class="w-2 h-2 bg-army-green rounded-full mr-3 group-hover/item:scale-150 transition-transform"></span>
                                Integrity & Trust
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#administration" class="group inline-flex flex-col items-center gap-4">
                    <span class="text-army-green text-xs font-black tracking-[0.4em] uppercase opacity-60 group-hover:opacity-100 transition-opacity">Expert Team</span>
                    <div class="relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gold/20 rounded-full blur-xl group-hover:bg-gold/40 transition-colors animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                            <i class="fa-solid fa-chevron-down text-gold animate-bounce"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Meet Our Administration Section -->
    <section id="administration" class="py-16 bg-white" x-data="{ page: 1 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-army-green mb-12 uppercase tracking-tighter">MEET OUR ADMINISTRATORS</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Admin 1 (Page 1) - Chairman, Vice Chairman, Secretary -->
                <template x-if="page === 1">
                    <div class="contents">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/Chairman.jpeg') }}" alt="Chairman" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Mr. Shehu Sunusi Lalin</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Chairman</p>
                                <p class="text-gray-600 italic">"Leading with integrity and commitment to member satisfaction"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-army-green card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/Vice_chairman.jpeg') }}" alt="Vice Chairman" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Pharm. Ahmed Usman Tanze</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Vice Chairman</p>
                                <p class="text-gray-600 italic">"Supporting excellence in cooperative services"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/secretary.jpeg') }}" alt="Secretary" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Dr. Kabiru Atiku</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Secretary</p>
                                <p class="text-gray-600 italic">"Ensuring transparency and accountability in all operations"</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Admin (Page 2) - Financial Secretary, Auditor, Ex-Officio -->
                <template x-if="page === 2">
                    <div class="contents">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/Financial_Secretary.jpeg') }}" alt="Financial Secretary" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Dr. Liman Alhaji Mohammed (ACA)</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Financial Secretary</p>
                                <p class="text-gray-600 italic">"Financial stewardship and prudent resource management"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-army-green card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/AUDITOR.jpg') }}" alt="Auditor" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Mr. Muhammad Musa Awadu</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Auditor</p>
                                <p class="text-gray-600 italic">"Ensuring financial integrity and operational excellence"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/Dr_Yusuf_Bawa.jpeg') }}" alt="Ex-Officio" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Dr. Yusuf Bawa</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Ex-Officio</p>
                                <p class="text-gray-600 italic">"Contributing expertise for cooperative excellence"</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Admin (Page 3) - Treasurer, PRO, Ex-Officio -->
                <template x-if="page === 3">
                    <div class="contents">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/treasurer.jpeg') }}" alt="Treasurer" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Mrs. Hauwa Muhammad Abubakar</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Treasurer</p>
                                <p class="text-gray-600 italic">"Safeguarding cooperative resources with diligence"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-army-green card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/PRO.jpeg') }}" alt="PRO" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Mr. Abdullahi Tanko</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Public Relations Officer</p>
                                <p class="text-gray-600 italic">"Building strong relationships within the NSUK community"</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/Ex-Officio_Dr._Abubakar_Tafida.jpeg') }}" alt="Ex-Officio" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Dr. Abubakar Tafida</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Ex-Officio</p>
                                <p class="text-gray-600 italic">"Advancing the cooperative's vision through strategic insight"</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Admin (Page 4) - Manager -->
                <template x-if="page === 4">
                    <div class="contents">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-b-4 border-gold card-hover group mx-auto max-w-sm">
                            <div class="h-80 overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('images/admins/manager.jpeg') }}" alt="Manager" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-bold text-army-green mb-1">Mr. Aliyu Yunusa Suleiman</h3>
                                <p class="text-gold font-semibold uppercase tracking-wider text-sm mb-4">Manager</p>
                                <p class="text-gray-600 italic">"Ensuring efficient management and member-focused operations"</p>
                            </div>
                        </div>
                    </div>
                </template>


            </div>

            <!-- View All Button & Pagination -->
            <div class="flex flex-col items-center mt-16 space-y-8">
                <!-- Pagination UI -->
                <div class="flex items-center space-x-3">
                    <button @click="page = 1" :class="page === 1 ? 'bg-gold text-white shadow-lg scale-110' : 'bg-white text-army-green border-gray-200'" class="w-12 h-12 flex items-center justify-center rounded-xl border transition-all duration-300 font-black">1</button>
                    <button @click="page = 2" :class="page === 2 ? 'bg-gold text-white shadow-lg scale-110' : 'bg-white text-army-green border-gray-200'" class="w-12 h-12 flex items-center justify-center rounded-xl border transition-all duration-300 font-black">2</button>
                    <button @click="page = 3" :class="page === 3 ? 'bg-gold text-white shadow-lg scale-110' : 'bg-white text-army-green border-gray-200'" class="w-12 h-12 flex items-center justify-center rounded-xl border transition-all duration-300 font-black">3</button>
                    <button @click="page = 4" :class="page === 4 ? 'bg-gold text-white shadow-lg scale-110' : 'bg-white text-army-green border-gray-200'" class="w-12 h-12 flex items-center justify-center rounded-xl border transition-all duration-300 font-black">4</button>
                </div>

                <a href="#administration" class="inline-block bg-army-green hover:bg-gold hover:text-white text-white font-black py-4 px-12 rounded-xl transition-all duration-300 shadow-xl transform hover:scale-105 uppercase tracking-widest">
                    View All Administrators
                </a>
            </div>

            <div class="text-center mt-12">
                <a href="#contact" class="group inline-flex flex-col items-center gap-4">
                    <span class="text-army-green text-xs font-black tracking-[0.4em] uppercase opacity-60 group-hover:opacity-100 transition-opacity">Reach Out</span>
                    <div class="relative flex items-center justify-center">
                        <div class="absolute inset-0 bg-gold/20 rounded-full blur-xl group-hover:bg-gold/40 transition-colors animate-pulse"></div>
                        <div class="relative w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                            <i class="fa-solid fa-chevron-down text-gold animate-bounce"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- OUR MEMBERS GALLERY -->
    <section id="members-gallery" class="py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-gold rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-army-green rounded-full filter blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16 reveal">
                <div class="inline-block mb-6">
                    <div class="flex items-center gap-4">
                        <div class="h-px w-12 bg-gradient-to-r from-transparent to-gold"></div>
                        <i class="fa-solid fa-users text-4xl text-gold"></i>
                        <div class="h-px w-12 bg-gradient-to-l from-transparent to-gold"></div>
                    </div>
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-army-green mb-6 tracking-tight">
                    OUR <span class="text-gold">MEMBERS</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Meet some of the dedicated members who make our cooperative society thrive
                </p>
            </div>

            <!-- Members Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 reveal">
                <!-- Member 1 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_1.jpeg') }}" alt="Member 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_2.jpeg') }}" alt="Member 2" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 3 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_3.jpeg') }}" alt="Member 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 4 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_4.jpeg') }}" alt="Member 4" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 5 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_5.jpeg') }}" alt="Member 5" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 6 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_6.jpeg') }}" alt="Member 6" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 7 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_7.jpeg') }}" alt="Member 7" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 8 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_8.jpeg') }}" alt="Member 8" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 9 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_9.jpeg') }}" alt="Member 9" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>

                <!-- Member 10 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/members/member_10.jpeg') }}" alt="Member 10" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-army-green/90 via-army-green/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                        <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-sm">Cooperative Member</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Join CTA -->
            <div class="text-center mt-16 reveal">
                <a href="{{ route('join.step1') }}" class="inline-block bg-gold hover:bg-army-green text-white font-black py-4 px-12 rounded-xl transition-all duration-300 shadow-xl transform hover:scale-105 uppercase tracking-widest">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Become a Member
                </a>
            </div>
        </div>
    </section>

    <x-footer />

    <!-- Qur'an Recitation Audio & Toggle -->
    <div x-data="{ 
        playing: false,
        isLoading: false,
        status: 'Play Recitation',
        toggleAudio() {
            const audio = this.$refs.bgAudio;
            if (this.playing) {
                audio.pause();
                this.playing = false;
                this.status = 'Play Recitation';
            } else {
                this.isLoading = true;
                this.status = 'Connecting...';
                
                // Ensure audio is unmuted and volume is up
                audio.muted = false;
                audio.volume = 1.0;

                const playPromise = audio.play();
                
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        this.playing = true;
                        this.isLoading = false;
                        this.status = 'Pause Recitation';
                    }).catch(error => {
                        console.error('Playback failed:', error);
                        this.playing = false;
                        this.isLoading = false;
                        this.status = 'Blocked by Browser';
                        setTimeout(() => this.status = 'Click to enable sound', 3000);
                    });
                }
            }
        }
    }" class="fixed bottom-8 right-8 z-[100]">
        <audio x-ref="bgAudio" loop preload="auto" crossorigin="anonymous">
            <source src="https://download.quranmp3.net/arabic/saad-al-ghamdi/055.mp3" type="audio/mpeg">
            <source src="https://server8.mp3quran.net/ghamdi/055.mp3" type="audio/mpeg">
        </audio>
        
        <button @click="toggleAudio()" 
                class="audio-toggle group relative"
                :class="{ 'playing': playing, 'opacity-75': isLoading }"
                :disabled="isLoading"
                aria-label="Toggle Qur'an Recitation">
            <template x-if="playing">
                <div class="ripple"></div>
            </template>
            
            <i class="fas fa-spinner fa-spin text-xl" x-show="isLoading" x-cloak></i>
            <i class="fas fa-play text-xl" x-show="!playing && !isLoading"></i>
            <i class="fas fa-pause text-xl" x-show="playing && !isLoading" x-cloak></i>
            
            <!-- Tooltip -->
            <span class="absolute right-full mr-4 bg-army-green text-white text-[10px] uppercase tracking-widest px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none font-black border border-gold/30 shadow-xl">
                <span x-text="status"></span>
            </span>
        </button>
    </div>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
    <!-- Scroll Reveal Script -->
    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        // Initial check
        reveal();
    </script>
</body>
</html>
