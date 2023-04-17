    let isLoading = false;

    on(document, 'click', '.removeAddress', function(event) {
        event.target.parentNode.parentNode.parentNode.parentNode.remove();
    });

    on(document, 'click', '.removePhones', function(event) {
        event.target.parentNode.parentNode.parentNode.parentNode.remove();
    });

    on(document, 'click', '.clonePhones', function() {
        DuplicateItems('protoPhones', 'formPhones', '.rowPhones');
    });

    on(document, 'click', '.cloneAddress', function() {
        DuplicateItems('protoAddress','formAddress', '.rowAddress');
    });

    on(document, 'submit', '#image-file-form', function(event) {
        event.preventDefault();
        let isValid  = checkFormIsValid(event.target, event);
        SavePhoto(isValid);
    });

    on(document, 'submit', '#update-pass-form', function(event) {
        event.preventDefault();
        let isValid  = checkFormIsValid(event.target, event);
        updatePassUser(isValid);
    });

    on(document, 'submit', '#userContainer', function(event) {
        event.preventDefault();
        let isValid  = checkFormIsValid(event.target, event);
        updateDataUser(isValid, event.target);
    });

    const removeItems = (item) => {
        item.addEventListener("click",function(){
            this.parentNode.parentNode.parentNode.remove();
        });
    }

    const SavePhoto = (isValidForm) => {

        if(!isValidForm){
            return false;
        }

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
            fetch(Customer_js.url,
                {method: "POST", body: formData, signal: ctrl.signal})
                .then((response) => {
                    return response.json().then((data) => {
                        let MessageContainer = document.querySelector('.image-message-status div');
                        if(MessageContainer){
                            feedbackMessage(MessageContainer, data);
                        }

                        let profileUserImage = document.getElementById('profileUserImage');
                        if(profileUserImage){
                            profileUserImage.src = data.image;
                        }

                        let viewImageProfile = document.getElementById('viewImageProfile');
                        if(viewImageProfile){
                            viewImageProfile.src = data.image;
                        }

                        let nav_image_profile = document.querySelector('.nav-image-profile');
                        if(nav_image_profile){
                            nav_image_profile.src = data.image;
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

    const updatePassUser = (isValidForm) => {
        if(!isValidForm){
            return false;
        }

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

        params = objectScriptsToUrlParams(params);

        fetch(Customer_js.url + '?' + params)
            .then(response => {
                if(response.ok) return response.json();
            })
            .then(json => {
                let MessageContainer = document.querySelector('.uppass-message-status div');
                if(MessageContainer){
                    feedbackMessage(MessageContainer, json);
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


    const updateDataUser = (isValidForm, formUserContainer) => {

        if(!isValidForm){
            return false;
        }

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

        let getFormData = new FormData(formUserContainer);
        for (let [key, value] of getFormData) {
            params[key] = value;
        }

        params = objectScriptsToUrlParams(params);

        fetch(Customer_js.url + '?' + params)
            .then(response => {
                if(response.ok) return response.json();
            })
            .then(json => {
                let MessageContainer = document.querySelector('.form-message-status div');
                if(MessageContainer){
                    feedbackMessage(MessageContainer, json);
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

    const DuplicateItems = (proto, item, itemRow) => {
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
                if(allInputClones[i].querySelector('input').classList.contains('required')){
                    allInputClones[i].querySelector('input').required = true;
                }
                console.log('tem a classe', allInputClones[i].querySelector('input').classList.contains('required'));
            }
        }
    }
