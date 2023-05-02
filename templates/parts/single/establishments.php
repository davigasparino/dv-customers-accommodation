<?php
$action = (!empty(get_query_var('action'))) ? get_query_var('action') : 'list';
(new class { use CustomersUtils; })::getTitle('partner', get_query_var('partner'));
$stablishments_menu = (new class { use CustomersUtils; })::getMenuItems('stablishments');?>
<div class="btn-group d-inline-flex flex-wrap my-4" role="group" aria-label="Partner buttons">
    <?php foreach ($stablishments_menu as $st_key => $st_value): ?>
        <a href="<?php echo esc_html(get_permalink().'/'.get_query_var('panel').'/'.get_query_var('partner').'/'.$st_key); ?>"
           class="btn btn-outline-dark d-flex <?php echo esc_attr(($st_key  === $action) ? 'active' : '' ); ?>">
            <span class="material-symbols-outlined me-2"><?php echo esc_html($st_value['icon']); ?></span>
            <?php echo esc_html($st_value['name']); ?>
        </a>
    <?php endforeach;?>
</div>

<?php include(CustomerPATH . 'templates/parts/stablishments/'.$action.'.php'); ?>

