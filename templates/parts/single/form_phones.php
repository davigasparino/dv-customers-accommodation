<?php
    $customer_phones = get_query_var('customer_phones');
    $phones = isset($customer_phones['values']) ? $customer_phones['values'] : array();
    $ddi = $phones['ddi'] ?? '';
    $ddd = $phones['ddd'] ?? '';
    $number = $phones['number'] ?? '';
    $itemRequire = ($customer_phones['code'] !== 'XXX') ? 'required' : '';
    $itemRequireClass = ($customer_phones['code'] === 'XXX') ? 'required' : '';
?>
<div class="col-md-6 <?php echo esc_attr($customer_phones['class']) ?> mb-3">
    <div class="card p-0">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">DDI</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                            name="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="DDI"
                            maxlength="3"
                            value="<?php echo esc_attr($ddi); ?>"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">DDD</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                            name="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="DDD"
                            maxlength="3"
                            value="<?php echo esc_attr($ddd); ?>"
                            <?php echo esc_attr($itemRequire); ?>
                        >
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">Número</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control <?php echo esc_attr($itemRequireClass); ?>"
                            name="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="Número"
                            maxlength="11"
                            value="<?php echo esc_attr($number); ?>"
                            <?php echo esc_attr($itemRequire); ?>
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