<?php
$userFields = get_query_var('userFields');
$username = (isset($userFields, $userFields['userfields'], $userFields['userfields']['name'])) ? $userFields['userfields']['name'] : '';
$userEmail = (isset($userFields, $userFields['userfields'], $userFields['userfields']['email'])) ? $userFields['userfields']['email'] : '';
$lastname = (isset($userFields, $userFields['userfields'], $userFields['userfields']['lastname'])) ? $userFields['userfields']['lastname'] : '';
?>
<div class="card">
    <div class="card-body p-2">
        <?php $profileImage = (isset($userFields, $userFields['ID'])) ? get_the_post_thumbnail_url($userFields['ID']) : null; ?>
        <?php $profileImage = (isset($profileImage) && !empty($profileImage)) ? $profileImage : CustomerURL . 'assets/public/img/image-default.jpg'; ?>
        <figure class="figure position-relative p-0">
            <img src="<?php echo esc_url($profileImage); ?>" class="figure-img img-fluid rounded m-0 " alt="...">
            <div class="hstack gap-3 position-absolute bottom-0 end-0 ">
                <div class="p-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary border-0 p-0 m-0" data-bs-toggle="modal" data-bs-target="#updateImageMd">
                        <span class="material-symbols-outlined">image_search</span>
                    </button>
                </div>
            </div>
        </figure>


        <h5 class="card-title"><?php echo esc_attr($username); ?></h5>

    </div>
    <div class="card-footer">
        <?php include(CustomerPATH . '/templates/parts/single/form_update_pass.php'); ?>
    </div>
</div>
<div class="modal fade" id="updateImageMd" aria-hidden="true" aria-labelledby="updateImageMdLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateImageMdLabel">Enviar Imagem</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="image-file-form" class="g-3" action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="profileImage" id="profileImage">
                        <label class="input-group-text pt-0 pb-0 m-0" for="profileImage">
                            <button class="btn btn-small p-0 m-0 border-0" type="button" data-bs-dismiss="modal" id="updateUserImage">
                                <span class="material-symbols-outlined">cloud_upload</span>
                            </button>
                        </label>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>