export default{

    // Create Data
    createData() {
        this.dataModalLoading = true;
        this.$Progress.start()
        // request send and get response
        this.form.post(this.currentUrl + '/store' + '').then(response => {
            // Input field make empty
            this.form.reset();
            this.form.errors.clear();
            this.resetForm();
            this.dataModalLoading = false;
            // Hide model
            this.dataModalDialog = false;
            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            this.$Progress.finish();

            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });

        }).catch(error=>{
            this.dataModalLoading = false;
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong',
                customClass: 'text-danger'
            });
            console.log(response);
        });

    },

    // Update data
    updateData() {
        this.dataModalLoading = true;
        this.$Progress.start();
        // request send and get response
        this.form.put(this.currentUrl + '/update/?id=' + this.form.id).then(response => {
            // Input field make empty
            this.form.reset();
            this.form.errors.clear();
            this.resetForm();
            this.dataModalLoading = false;
            // Hide model
            this.dataModalDialog = false;
            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            this.$Progress.finish();

            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });

        }).catch(error=>{
            this.dataModalLoading = false;
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong',
                customClass: 'text-danger'
            });
            console.log(response);
        });;
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
                axios.delete(this.currentUrl + '/destroy_temp?id=' + id).then((response) => {
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
    deleteData(id, loc) {

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
                axios.delete(this.currentUrl + '/destroy?id=' + id + '&location='+loc).then((response) => {
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

    // restore Data
    restoreData(id, loc) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to restore this data?",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Restore it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                axios.put(this.currentUrl + '/restore?id=' + id + '&location='+loc).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Restored!',
                        'Your file has been Restored.',
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




    damageChange(data){
        // console.log('status', data.status)
        if(data.damage_st == 1){
            var text = "Are you want to mark this as Damage ?"
            var btnText = "Damage"
           
        }else{
            var text = "Are you want to mark this as Good ?"
            var btnText = "Good"
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
                axios.post(this.currentUrl + '/damage_status/' + data.id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Changed!',
                        'Product has been Changed.',
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