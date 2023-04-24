    <?php
    $userFields = get_query_var('userFields');
    include(CustomerPATH . '/templates/parts/single/part_title.php');
    ?>
    <div class="row">
        <div class="col-md-6 col-12 offset-md-3 mt-md-5">
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
                <?php $userID = (isset($userFields, $userFields['ID'])) ? $userFields['ID'] : ''; ?>
                <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($userID); ?>">
                <div class="mb-3 row d-flex justify-content-end">
                    <button class="btn btn-outline-dark w-50 mt-2" type="submit" id="updatePass">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
