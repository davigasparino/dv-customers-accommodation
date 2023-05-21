<?php
    $userFields = get_query_var('userFields');
    $current_user = wp_get_current_user();
    $userEmail = (isset($userFields, $userFields['userfields'], $userFields['userfields']['email'])) ? $userFields['userfields']['email'] : '';
    $lastname = (isset($userFields, $userFields['userfields'], $userFields['userfields']['lastname'])) ? $userFields['userfields']['lastname'] : '';

    $userMetas = array_shift(get_user_meta($current_user->ID, 'user_fields'));
    $profileImage = !empty($userMetas['profile']) ? wp_get_attachment_image_url($userMetas['profile'], 'large') : CustomerURL . 'assets/public/img/image-default.jpg';;
?>

    <h5 class="card-title">Olá, <?php echo esc_attr($userFields['currentUser']->first_name); ?></h5>
    <figure class="figure position-relative p-50 mb-0 w-100">
        <img src="<?php echo esc_url($profileImage); ?>" class="figure-img img-fluid m-0 image-profile" id="profileUserImage" alt="..." <?php if(!empty($userMetas['profile'])): ?> data-bs-toggle="modal" data-bs-target="#viewImageMd" <?php endif; ?> >
        <div class="hstack gap-3 position-absolute bottom-0 end-0 ">
            <button type="button" class="btn btn-sm btn-outline-dark orange-500 border-0 p-0 m-0 d-flex" data-bs-toggle="modal" data-bs-target="#updateImageMd">
                <span class="material-symbols-outlined">image_search</span>
            </button>
        </div>
    </figure>
    <div class="modal fade" id="updateImageMd" aria-hidden="true" aria-labelledby="updateImageMdLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateImageMdLabel">Enviar Imagem</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="image-message-status">
                        <div></div>
                    </div>
                    <form id="image-file-form" class="g-3" action="" method="post" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="profileImage" id="profileImage" required>
                            <input type="hidden" id="image_user_id" name="image_user_id" value="<?php echo esc_attr($current_user->ID); ?>">
                            <label class="input-group-text pt-0 pb-0 m-0" for="profileImage">
                                <button class="btn btn-small p-0 m-0 border-0" type="submit" id="updateUserImage">
                                    <span class="material-symbols-outlined">cloud_upload</span>
                                </button>
                            </label>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="viewImageMd" aria-hidden="true" aria-labelledby="viewImageMdLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewImageMdLabel">Imagem do perfil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img id="viewImageProfile" src="<?php echo esc_url((!empty($userMetas['profile'])) ? wp_get_attachment_image_url($userMetas['profile'], 'full') : ''); ?>" class="img-fluid" alt="...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 p-0 m-0" data-bs-toggle="modal" data-bs-target="#updateImageMd">
                        <span class="material-symbols-outlined">image_search</span>
                    </button>
                </div>

            </div>
        </div>
    </div>