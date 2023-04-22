<div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvLogin" aria-labelledby="offCanvLoginLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offCanvLoginLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="loginUsers" class="needs-validation p-4" novalidate>
            <div class="login-message-status">
                <div></div>
            </div>
            <div class="mb-3 mt-3">
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
            <div class="mb-3 form-check p-0">
                Ainda não possuí cadastro? <a href="/cadastrar">Criar Conta</a>
            </div>
            <button class="btn btn-outline-dark" type="submit" id="loginSend">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Entrar
            </button>
        </form>
    </div>
</div>
