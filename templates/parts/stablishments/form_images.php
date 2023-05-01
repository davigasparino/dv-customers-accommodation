<?php $IDPost = get_query_var('postid') ?? null; ?>

<div class="container">
    <div class="row">
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#pictureImages">
            <span class="material-symbols-outlined">add_photo_alternate</span>
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pictureImages" tabindex="-1" aria-labelledby="pictureImagesLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="pictureImagesLabel">Fotos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="container">
                    <div class="row status-bar-items sticky-top bg-white pb-2 ">
                        <div class="display-1 status-message text-center"></div>
                        <p class="upload-messages mt-4 text-center mb-0"></p>
                        <div class="progress-wrapper progress p-0">
                            <div class="progress progress-bar progress-bar-striped progress-bar-animated bg-dark" id="progress-bar-images" ></div>
                        </div>
                    </div>
                    <div class="row mt-3 position-relative">
                        <div class="images-loader d-none bg-white justify-content-center align-items-center position-absolute w-100 h-100 bg-opacity-75 z-3">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap images-container">
                            <?php if($IDPost): ?>
                            <?php $getAllImages = array_shift(get_post_meta($IDPost, 'estab_img'));
                            if($getAllImages):?>
                            <ul class="d-flex flex-wrap p-0 m-0">
                            <?php foreach ($getAllImages as $imgKey => $theImg): ?>
                                <li class="list-group" data-position="<?php echo esc_attr($imgKey); ?>" data-id="<?php echo esc_attr($theImg['img']); ?>">
                                    <button><span class="material-symbols-outlined">cancel</span></button>
                                    <img src="<?php echo esc_url(wp_get_attachment_image_url($theImg['img'], 'medium')); ?>" class="gallery-img img-thumbnail thumbnail m-2">
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 position-relative  z-1">
                            <form id="establishmentPictures" class="row g-3 mt-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="establishmentImages[]" id="establishmentImage" required multiple>
                                </div>
                                <input type="hidden" id="postID" value="<?php echo esc_attr($IDPost); ?>">
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

