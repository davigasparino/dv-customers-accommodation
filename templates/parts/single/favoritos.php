<section class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row">
            <?php (new class { use CustomersUtils; })::getTitle('customer', $param); ?>
        </div>
    </div>
</section>

<?php
$current_user = wp_get_current_user();
$FavMeta = get_user_meta($current_user->ID, 'custom') ?? null;
$Favorites = (json_decode($FavMeta[0]['favorite_items'])) ?? array();
if(!empty($Favorites)):
    $query = new WP_Query(array(
        'post_type' => 'stablishments',
        'post_status' => array('publish'),
        'post__in' => $Favorites,
    ));
$baseUrl = get_permalink();
?>
    <section class="container-fluid bg-light">
        <div class="container">
        <?php while($query->have_posts()): $query->the_post(); ?>
            <div class="row my-4 py-3 shadow">
                <div class="col-3">
                    <?php
                    $postDatas = array_shift(get_post_meta(get_the_ID(), 'estab_fields'));
                    $images = array_shift(get_post_meta(get_the_ID(), 'estab_img'));
                    if($images): ?>
                        <div id="carouselList<?php echo esc_attr(get_the_ID()); ?>" class="carousel slide">
                            <div class="carousel-indicators">
                                <?php $imgCount = 0; foreach ($images as $image_key => $image): if($imgCount > 4) continue; ?>
                                    <button type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide-to="<?php echo esc_attr($image_key); ?>" class="<?php echo esc_attr(($imgCount === 0) ? 'active' : ''); ?>" aria-current="<?php echo esc_attr(($imgCount === 0) ? 'true' : ''); ?>" aria-label="Slide <?php echo esc_attr($image_key); ?>"></button>
                                    <?php $imgCount++; endforeach;?>
                            </div>
                            <div class="carousel-inner">
                                <?php $imgCount = 0; foreach ($images as $image): if($imgCount > 4) continue; ?>
                                    <div class="carousel-item <?php echo esc_attr(($imgCount === 0) ? 'active' : ''); ?>">
                                        <img src="<?php echo wp_get_attachment_image_url($image['img'], 'large') ?>" style="height: 140px; object-fit: cover;" class="d-block w-100 " alt="...">
                                    </div>
                                    <?php $imgCount++; endforeach;?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselList<?php echo esc_attr(get_the_ID()); ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    <?php endif;?>
                </div>
                <div class="col-6 ps-4 d-flex justify-content-center flex-column">
                    <h4>
                        <a href="<?php echo $baseUrl.get_query_var('panel').'/'.get_query_var('partner').'/form/'.get_the_ID(); ?>" class="link-dark text-decoration-none">
                            <?php echo esc_html($postDatas['name']); ?>
                        </a>
                    </h4>
                    <h5 class="display-6">
                        R$
                        <small class="text-body-secondary"><?php echo esc_html(isset($postDatas, $postDatas['coust']) ? $postDatas['coust'] : ''); ?></small>
                    </h5>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </section>
<?php endif;