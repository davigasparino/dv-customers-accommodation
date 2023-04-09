window.addEventListener('load', function () {

    /**
     * Object To Url Params
     *
     * @param obj
     * @returns {string}
     */
    var objectScriptsToUrlParams = function(obj){
        let params = "";
        for (var key in obj) {
            if (params != "") {
                params += "&";
            }
            params += key + "=" + encodeURIComponent(obj[key]);
        }
        return params;
    };

    let isScriptsLoading = false;
    const btnCustomerForm = document.getElementById('loginSend');
    if(btnCustomerForm){
        btnCustomerForm.addEventListener('click', function (){
            loginSend();
        });
    }

    const btnLogout = document.getElementById('userLogout');
    if(btnLogout){
        btnLogout.addEventListener('click', function (){
            userLogout();
        });
    }

    let userLogout = function(){
        if(isScriptsLoading){
            return false;
        }

        let btnLoader = document.querySelector('#userLogout span');
        btnLoader.classList.remove('d-none');

        isScriptsLoading = true;

        let params = {
            action: 'userLogout',
        };

        params = objectScriptsToUrlParams(params);

        fetch(Customer_js.url + '?' + params)
            .then(response => {
                if(response.ok) return response.json();
            })
            .then(json => {
                console.log(json.message);
                window.location.href = '/';
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

    let loginSend = function(){
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
            console.log(json.message);
                window.location.href = json.url;
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

});