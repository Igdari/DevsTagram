import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone',{
    dictDefaultMessage: "Sube Aqui tu Imagen",
    acceptedFiles: ".pnh,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,
})

//Eventos
dropzone.on('sending', function (file, xhr, formData) {
    console.log(formData);
})

dropzone.on('success', function (file, response){
    console.log(response);
})

dropzone.on('error', function (file, message){
    console.log(message);
})

dropzone.on('removedfile', function (){
    console.log('Archivo Eliminado');
})