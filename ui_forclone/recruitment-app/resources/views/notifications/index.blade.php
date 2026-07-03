@extends('layouts.recruitment')

@section('content')
<div class="page-content" style="padding: 32px; max-width: 1000px; margin: 0 auto;">
    <div class="page-header" style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 32px; font-weight: 800; color: #0F172A; letter-spacing: -0.03em;">Notifications</h1>
            <p style="color: #64748B; font-size: 16px; margin-top: 4px;">Stay updated with the latest activity on the recruitment portal.</p>
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="btn-secondary" style="height: 44px; padding: 0 20px; border-radius: 12px; font-weight: 700; border: 1.5px solid #E2E8F0; background: #fff;">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="profile-card" style="padding: 0; overflow: hidden;">
        @forelse($notifications as $notification)
            <div style="padding: 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; {{ $notification->read_at ? 'opacity: 0.7;' : 'background: #F8FAFC; border-left: 4px solid var(--primary);' }}">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: {{ $notification->read_at ? '#F1F5F9' : '#EFF6FF' }}; display: flex; align-items: center; justify-content: center; color: {{ $notification->read_at ? '#64748B' : 'var(--primary)' }}; flex-shrink: 0;">
                        <x-icon name="bell" style="width: 24px; height: 24px;" />
                    </div>
                    <div>
                        <p style="font-size: 16px; color: #0F172A; font-weight: 600; margin-bottom: 4px;">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                        <div style="display: flex; align-items: center; gap: 12px; color: #64748B; font-size: 14px;">
                            <span>{{ $notification->created_at->format('M d, Y • h:i A') }}</span>
                            <span style="width: 4px; height: 4px; background: #CBD5E1; border-radius: 50%;"></span>
                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                
                @if(!$notification->read_at)
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: var(--primary); font-weight: 700; font-size: 14px; cursor: pointer; padding: 8px 16px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='none'">
                            Mark as read
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div style="padding: 80px 20px; text-align: center;">
                <div style="width: 80px; height: 80px; background: #F8FAFC; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <x-icon name="bell" style="width: 40px; height: 40px; color: #94A3B8;" />
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 8px;">All caught up!</h3>
                <p style="font-size: 15px; color: #64748B;">You don't have any notifications at the moment.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 24px;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
