<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 dark:text-gray-200 uppercase tracking-widest">
            {{ __('New Support Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('support.store') }}" class="space-y-6">
                        @csrf

                        <!-- Subject -->
                        <div>
                            <x-input-label for="subject" :value="__('Subject')" class="font-black uppercase tracking-widest text-[10px] opacity-60" />
                            <x-text-input id="subject" class="block mt-1 w-full border-gray-100 dark:border-gray-700 focus:border-army-green focus:ring-army-green rounded-xl shadow-sm" type="text" name="subject" :value="old('subject')" required autofocus placeholder="e.g., Question about my recent loan application" />
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <x-input-label for="priority" :value="__('Priority')" class="font-black uppercase tracking-widest text-[10px] opacity-60" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-100 dark:border-gray-700 focus:border-army-green focus:ring-army-green rounded-xl shadow-sm text-sm font-bold bg-white dark:bg-gray-900">
                                <option value="low">Low - General inquiry</option>
                                <option value="medium" selected>Medium - Need assistance</option>
                                <option value="high">High - Urgent issue</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <!-- Message -->
                        <div>
                            <x-input-label for="message" :value="__('Message')" class="font-black uppercase tracking-widest text-[10px] opacity-60" />
                            <textarea id="message" name="message" rows="6" class="block mt-1 w-full border-gray-100 dark:border-gray-700 focus:border-army-green focus:ring-army-green rounded-2xl shadow-sm text-sm font-medium" placeholder="Describe your issue or question in detail..." required>{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('support.index') }}" class="mr-4 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-colors">
                                Cancel
                            </a>
                            <x-primary-button class="bg-army-green hover:bg-army-green/90 rounded-xl px-8 py-3">
                                {{ __('Create Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 bg-gold/5 border border-gold/10 rounded-2xl p-6 flex gap-4">
                <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center shrink-0">
                    <i class="fas fa-info-circle text-gold"></i>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-gold mb-1">Response Time</h5>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Our support team typically responds within 24 hours during business days (Monday - Friday). For urgent matters, please prioritize your ticket accordingly.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
