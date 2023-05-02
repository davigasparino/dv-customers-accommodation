<section class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <?php (new class { use CustomersUtils; })::getTitle('customer', $param); ?>
        </div>
    </div>
</section>
