<?php get_header();?>
    <div class="container">
        <div class="row m-0">
            <div class="col-12">
                <?php
                if(isset($_SESSION['customer_id'])){
                    $FavMeta = get_post_meta($_SESSION['customer_id'], 'custom') ?? null;
                    $Favorites = (isset($FavMeta[0]['favorite_items'])) ? json_decode($FavMeta[0]['favorite_items']) : array();
                }

                $favClass = (isset($Favorites) && is_int(array_search(get_the_ID(), $Favorites))) ? 'rounded' : 'outlined';
                $images = array_shift(get_post_meta(get_the_ID(), 'estab_img'));
                if($images): ?>
                    <div id="carouselList<?php echo esc_attr(get_the_ID()); ?>" class="carousel slide" data-bs-ride="carousel">
                        <button class="favorite-btn" data-id="<?php echo esc_attr(get_the_ID()); ?>">
                            <span class="material-symbols-<?php echo esc_attr($favClass); ?>">favorite</span>
                        </button>
                        <div class="carousel-indicators">
                            <?php $imgCount = 0; foreach ($images as $image_key => $image): if($imgCount > 4) continue; ?>
                                <button type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide-to="<?php echo esc_attr($image_key); ?>" class="<?php echo esc_attr(($imgCount === 0) ? 'active' : ''); ?>" aria-current="<?php echo esc_attr(($imgCount === 0) ? 'true' : ''); ?>" aria-label="Slide <?php echo esc_attr($image_key); ?>"></button>
                                <?php $imgCount++; endforeach;?>
                        </div>
                        <div class="carousel-inner ratio ratio-21x9">
                            <?php $imgCount = 0; foreach ($images as $image): if($imgCount > 4) continue; ?>
                                <div class="carousel-item <?php echo esc_attr(($imgCount === 0) ? 'active' : ''); ?>">
                                    <img src="<?php echo wp_get_attachment_image_url($image['img'], 'large') ?>" class="d-block w-100" alt="...">
                                </div>
                                <?php $imgCount++; endforeach;?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide="prev">
                            <span class="material-symbols-outlined">arrow_left</span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide="next">
                            <span class="material-symbols-outlined">arrow_right</span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="pswp-gallery" id="my-gallery">
                <a
                    href="https://cdn.photoswipe.com/photoswipe-demo-images/photos/1/img-2500.jpg"
                    data-pswp-width="1875"
                    data-pswp-height="2500"
                    target="_blank"
                >
                    <img
                        src="https://cdn.photoswipe.com/photoswipe-demo-images/photos/1/img-200.jpg"
                        alt=""
                    />
                </a>
                <a
                    href="https://cdn.photoswipe.com/photoswipe-demo-images/photos/2/img-2500.jpg"
                    data-pswp-width="1669"
                    data-pswp-height="2500"
                    target="_blank"
                >
                    <img
                        src="https://cdn.photoswipe.com/photoswipe-demo-images/photos/2/img-200.jpg"
                        alt=""
                    />
                </a>
                <a
                    href="https://cdn.photoswipe.com/photoswipe-demo-images/photos/3/img-2500.jpg"
                    data-pswp-width="2500"
                    data-pswp-height="1666"
                    target="_blank"
                >
                    <img
                        src="https://cdn.photoswipe.com/photoswipe-demo-images/photos/3/img-200.jpg"
                        alt=""
                    />
                </a>
            </div>

        </div>
    </div>
<?php get_footer();