import { Utils } from './modules/utils.js';
const utils = new Utils();

let isScriptsLoading = false;


utils.on(document, 'submit', '#loginUsers', function(event) {
    event.preventDefault();
    let isValid  = utils.checkFormIsValid(event.target, event);
    loginSend(isValid);
});

utils.on(document, 'click', '#userLogout', function(event) {
    userLogout();
});

const loginSend = (isValid) => {

    if(!isValid){
        return false;
    }

    if(isScriptsLoading){
        return false;
    }

    let btnLoader = document.querySelector('#loginSend span');
    btnLoader.classList.remove('d-none');

    isScriptsLoading = true;

    let userLogin = document.getElementById('usermail');
    if(userLogin){
        userLogin = userLogin.value;
    }

    let userPass = document.getElementById('userpass');
    if(userPass){
        userPass = userPass.value;
    }

    let params = {
        action: 'loginUser',
        nounce: Customer_js.nounce,
        url: Customer_js.Customer_ajax,
        userLogin: userLogin,
        userPass: userPass
    };

    params = utils.objectScriptsToUrlParams(params);

    fetch(Customer_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .then(json => {
            let MessageContainer = document.querySelector('.login-message-status div');
            if(MessageContainer){
                utils.feedbackMessage(MessageContainer, json);
            }

            if(json.status && json.status === 'ok'){
                window.location.href = json.url;
            }
        })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            isScriptsLoading = false;
        })
        .catch( () => {
            isScriptsLoading = false;
        })
        .finally(() => {
            btnLoader.classList.add("d-none");
        });
}

const userLogout = () => {
    if(isScriptsLoading){
        return false;
    }

    isScriptsLoading = true;

    let params = {
        action: 'userLogout',
    };

    params = utils.objectScriptsToUrlParams(params);

    fetch(Customer_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .then(json => {
            let MessageContainer = document.querySelector('.login-message-status div');
            if(MessageContainer){
                utils.feedbackMessage(MessageContainer, json);
            }
        })
        .catch( () => {
        })
        .finally(() => {
            window.location.href = '/';
        });
}