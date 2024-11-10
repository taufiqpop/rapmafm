<div id="modal-change-profile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-change-profileLabel"
    aria-hidden="true">
    <form action="{{ route('users.change-profile') }}" method="post" id="form-change-profile" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modal-change-profileLabel">Form Ganti Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update-fullname">Nama Lengkap</label>
                        <input type="text" name="name" id="update-fullname" class="form-control"
                            placeholder="Masukkan Nama Lengkap" required>
                        <div id="error-update-fullname"></div>
                    </div>
                    <div class="form-group">
                        <label for="update-username">Username</label>
                        <input type="text" name="username" id="update-username" class="form-control"
                            placeholder="Masukkan Username" required>
                        <div id="error-update-username"></div>
                    </div>
                    <div class="form-group">
                        <label for="update-email">Email</label>
                        <input type="email" name="email" id="update-email" class="form-control"
                            placeholder="Masukkan Email" required>
                        <div id="error-update-email"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
