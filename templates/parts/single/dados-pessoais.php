<?php
    $userFields = get_query_var('userFields');
    $name = $userFields['currentUser']->first_name ?? null;
    $last_name = $userFields['currentUser']->last_name ?? null;
    $user_email = $userFields['currentUser']->user_email ?? null;
    $cpf = (isset($userFields, $userFields['userfields'], $userFields['userfields']['cpf'])) ? $userFields['userfields']['cpf'] : '';
    $rg = (isset($userFields, $userFields['userfields'], $userFields['userfields']['rg'])) ? $userFields['userfields']['rg'] : '';

    $param = (!empty(get_query_var('panel'))) ? get_query_var('panel') : 'dashboard';
?>

<form id="userContainer" class="needs-validation" novalidate>
    <section class="container-fluid bg-light p-5">
        <div class="container">
            <?php (new class { use CustomersUtils; })::getTitle('customer', $param); ?>
            <div class="row">
                <?php include(CustomerPATH . '/templates/parts/message_form.php');?>
                <div class="col-12 col-md-6 py-3 pe-md-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">Nome</span>
                        <input type="text" class="form-control" name="user_name" id="user_name" maxlength="70" aria-label="Nome" value="<?php echo esc_attr($name); ?>" required>
                    </div>
                </div>
                <div class="col-12 col-md-6 py-3 ps-md-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">Sobrenome</span>
                        <input type="text" class="form-control" name="user_lastname" id="user_lastname" maxlength="70" aria-label="Sobrenome" value="<?php echo esc_attr($last_name); ?>" required>
                    </div>
                </div>
                <div class="col-12 col-md-6 py-3 pe-md-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">CPF</span>
                        <input type="text" class="form-control" name="user_cpf" id="user_cpf" maxlength="70" aria-label="CPF" value="<?php echo esc_attr($cpf); ?>" required>
                    </div>
                </div>
                <div class="col-12 col-md-6 py-3 ps-md-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">RG</span>
                        <input type="text" class="form-control" name="user_rg" id="user_rg" maxlength="70" aria-label="RG" value="<?php echo esc_attr($rg); ?>" required>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="container-fluid p-5">
        <div class="container">
            <h3 class="mb-3 mt-5"><span class="material-symbols-outlined">lock</span> Login </h3>
            <div class="row">
                <div class="col-12 col-md-6 py-3 pe-md-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">E-mail</span>
                        <input type="email" class="form-control" name="user_email" id="user_email" aria-label="E-mail" maxlength="70" value="<?php echo esc_attr($user_email); ?>" required>
                    </div>
                </div>
                <?php if(!$userFields): ?>
                    <div class="col-12 col-md-6 ps-md-4">
                        <div class="input-group input-group-lg py-3">
                            <span class="input-group-text">Senha</span>
                            <input type="password" class="form-control" name="user_pass" id="user_pass" aria-label="Password" value="" required>
                        </div>

                        <div class="input-group input-group-lg py-3">
                            <span class="input-group-text">Confirmar</span>
                            <input type="password" class="form-control" name="confirm_user_pass" id="confirm_user_pass" aria-label="Confirm Password" value="" required>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="container-fluid bg-light p-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">signpost</span> Endereço</h3>
            <div class="row rowAddress p-0 m-0">
                <?php
                set_query_var('customer_address', array(
                    'class' => 'protoAddress d-none',
                    'code' => 'XXX'
                ));
                include(CustomerPATH . '/templates/parts/single/form_address.php');

                if(isset($userFields, $userFields['currentUser']->ID)){
                    $userAddress = get_user_meta($userFields['currentUser']->ID, 'user_address')[0];
                    if(isset($userAddress) && is_array($userAddress)){
                        foreach ($userAddress as $key => $address){
                            set_query_var('customer_address', array(
                                'class' => 'formAddress',
                                'code' => $key,
                                'values' => $address
                            ));
                            include(CustomerPATH . '/templates/parts/single/form_address.php');
                        }
                    }
                }
                ?>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-outline-dark cloneAddress d-flex justify-content-center align-items-center border-0" type="button">
                    <span class="material-symbols-outlined ">add_circle</span>
                    Adicionar
                </button>
            </div>
        </div>
    </section>
    <section class="container-fluid p-5">
        <div class="container">
            <h3 class="mb-3 mt-3"><span class="material-symbols-outlined me-2">mobile_friendly</span> Telefone</h3>
            <div class="row p-0 rowPhones m-0">
                <?php
                set_query_var('customer_phones', array(
                    'class' => 'protoPhones d-none',
                    'code' => 'XXX',
                ));
                include(CustomerPATH . '/templates/parts/single/form_phones.php');

                if(isset($userFields, $userFields['currentUser']->ID)) {
                    $userPhones = get_user_meta($userFields['currentUser']->ID, 'user_phones')[0];
                    if (isset($userPhones) && is_array($userPhones)) {
                        foreach ($userPhones as $key => $phone) {
                            set_query_var('customer_phones', array(
                                'class' => 'formPhones',
                                'code' => $key,
                                'values' => $phone
                            ));
                            include(CustomerPATH . '/templates/parts/single/form_phones.php');
                        }
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
    <div class="container p-5 text-end">
        <?php $userID = $userFields['currentUser']->ID ?? ''; ?>
        <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($userID); ?>">

        <div class="col-12">
            <button class="btn btn-outline-dark btn-lg" type="submit" id="updateUser">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Enviar
            </button>
        </div>
    </div>
</form>