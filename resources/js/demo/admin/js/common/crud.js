export default{

    // Create Data
    async createData() {
        //console.log('Form submited');
        this.$Progress.start()
        // request send and get response
        const response = await this.form.post(this.currentUrl +'/store'+ '');
        // Input field make empty
        this.form.reset();
        this.form.errors.clear();
        // Hide model
        //this.$refs['data-modal'].hide();
        this.dataModalDialog = false;
        // Refresh Tbl Data with current page
        this.getResults(this.currentPageNumber);
        this.$Progress.finish();

        if (response.status == 200) {
            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong<br>'+data.message,
                customClass: 'text-danger'
            });
            // Swal.fire("Failed!", data.message, "warning");
            console.log(response);
        }

    },

    // Update data
    async updateData() {
        this.addRoomsLoader = true
        //console.log('Edit Form submited', this.form.id);
        this.$Progress.start();
        // request send and get response
        const response = await this.form.put(this.currentUrl + '/update/' + this.form.id);
        // Input field make empty
        this.form.reset();
        this.addRoomsLoader = false
        // Hide model
        //this.$refs['data-modal'].hide();
        this.dataModalDialog = false;
        // Refresh Tbl Data with current page
        this.getResults(this.currentPageNumber);
        this.$Progress.finish();
        
        if (response.status == 200) {
            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong<br>'+data.message,
                customClass: 'text-danger'
            });
            // Swal.fire("Failed!", data.message, "warning");
            console.log(response);
        }

    },

    // Delete Data
    deleteDataTemp(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                this.form.delete(this.currentUrl + '/destroy_temp/' + id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    //Swal.fire("Failed!", data.message, "warning");
                });
            }
        })
    },

    // Delete Data
    deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                this.form.delete(this.currentUrl + '/destroy/' + id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                });
            }
        })
    },


    // Delete DataDirict Data without form
    deleteDataDirict(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                axios.delete(this.currentUrl + '/destroy/' + id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                });
            }
        })
    },

    // Change Status
    statusChange(data){
        // console.log('status', data.status)
        if(data.status == 1){
            var text = "Are you want to inactive ?"
            var btnText = "Inactive"
           
        }else{
            var text = "Are you want to active ?"
            var btnText = "Active"
        }

        Swal.fire({
            title: 'Are you sure?',
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: btnText,
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                this.form.post(this.currentUrl + '/status/' + data.id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Changed!',
                        'Status has been Changed.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                });
            }
        })
    },

    // Add Data Model
    addDataModel() {
        this.editmode = false;
        this.form.reset();
        //this.$refs['data-modal'].show();
        this.dataModalDialog = true;
    },

    // Edit Data Modal
    editDataModel(singleData){
        this.editmode = true;
        this.dataModelTitle = 'Update Data'
        this.form.reset();
        this.form.fill(singleData);
        //this.$refs['data-modal'].show();
        this.dataModalDialog = true;
    },

    // reset form
    resetForm(){
        this.form.reset();
        this.$refs.form.resetValidation();
        this.form.errors.clear();
    }
          
}