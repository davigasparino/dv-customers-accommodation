import { Utils } from './modules/utils.js';
const utils = new Utils();

let isLoading = false;

utils.on(document, 'submit', '#stablishmentdata', function(event) {
    event.preventDefault();
    let isValid  = utils.checkFormIsValid(event.target, event);
    updateDataEstablisment(isValid, event.target);
});

const updateDataEstablisment = (isValidForm, formstablishmentdata) => {

    if(!isValidForm){
        return false;
    }

    if(isLoading){
        return false;
    }

    let btnLoader = document.querySelector('#updateEstablisment span');
    btnLoader.classList.remove('d-none');

    isLoading = true;

    let params = {
        action: 'updateEstablisment',
        nounce: Establisment_js.nounce,
        url: Establisment_js.Establisment_ajax
    };

    let countPhones = document.querySelectorAll('.formPhones');
    if(countPhones){
        params['countPhones'] = countPhones.length;
    }

    let countAddress = document.querySelectorAll('.formAddress');
    if(countAddress){
        params['countAddress'] = countAddress.length;
    }

    let getFormData = new FormData(formstablishmentdata);
    for (let [key, value] of getFormData) {
        params[key] = value;
    }

    params = utils.objectScriptsToUrlParams(params);

    fetch(Establisment_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .then(json => {
            let MessageContainer = document.querySelector('.form-message-status div');
            if(MessageContainer){
                utils.feedbackMessage(MessageContainer, json);
            }

            if(json.status && json.status === 'ok'){
                window.location.href = json.url;
            }
        })
        .then(function (data) {
            isLoading = false;
        })
        .catch( () => {
            isLoading = false;
        })
        .finally(() => {
            btnLoader.classList.add("d-none");
        });
}