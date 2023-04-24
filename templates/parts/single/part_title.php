<?php
$adminLinks = get_query_var('menu_params');
$param = (!empty(get_query_var('panel'))) ? get_query_var('panel') : 'dashboard';
?>
<h3 class="mb-3">
    <span class="material-symbols-outlined me-2"><?php echo esc_html($adminLinks[$param]['icon']); ?></span>
    <?php echo esc_html($adminLinks[$param]['name']); ?>
</h3>
