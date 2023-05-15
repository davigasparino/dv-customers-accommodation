<button class="btn-home-filter" data-bs-toggle="offcanvas" data-bs-target="#home-filter-options">
    <span class="material-symbols-outlined">page_info</span>
    Filtrar
</button>
<div class="list-group home-filter-list">
    <?php
    $tax_type = get_terms(array(
        'taxonomy'   => array('partner_type', 'partner_add'),
        'hide_empty' => false,
    ));

    foreach ($tax_type as $type): ?>
        <button class="btn list-group-item border-0 d-flex flex-column justify-content-center align-items-center bg-transparent">
            <?php $termIcon = get_term_meta($type->term_id, 'icon'); ?>
            <?php if(isset($termIcon[0]) && !empty($termIcon[0])): ?>
                <span class="icon material-symbols-outlined"><?php echo get_term_meta($type->term_id, 'icon')[0]; ?></span>
            <?php endif; ?>
            <span class="item"><?php echo esc_html($type->name); ?></span>
        </button>
    <?php endforeach; ?>
</div>