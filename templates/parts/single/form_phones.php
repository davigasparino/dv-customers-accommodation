<?php
    $customer_phones = get_query_var('customer_phones');
    $phones = isset($customer_phones['values']) ? $customer_phones['values'] : array();
    $ddi = $phones['ddi'] ?? '';
    $ddd = $phones['ddd'] ?? '';
    $number = $phones['number'] ?? '';
?>
<div class="col-md-6 <?php echo esc_attr($customer_phones['class']) ?> mb-3">
    <div class="card p-0">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">DDI</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_ddi_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="DDI"
                            value="<?php echo esc_attr($ddi); ?>"
                            required
                        >
                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">DDD</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_ddd_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="DDD"
                            value="<?php echo esc_attr($ddd); ?>"
                            required
                        >
                    </div>
                </div>

                <div class="col-md-8 mb-3">
                    <label for="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>" class="form-label">Número</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>"
                            id="user_phones_number_<?php echo esc_attr($customer_phones['code']) ?>"
                            aria-label="Número"
                            value="<?php echo esc_attr($number); ?>"
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