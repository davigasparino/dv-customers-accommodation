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
//
// utils.on(document, 'click', '#debugImages', function(event){
//     getImgDataDebug();
// });
//
// utils.on(document, 'click', '.delete-image', function(event){
//     event.target.parentElement.parentElement.remove();
//     deleteImgArrItem(parseInt(event.target.parentElement.dataset.id));
// });
//
//
// const deleteImgArrItem = (item) => {
//     console.log('ITEM => ', item);
//     AllImages.splice(item, 1);
//     //clearIndexList();
// }
//
// const clearIndexList = () => {
//     let imageOrderList = document.querySelectorAll('#uploadImagesView li');
//     for(let i=0; i<imageOrderList.length; i++){
//         imageOrderList[i].dataset.key = i;
//         document.querySelectorAll('#uploadImagesView li button')[i].dataset.id = i;
//     }
// }
//
// const imgPreview = document.getElementById("uploadImagesView");
//
// var AllImages = [];
//
// const getImgDataDebug = () => {
    // let chooseFile = document.getElementById("establishmentImage");
    // const files = chooseFile.files;
    //
    // console.log('File => ', chooseFile.files.length);
    // if (files) {
    //     for(var i=0; i<chooseFile.files.length; i++){
    //         let fileReader = new FileReader();
    //         fileReader.readAsDataURL(files[i]);
    //         fileReader.addEventListener("load", function () {
    //             imgPreview.style.display = "block";
    //             console.log('result => ', this.result);
    //         });
    //     }
    //
    // }

    //clearIndexList();
    // console.log('DEBUG => ', AllImages);
    //console.log('DEBUG => ', typeof AllImages);
    // console.log('DEBUG => ', AllImages.length);
// }
//
var count_image = 0;
// const ImagesPreviewArr = [];
//
const getImgData = (callback) => {
    var formdata = new FormData();
    let theImage = document.getElementById('establishmentImage');
    recursiveExecRequest(theImage.files, formdata)
}

function recursiveExecRequest(theImageFiles, formdata){
    formdata.append('establishmentImages', theImageFiles[count_image]);
    formdata.append("action", "uploadImages");
    formdata.append("postID", document.getElementById('postID').value);
    formdata.append("nounce", Establisment_js.nounce);
    formdata.append("url", Establisment_js.Establisment_ajax);

    console.log('count_image => ', count_image);
    var request = new XMLHttpRequest();
    if (theImageFiles) {
         request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log('on ready change => ', this.responseText);
                console.log('Status COntador => ',count_image + ' - ' + theImageFiles.length);

                count_image++;
                if (count_image < theImageFiles.length) {
                    console.log('Aguarde, em 4 segundo será chamada a função novamente');
                    setTimeout(function () {
                        recursiveExecRequest(theImageFiles, formdata);
                    },2000);
                }else{
                    setTimeout(function () {
                        console.log('Contador zerado');
                        count_image = 0;
                    },6000);
                }
            }
        };

        request.upload.addEventListener('progress', function (e) {
            var file1Size = theImageFiles[count_image].size;

            if (e.loaded <= file1Size) {
                var percent = Math.round(e.loaded / file1Size * 100);
                $('#progress-bar-file1').width(percent + '%').html(percent + '%');
            }

            if (e.loaded == e.total) {
                $('#progress-bar-file1').width(100 + '%').html(100 + '%');
            }
        });

        request.open('post', '/stablishment-ajax');
        //request.open('post', Establisment_js.Establisment_ajax);
        request.timeout = 945000;
        request.send(formdata);
    }
}


    // let chooseFile = document.getElementById("establishmentImage");
    // const files = chooseFile.files;
    // if (files) {
    //     // let theForm = document.getElementById('establishmentPictures');
    //     // console.log('theForm', theForm);
    //     //
    //     let getFormData = new FormData(theForm);
    //     getFormData.append( "action", "uploadImages");
    //     getFormData.append( "nounce", Establisment_js.nounce);
    //     getFormData.append( "url", Establisment_js.Establisment_ajax);
    //
    //     let ctrl = new AbortController()    // timeout
    //     setTimeout(() => ctrl.abort(), 5000);
    //
    //     fetch(Establisment_js.url,
    //         {method: "POST", body: getFormData, signal: ctrl.signal})
    //         .then(response => {
    //             if(response.ok) return response.json();
    //         })
    //         .then(json => {
    //             let MessageContainer = document.querySelector('.form-message-status div');
    //             if(MessageContainer){
    //                 utils.feedbackMessage(MessageContainer, json);
    //             }
    //
    //             if(json.status && json.status === 'ok'){
    //                 window.location.href = json.url;
    //             }
    //         })
    //         .then(function (data) {
    //             isLoading = false;
    //         })
    //         .catch( () => {
    //             isLoading = false;
    //         })
    //         .finally(() => {
    //             btnLoader.classList.add("d-none");
    //         });
        //
        //
        //
        // for(let i=0; i<chooseFile.files.length; i++){
        //     let fileReader = new FileReader();
        //     fileReader.readAsDataURL(files[i]);
        //     fileReader.addEventListener("load", function () {
        //         //ImagesPreviewArr[count_image] = this.result;
        //         // imgPreview.style.display = "flex";
        //         // imgPreview.insertAdjacentHTML("beforeend", '<li data-key="'+count_image+'">'+count_image+' : <img class="img-thumbnail" src="' + this.result + '" /><button class="btn btn-outline-danger border-0 delete-image" data-id="'+count_image+'"><span class="material-symbols-outlined">delete</span></button></li>');
        //         // count_image++;
        //         console.log('this -> ', this.result);
        //     });
        // }
    //}




const mountPreviewImages = (files, total) => {
    for(let i=0; i<total; i++){
        let fileReader = new FileReader();
        fileReader.readAsDataURL(files[i]);
        fileReader.addEventListener("load", function () {
            ImagesPreviewArr[count_image] = this.result;
            // imgPreview.style.display = "flex";
            // imgPreview.insertAdjacentHTML("beforeend", '<li data-key="'+count_image+'">'+count_image+' : <img class="img-thumbnail" src="' + this.result + '" /><button class="btn btn-outline-danger border-0 delete-image" data-id="'+count_image+'"><span class="material-symbols-outlined">delete</span></button></li>');
            // count_image++;
        });
    }
    return getImagesPreview(total);
}

const getImagesPreview = async (total) => {

    console.log('get images PREVIEW => ', ImagesPreviewArr);
    console.log('get images PREVIEW => ', typeof ImagesPreviewArr);
    console.log('get images PREVIEW => ', ImagesPreviewArr[0]);

    for (let i=0; i < total; i++){

        imgPreview.style.display = "flex";
        imgPreview.insertAdjacentHTML("beforeend", '<li data-key="'+i+'">'+i+' : <img class="img-thumbnail" src="' + ImagesPreviewArr[i] + '" /><button class="btn btn-outline-danger border-0 delete-image" data-id="'+i+'"><span class="material-symbols-outlined">delete</span></button></li>');
    }
    slist(document.getElementById("uploadImagesView"));
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



    //let imageOrderList = document.querySelectorAll('#uploadImagesView li');

    // let TheFiles = AllImages;
    // console.log('quantidade de imagens => ', TheFiles.length);
    // if (TheFiles) {
    //     for(var i=0; i < TheFiles.length; i++){
    //         if(imageOrderList[i] && imageOrderList[i].dataset && imageOrderList[i].dataset.key){
    //             console.log('sync AllImages => ', AllImages[imageOrderList[i].dataset.key]);
    //             getFormData.append("Images_"+i, AllImages[imageOrderList[i].dataset.key]);
    //         }
    //     }
    // }
    //
    // getFormData.append("TotalImages", AllImages.length);

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

const slist = async (target) => {
        // (A) SET CSS + GET ALL LIST ITEMS
    target.classList.add("slist");
    let items = target.getElementsByTagName("li"), current = null;
    console.log('TARGET ===> ', items);
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
            }
        };
    }
}