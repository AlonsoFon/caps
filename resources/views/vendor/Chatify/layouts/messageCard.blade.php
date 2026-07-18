<?php
$seenIcon = (!!$seen ? 'check-double' : 'check');
$timeAndSeen = "<span data-time='$created_at' class='message-time'>
        ".($isSender ? "<span class='fas fa-$seenIcon' seen'></span>" : '' )." <span class='time'>$timeAgo</span>
    </span>";
?>

<div class="message-card @if($isSender) mc-sender @endif" data-id="{{ $id }}">
    {{-- Delete Message Button --}}
    @if ($isSender)
        <div class="actions">
            <i class="fas fa-trash delete-btn" data-id="{{ $id }}"></i>
        </div>
    @endif
    {{-- Card --}}
    @php
        $user = Auth::user()->load('sub_users');
        $chat_message = \DB::table('ch_messages')->where('id', $id)->first();
        if(isset($chat_message)){
            if($chat_message->sub_user_id != null){
                $sub_user = \DB::table('sub_users')->where('id', $chat_message->sub_user_id)->first();
                if(isset($sub_user)){
                    $user_name = $sub_user->name;
                } else {
                    $user_name = $user->name;
                }
            } else {
                $user_name = $user->name;
            }
        }
    @endphp
    <div class="message-card-content">
        <div class="message-card-header">
            <div class="message" style="background: @if ($isSender) black @else #db2424 @endif !important;font-size: 12px; color: white;">
                {{ $user_name }}:
            </div> 
        </div>
        @if (@$attachment->type != 'image' || $message)
            <div class="message">
                {!! ($message == null && $attachment != null && @$attachment->type != 'file') ? $attachment->title : nl2br($message) !!}
                {!! $timeAndSeen !!}
                {{-- If attachment is a file --}}
                @if(@$attachment->type == 'file')
                <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName'=>$attachment->file]) }}" class="file-download" style="color: black">
                    <span class="fas fa-file"></span> {{$attachment->title}}</a>
                @endif
            </div>
        @endif
        @if(@$attachment->type == 'image')
        <div class="image-wrapper" style="text-align: {{$isSender ? 'end' : 'start'}}">
            <div class="image-file chat-image" style="background-image: url('{{ Chatify::getAttachmentUrl($attachment->file) }}')">
                <div>{{ $attachment->title }}</div>
            </div>
            <div style="margin-bottom:5px">
                {!! $timeAndSeen !!}
            </div>
        </div>
        @endif
    </div>
</div>
