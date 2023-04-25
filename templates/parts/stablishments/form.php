<form id="stablishmentdata" class="row g-3 needs-validation" novalidate>
    <div class="row">
        <div class="col-md-4 mb-4">
            <label for="name" class="form-label">Nome</label>
            <div class="input-group">
                <input type="text" class="form-control" name="name" id="user_name" maxlength="70" aria-label="Nome" value="" required>
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
                        value=""
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
                        value=""
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
                        value=""
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
                        value=""
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
                        value=""
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
                        value=""
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
                        value=""
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
    
    <input type="hidden" name="userid" id="userid" value="<?php echo esc_attr($_SESSION['customer_id']); ?>">

    <div class="col-12">
        <button class="btn btn-outline-dark" type="submit" id="updateEstablisment">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Cadastrar
        </button>
    </div>
</form>