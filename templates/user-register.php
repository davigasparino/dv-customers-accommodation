<?php get_header(); ?>
    <div class="container">
        <h2 class="display-6 my-4">Dados pessoais</h2>
    </div>
    <div class="container-fluid px-0 py-2">
        <div class="row">
            <div class="col-md-12 col-12 py-3">
                <?php include(CustomerPATH . 'templates/parts/message_form.php'); ?>
                <?php include(CustomerPATH . 'templates/parts/single/dados-pessoais.php'); ?>
            </div>
        </div>
    </div>
<?php get_footer();