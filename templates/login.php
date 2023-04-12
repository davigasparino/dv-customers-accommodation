
<?php if(isset($_SESSION['customer_loggedin'])): ?>
    <div class="btn-group dropstart">
        <button class="dropdown-toggle border-0 bg-transparent" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
            <?php
            $userProfileImage = get_the_post_thumbnail_url($_SESSION['customer_id'], 'thumbnail');
            if($userProfileImage):?>
                <img src="<?php echo esc_url($userProfileImage); ?>" class="nav-image-profile">
            <?php else: ?>
                <span class="material-symbols-outlined">account_circle</span>
            <?php endif; ?>
        </button>
        <ul class="dropdown-menu" id="nav-user-panel">
            <li><a class="dropdown-item" href="<?php echo esc_url(get_permalink($_SESSION['customer_id'])); ?>"><?php echo esc_html(array_shift(get_post_meta($_SESSION['customer_id'], 'user_fields'))['name']); ?></a></li>
            <li>
                <a class="dropdown-item" href="#" id="userLogout">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span class="material-symbols-outlined btn-icon">logout</span>
                </a>
            </li>
        </ul>
    </div>

<?php else: ?>
    <div class="dropdown dropstart">
        <button type="button" class="border-0 bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <span class="material-symbols-outlined">account_circle</span>
        </button>
        <form id="loginUsers" class="needs-validation dropdown-menu p-4" novalidate>
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
                <button class="btn btn-outline-dark" type="button" id="loginSend">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Entrar
                </button>
        </form>
    </div>
<?php endif; ?>