<?php
    $IDPost = get_query_var('postid') ?? null;

    $stab_fields = (get_post_meta($IDPost, 'estab_fields')) ? array_shift(get_post_meta($IDPost, 'estab_fields')) : null;
    $stab_address = (get_post_meta($IDPost, 'estab_address')) ? array_shift(get_post_meta($IDPost, 'estab_address')) : null;
    $estab_phones = (get_post_meta($IDPost, 'estab_phones')) ? array_shift(get_post_meta($IDPost, 'estab_phones')) : null;

    $title = isset($stab_fields['name']) ? $stab_fields['name'] : '';
    $description = isset($stab_fields['description']) ? $stab_fields['description'] : '';
    $excerpt = isset($stab_fields['excerpt']) ? $stab_fields['excerpt'] : '';
    $coust = isset($stab_fields['coust']) ? $stab_fields['coust'] : '';
    $people_limit = isset($stab_fields['people_limit']) ? $stab_fields['people_limit'] : '';
    $email = isset($stab_fields['email']) ? $stab_fields['email'] : '';
    $country = isset($stab_address['country']) ? $stab_address['country'] : '';
    $state = isset($stab_address['state']) ? $stab_address['state'] : '';
    $city = isset($stab_address['city']) ? $stab_address['city'] : '';
    $address = isset($stab_address['address']) ? $stab_address['address'] : '';
    $map = isset($stab_address['map']) ? $stab_address['map'] : '';
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
        <div class="col-12">
            <div class="input-group input-group-lg py-3">
                <span class="input-group-text">Título</span>
                <input type="text" class="form-control" name="title" id="title" maxlength="70" aria-label="Nome" value="<?php echo esc_html($title); ?>" >
            </div>
        </div>

        <div class="col-md-4 col-12 mb-4">
            <div class="input-group input-group-lg py-3">
                <span class="input-group-text">Diária R$</span>
                <input type="text" class="form-control" name="coust" id="coust" maxlength="70" aria-label="Valor" value="<?php echo esc_html($coust); ?>" >
            </div>
        </div>
        <div class="col-md-4 col-12 mb-4">
            <div class="input-group input-group-lg py-3">
                <span class="input-group-text">Limite de Pessoas</span>
                <input type="number" class="form-control" name="people_limit" id="people_limit" maxlength="4" aria-label="Limite" value="<?php echo esc_html($people_limit); ?>" >
            </div>
        </div>



        <div class="col-12 mb-4">
            <div class="input-group">
                <span class="input-group-text input-group-lg">Resumo para o anúncio</span>
                <input type="text" class="form-control" maxlength="60" name="excerpt" id="excerpt" value="<?php echo esc_html($excerpt); ?>">
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="input-group">
                <span class="input-group-text input-group-lg rounded-top-2 rounded-bottom-0">Descrição</span>
                <textarea id="inp_editor1" name="inp_editor1" >
                 <?php echo $description; ?>
                </textarea>
            </div>
        </div>

    </div>

    <section class="container-fluid bg-light mt-3">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">signpost</span> Endereço</h3>
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Pais</span>
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
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">UF</span>
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
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">CEP</span>
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
                        <button class="btn btn-outline-dark p-0 d-flex justify-content-center align-items-center" type="button" id="getCEP_<?php echo esc_attr($cep); ?>">
                            <span class="material-symbols-outlined ps-2 pe-2">search</span>
                        </button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Endereço</span>
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
                <div class="col-sm-12 col-md-3 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">N°</span>
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
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Cidade</span>
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
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Bairro</span>
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

                <div class="col-sm-12 col-md-4 mb-4">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">E-mail</span>
                        <input type="email" class="form-control" name="email" id="email" aria-label="E-mail" maxlength="70" value="<?php echo esc_attr($email); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    if(!empty($address)): ?>
    <section class="container-fluid py-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">map</span> Mapa</h3>
            <div class="row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="address__map" name="address__map" <?php echo esc_attr(($map) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="address__map">
                        Exibir mapa do estabelecimento?
                    </label>
                </div>
                <?php
                    $zoom = 5000;

                    $addressComplete = $address.' '.$address_number.' '.$neighborhood.' '.$city.' '.$state.' '.$country;

                    echo  '<p>'.$addressComplete.'</p>';
                    $lng = 'br';

                    $src = 'https://www.google.com/maps/embed?pb='.
                    '!1m18'.
                        '!1m12'.
                            '!1m3'.
                                '!1d'.$zoom.
                                '!2d0'.
                                '!3d0'.
                            '!2m3'.
                                '!1f0'.
                                '!2f0'.
                                '!3f0'.
                            '!3m2'.
                                '!1i1024'.
                                '!2i768'.
                            '!4f13.1'.
                            '!3m3'.
                                '!1m2'.
                                '!1s0'.
                                '!2s'.rawurlencode($addressComplete).
                            '!5e0'.
                            '!3m2'.
                                '!1s'.$lng.
                                '!2s'.$lng.
                            '!4v'.time().'000'.
                            '!5m2'.
                                '!1s'.$lng.
                                '!2s'.$lng;

                    ?>
                    <iframe src="<?php echo esc_attr($src); ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section class="container-fluid py-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">house</span> Categoria</h3>
            <div class="row p-0 m-0">
                <div class="col-12 p-0">
                    <?php
                    $tax_add = get_terms(array(
                        'taxonomy'   => 'partner_type',
                        'hide_empty' => false,
                    ));

                    $theTerms = !empty(get_the_terms($IDPost, 'partner_type')) ? get_the_terms($IDPost, 'partner_type') : array();

                    foreach ($tax_add as $add): ?>
                        <input
                                type="checkbox"
                                class="btn-check"
                            <?php echo (array_search($add, $theTerms) !== false) ? 'checked' : ''; ?>
                                id="tax_type_<?php echo esc_attr($add->term_id); ?>"
                                name="tax_type_<?php echo esc_attr($add->term_id); ?>"
                                value="<?php echo esc_attr($add->term_id); ?>" autocomplete="off">
                        <label class="btn btn-outline-dark mb-2 me-2 btn-sm d-inline-flex" for="tax_type_<?php echo esc_attr($add->term_id); ?>">
                            <?php $theIcon = get_term_meta($add->term_id, 'icon');
                            if(isset($theIcon[0]) && !empty($theIcon[0])): ?>
                                <span class="material-symbols-outlined me-2"><?php echo esc_html($theIcon[0]); ?></span>
                            <?php endif; ?>
                            <?php echo esc_html(ucwords($add->name)); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid py-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">mobile_friendly</span> Adicionais</h3>
            <div class="row p-0 m-0">
                <div class="col-12 p-0">
                <?php
                $tax_add = get_terms(array(
                    'taxonomy'   => 'partner_add',
                    'hide_empty' => false,
                ));

                $theTerms = !empty(get_the_terms($IDPost, 'partner_add')) ? get_the_terms($IDPost, 'partner_add') : array();

                foreach ($tax_add as $add): ?>
                    <input
                        type="checkbox"
                        class="btn-check"
                        <?php echo (array_search($add, $theTerms) !== false) ? 'checked' : ''; ?>
                        id="tax_partner_<?php echo esc_attr($add->term_id); ?>"
                        name="tax_partner_<?php echo esc_attr($add->term_id); ?>"
                        value="<?php echo esc_attr($add->term_id); ?>" autocomplete="off">
                    <label class="btn btn-outline-dark mb-2 me-2 btn-sm d-inline-flex" for="tax_partner_<?php echo esc_attr($add->term_id); ?>">
                        <?php $theIcon = get_term_meta($add->term_id, 'icon');
                        if(isset($theIcon[0]) && !empty($theIcon[0])): ?>
                            <span class="material-symbols-outlined me-2"><?php echo esc_html($theIcon[0]); ?></span>
                        <?php endif; ?>
                        <?php echo esc_html(ucwords($add->name)); ?>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid py-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">mobile_friendly</span> Telefone</h3>
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
                <button class="btn btn-outline-dark clonePhones d-flex justify-content-center align-items-center border-0" type="button">
                    <span class="material-symbols-outlined ">add_circle</span>
                    Adicionar
                </button>
            </div>
        </div>
    </section>

    <?php
        $current_user = wp_get_current_user();
        $theUser = $current_user->ID;
    ?>
    <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($theUser); ?>">
    <input type="hidden" name="urlreturn" id="urlreturn" value="<?php echo esc_attr(get_permalink().get_query_var('panel').'/'.get_query_var('partner').'/'); ?>">

    <div class="col-12 text-end">
        <button class="btn btn-outline-dark btn-lg" type="submit" id="updateEstablisment">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Cadastrar
        </button>
    </div>
</form>