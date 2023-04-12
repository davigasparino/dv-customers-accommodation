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
?>
<div class="col-12 mb-3 <?php echo esc_attr($customer_address['class']); ?>">
    <div class="card p-0">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_country" class="form-label">País</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_country"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_country"
                            value="<?php echo esc_attr($country); ?>"
                            aria-label="Páis"
                            maxlength="40"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_state" class="form-label">Estado</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_state"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_state"
                            aria-label="Estado"
                            value="<?php echo esc_attr($state); ?>"
                            maxlength="40"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_city" class="form-label">Cidade</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_city"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_city"
                            aria-label="Cidade"
                            value="<?php echo esc_attr($city); ?>"
                            maxlength="40"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_address" class="form-label">Endereço</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_address"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_address"
                            aria-label="Endereço"
                            value="<?php echo esc_attr($street); ?>"
                            maxlength="70"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_address_number" class="form-label">N°</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_address_number"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_address_number"
                            aria-label="número"
                            value="<?php echo esc_attr($address_number); ?>"
                            maxlength="8"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_neighborhood" class="form-label">Bairro</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="address_<?php echo esc_attr($customer_address['code']); ?>_neighborhood"
                            id="address_<?php echo esc_attr($customer_address['code']); ?>_neighborhood"
                            aria-label="Bairro"
                            value="<?php echo esc_attr($neighborhood); ?>"
                            maxlength="70"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="address_<?php echo esc_attr($customer_address['code']); ?>_cep" class="form-label">CEP</label>
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
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
        </div>
        <div class="card-footer text-body-secondary d-flex justify-content-end">
            <button class="btn btn-outline-dark removeAddress p-0 d-flex justify-content-center align-items-center border-0" type="button">
                <span class="material-symbols-outlined p-2">delete</span>
            </button>
        </div>
    </div>
</div>