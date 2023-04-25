<?php
$partner = (!empty(get_query_var('partner'))) ? get_query_var('partner') : 'dashboard-anfitriao';
(new class { use CustomersUtils; })::getTitle('customer', get_query_var('panel'));

$partinerLinks = (new class { use CustomersUtils; })::getMenuItems('partner');?>
<div class="btn-group mb-5" role="group" aria-label="Partner buttons">
    <?php foreach ($partinerLinks as $part_key => $part_value): ?>
        <a href="<?php echo esc_html(get_permalink().'/'.get_query_var('panel').'/'.$part_key); ?>"
           class="btn btn-outline-dark d-flex <?php echo esc_attr(($part_key  === $partner) ? 'active' : '' ); ?>">
            <span class="material-symbols-outlined me-2"><?php echo esc_html($part_value['icon']); ?></span>
           <?php echo esc_html($part_value['name']); ?>
        </a>
    <?php endforeach;?>
</div>
<?php include(CustomerPATH . 'templates/parts/single/'.$partner.'.php'); ?>