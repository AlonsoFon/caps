<style>
    .messenger-sendCard form {
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

.sub-user-select {
    width: 40%;
    height: 38px;
    margin-top: 5px;
    padding: 0 12px;
    margin-bottom: 8px;

    border: 1px solid #e4e6eb;
    border-radius: 8px;
    background: #fff;

    font-size: 14px;
    color: #444;

    outline: none;
    transition: .2s;
}

.sub-user-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13,110,253,.15);
}

.message-row {
    display: flex;
    align-items: center;
    width: 100%;
}
</style>
<div class="messenger-sendCard">
    @php
    $user = Auth::user()->load('sub_users');
    @endphp
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <select name="sub_user_id" id="sub_user_id" class="sub-user-select">
                <option value="None">{{ $user->name }}</option>
                @foreach($user->sub_users as $subUser)
                    <option value="{{ $subUser->id }}">{{ $subUser->name }}</option>
                @endforeach
        </select>

        <div class="message-row">
            <label><span class="fas fa-plus-circle"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
            <button class="emoji-button"></span><span class="fas fa-smile"></button>
            <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
            
            <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
        </div>
    </form>
</div>

