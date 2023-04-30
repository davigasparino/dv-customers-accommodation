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
            <div class="modal-body">
                <div class="container">
                    <div class="row status-bar-items">
                        <div class="display-1 status-message text-center"></div>
                        <p class="upload-messages mt-4 text-center mb-0"></p>
                        <div class="progress-wrapper progress p-0">
                            <div class="progress progress-bar progress-bar-striped progress-bar-animated bg-dark" id="progress-bar-images" ></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex flex-wrap images-container">
                            <?php if($IDPost): ?>
                            <?php $getAllImages = array_shift(get_post_meta($IDPost, 'estab_img'));
                            if($getAllImages):
                            foreach ($getAllImages as $theImg): ?>
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($theImg['img'], 'medium')); ?>" class="gallery-img img-thumbnail thumbnail m-2">
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <form id="establishmentPictures" class="row g-3 mt-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="establishmentImages[]" id="establishmentImage" required multiple>
                    </div>
                    <input type="hidden" id="postID" value="<?php echo esc_attr($IDPost); ?>">
                    <div class="col-12">
                        <button type="button" id="debugImages">Start</button>
                        <ul id="uploadImagesView"></ul>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

