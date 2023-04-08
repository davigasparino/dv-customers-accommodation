<?php get_header(); ?>
<div class="container pt-5">
    <div class="row">
        <div class="col-12">
            <form class="row g-3 needs-validation" novalidate>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <a href="" type="button" id="loginSend" class="btn btn-primary">Submit</a>
            </form>

        </div>
    </div>
</div>
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