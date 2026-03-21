<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#001D3D] text-white min-h-screen flex items-center justify-center p-4 overflow-hidden relative">
    <!-- Background Glow -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-red-600 opacity-10 blur-[120px] rounded-full animate-pulse-slow"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-[#F59E0B] opacity-10 blur-[120px] rounded-full animate-pulse-slow"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center">
        <!-- Error Code -->
        <div class="text-[120px] md:text-[180px] font-black leading-none bg-gradient-to-br from-red-400 to-red-600 bg-clip-text text-transparent animate-float opacity-80">
            500
        </div>
        
        <!-- Illustration/Icon -->
        <div class="mb-8 -mt-4">
             <div class="w-24 h-1 bg-red-500/30 mx-auto rounded-full mb-8"></div>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-4">Something Broke</h1>
        <p class="text-gray-400 text-lg mb-10 leading-relaxed">
            Our digital secretariat is currently experiencing a technical hitch. We've been notified and are working to fix it.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-900/40 hover:-translate-y-0.5">
                Go Home
            </a>
            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold rounded-2xl transition-all duration-300 backdrop-blur-sm">
                Try Again
            </a>
        </div>
        
        <!-- Footer Info -->
        <div class="mt-16 pt-8 border-t border-white/5">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} NSUK Ummah Cooperative Registry</p>
        </div>
    </div>

    <!-- Background Elements -->
    <div class="absolute top-1/4 left-10 w-2 h-2 bg-red-500 rounded-full opacity-40 animate-ping"></div>
    <div class="absolute bottom-1/3 right-20 w-3 h-3 bg-amber-500 rounded-full opacity-30 animate-pulse"></div>
</body>
</html>
