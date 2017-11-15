<div class="ks-info ks-messenger__info">
    <div class="ks-header">
        User Info
    </div>
    <div class="ks-body">
        <div class="ks-item ks-user">
                                <span class="ks-avatar ks-online">
                                    <img src="{{ asset($user->photo) }}" width="36" height="36"
                                         class="rounded-circle">
                                </span>
            <span class="ks-name">
                                    {{ $user->name }}
                                </span>
        </div>

        <div class="ks-item">
            <div class="ks-name">Username</div>
            <div class="ks-text">
                {{ $user->username }}
            </div>
        </div>
        <div class="ks-item">
            <div class="ks-name">Email</div>
            <div class="ks-text">
                {{ $user->email }}
            </div>
        </div>
    </div>
    <div class="ks-footer">
        <div class="ks-item">
            <div class="ks-name">Created</div>
            <div class="ks-text">
                {{ $user->created_at }}
            </div>
        </div>
        <div class="ks-item">
            <div class="ks-name">User Group</div>
            <div class="ks-text">
                {{ $user->usergroup->group_name }}
            </div>
        </div>
        @if($user->usergroup->id !== 1 && $user->user_group_id !== 2)
            <div class="ks-item">
                <div class="ks-name">Partner</div>
                <div class="ks-text">
                   {{ $user->partner->name }}
                </div>
            </div>
            @endif
    </div>
</div>
           