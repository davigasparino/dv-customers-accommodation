<?php
    $IDPost = get_query_var('postid') ?? null;

    $stab_fields = (get_post_meta($IDPost, 'estab_fields')) ? array_shift(get_post_meta($IDPost, 'estab_fields')) : null;
    $stab_address = (get_post_meta($IDPost, 'estab_address')) ? array_shift(get_post_meta($IDPost, 'estab_address')) : null;
    $estab_phones = (get_post_meta($IDPost, 'estab_phones')) ? array_shift(get_post_meta($IDPost, 'estab_phones')) : null;

    $title = isset($stab_fields['name']) ? $stab_fields['name'] : '';
    $description = isset($stab_fields['description']) ? $stab_fields['description'] : '';
    $coust = isset($stab_fields['coust']) ? $stab_fields['coust'] : '';
    $email = isset($stab_fields['email']) ? $stab_fields['email'] : '';
    $country = isset($stab_address['country']) ? $stab_address['country'] : '';
    $state = isset($stab_address['state']) ? $stab_address['state'] : '';
    $city = isset($stab_address['city']) ? $stab_address['city'] : '';
    $address = isset($stab_address['address']) ? $stab_address['address'] : '';
    $address_number = isset($stab_address['address_number']) ? $stab_address['address_number'] : '';
    $neighborhood = isset($stab_address['neighborhood']) ? $stab_address['neighborhood'] : '';
    $cep = isset($stab_address['cep']) ? $stab_address['cep'] : '';

    if($IDPost){
        include(CustomerPATH . '/templates/parts/stablishments/form_images.php');
    }
    include(CustomerPATH . '/templates/parts/message_form.php');
?>
<form id="stablishmentdata" class="row g-3 mt-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
    <div class="row">
        <div class="col-md-4 mb-4">
            <label for="title" class="form-label">Título</label>
            <div class="input-group">
                <input type="text" class="form-control" name="title" id="title" maxlength="70" aria-label="Nome" value="<?php echo esc_html($title); ?>" >
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <label for="coust" class="form-label">Valor da Diária</label>
            <div class="input-group">
                <span class="input-group-text">R$</span>
                <input type="text" class="form-control" name="coust" id="coust" maxlength="70" aria-label="Valor" value="<?php echo esc_html($coust); ?>" >
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <label for="email" class="form-label">E-mail</label>
            <div class="input-group">
                <input type="email" class="form-control" name="email" id="email" aria-label="E-mail" maxlength="70" value="<?php echo esc_attr($email); ?>">
            </div>
        </div>


        <div class="col-12 mb-4">
            <label for="description" class="form-label">Descrição</label>
            <div class="input-group">
                <textarea id="inp_editor1" name="inp_editor1" >
                 <?php echo $description; ?>
                </textarea>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="address__country" class="form-label">País</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__country"
                        id="address__country"
                        value="<?php echo esc_html($country); ?>"
                        aria-label="Páis"
                        maxlength="40"

                >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="address__state" class="form-label">Estado</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__state"
                        id="address__state"
                        aria-label="Estado"
                        value="<?php echo esc_html($state); ?>"
                        maxlength="40"

                >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="address__city" class="form-label">Cidade</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__city"
                        id="address__city"
                        aria-label="Cidade"
                        value="<?php echo esc_html($city); ?>"
                        maxlength="40"

                >
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="address__address" class="form-label">Endereço</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__address"
                        id="address__address"
                        aria-label="Endereço"
                        value="<?php echo esc_html($address); ?>"
                        maxlength="70"

                >
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <label for="address__address_number" class="form-label">N°</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__address_number"
                        id="address__address_number"
                        aria-label="número"
                        value="<?php echo esc_html($address_number); ?>"
                        maxlength="8"

                >
            </div>
        </div>
        <div class="col-md-5 mb-4">
            <label for="address__neighborhood" class="form-label">Bairro</label>
            <div class="input-group">
                <input
                        type="text"
                        class="form-control "
                        name="address__neighborhood"
                        id="address__neighborhood"
                        aria-label="Bairro"
                        value="<?php echo esc_html($neighborhood); ?>"
                        maxlength="70"

                >
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="address__cep" class="form-label">CEP</label>
            <div class="input-group mb-3">
                <input
                        type="text"
                        class="form-control "
                        placeholder="CEP"
                        aria-label="CEP"
                        value="<?php echo esc_html($cep); ?>"
                        aria-describedby="getCEP"
                        name="address__cep"
                        maxlength="10"
                        id="address__cep"
                >
                <button class="btn btn-outline-dark p-0 d-flex justify-content-center align-items-center" type="button" id="getCEP_">
                    <span class="material-symbols-outlined ps-2 pe-2">search</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row p-0 rowPhones m-0">
        <?php
        set_query_var('establishment_phones', array(
            'class' => 'protoPhones d-none',
            'code' => 'XXX',
        ));
        include(CustomerPATH . '/templates/parts/stablishments/form_phones.php');

        if (isset($estab_phones) && is_array($estab_phones)) {
            foreach ($estab_phones as $key => $phone) {
                set_query_var('establishment_phones', array(
                    'class' => 'formPhones',
                    'code' => $key,
                    'values' => $phone
                ));
                include(CustomerPATH . '/templates/parts/stablishments/form_phones.php');
            }
        }
        ?>

    </div>
    <div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-outline-dark clonePhones w-50 p-0 d-flex justify-content-center align-items-center border-0" type="button">
            <span class="material-symbols-outlined p-2">add_circle</span>
        </button>
    </div>
    
    <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($_SESSION['customer_id']); ?>">
    <input type="hidden" name="urlreturn" id="urlreturn" value="<?php echo esc_attr(get_permalink().get_query_var('panel').'/'.get_query_var('partner').'/'); ?>">

    <div class="col-12">
        <button class="btn btn-outline-dark" type="submit" id="updateEstablisment">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Cadastrar
        </button>
    </div>
</form>