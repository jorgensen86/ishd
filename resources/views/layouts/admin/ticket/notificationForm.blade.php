<div class="modal-header">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <div class="timeline notifications">
        @foreach ($notifications as $notification)
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header">
                        {{ $notification->user->name }} έστειλε ένα αίτημα
                    </h3>
                    <div class="timeline-body">{{ $notification->body }}</div>
                </div>
            </div>
        @endforeach
    </div>
    <form action="">
    
        <div class="form-group">
            <textarea name="" id="" class="form-control"></textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
</div>
