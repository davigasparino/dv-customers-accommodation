import { Utils } from './modules/utils.js';
const utils = new Utils();

let isLoading = false;

utils.on(document, 'submit', '#stablishmentdata', function(event) {
    event.preventDefault();
    let isValid  = utils.checkFormIsValid(event.target, event);
    updateDataEstablisment(isValid, event.target);
});

utils.on(document, 'change', '#establishmentImage', function(event){
    getImgData();
});

utils.on(document, 'click', '.images-container ul li button', function(event){
    let TheItem = event.target.parentNode.parentNode;
    deleteImage(TheItem.dataset.position, TheItem.dataset.id, TheItem);
});

var count_image = 0;

const getImgData = () => {
    var formdata = new FormData();
    let theImage = document.getElementById('establishmentImage');
    recursiveExecRequest(theImage.files, formdata)
}

function recursiveExecRequest(theImageFiles, formdata){
    let loadingContainer = document.querySelector('.images-loader');
    loadingContainer.classList.remove('d-none');
    loadingContainer.classList.add('d-flex');

    formdata.append('establishmentImages', theImageFiles[count_image]);
    formdata.append("action", "uploadImages");
    formdata.append("postID", document.getElementById('postID').value);
    formdata.append("nounce", Establisment_js.nounce);
    formdata.append("url", Establisment_js.Establisment_ajax);

    let statusMessage = document.querySelector('.status-bar-items .status-message');
    statusMessage.innerText = (count_image+1) +'/'+theImageFiles.length;

    let uploadMessage = document.querySelector('.status-bar-items .upload-messages');
    uploadMessage.innerText = 'Iniciando upload da imagem '+(count_image+1);

    var request = new XMLHttpRequest();
    if (theImageFiles) {
         request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                count_image++;
                if (count_image < theImageFiles.length) {
                    setTimeout(function () {
                        recursiveExecRequest(theImageFiles, formdata);
                    },1000);
                }else{
                    setTimeout(function () {
                        loadingContainer.classList.add('d-none');
                        loadingContainer.classList.remove('d-flex');
                        uploadMessage.innerText = 'Finalizado.';
                        count_image = 0;
                    },4000);
                }

                if(this.response){
                    let imgContainer = document.querySelector('.images-container ul');
                    let imgLI = document.createElement('li');
                    let imgURL = JSON.parse(this.response).image_url;
                    let img = document.createElement('img');
                    let imgLiButton = document.createElement('button');
                    let imgButtonSpan = document.createElement('span');
                    imgButtonSpan.classList.add('material-symbols-outlined');
                    imgButtonSpan.innerText = 'cancel';
                    imgLiButton.appendChild(imgButtonSpan);
                    imgLI.appendChild(imgLiButton);
                    imgLI.classList.add('list-group');
                    imgLI.dataset.position = document.querySelectorAll('.images-container ul li').length;
                    imgLI.dataset.id = JSON.parse(this.response).image_id;
                    img.classList.add('gallery-img', 'img-thumbnail','thumbnail','m-2');
                    img.src = imgURL;
                    imgLI.appendChild(img);
                    imgContainer.appendChild(imgLI);
                    let modalPictures = document.querySelector('#pictureImages div.modal-body.pt-0');
                    modalPictures.scrollTo(0, modalPictures.scrollHeight);
                    slist(document.querySelector(".images-container"));
                }
            }
        };

        let progressBar = document.getElementById('progress-bar-images');
        progressBar.style.width = '0';
        progressBar.innerText = 0 + '%';

        request.upload.addEventListener('progress', function (e) {
            var file1Size = theImageFiles[count_image].size;

            if (e.loaded <= file1Size) {
                uploadMessage.innerText = 'Upload da imagem '+(count_image+1)+' em andamento.';

                var percent = Math.round(e.loaded / file1Size * 100);
                progressBar.style.width = percent + '%';
                progressBar.innerText = percent + '%';
            }

            if (e.loaded == e.total) {
                uploadMessage.innerText = 'Finalizando upload imagem '+(count_image+1)+', por favor aguarde mais um pouco.';
                progressBar.style.width = '100%';
                progressBar.innerText = 100 + '%';
            }
        });

        request.open('post', '/stablishment-ajax');
        request.timeout = 945000;
        request.send(formdata);
    }
}

const editor1 = new RichTextEditor("#inp_editor1");

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

    let getFormData = new FormData(formstablishmentdata);

    let countPhones = document.querySelectorAll('.formPhones');
    if(countPhones){
        getFormData.append( "countPhones", countPhones.length);
    }

    let countAddress = document.querySelectorAll('.formAddress');
    if(countAddress){
        getFormData.append( "countAddress", countAddress.length);
    }

    getFormData.append( "action", "updateEstablisment");
    getFormData.append( "nounce", Establisment_js.nounce);
    getFormData.append( "url", Establisment_js.Establisment_ajax);

    getFormData.append( "coust", document.getElementById('coust').value);
    getFormData.append( "email", document.getElementById('email').value);
    getFormData.append( "description", document.getElementById('inp_editor1').value);

    const ctrl = new AbortController()    // timeout
    setTimeout(() => ctrl.abort(), 5000);

    fetch(Establisment_js.url,
        {method: "POST", body: getFormData, signal: ctrl.signal})
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

const savePosition = () => {
    let loadingContainer = document.querySelector('.images-loader');
    loadingContainer.classList.remove('d-none');
    loadingContainer.classList.add('d-flex');
    let allPositions = [];
    let getPositions = document.querySelectorAll('.images-container ul li');
    getPositions.forEach(element => {
        allPositions.push([parseInt(element.dataset.position), parseInt(element.dataset.id)]);
    });

    let getFormData = new FormData();
    getFormData.append( "action", "reorderImages");
    getFormData.append( "nounce", Establisment_js.nounce);
    getFormData.append( "url", Establisment_js.Establisment_ajax);
    getFormData.append("postID", document.getElementById('postID').value);
    getFormData.append("positions", JSON.stringify(allPositions));

    const ctrl = new AbortController()    // timeout
    setTimeout(() => ctrl.abort(), 5000);

    fetch(Establisment_js.url,
        {method: "POST", body: getFormData, signal: ctrl.signal})
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
            reindexPositions();
            loadingContainer.classList.add('d-none');
            loadingContainer.classList.remove('d-flex');
        });
}

const reindexPositions = () => {
    let getPositions = document.querySelectorAll('.images-container ul li');
    let i = 0;
    getPositions.forEach(element => {
        element.dataset.position = i;
        i++;
    });
}

reindexPositions();

const deleteImage = (imagePosition, imageId, item) => {
    let loadingContainer = document.querySelector('.images-loader');
    loadingContainer.classList.remove('d-none');
    loadingContainer.classList.add('d-flex');

    let params = {
        action: 'deleteImage',
        nounce: Establisment_js.nounce,
        postID: document.getElementById('postID').value,
        imgPosition: imagePosition,
        imageId: imageId
    };

    params = utils.objectScriptsToUrlParams(params);

    item.remove();
    fetch(Establisment_js.url + '?' + params)
        .then(function (response) {
            return response.text();
        })
        .then(response => {
            if(response.ok) return response.json();
        })
        .catch(function () {

        })
        .finally(() => {
            loadingContainer.classList.add('d-none');
            loadingContainer.classList.remove('d-flex');
            reindexPositions();
        });
}

const slist = (target) => {
        // (A) SET CSS + GET ALL LIST ITEMS
    target.classList.add("slist");
    let items = target.getElementsByTagName("li"), current = null;
    // (B) MAKE ITEMS DRAGGABLE + SORTABLE
    for (let i of items) {
        // (B1) ATTACH DRAGGABLE
        i.draggable = true;

        // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
        i.ondragstart = e => {
            current = i;
            for (let it of items) {
                if (it != current) { it.classList.add("hint"); }
            }
        };

        // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
        i.ondragenter = e => {
            if (i != current) { i.classList.add("active"); }
        };

        // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
        i.ondragleave = () => i.classList.remove("active");

        // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
        i.ondragend = () => { for (let it of items) {
            it.classList.remove("hint");
            it.classList.remove("active");
        }};

        // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
        i.ondragover = e => e.preventDefault();

        // (B7) ON DROP - DO SOMETHING
        i.ondrop = e => {
            e.preventDefault();
            if (i != current) {
                let currentpos = 0, droppedpos = 0;
                for (let it=0; it<items.length; it++) {
                    if (current == items[it]) { currentpos = it; }
                    if (i == items[it]) { droppedpos = it; }
                }
                if (currentpos < droppedpos) {
                    i.parentNode.insertBefore(current, i.nextSibling);
                } else {
                    i.parentNode.insertBefore(current, i);
                }
                savePosition();
            }
        };
    }
}

slist(document.querySelector(".images-container"));

