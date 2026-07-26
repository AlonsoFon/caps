{{-- ---------------------- Image modal box ---------------------- --}}
<div id="imageModalBox" class="imageModal">
    <span class="imageModal-close">&times;</span>
    <img class="imageModal-content" id="imageModalBoxSrc">
  </div>

  {{-- ---------------------- Delete Modal ---------------------- --}}
  <div class="app-modal" data-name="delete">
      <div class="app-modal-container">
          <div class="app-modal-card" data-name="delete" data-modal='0'>
              <div class="app-modal-header">Are you sure you want to delete this?</div>
              <div class="app-modal-body">You can not undo this action</div>
              <div class="app-modal-footer">
                  <a href="javascript:void(0)" class="app-btn cancel">Cancel</a>
                  <a href="javascript:void(0)" class="app-btn a-btn-danger delete">Delete</a>
              </div>
          </div>
      </div>
  </div>
  {{-- ---------------------- Alert Modal ---------------------- --}}
  <div class="app-modal" data-name="alert">
      <div class="app-modal-container">
          <div class="app-modal-card" data-name="alert" data-modal='0'>
              <div class="app-modal-header"></div>
              <div class="app-modal-body"></div>
              <div class="app-modal-footer">
                  <a href="javascript:void(0)" class="app-btn cancel">Cancel</a>
              </div>
          </div>
      </div>
  </div>
  {{-- ---------------------- Settings Modal ---------------------- --}}
  <div class="app-modal" data-name="settings">
      <div class="app-modal-container">
          <div class="app-modal-card" data-name="settings" data-modal='0'>
              <form id="update-settings" action="{{ route('avatar.update') }}" enctype="multipart/form-data" method="POST">
                  @csrf
                  {{-- <div class="app-modal-header">Update your profile settings</div> --}}
                  <div class="app-modal-body">
                      {{-- Udate profile avatar --}}
                      <div class="avatar av-l upload-avatar-preview chatify-d-flex"
                      style="background-image: url('{{ Chatify::getUserWithAvatar(Auth::user())->avatar }}');"
                      ></div>
                      <p class="upload-avatar-details"></p>
                      <label class="app-btn a-btn-primary update" style="background-color:{{$messengerColor}}">
                          Trocar Foto de Perfil
                          <input class="upload-avatar chatify-d-none" accept="image/*" name="avatar" type="file" />
                      </label>
                      {{-- Dark/Light Mode  --}}
                      <p class="divider"></p>
                        <a href="{{ route('logout') }}"
                        class="app-btn a-btn-secuntary"
                        style="text-decoration: none; color: white; margin-bottom: 20px; background: black;"
                        onclick="event.preventDefault(); logout();">
                            Sair da conta
                        </a>

                        <script>
                            function logout() {
                                fetch('{{ route('logout') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (response.redirected) {
                                        window.location.href = response.url;
                                    } else {
                                        window.location.href = '/';
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                            }
                        </script>
                        <a href="/profile"
                        class="app-btn a-btn-secuntary"
                        style="text-decoration: none; color: white; margin-bottom: 20px; background: blue;"
                        >
                            Editar Perfil
                        </a>
                        
                      
                  </div>
                  <div class="app-modal-footer">
                      <a href="javascript:void(0)" class="app-btn cancel">Cancelar</a>
                      <input type="submit" class="app-btn a-btn-success update" value="Salvar" />
                  </div>
              </form>
          </div>
      </div>
  </div>
