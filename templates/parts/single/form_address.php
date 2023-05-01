<?php
    $customer_address = get_query_var('customer_address');
    $address = isset($customer_address['values']) ? $customer_address['values'] : array();
    $country = $address['country'] ?? '';
    $state = $address['state'] ?? '';
    $city = $address['city'] ?? '';
    $street = $address['address'] ?? '';
    $address_number = $address['address_number'] ?? '';
    $neighborhood = $address['neighborhood'] ?? '';
    $cep = $address['cep'] ?? '';
    $itemRequire = ($customer_address['code'] !== 'XXX') ? 'required' : '';
    $itemRequireClass = ($customer_address['code'] === 'XXX') ? 'required' : '';
?>
<div class="col-12 p-0 <?php echo esc_attr($customer_address['class']); ?>">
    <div class="card border-top-0 rounded-0 border-start-0 border-end-0 p-0 bg-transparent mb-5">
        <div class="card-body border-0 px-0 text-end">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Pais</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_country"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_country"
                                value="<?php echo esc_attr($country); ?>"
                                aria-label="Páis"
                                maxlength="40"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Estado</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_state"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_state"
                                aria-label="Estado"
                                value="<?php echo esc_attr($state); ?>"
                                maxlength="40"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Cidade</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_city"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_city"
                                aria-label="Cidade"
                                value="<?php echo esc_attr($city); ?>"
                                maxlength="3"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Bairro</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_neighborhood"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_neighborhood"
                                aria-label="Bairro"
                                value="<?php echo esc_attr($neighborhood); ?>"
                                maxlength="70"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Endereço</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_address"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_address"
                                aria-label="Endereço"
                                value="<?php echo esc_attr($street); ?>"
                                maxlength="70"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">N°</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_address_number"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_address_number"
                                aria-label="número"
                                value="<?php echo esc_attr($address_number); ?>"
                                maxlength="8"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">CEP</span>
                        <input
                                type="text"
                                class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                                placeholder="CEP"
                                aria-label="CEP"
                                value="<?php echo esc_attr($cep); ?>"
                                aria-describedby="getCEP"
                                name="address_<?php echo esc_attr($customer_address['code']); ?>_cep"
                                maxlength="10"
                                id="address_<?php echo esc_attr($customer_address['code']); ?>_cep"
                        >
                        <button class="btn btn-outline-dark p-0 d-flex justify-content-center align-items-center" type="button" id="getCEP_<?php echo esc_attr($customer_address['code']); ?>">
                            <span class="material-symbols-outlined ps-2 pe-2">search</span>
                        </button>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-dark removeAddress p-0 border-0" type="button">
                <span class="material-symbols-outlined p-2">delete</span>
            </button>
        </div>
    </div>
</div>