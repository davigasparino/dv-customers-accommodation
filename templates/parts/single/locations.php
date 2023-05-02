<section class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <?php (new class { use CustomersUtils; })::getTitle('partner', get_query_var('partner')); ?>
        </div>
    </div>
</section>
