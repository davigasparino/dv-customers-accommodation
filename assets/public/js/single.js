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
    
    const btnCustomerForm = document.getElementById('updateUser');
    if(btnCustomerForm){
        btnCustomerForm.addEventListener('click', function (){
            updateDataUser();
        });
    }

    let MessageContainer = document.querySelector('.form-message-status div');

    let updateDataUser = function(){
        if(isLoading){
            return false;
        }

        let btnLoader = document.querySelector('#updateUser span');
        btnLoader.classList.remove('d-none');

        isLoading = true;

        let params = {
            action: 'UpdateUserDatas',
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

        if(MessageContainer){
            MessageContainer.className = "";
            MessageContainer.innerText = "";
        }

        fetch(Customer_js.url + '?' + params)
            .then(response => {
                if(response.ok) return response.json();
            })
            .then(json => {
                if(MessageContainer){
                    MessageContainer.innerText = json.message;
                    MessageContainer.classList.add(json.class.split(',')[0], json.class.split(',')[1]);
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

    let getAllAddressCards = document.querySelectorAll(".removeAddress");

    function removeItems(item){
        item.addEventListener("click",function(){
            this.parentNode.parentNode.parentNode.remove();
        });
    }

    if(getAllAddressCards){
        getAllAddressCards.forEach(removeItems);
    }

    let getAllNumbersCards = document.querySelectorAll(".removePhones");
    if(getAllNumbersCards){
        getAllNumbersCards.forEach(removeItems);
    }

    function DuplicateItems(proto, item, itemRow) {
        let getItem = document.querySelectorAll('.'+item);
        if(getItem){
            let countItems = getItem.length;

            const originItem = document.querySelector('.'+proto);
            const cloneItem = originItem.cloneNode(true);
            cloneItem.classList.add(item);
            cloneItem.classList.remove(proto);
            cloneItem.classList.remove('d-none');
            document.querySelector(itemRow).appendChild(cloneItem);

            let allInputClones = cloneItem.querySelectorAll('.input-group');
            for(var i = 0; i < allInputClones.length; i++){
                let name = allInputClones[i].querySelector('input').name;
                allInputClones[i].querySelector('input').name = name.replace(/XXX/g, countItems);
                allInputClones[i].querySelector('input').id = name.replace(/XXX/g, countItems);
            }
        }
    }

    let clonePhones = document.querySelector('.clonePhones');
    if(clonePhones){
        clonePhones.addEventListener('click', function(){
            DuplicateItems('protoPhones', 'formPhones', '.rowPhones');
        });
    }
    
    let cloneAdress = document.querySelector('.cloneAddress');
    if(cloneAdress){
        cloneAdress.addEventListener('click', function(){
            DuplicateItems('protoAddress','formAddress', '.rowAddress');
        });
    }

    on(document, 'click', '.removeAddress', function(event) {
        event.target.parentNode.parentNode.parentNode.parentNode.remove();
    });

    on(document, 'click', '.removePhones', function(event) {
        event.target.parentNode.parentNode.parentNode.parentNode.remove();
    });

    on(document, 'click', '#updateUserImage', function(inp) {
        SavePhoto();
    });

    async function SavePhoto()
    {
        letMyForm = document.getElementById('image-file-form');
        let formData = new FormData();
        let photo = document.getElementById('profileImage').files[0];
        let postID = document.getElementById('userid').value;

        formData.append("action", 'UploadProfileImage');
        formData.append("postID", postID);
        formData.append("photo", photo);
        formData.append("nounce", Customer_js.nounce);


        const ctrl = new AbortController()    // timeout
        setTimeout(() => ctrl.abort(), 5000);

        try {
            await fetch(Customer_js.url,
                {method: "POST", body: formData, signal: ctrl.signal})
                .then((response) => {
                    return response.json().then((data) => {
                        console.log(data);
                        let profileUserImage = document.getElementById('profileUserImage');
                        if(profileUserImage){
                            profileUserImage.src = data.image;
                        }
                        return data;
                    }).catch((err) => {
                        console.log(err);
                    })
                });
        }catch(e){
            console.log('Huston we have problem...:', e);
        }

    }

    const btnUpPass = document.getElementById('updatePass');
    if(btnUpPass){
        btnUpPass.addEventListener('click', function (){
            updatePassUser();
        });
    }

    let updatePassUser = function(){
        if(isLoading){
            return false;
        }

        let btnLoader = document.querySelector('#updatePass span');
        btnLoader.classList.remove('d-none');

        isLoading = true;

        let params = {
            action: 'updatePass',
            nounce: Customer_js.nounce,
            url: Customer_js.Customer_ajax
        };

        let oldPassword = document.getElementById('oldPassword');
        if(oldPassword){
            params['oldPassword'] = oldPassword.value;
        }

        let newPassword = document.getElementById('newPassword');
        if(oldPassword){
            params['newPassword'] = newPassword.value;
        }

        let confirmNewPassword = document.getElementById('confirmNewPassword');
        if(oldPassword){
            params['confirmNewPassword'] = confirmNewPassword.value;
        }

        let userPassword = document.getElementById('userid');
        if(oldPassword){
            params['userPassword'] = userPassword.value;
        }

        params = objectToUrlParams(params);

        fetch(Customer_js.url + '?' + params)
            .then(response => {
                if(response.ok) return response.json();
            })
            .then(json => {
                console.log(json.message);
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

});
const on = (element, type, selector, handler) => {
    element.addEventListener(type, (event) => {
        if (event.target.closest(selector)) {
            handler(event);
        }
    });
};
// (() => {
//     'use strict'
//
//     // Fetch all the forms we want to apply custom Bootstrap validation styles to
//     const forms = document.querySelectorAll('.needs-validation')
//
//     // Loop over them and prevent submission
//     Array.from(forms).forEach(form => {
//         form.addEventListener('submit', event => {
//             if (!form.checkValidity()) {
//                 event.preventDefault()
//                 event.stopPropagation()
//             }
//
//             form.classList.add('was-validated')
//         }, false)
//     })
// })()