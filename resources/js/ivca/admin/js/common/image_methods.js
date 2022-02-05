export default{
     // Upload Image
     upload_image(e) {
        let file = e.target.files[0];
        let reader = new FileReader();

        if (file['size'] < this.imageMaxSize) {
            reader.onloadend = (file) => {
                //console.log('RESULT', reader.result)
                this.form.image = reader.result;
            }
            reader.readAsDataURL(file);
        } else {
            alert('File size can not be bigger than 2 MB')
        }
    },

    //For getting Instant Uploaded Photo
    get_image() {

        if (this.form.image) {
            let photo = (this.form.image.length > 100) ? this.form.image : this.imagePathSm + this.form.image;
            return photo;
        }
        return null;
    },


    // File Upload
    onFileChange(e){
        let file = e.target.files[0];

        if(file['size'] < this.fileMaxSize) {
            this.form.document = file;
        }else{
             alert('File size can not be bigger than 5 MB')
        }
        //console.log(file)
        //console.log(this.form.document)
    },
    
}