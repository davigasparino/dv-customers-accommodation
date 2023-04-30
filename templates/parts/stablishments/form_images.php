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
                <style>
                    .progress-wrapper {
                        width:100%;
                    }
                    .progress-wrapper .progress {
                        width:0%;
                        padding:5px 0px 5px 0px;
                    }
                </style>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

                <div class="container">
                    <div class="row">
                        <div class="progress-wrapper progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100">
                            <div id="progress-bar-file1" class="progress progress-bar progress-bar-striped progress-bar-animated bg-dark"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex flex-wrap">
                            <?php if($IDPost): ?>
                            <?php $getAllImages = array_shift(get_post_meta($IDPost, 'estab_img'));
                            if($getAllImages):
                            foreach ($getAllImages as $theImg): ?>
<!--                                --><?php //echo wp_get_attachment_image( $theImg['img'], 'your-custom-size' ); ?>
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($theImg['img'], 'medium')); ?>" style="width: 120px; height: 80px; object-fit: cover;" class="img-thumbnail thumbnail m-2">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

