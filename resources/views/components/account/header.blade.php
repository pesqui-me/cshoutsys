@props(['title' => '', 'actions' => null])

<header class="header">
    <div class="header-left">
        <button class="menu-toggle" @click="sidebarOpen = !sidebarOpen" type="button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        
        @if(isset($back))
            {{ $back }}
        @endif
        
        <h1 class="header-title">{{ $title }}</h1>
    </div>
    
    <div class="header-right">
        @if($actions)
            {{ $actions }}
        @endif
        
        <button class="notification-btn" @click="notificationsOpen = !notificationsOpen" type="button">
            🔔
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="badge">{{ auth()->user()->unreadNotifications->count() }}</span>
            @endif
        </button>
        @if(auth()->user()->getFirstMediaUrl('avatar'))
            <img src="{{ auth()->user()->getFirstMediaUrl('avatar') }}" 
                    alt="{{ auth()->user()->name }}" 
                    class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-100"
                    x-ref="avatarPreview">
        @else
            <div class="user-menu" onclick="window.location.href='{{ route('user.profile.home') }}'">
                <div class="user-avatar">{{ auth()->user()->initials }}</div>
            </div>
        @endif
    </div>
</header>