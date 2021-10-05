//---IMPORT---//


//---VARIABLE---//
const IMG_INPUT = document.querySelector("#product_image");
const IMG_PREVIEW = document.querySelector(".form_image");
const DEL_BTN = document.createElement("div");
const IMG_CHANGE_INPUT = document.querySelector("#product_image_change");

const FILES_TYPES = [
    'image/jpeg',
    'image/png'
]

//---FUNCTION---//
function validFileType(file) {
    for(var i = 0; i < FILES_TYPES.length; i++) {
        if(file.type === FILES_TYPES[i]) {
            return true;
        }
    }

    return false;
}
function createTextEl(text){
    const textEL = document.createElement("p");
    textEL.innerText = text;

    return textEL;
}

function setImgBg(){
    if(IMG_INPUT.files.length > 0){
        if(validFileType(IMG_INPUT.files[0])){
            IMG_CHANGE_INPUT.value = true;

            IMG_PREVIEW.style.setProperty('--img-url', `url('${window.URL.createObjectURL(IMG_INPUT.files[0])}')`);
            DEL_BTN.style.display = "block";

            const texts = IMG_PREVIEW.querySelectorAll("p");
            texts.forEach((text) => {
                text.remove();
            });
        }else{
            IMG_PREVIEW.appendChild(createTextEl("Format invalide"));
        }
    }else{
        IMG_PREVIEW.appendChild(createTextEl("Aucune image"));
    }
}

//---EVENT---//
IMG_INPUT.addEventListener("change", setImgBg);

DEL_BTN.addEventListener("click", (e) => {
    e.preventDefault();

    IMG_CHANGE_INPUT.value = true;
    IMG_INPUT.value = "";

    IMG_PREVIEW.style.setProperty('--img-url', '');
    IMG_PREVIEW.appendChild(createTextEl("Aucune image"));
    DEL_BTN.style.display = "none";
});

//---MAIN---//
DEL_BTN.classList.add("form_image_del");
IMG_PREVIEW.appendChild(DEL_BTN);

if(!IMG_PREVIEW.style.getPropertyValue('--img-url')){
    IMG_PREVIEW.appendChild(createTextEl("Aucune image"));
    DEL_BTN.style.display = "none";
}