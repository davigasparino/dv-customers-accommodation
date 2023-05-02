    <section class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row">
                <?php
                $userFields = get_query_var('userFields');
                (new class { use CustomersUtils; })::getTitle('customer', get_query_var('panel'));
                ?>
            </div>
        </div>
    </section>

    <section class="container-fluid py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="uppass-message-status">
                        <div></div>
                    </div>
                    <form id="update-pass-form" class="g-3 needs-validation container text-end" novalidate>
                        <div class="mb-3 row">
                            <div class="input-group input-group-lg py-3">
                                <span class="input-group-text">Senha Atual</span>
                                <input type="password" class="form-control" id="oldPassword" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="input-group input-group-lg py-3">
                                <span class="input-group-text">Nova Senha</span>
                                <input type="password" class="form-control" id="newPassword" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="input-group input-group-lg py-3">
                                <span class="input-group-text">Confirmar</span>
                                <input type="password" class="form-control" id="confirmNewPassword" required>
                            </div>
                        </div>
                        <?php $userID = (isset($userFields, $userFields['ID'])) ? $userFields['ID'] : ''; ?>
                        <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($userID); ?>">
                        <button class="btn btn-outline-dark btn-lg mt-2" type="submit" id="updatePass">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Atualizar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>