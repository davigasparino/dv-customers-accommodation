<?php get_header(); ?>
    <div class="container pt-5">
        <div class="row">
            <h2 class="display-6">Dados pessoais</h2>
            <div class="col-md-2 col-12">
                <div class="card">
                    <div class="card-body p-2">

                            <img src="" id="profileUserImage" class="img-thumbnail card-img-top" alt="...">

                        <h5 class="card-title"></h5>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-10 col-12">
                <form id="userContainer" class="row g-3 needs-validation" novalidate>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <label for="user_name" class="form-label">Nome</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="user_name" id="user_name" aria-label="Nome" value="" required>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <label for="user_lastname" class="form-label">Sobrenome</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="user_lastname" id="user_lastname" aria-label="Sobrenome" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <label for="user_email" class="form-label">E-mail</label>
                            <div class="input-group">
                                <input type="email" class="form-control" name="user_email" id="user_email" aria-label="E-mail" value="" required>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <label for="user_pass" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="user_pass" id="user_pass" aria-label="Password" value="" required>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <label for="confirm_user_pass" class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_user_pass" id="confirm_user_pass" aria-label="Confirm Password" value="" required>
                            </div>
                        </div>
                    </div>

                    <h2 class="display-6">Endereço</h2>

                    <div class="row rowAddress p-0 m-0">
                        <div class="col-12 mb-3 protoAddress d-none">
                            <div class="card p-0">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="address_XXX_country" class="form-label">País</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_country"
                                                        id="address_XXX_country"
                                                        aria-label="Páis"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="address_XXX_state" class="form-label">Estado</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_state"
                                                        id="address_XXX_state"
                                                        aria-label="Estado"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="address_XXX_city" class="form-label">Cidade</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_city"
                                                        id="address_XXX_city"
                                                        aria-label="Cidade"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="address_XXX_address" class="form-label">Endereço</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_address"
                                                        id="address_XXX_address"
                                                        aria-label="Endereço"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="address_XXX_address_number" class="form-label">N°</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_address_number"
                                                        id="address_XXX_address_number"
                                                        aria-label="número"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="address_XXX_neighborhood" class="form-label">Bairro</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="address_XXX_neighborhood"
                                                        id="address_XXX_neighborhood"
                                                        aria-label="Bairro"
                                                        required
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="address_XXX_cep" class="form-label">CEP</label>
                                            <div class="input-group mb-3">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="CEP"
                                                        aria-label="CEP"
                                                        aria-describedby="getCEP"
                                                        name="address_XXX_cep"
                                                        id="address_XXX_cep"
                                                >
                                                <button class="btn btn-outline-dark p-0 d-flex justify-content-center align-items-center" type="button" id="getCEP_XXX">
                                                    <span class="material-symbols-outlined ps-2 pe-2">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-body-secondary d-flex justify-content-end">
                                    <button class="btn btn-outline-dark removeAddress p-0 d-flex justify-content-center align-items-center border-0" type="button">
                                        <span class="material-symbols-outlined p-2">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-outline-secondary cloneAddress w-50 p-0 d-flex justify-content-center align-items-center border-0" type="button">
                            <span class="material-symbols-outlined p-2">add_circle</span>
                        </button>
                    </div>

                    <h2 class="display-6">Telefone</h2>
                    <div class="row p-0 rowPhones m-0">
                        <div class="col-md-6 protoPhones d-none mb-3">
                            <div class="card p-0">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label for="user_phones_ddi_XXX" class="form-label">DDI</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="user_phones_ddi_XXX"
                                                        id="user_phones_ddi_XXX"
                                                        aria-label="DDI"
                                                        required
                                                >
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="user_phones_ddd_XXX" class="form-label">DDD</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="user_phones_ddd_XXX"
                                                        id="user_phones_ddd_XXX"
                                                        aria-label="DDD"
                                                        required
                                                >
                                            </div>
                                        </div>

                                        <div class="col-md-8 mb-3">
                                            <label for="user_phones_number_XXX" class="form-label">Número</label>
                                            <div class="input-group">
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        name="user_phones_number_XXX"
                                                        id="user_phones_number_XXX"
                                                        aria-label="Número"
                                                        required
                                                >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-body-secondary d-flex justify-content-end">
                                    <button class="btn btn-outline-dark removePhones p-0 d-flex justify-content-center align-items-center border-0" type="button">
                                        <span class="material-symbols-outlined p-2">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-outline-secondary clonePhones w-50 p-0 d-flex justify-content-center align-items-center border-0" type="button">
                            <span class="material-symbols-outlined p-2">add_circle</span>
                        </button>
                    </div>

                    <input type="hidden" name="userid" id="userid" value="">
                    <div class="col-12">
                        <button class="btn btn-outline-dark" type="button" id="updateUser">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" aria-hidden="true" aria-labelledby="staticBackdropLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Alterar Imagem</h1>
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

<?php get_footer();