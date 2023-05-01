<?php
    $customer_phones = get_query_var('customer_phones');
    $phones = isset($customer_phones['values']) ? $customer_phones['values'] : array();
    $ddi = $phones['ddi'] ?? '';
    $ddd = $phones['ddd'] ?? '';
    $number = $phones['number'] ?? '';
    $itemRequire = ($customer_phones['code'] !== 'XXX') ? 'required' : '';
    $itemRequireClass = ($customer_phones['code'] === 'XXX') ? 'required' : '';
?>
<div class="col-12 <?php echo esc_attr($customer_phones['class']) ?> mb-3">
    <div class="card border-top-0 rounded-0 border-start-0 border-end-0 p-0 bg-transparent mb-5">
        <div class="card-body border-0 px-0 text-end">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">DDI</span>
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
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">DDD</span>
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
                    <div class="input-group input-group-lg py-3">
                        <span class="input-group-text">Número</span>
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

            <button class="btn btn-outline-dark removePhones p-0 border-0" type="button">
                <span class="material-symbols-outlined p-2">delete</span>
            </button>
        </div>
    </div>
</div>