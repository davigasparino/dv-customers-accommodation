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

utils.on(document, 'click', '.establishments-cards .favorite-btn', function(event){
    favoriteItem(event);
});

utils.on(document, 'click', '.btn-minus, .btn-plus', function(e){
    let input = e.target.parentNode.parentNode.querySelector('input');

    if(!input.value){
        input.value = 0;
    }

    if(e.target.closest('.btn-minus') && input.value > 0){
        input.value = input.value - 1;
    }else if(!e.target.closest('.btn-minus')){
        input.value = parseInt(input.value) + 1;
    }
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
        nounce: CustomUser_js.nounce,
        url: CustomUser_js.CustomUser_ajax,
        userLogin: userLogin,
        userPass: userPass
    };

    params = utils.objectScriptsToUrlParams(params);

    fetch(CustomUser_js.url + '?' + params)
        .then(response => {
            if(response.ok) {
                console.log('response.ok => ', response.ok);
                return response.json();
            }
        })
        .then(json => {
            let MessageContainer = document.querySelector('.login-message-status div');
            if(MessageContainer){
                utils.feedbackMessage(MessageContainer, json);
            }
            console.log('json.url 1 => ', json.url);
            if(json.status && json.status === 'ok'){
                window.location.href = json.url;
                console.log('json.url 2 => ', json.url);
            }
        })
        .finally(() => {
            btnLoader.classList.add("d-none");
            isScriptsLoading = false;
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

    fetch(CustomUser_js.url + '?' + params)
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

const favoriteItem = (event) =>{

    let ItemID = event.target.parentNode.dataset.id;

    if(!ItemID)
        return false;

    if(isScriptsLoading)
        return false;

    isScriptsLoading = true;

    if(event.target.classList.value === 'material-symbols-outlined'){
        event.target.classList.add('material-symbols-rounded');
        event.target.classList.remove('material-symbols-outlined');
    }else{
        event.target.classList.remove('material-symbols-rounded');
        event.target.classList.add('material-symbols-outlined');
    }

    let params = {
        action: 'FavoriteItem',
        id: ItemID
    };

    params = utils.objectScriptsToUrlParams(params);

    console.log("CustomUser_js => ", CustomUser_js.url);

    fetch( CustomUser_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .catch( () => {

        })
        .finally( () => {
            isScriptsLoading = false;
        });
}

import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe/dist/photoswipe-lightbox.esm.js';

const lightbox = new PhotoSwipeLightbox({
    gallery: '#establishmentsGallery',
    children: 'a',
    pswpModule: () => import('https://unpkg.com/photoswipe'),
});

lightbox.init();

utils.on(document, 'click', '#viewAllImages', function(event){
    event.target.classList.add('d-none');
    document.getElementById('closeAllImages').classList.remove('d-none');
    document.querySelector('.last-images').classList.add('active');
});

utils.on(document, 'click', '#closeAllImages', function(event){
    event.target.classList.add('d-none');
    document.getElementById('viewAllImages').classList.remove('d-none');
    document.querySelector('.last-images').classList.remove('active');
});