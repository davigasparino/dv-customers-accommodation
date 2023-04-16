let isScriptsLoading = false;

const on = (element, type, selector, handler) => {
    element.addEventListener(type, (event) => {
        if (event.target.closest(selector)) {
            handler(event);
        }
    });
};

on(document, 'submit', '#loginUsers', function(event) {
    event.preventDefault();
    let isValid  = checkFormIsValid(event.target, event);
    loginSend(isValid);
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

    params = objectScriptsToUrlParams(params);

    fetch(Customer_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .then(json => {
            let MessageContainer = document.querySelector('.login-message-status div');
            if(MessageContainer){
                feedbackMessage(MessageContainer, json);
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

on(document, 'click', '#userLogout', function(event) {
    userLogout();
});

const userLogout = () => {
    if(isScriptsLoading){
        return false;
    }

    let btnLoader = document.querySelector('#userLogout span');
    btnLoader.classList.remove('d-none');

    isScriptsLoading = true;

    let btnlogout = document.querySelector('span.btn-icon');
    if(btnlogout){
        btnlogout.classList.add('d-none');
    }

    let params = {
        action: 'userLogout',
    };

    params = objectScriptsToUrlParams(params);

    fetch(Customer_js.url + '?' + params)
        .then(response => {
            if(response.ok) return response.json();
        })
        .then(json => {
            let MessageContainer = document.querySelector('.login-message-status div');
            if(MessageContainer){
                feedbackMessage(MessageContainer, json);
            }
            window.location.href = '/';
        })
        .catch( () => {
        })
        .finally(() => {
            btnLoader.classList.add("d-none");
            if(btnlogout){
                btnlogout.classList.remove('d-none');
            }
        });
}


const objectScriptsToUrlParams = (obj) => {
    let params = "";
    for (var key in obj) {
        if (params != "") {
            params += "&";
        }
        params += key + "=" + encodeURIComponent(obj[key]);
    }
    return params;
};

const feedbackMessage = (container, json) => {
    if(container){
        container.className = "";
        container.innerText = "";
    }

    if(container){
        container.innerText = json.message;
        container.classList.add(json.class.split(',')[0], json.class.split(',')[1]);
    }
}

const checkFormIsValid = (theForm, theEvent) => {
    let isValidForm = false;
    if (!theForm.checkValidity()) {
        theEvent.stopPropagation();
        isValidForm = false;
    }else{
        isValidForm = true;
    }
    theForm.classList.add('was-validated');

    return isValidForm;
}