@extends('layouts.recruitment')

@section('content')
<div class="page-content" style="padding: 0; display: flex; flex-direction: column;">
    
    <!-- Pipeline Header -->
    <div class="pipeline-header">
        <div class="header-info">
            <h1 class="page-title">Hiring Pipeline</h1>
            <p class="page-subtitle">Visual funnel management for active candidates</p>
        </div>
        <div class="header-actions">
            <div class="view-toggle">
                <button class="toggle-btn active">Board View</button>
                <button class="toggle-btn">List View</button>
            </div>
            <button class="btn btn-primary add-btn">
                <x-icon name="users" class="w-5 h-5" /> Add Candidate
            </button>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board-container" id="pipeline-board">
        @foreach($stages as $stage)
            <div class="kanban-column-wrapper">
                <!-- Column Header -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 4px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0F172A; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">{{ $stage }}</h3>
                        <span class="stage-count" style="font-size: 12px; font-weight: 700; background: #E2E8F0; color: #475569; padding: 2px 8px; border-radius: 6px;">{{ $pipeline[$stage]->count() }}</span>
                    </div>
                    <button style="color: #94A3B8; background: none; border: none; cursor: pointer;"><x-icon name="dashboard" class="w-4 h-4" /></button>
                </div>

                <!-- Cards Container -->
                <div class="kanban-column" data-stage="{{ $stage }}" style="flex: 1; display: flex; flex-direction: column; gap: 12px; overflow-y: auto; padding-bottom: 20px; min-height: 100px;">
                    @foreach($pipeline[$stage] as $applicant)
                        @php $application = $applicant->applications->first(); @endphp
                        <div class="kanban-card" data-application-id="{{ $application->id }}" style="cursor: grab;">
                            <a href="{{ route('applicants.show', $applicant->id) }}" style="text-decoration: none; color: inherit;">
                                <div style="background: white; border-radius: 16px; padding: 20px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;" 
                                     onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05)'; this.style.borderColor='var(--primary)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.02)'; this.style.borderColor='#F1F5F9'">
                                    
                                    <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                                        <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                                             style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; background: #F8FAFC;" alt="Avatar">
                                        <div style="flex: 1;">
                                            <h4 style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0; line-height: 1.3;">{{ $applicant->full_name }}</h4>
                                            <p style="font-size: 12px; color: #64748B; margin: 2px 0 0; font-weight: 500;">{{ $application->jobOpening->position->title }}</p>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span style="font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em;">#{{ $application->reference_number }}</span>
                                        <div style="display: flex; align-items: center; -space-x-2">
                                            <div style="width: 24px; height: 24px; border-radius: 50%; background: #F1F5F9; border: 2px solid white; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #64748B;">JS</div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #F8FAFC; display: flex; gap: 8px;">
                                        @if($application->decision_status == 'Shortlisted')
                                            <span style="font-size: 10px; font-weight: 800; color: #059669; background: #D1FAE5; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">Shortlisted</span>
                                        @endif
                                        <span style="font-size: 10px; font-weight: 800; color: #6366F1; background: #EEF2FF; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">Active</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Load SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const columns = document.querySelectorAll('.kanban-column');
    
    columns.forEach(column => {
        new Sortable(column, {
            group: 'pipeline',
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                const applicationId = evt.item.dataset.applicationId;
                const newStage = evt.to.dataset.stage;
                const oldStage = evt.from.dataset.stage;

                if (newStage === oldStage) return;

                // Update counts (optimistic UI)
                updateStageCounts();

                // Send AJAX request
                fetch(`/applications/${applicationId}/update-stage`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        current_stage: newStage
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message);
                    } else {
                        showToast('Error updating stage', 'error');
                        // Optional: revert changes
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Connection error', 'error');
                });
            }
        });
    });

    function updateStageCounts() {
        document.querySelectorAll('.kanban-column').forEach(col => {
            const count = col.querySelectorAll('.kanban-card').length;
            const countBadge = col.closest('div').parentElement.querySelector('.stage-count');
            if (countBadge) countBadge.textContent = count;
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.bottom = '40px';
        toast.style.right = '40px';
        toast.style.padding = '16px 24px';
        toast.style.borderRadius = '16px';
        toast.style.background = type === 'success' ? '#0F172A' : '#EF4444';
        toast.style.color = 'white';
        toast.style.fontWeight = '700';
        toast.style.fontSize = '14px';
        toast.style.boxShadow = '0 20px 25px -5px rgba(0,0,0,0.1)';
        toast.style.zIndex = '2000';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '12px';
        const successIcon = `<svg style="width: 20px; height: 20px; color: #10B981;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
        const errorIcon = `<svg style="width: 20px; height: 20px; color: #EF4444;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>`;
        
        toast.innerHTML = (type === 'success' ? successIcon : errorIcon) + ` <span style="font-weight: 600;">${message}</span>`;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
</script>

@endsection

<style>
.sortable-ghost {
    opacity: 0.4;
    background: #F1F5F9 !important;
    border: 2px dashed #CBD5E1 !important;
}
.sortable-drag {
    cursor: grabbing !important;
}
</style>
