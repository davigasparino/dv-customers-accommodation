<?php
    session_start();

    if (!isset($_SESSION['customer_loggedin']) || $_SESSION['customer_id'] !== get_the_ID()) {
        header('Location: /');
        exit;
    }
    get_header();

    $userFields = get_post_meta(get_the_ID(), 'user_fields')[0];
    set_query_var('userFields', array(
        'ID' => get_the_ID(),
        'userfields' => $userFields
    ));
?>
    <div class="container pt-5">
        <div class="row">
            <h2 class="display-6">Dados pessoais</h2>
            <div class="col-md-3 col-12">
                <div class="card border-0">
                    <div class="card-body p-2">
                        <?php include(CustomerPATH . '/templates/parts/single/form_image.php'); ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group-vertical mt-3 w-100" role="group" aria-label="Vertical button group">
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2">badge</span>
                            Dados Pessoais
                        </button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2">real_estate_agent</span>
                            Modo Anfitrião
                        </button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2">heart_check</span>
                            Favoritos</button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2">calendar_month</span>
                            Reservas</button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2">credit_card</span>
                            Financeiro</button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center">
                            <span class="material-symbols-outlined me-2 d-flex align-items-lg-center">contact_support</span>
                            Preciso de ajuda</button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center" data-bs-toggle="modal" data-bs-target="#updatePassMd">
                            <span class="material-symbols-outlined me-2">lock_reset</span>
                            Trocar senha
                        </button>
                        <button type="button" class="btn btn-outline-dark d-flex align-items-lg-center" id="userLogout">
                            <span class="material-symbols-outlined me-2 me-2">exit_to_app</span>
                            Sair
                        </button>
                    </div>
                    <?php include(CustomerPATH . '/templates/parts/single/form_update_pass.php'); ?>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <?php include(CustomerPATH . '/templates/parts/message_form.php'); ?>
                <?php include(CustomerPATH . '/templates/parts/single/form.php'); ?>
            </div>
        </div>
    </div>

<?php get_footer();