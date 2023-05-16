<?php get_header();?>
    <div class="container">
        <div class="row">
            <?php
            if(isset($_SESSION['customer_id'])){
                $FavMeta = get_post_meta($_SESSION['customer_id'], 'custom') ?? null;
                $Favorites = (isset($FavMeta[0]['favorite_items'])) ? json_decode($FavMeta[0]['favorite_items']) : array();
            }
            $favClass = (isset($Favorites) && is_int(array_search(get_the_ID(), $Favorites))) ? 'rounded' : 'outlined';
            $images = array_shift(get_post_meta(get_the_ID(), 'estab_img'));
            if($images): ?>
                <div id="establishmentsGallery">
                    <div class="one-image">
                        <?php IterateGalleryImages($images, 0, 0);?>
                    </div>
                    <div class="two-images">
                        <?php IterateGalleryImages($images, 1, 4);?>
                    </div>
                    <div class="twelve-images">
                        <?php IterateGalleryImages($images, 5, 12);?>
                    </div>
                    <div class="last-images">
                        <?php IterateGalleryImages($images, 13);?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer();

function IterateGalleryImages($images = array(), $init = 0, $end = null){
    foreach ($images as $key => $image):

        if($key < $init) continue;

        $image_url = wp_get_attachment_image_url($image['img'], 'large');
        $imageMetas = wp_get_attachment_metadata($image['img']);
        ?>
        <a href="<?php echo esc_url($image_url); ?>"
           data-pswp-width="<?php echo esc_attr($imageMetas['width']) ?>"
           data-pswp-height="<?php echo esc_attr($imageMetas['height']) ?>"
           target="_blank" >
            <img src="<?php echo esc_url($image_url); ?>" alt=""/>
        </a>
    <?php if($key === $end) break;
    endforeach;
}