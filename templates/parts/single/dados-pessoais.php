<?php
    $userFields = get_query_var('userFields');
    $username = (isset($userFields, $userFields['userfields'], $userFields['userfields']['name'])) ? $userFields['userfields']['name'] : '';
    $userEmail = (isset($userFields, $userFields['userfields'], $userFields['userfields']['email'])) ? $userFields['userfields']['email'] : '';
    $lastname = (isset($userFields, $userFields['userfields'], $userFields['userfields']['lastname'])) ? $userFields['userfields']['lastname'] : '';

    $param = (!empty(get_query_var('panel'))) ? get_query_var('panel') : 'dashboard';

    (new class { use CustomersUtils; })::getTitle('customer', $param);
    include(CustomerPATH . '/templates/parts/message_form.php');
?>

<form id="userContainer" class="row g-3 needs-validation" novalidate>
    <div class="col-md-4 mb-4">
        <label for="user_name" class="form-label">Nome</label>
        <div class="input-group">
            <input type="text" class="form-control" name="user_name" id="user_name" maxlength="70" aria-label="Nome" value="<?php echo esc_attr($username); ?>" required>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <label for="user_lastname" class="form-label">Sobrenome</label>
        <div class="input-group">
            <input type="text" class="form-control" name="user_lastname" id="user_lastname" maxlength="70" aria-label="Sobrenome" value="<?php echo esc_attr($lastname); ?>" required>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <label for="user_email" class="form-label">E-mail</label>
        <div class="input-group">
            <input type="email" class="form-control" name="user_email" id="user_email" aria-label="E-mail" maxlength="70" value="<?php echo esc_attr($userEmail); ?>" required>
        </div>
    </div>
    <?php if(!$userFields): ?>
    <div class="col-md-4 mb-4">
        <div class="input-group mb-3">
            <label for="user_pass" class="form-label">Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" name="user_pass" id="user_pass" aria-label="Password" value="" required>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="input-group mb-3">
            <label for="confirm_user_pass" class="form-label">Confirmar Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" name="confirm_user_pass" id="confirm_user_pass" aria-label="Confirm Password" value="" required>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <h3 class="mb-3"><span class="material-symbols-outlined me-2">signpost</span> Endereço</h3>
        <div class="row rowAddress p-0 m-0">
            <?php
            set_query_var('customer_address', array(
                'class' => 'protoAddress d-none',
                'code' => 'XXX'
            ));
            include(CustomerPATH . '/templates/parts/single/form_address.php');

            if(isset($userFields, $userFields['ID'])){
                $userAddress = get_post_meta($userFields['ID'], 'user_address')[0];
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
            <button class="btn btn-outline-dark cloneAddress w-50 p-0 d-flex justify-content-center align-items-center border-0" type="button">
                <span class="material-symbols-outlined p-2">add_circle</span>
            </button>
        </div>

    <h3 class="mb-3"><span class="material-symbols-outlined me-2">mobile_friendly</span> Telefone</h3>


        <div class="row p-0 rowPhones m-0">
            <?php
            set_query_var('customer_phones', array(
                'class' => 'protoPhones d-none',
                'code' => 'XXX',
            ));
            include(CustomerPATH . '/templates/parts/single/form_phones.php');

            if(isset($userFields, $userFields['ID'])) {
                $userPhones = get_post_meta($userFields['ID'], 'user_phones')[0];
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
            <button class="btn btn-outline-dark clonePhones w-50 p-0 d-flex justify-content-center align-items-center border-0" type="button">
                <span class="material-symbols-outlined p-2">add_circle</span>
            </button>
        </div>

    <?php $userID = (isset($userFields, $userFields['ID'])) ? $userFields['ID'] : ''; ?>
    <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($userID); ?>">

    <div class="col-12">
        <button class="btn btn-outline-dark" type="submit" id="updateUser">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Enviar
        </button>
    </div>
</form>