@extends('layouts.recruitment')

@section('content')
<div class="page-content" style="padding: 32px; max-width: 1000px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -0.03em; color: #0F172A;">Notification Center</h1>
            <p style="font-size: 15px; color: #64748B; font-weight: 600; margin-top: 4px;">Manage your recruitment alerts and system updates</p>
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="btn-primary" style="height: 48px; padding: 0 24px; border-radius: 12px; font-weight: 700; background: #0F172A; color: white; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                    <x-icon name="check" class="w-5 h-5" /> Mark All as Read
                </button>
            </form>
        @endif
    </div>

    <div style="background: white; border-radius: 24px; border: 1px solid #F1F5F9; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
        @forelse($notifications as $notification)
            <div style="padding: 24px 32px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between; transition: all 0.2s; {{ $notification->read_at ? 'opacity: 0.7;' : 'background: #F8FAFC; border-left: 4px solid var(--primary);' }}"
                 onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='{{ $notification->read_at ? 'white' : '#F8FAFC' }}'">
                
                <div style="display: flex; align-items: center; gap: 24px; flex: 1;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: {{ $notification->read_at ? '#F1F5F9' : '#EFF6FF' }}; display: flex; align-items: center; justify-content: center; color: {{ $notification->read_at ? '#94A3B8' : 'var(--primary)' }}; flex-shrink: 0;">
                        <x-icon name="{{ $notification->read_at ? 'bell' : 'bell' }}" class="w-6 h-6" />
                    </div>
                    <div>
                        <p style="font-size: 16px; font-weight: {{ $notification->read_at ? '600' : '700' }}; color: #0F172A; margin: 0; line-height: 1.5;">{{ $notification->data['message'] ?? 'System Notification' }}</p>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 4px;">
                            <span style="font-size: 13px; color: #94A3B8; font-weight: 600;">{{ $notification->created_at->diffForHumans() }}</span>
                            @if(!$notification->read_at)
                                <span style="width: 6px; height: 6px; background: var(--primary); border-radius: 50%;"></span>
                                <span style="font-size: 12px; color: var(--primary); font-weight: 700; text-transform: uppercase;">New</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if(!$notification->read_at)
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit" style="background: white; border: 1.5px solid #E2E8F0; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; color: #475569; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#0F172A'; this.style.color='white'; this.style.borderColor='#0F172A'" onmouseout="this.style.background='white'; this.style.color='#475569'; this.style.borderColor='#E2E8F0'">
                            Dismiss
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div style="padding: 80px 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background: #F8FAFC; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <x-icon name="bell" style="width: 40px; height: 40px; color: #CBD5E1;" />
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">All caught up!</h3>
                <p style="font-size: 15px; color: #94A3B8; font-weight: 600; margin-top: 8px;">You don't have any new notifications at the moment.</p>
                <a href="{{ route('dashboard') }}" style="display: inline-block; margin-top: 24px; font-size: 14px; font-weight: 700; color: var(--primary); text-decoration: none;">Return to Dashboard &rarr;</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 32px;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
