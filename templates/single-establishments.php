<?php get_header();?>
    <?php $estab_address = get_post_meta(get_the_id(), 'estab_address')[0]; ?>
    <?php $estab_fields = get_post_meta(get_the_id(), 'estab_fields')[0]; ?>
    <div class="container py-5">
        <div class="row">
            <h1 ><?php echo esc_html(get_the_title()); ?></h1>

            <div class="col-12 d-flex justify-content-between align-items-end py-2">
                <a class="icon-link d-inline-flex text-decoration-none text-dark" href="#">
                    <span class="material-symbols-outlined me-2">map</span>
                    <?php echo esc_html($estab_address['address'].', '.$estab_address['address'].' - '.$estab_address['state'].' '.$estab_address['state'].' '.$estab_address['cep']); ?>
                </a>

                <div class="top-single-btns">
                    <button class="d-inline-flex border-0 btn btn-brand" href="#">
                        <span class="material-symbols-outlined">share</span>
                        Compartilhar
                    </button>

                    <button class="d-inline-flex border-0 btn btn-brand" href="#">
                        <span class="material-symbols-outlined">favorite</span>
                        Salvar
                    </button>
                </div>

            </div>

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
            <button id="viewAllImages" class="btn d-inline-flex border-0 align-items-center justify-content-center">
                <span class="material-symbols-outlined">keyboard_double_arrow_down</span>
                Mostrar todas
            </button>
            <button id="closeAllImages" class=" d-none btn d-inline-flex border-0 align-items-center justify-content-center">
                <span class="material-symbols-outlined">keyboard_double_arrow_up</span>
                Ocultar imagens
            </button>
        </div>
    </div>
    <div class="container-fluid bg-light bg-gradient">
        <div class="container py-4">
            <h3 class="text-center">O que esse lugar oferece</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4  row-cols-xl-5 py-2">
                <?php
                $tax_add = get_the_terms(get_the_ID(), 'partner_add');
                $tax_partner = get_the_terms(get_the_ID(), 'partner_type');
                $tax_mixed = array_merge($tax_add, $tax_partner);

                foreach ($tax_mixed as $add): ?>
                    <div class="col d-inline-flex p-2">
                        <?php $theIcon = get_term_meta($add->term_id, 'icon');
                        if(isset($theIcon[0]) && !empty($theIcon[0])): ?>
                            <span class="material-symbols-outlined me-2"><?php echo esc_html($theIcon[0]); ?></span>
                        <?php endif; ?>
                        <?php echo esc_html(ucwords($add->name)); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container py-2">
        <div class="row justify-content-md-center py-5">
            <div class="col-6">
                <?php echo $estab_fields['description']; ?>
            </div>
            <div class="col-4 ps-md-4">
                <div class="card checkout border-secondary mb-3 shadow sticky-top">
                    <div class="card-header">Reserva</div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">Secondary card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
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