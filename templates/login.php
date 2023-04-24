
<?php if(isset($_SESSION['customer_loggedin'])): ?>
    <div class="btn-group dropstart">
        <a class="border-0 bg-transparent" type="button" href="<?php echo esc_url(get_permalink($_SESSION['customer_id'])); ?>">
            <?php
            $userProfileImage = get_the_post_thumbnail_url($_SESSION['customer_id'], 'thumbnail');
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