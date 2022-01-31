export default{

    
    // managerSelectBy
    managerSelectBy(){

        //console.log('managerSelectBy', this.radioBtnSeelected)
        //select manager By Id
        if(this.radioBtnSeelected  == 'managerById'){
            this.managerByIdShow = true
            this.managerByEmailShow = false
            this.form.manager_emails = ''
        }
        //select manager By manual input Email
        if(this.radioBtnSeelected  == 'managerByEmail'){
            this.managerByIdShow = false
            this.managerByEmailShow = true
            this.form.manager_id = []
            this.selectedManagerName = []
        }
    },

   


    // Create Data
    createData() {
        // Loading Animation
        this.dataModalLoading = true
        // Assign Roles
        this.form.roles = this.currentRoles

        // request send and get response
        this.form.post(this.currentUrl +'/store'+ '').then(response=>{
            // Loading Animation
            this.dataModalLoading = false
            // Input field make empty
            this.form.reset();
            // Hide model
            this.dataModalDialogUserReg = false;
            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });
        }).catch(data => {
            // Loading Animation
            this.dataModalLoading = false
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Somthing Going Wrong<br>'+data.message,
            //     customClass: 'text-danger'
            // });
            Toast.fire("error", "Somthing Going Wrong");
        });
    
    },



    // Edit Data Modal
    editDataModelDirect(singleData){

        //console.log('singleData', singleData)
       
        this.manager_name = singleData.manager_name
        this.manager_email = singleData.manager_email
        this.bu_name = singleData.bu_name
        this.bu_email = singleData.bu_email
        this.remarks = singleData.remarks

        this.form.reset()
        this.form.fill(singleData)

        this.form.user = 1
        this.form.status = 1

        // Show dilog
        this.dataModalDialogUserReg = true

    },


   

    // Variables make empty
    makeEmptyVariables(){
        this.selectedManager=[];
        this.selectedManagerName=[];
    },


    // Get all Role
    getRoles() {
        axios.get(this.currentUrl + '/roles_data').then(response => {
            //console.log(response.data)
            this.allRoles = response.data
        }).catch(error => {
            console.log(error)
        })
    },

   


    // editRoleModel
    editRoleModel(roleData) {
        console.log(roleData.id)
        this.currentRoleId = roleData.id
        // Current role array empty
        this.currentRoles = []
        // role found then push in arry
        roleData.roles.forEach(element => {
            // console.log('loop', element.id)
            this.currentRoles.push(element.id)
        })

        // Role modal show
        this.roleModelShow = true;
    },

    // update user role
    updateUserRole() {

        this.roleUpdating = true
        axios.post(this.currentUrl + '/roles_update', {
                currentRoleId: this.currentRoleId,
                roles: this.currentRoles,
            })
            .then(response => {
                this.roleUpdating = false
                //console.log(response)
                // Refetch
                this.getResults();
                // Modal closed
                this.roleModelShow = false;

                Swal.fire({
                    icon: response.data.icon,
                    title: response.data.msg,
                    customClass: 'text-success'
                });
            })
            .catch(error => {
                // Modal closed
                this.roleModelShow = false;
                this.roleUpdating = false
                Swal.fire({
                    icon: 'error',
                    title: 'Somthing Going Wrong',
                    customClass: 'text-danger'
                });
                console.log(error)
            })


    },




    
   

    // // showSingleUserDetails
    // showSingleUserDetails(singleData){

    //     this.$Progress.start();
    //     this.singleUserModalShow = true
    //     this.singleUserModalData = singleData
    //     this.$Progress.finish();

    //     //console.log(singleData)

    // },



}