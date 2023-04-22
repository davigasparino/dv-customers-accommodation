
<?php if(isset($_SESSION['customer_loggedin'])): ?>
    <div class="btn-group dropstart">
        <button class="dropdown-toggle border-0 bg-transparent" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
            <?php
            $userProfileImage = get_the_post_thumbnail_url($_SESSION['customer_id'], 'thumbnail');
            if($userProfileImage):?>
                <img src="<?php echo esc_url($userProfileImage); ?>" class="nav-image-profile">
            <?php else: ?>
                <span class="material-symbols-outlined">account_circle</span>
            <?php endif; ?>
        </button>
        <ul class="dropdown-menu" id="nav-user-panel">
            <li><a class="dropdown-item" href="<?php echo esc_url(get_permalink($_SESSION['customer_id'])); ?>"><?php echo esc_html(array_shift(get_post_meta($_SESSION['customer_id'], 'user_fields'))['name']); ?></a></li>
        </ul>
    </div>

<?php else: ?>
    <div class="dropdown dropstart">
        <button class="btn border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvLogin" aria-controls="offCanvLogin">
            <span class="material-symbols-outlined">account_circle</span>
        </button>
    </div>
<?php endif; ?>