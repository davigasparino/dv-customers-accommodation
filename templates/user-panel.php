<?php
    if(is_user_logged_in()):

    get_header();

    $current_user = wp_get_current_user();

    $userFields = get_user_meta($current_user->ID, 'user_fields')[0];
    set_query_var('userFields', array(
        'ID' => $current_user->ID,
        'userfields' => $userFields,
        'currentUser' => $current_user
    ));

    $param = (!empty(get_query_var('panel'))) ? get_query_var('panel') : 'dashboard';
    $adminLinks = (new class { use CustomersUtils; })::getMenuItems('customer');

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-3 col-12 shadow position-relative col-cms-left py-4">
                <div class="border-0 mw-300px">
                    <div class="card-body py-0 px-0 px-md-3">
                        <?php include(CustomerPATH . '/templates/parts/single/form_image.php'); ?>
                    </div>
                </div>
                <div class="px-0 px-md-3 admin-menu sticky-top mw-300px">
                    <div class="btn-group-vertical mt-3 w-100" role="group" aria-label="Vertical button group">
                        <?php foreach($adminLinks as $key_link => $link_value): ?>
                            <a
                                href="<?php echo esc_url(get_permalink() . '/'. $key_link); ?>"
                                class="<?php echo ($param === $key_link) ? 'active' : ''; ?> btn btn-outline-dark d-flex align-items-lg-center"
                                <?php if(isset($link_value['id'])): ?>
                                id="<?php echo esc_html($link_value['id']); ?>"
                                <?php endif; ?>
                            >
                                <span class="material-symbols-outlined me-2"><?php echo esc_html($link_value['icon']); ?></span>
                                <?php echo esc_html($link_value['name']); ?>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-9 col-12 p-0">
                <?php include(CustomerPATH . '/templates/parts/single/'.$param.'.php'); ?>
            </div>
        </div>
    </div>
<?php
    get_footer();

    else:
        header('Location: /');
    endif;