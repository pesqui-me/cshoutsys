@props([
    'label' => '',
    'value' => '',
    'icon' => '📊',
    'change' => null,
    'positive' => false
])

<div class="stat-card">
    <div class="stat-header">
        <span class="stat-label">{{ $label }}</span>
        <span class="stat-icon">{{ $icon }}</span>
    </div>
    <div class="stat-value">{{ $value }}</div>
    @if($change)
        <div class="stat-change {{ $positive ? 'positive' : '' }}">
            {{ $change }}
        </div>
    @endif
</div>