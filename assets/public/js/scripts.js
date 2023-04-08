window.addEventListener('load', function () {

    /**
     * Object To Url Params
     *
     * @param obj
     * @returns {string}
     */
    var objectToUrlParams = function(obj){
        let params = "";
        for (var key in obj) {
            if (params != "") {
                params += "&";
            }
            params += key + "=" + encodeURIComponent(obj[key]);
        }
        return params;
    };

    let isLoading = false;
    const btnCustomerForm = document.getElementById('loginSend');
    if(btnCustomerForm){
        btnCustomerForm.addEventListener('click', function (){
            loginUser();
        });
    }

    let loginUser = function(){
        if(isLoading){
            return false;
        }

        let btnLoader = document.querySelector('#loginUser span');
        btnLoader.classList.remove('d-none');

        isLoading = true;

        let params = {
            action: 'loginUserDatas',
            nounce: Customer_js.nounce,
            url: Customer_js.Customer_ajax
        };

        let countPhones = document.querySelectorAll('.formPhones');
        if(countPhones){
            params['countPhones'] = countPhones.length;
        }

        let countAddress = document.querySelectorAll('.formAddress');
        if(countAddress){
            params['countAddress'] = countAddress.length;
        }

        let form = document.getElementById('userContainer');
        let getFormData = new FormData(form);
        for (let [key, value] of getFormData) {
            params[key] = value;
        }

        params = objectToUrlParams(params);

        fetch(Customer_js.url + '?' + params)
            .then(function (response) {
                return response.text();
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

});
const on = (element, type, selector, handler) => {
    element.addEventListener(type, (event) => {
        if (event.target.closest(selector)) {
            handler(event);
        }
    });
};