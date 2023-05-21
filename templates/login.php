
<?php if(is_user_logged_in()): $current_user = wp_get_current_user(); ?>
    <div class="btn-group dropstart">
        <a class="border-0 bg-transparent" type="button" href="<?php echo esc_url(site_url()); ?>/admin">
            <?php
            $userProfileImage = get_the_post_thumbnail_url($current_user->ID, 'thumbnail');
            if($userProfileImage):?>
                <img src="<?php echo esc_url($userProfileImage); ?>" class="nav-image-profile">
            <?php else: ?>
                <span class="material-symbols-outlined">account_circle</span>
            <?php endif; ?>
        </a>
    </div>

<?php else: ?>
    <div class="dropdown dropstart">
        <button class="btn border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvLogin" aria-controls="offCanvLogin">
            <span class="material-symbols-outlined">account_circle</span>
        </button>
    </div>
<?php endif; ?>