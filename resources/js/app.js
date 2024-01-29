import Dropzone from "dropzone";
 
Dropzone.autoDiscover = false;
 
if(document.getElementById("dropzone")) {
  const dropzone = new Dropzone("#dropzone",{
    dictDefaultMessage: 'Sube aqui tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivos",
    maxFiles: 1,
    uploadMultiple: false,
  
    init: function() {
      const dropzoneInstance = this;
      const imagenInput = document.querySelector('[name="imagen"]');
    
      if (imagenInput.value.trim()) {
        const imagenPublicada = {
          size: 1234,
          name: imagenInput.value.trim()
        };
    
        this.emit("addedfile", imagenPublicada);
        this.emit("thumbnail", imagenPublicada, `/uploads/${imagenPublicada.name}`);
        this.emit("complete", imagenPublicada);
    
        // Manejar el caso en que se elimine el archivo
        imagenPublicada.previewElement.querySelector(".dz-remove").addEventListener("click", function() {
          dropzoneInstance.removeFile(imagenPublicada);
          imagenInput.value = "";
        });
      }
    }
  })
  
  
  dropzone.on("success",function(file, response){
    console.log(response)
  
    document.querySelector('[name="imagen"]').value = response.imagen
  })
  
  dropzone.on('removedfile', function(){
    document.querySelector('[name="imagen"]').value=""
  })
}