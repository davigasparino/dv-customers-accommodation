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
            <div class="col-md-2 col-12">
                <?php include(CustomerPATH . '/templates/parts/single/form_image.php'); ?>
            </div>
            <div class="col-md-10 col-12">
                <?php include(CustomerPATH . '/templates/parts/single/form.php'); ?>
            </div>
        </div>
    </div>

<?php get_footer();