<ul-body wire:poll.visible="checkCountsAndLogs">
    @foreach($lastLogs as $log)
        <li class="{{ in_array($log->id, $unreadedLogsIds) ? 'unreaded' : '' }}">
            <div>{{ $log->description }}</div>
            <div class="">
                <div class="by-user"><i class="fa fa-user fa-sm"></i>
                    <span>{{ $log->causer->name ?? 'غير معروف' }}</span></div>
                <div class="since"><i class="fa fa-clock fa-sm"></i>
                    <span>{{ $log->created_at->diffForHumans() }}</span></div>
            </div>
        </li>
    @endforeach
</ul-body>
