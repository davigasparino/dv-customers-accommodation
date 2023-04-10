<button type="button" class="btn btn-outline-dark border-0" data-bs-target="#mdLogin" data-bs-toggle="modal"><span class="material-symbols-outlined">account_circle</span></button>
<?php if(isset($_SESSION['loggedin'])): ?>
    <button class="btn btn-outline-dark border-0" type="button" id="userLogout">
        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        <span class="material-symbols-outlined btn-icon">logout</span>
    </button>
<?php endif; ?>
<div class="modal fade" style="z-index: 99;" id="mdLogin" aria-hidden="true" aria-labelledby="mdLoginLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdLoginLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginUsers" class="row g-3 needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="usermail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="usermail" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">Well never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="userpass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="userpass" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="userRemember">
                        <label class="form-check-label" for="userRemember">Salvar credenciais</label>
                    </div>
                    <div class="mb-3 form-check">
                        <label>Ainda não possuí cadastro? <a href="/cadastrar">Criar Conta</a> </label>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-dark" type="button" id="loginSend">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Entrar
                </button>
            </div>
        </div>
    </div>
</div>