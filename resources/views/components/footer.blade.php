<footer id="contact" class="bg-[#0b1222] text-white py-12 md:py-16 border-t border-white/10 relative overflow-hidden">
    <!-- Clean Background -->
    <div class="absolute inset-0 bg-logo-pattern opacity-[0.015] pointer-events-none"></div>
    
    <div class="w-full px-4 md:px-10 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/5">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-4 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center gap-4 group mb-6">
                    <x-application-logo class="h-12 w-auto transition-transform duration-500 group-hover:scale-105" />
                    <div>
                        <h3 class="font-black text-xl text-white uppercase tracking-tighter italic">NUMCSU</h3>
                        <p class="text-[9px] text-gold font-black uppercase tracking-[0.2em]">Digital Command</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed max-w-sm font-medium opacity-60">
                    Nasarawa State University Ummah Multi-Purpose Cooperative Society. Digital financial excellence since 2019.
                </p>
            </div>

            <!-- Links Grid -->
            <div class="col-span-1 md:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-8">
                <div class="flex flex-col gap-4">
                    <h4 class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2 font-black italic">Navigation</h4>
                    <nav class="flex flex-col gap-3">
                        <a href="/#home" class="text-[10px] text-gray-500 hover:text-white transition-all uppercase font-bold tracking-widest">Home Base</a>
                        <a href="/#about" class="text-[10px] text-gray-500 hover:text-white transition-all uppercase font-bold tracking-widest">About Us</a>
                        <a href="{{ route('bye-laws') }}" class="text-[10px] text-gray-500 hover:text-white transition-all uppercase font-bold tracking-widest">Bye-Laws</a>
                    </nav>
                </div>

                <div class="flex flex-col gap-4">
                    <h4 class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2 font-black italic">Contact</h4>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-[10px] text-gold"></i>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">NSUK, Keffi HQ</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-envelope text-[10px] text-gold"></i>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">hq@numcsu.com</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center md:items-end gap-6 text-right">
                    <h4 class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2 font-black italic">Social</h4>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-500 hover:text-gold transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-500 hover:text-gold transition-colors"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-500 hover:text-gold transition-colors"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-xl border border-white/5">
                <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></div>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">System Active</span>
            </div>
            
            <p class="text-[9px] font-bold text-gray-600 uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} <span class="text-gray-400">NUMCSU COMMAND</span>. Secure Access.
            </p>

            <div class="flex gap-6">
                <a href="#" class="text-[9px] font-black text-gray-600 hover:text-gray-400 uppercase tracking-[0.2em] transition-all">Privacy</a>
                <a href="#" class="text-[9px] font-black text-gray-600 hover:text-gray-400 uppercase tracking-[0.2em] transition-all">Terms</a>
            </div>
        </div>
    </div>
</footer>
