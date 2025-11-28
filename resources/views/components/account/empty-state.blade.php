@props([
    'icon' => '📦',
    'title' => 'Aucun élément',
    'message' => '',
    'action' => null
])

<div class="card">
    <div class="empty-state">
        <div class="empty-icon">{{ $icon }}</div>
        <h3 class="empty-title">{{ $title }}</h3>
        @if($message)
            <p class="empty-text">{{ $message }}</p>
        @endif
        @if($action)
            {{ $action }}
        @endif
    </div>
</div>