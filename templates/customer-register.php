<?php get_header(); ?>
    <div class="container pt-5">
        <div class="row">
            <h2 class="display-6">Dados pessoais</h2>
            <div class="col-md-12 col-12">
                <?php include(CustomerPATH . 'templates/parts/message_form.php'); ?>
                <?php include(CustomerPATH . 'templates/parts/single/dados-pessoais.php'); ?>
            </div>
        </div>
    </div>
<?php get_footer();