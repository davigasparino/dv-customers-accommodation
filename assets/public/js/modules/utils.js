class Utils {
    constructor() {

    }

    on (element, type, selector, handler) {
        element.addEventListener(type, (event) => {
            if (event.target.closest(selector)) {
                handler(event);
            }
        });
    }

    objectScriptsToUrlParams(obj){
        let params = "";
        for (var key in obj) {
            if (params != "") {
                params += "&";
            }
            params += key + "=" + encodeURIComponent(obj[key]);
        }
        return params;
    }

    feedbackMessage(container, json){
        if(container){
            container.className = "";
            container.innerText = "";
        }

        if(container){
            container.innerText = json.message;
            container.classList.add(json.class.split(',')[0], json.class.split(',')[1]);
        }
    }

    checkFormIsValid(theForm, theEvent){
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
}



export { Utils };