<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notifications') }}
            </h2>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($notifications->count() > 0)
                        <div class="flex flex-col space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex items-center justify-between p-4 border rounded-lg {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-blue-50 dark:bg-gray-600 border-blue-400' }}">
                                    <div>
                                        <h4 class="font-bold {{ $notification->read_at ? 'text-gray-600 dark:text-gray-300' : 'text-blue-700 dark:text-blue-300' }}">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h4>
                                        <p class="text-sm mt-1 {{ $notification->read_at ? 'text-gray-500 dark:text-gray-400' : 'text-gray-800 dark:text-gray-200' }}">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-2">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    @if(is_null($notification->read_at))
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Mark as Read</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p>You have no notifications at this time.</p>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
