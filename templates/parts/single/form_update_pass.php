<div class="modal fade" id="updatePassMd" aria-hidden="true" aria-labelledby="updatePassMdLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updatePassMdLabel">Trocar Senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="uppass-message-status">
                    <div></div>
                </div>
                <form id="update-pass-form" class="g-3 needs-validation container" novalidate>
                    <div class="mb-3 row">
                        <label for="oldPassword" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="oldPassword" required>
                    </div>
                    <div class="mb-3 row">
                        <label for="newPassword" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="mb-3 row">
                        <label for="confirmNewPassword" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required>
                    </div>
                    <div class="mb-3 row d-flex justify-content-end">
                        <button class="btn btn-outline-dark w-50 mt-2" type="submit" id="updatePass">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>