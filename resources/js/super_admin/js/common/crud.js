export default{

    // Create Data
    createData() {
        // Loading Animation
        this.dataModalLoading = true
        // request send and get response
        this.form.post(this.currentUrl +'/store'+ '').then(response=>{
            // Loading Animation
            this.dataModalLoading = false
            // Input field make empty
            this.form.reset();
            // Hide model
            this.dataModalDialog = false;
            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });
        }).catch((data) => {
            // Loading Animation
            this.dataModalLoading = false
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong<br>'+data.message,
                customClass: 'text-danger'
            });
            //Swal.fire("Failed!", data.message, "warning");
        });
      
    },

    // Update data
    updateData() {
        // Loading Animation
        this.dataModalLoading = true
        // request send and get response
        this.form.put(this.currentUrl + '/update/' + this.form.id).then(response=>{
            // Loading Animation
            this.dataModalLoading = false
            // Input field make empty
            this.form.reset();
            // Hide model dataModalDialog
            this.dataModalDialog = false;
            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });

        }).catch((data) => {
            // Loading Animation
            this.dataModalLoading = false
            Swal.fire({
                icon: 'error',
                title: 'Somthing Going Wrong<br>'+data.message,
                customClass: 'text-danger'
            });
            //Swal.fire("Failed!", data.message, "warning");
        });
       
        
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
    addDataModel(){
        this.editmode = false;
        this.form.reset();
        this.dataModalDialog = true
    },

    // Edit Data Modal
    editDataModel(singleData){
        this.editmode = true;
        this.dataModelTitle = 'Update Data'
        this.form.reset();
        this.form.fill(singleData);
        this.dataModalDialog=true
    },

    
          
}