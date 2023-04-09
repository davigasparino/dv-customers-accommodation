<?php get_header(); ?>
<div class="container pt-5">
    <div class="row">
        <div class="col-12">
            <form id="loginUsers" class="row g-3 needs-validation" novalidate>
                <div class="mb-3">
                    <label for="usermail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="usermail" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="userpass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="userpass" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="userRemember">
                    <label class="form-check-label" for="userRemember">Salvar credenciais</label>
                </div>
                <button class="btn btn-outline-dark" type="button" id="loginSend">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Entrar
                </button>
            </form>

        </div>
    </div>
</div>

    <button class="btn btn-outline-dark" type="button" id="userLogout">
        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        Sair
    </button>

<script type="text/javascript">
    // (() => {
    //     'use strict'
    //
    //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
    //     const forms = document.querySelectorAll('.needs-validation')
    //
    //     // Loop over them and prevent submission
    //     Array.from(forms).forEach(form => {
    //         form.addEventListener('submit', event => {
    //             if (!form.checkValidity()) {
    //                 event.preventDefault()
    //                 event.stopPropagation()
    //             }
    //
    //             form.classList.add('was-validated')
    //         }, false)
    //     })
    // })()
</script>
<?php get_footer(); ?>