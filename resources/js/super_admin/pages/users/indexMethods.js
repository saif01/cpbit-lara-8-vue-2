import axios from "axios";

export default{

    // Get table data
    getResults(page = 1) {
        this.dataLoading = true;
        axios.get(this.currentUrl+'/index?page=' + page +
                '&paginate=' + this.paginate +
                '&search=' + this.search +
                '&sort_direction=' + this.sort_direction +
                '&sort_field=' + this.sort_field +
                '&search_field=' + this.search_field + 
                '&zone_office='+ this.zone_office +
                '&department='+ this.department

            )
            .then(response => {
                //console.log(response.data.data);
                //console.log(response.data.from, response.data.to);
                this.allData = response.data;
                this.totalValue = response.data.total;
                this.dataShowFrom = response.data.from;
                this.dataShowTo = response.data.to;
                this.currentPageNumber  = response.data.current_page
                // Loading Animation
                this.dataLoading = false;

            });
    },

    // getFullList
    getFullList(){
        axios.get(this.currentUrl+'/full_list').then(response=>{
            this.fullUserList = response.data
        }).catch(error=>{
            console.log(error)
        })
    },

    
    // Manager Data array show by manager ID array
    manegerData(newValue) {

        let fianlArray = [];
        if(newValue){
            var allDataArr = this.fullUserList;
            // Text split in array
            var managerId = newValue.split(',')
            //console.log(managerId, newValue, allDataArr);
            
            // Manager ID check in all Data
            for (var key in allDataArr) {
                var value = allDataArr[key];
                // Check manager ID in Current Data
                for(var key2 in managerId){
                    var value2 = managerId[key2];
                    // Single value check
                    if(value2 == value.id){
                        //console.log('value found', value.id, value.name)
                        // Name push in array

                        //fianlArray['id'].push(value.id)
                        fianlArray.push(value)
                        //fianlArray['all'].push(value) 
                        
                        //fianlArray[value.id] = value.name
                        //fianlArray.push(value.id)
                        // fianlArray.push(value.name)
                    
                    }
                    // console.log('for2 -- ', key2, value2);
                }
            }
        }
        //console.log('fianlArray -- ', fianlArray);
        return fianlArray;
        
       
    },

    // Show user name by user ID
    userNameByID(id){

        let userName = '';

        if(id){
            var allDataArr = this.allData.data;
            // Manager ID check in all Data
            for (var key in allDataArr) {
                var value = allDataArr[key];
                // Single value check
                if(id == value.id){     
                    userName = value.name  
                }
            }
        }

        return userName
    },



    // managerSelectBy
    managerSelectBy(){
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
        }
    },

    //Set Manager
    setManager(){
        // make empty
        this.form.manager_id = []
        this.selectedManagerName = []

        var allDataArr = this.allData.data;
        var managerId = this.selectedManager
        //console.log(managerId, myarr, singleData.manager_id);
        
        // Manager ID check in all Data
        for (var key in allDataArr) {
            var value = allDataArr[key];
            // Check manager ID in Current Data
            for(var key2 in managerId){
                var value2 = managerId[key2];
                // Single value check
                if(value2 == value.id){
                    //console.log('value found', value.id, value.name)
                    // Name push in array
                    this.selectedManagerName.push(value.name)
                    // ID Push in form obj
                    this.form.manager_id.push(value.id)
                }
                // console.log('for2 -- ', key2, value2);
            }
        }
       
       
        console.log('selectedManagerName', this.selectedManagerName, this.form)
        // Hide second modal
        this.userModal2ndShowHide = false
   
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

    // Update data
    updateData() {
        // Loading Animation
        this.dataModalLoading = true
        // Assign Roles
        this.form.roles = this.currentRoles
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



    // Edit Data Modal
    editDataModel(singleData){

        this.selectedManagerName = []
        this.selectedManager = []

        //console.log('singleData', this.selectedManager, singleData.manager_id)
        if(singleData.manager_id){
            // Make Empty
            this.selectedManager = []
            this.selectedManager = singleData.manager_id.split(',')
            this.selectedManagerName = []
        
            //this.selectedManager.push(singleData.manager_id);
            var allDataArr = this.allData.data;
            // Text split in array
            var managerId = this.selectedManager
            //console.log(managerId, myarr, singleData.manager_id);
            // Manager ID check in all Data
            for (var key in allDataArr) {
                var value = allDataArr[key];
                // Check manager ID in Current Data
                for(var key2 in managerId){
                    var value2 = managerId[key2];
                    // Single value check
                    if(value2 == value.id){
                        //console.log('value found', value.id, value.name)
                        // Name push in array
                        this.selectedManagerName.push(value.name)
                    }
                    // console.log('for2 -- ', key2, value2);
                }
            }
        }

        // Role Assign
        if(singleData.roles){

            this.currentRoles = []
            // role found then push in arry
            singleData.roles.forEach(element => {
                // console.log('loop', element.id)
                this.currentRoles.push(element.id)
            })

        }

        // manager_id
        if(singleData.manager_id){
            this.radioBtnSeelected = 'managerById'
            this.managerByIdShow = true
            this.managerByEmailShow = false
        }

        // manager_emails
        if(singleData.manager_emails){
            this.radioBtnSeelected = 'managerByEmail'
            this.managerByIdShow = false
            this.managerByEmailShow = true
        }

        

        this.editmode = true;
        this.dataModelTitle = 'Update Data'
        this.form.reset();
        this.form.fill(singleData);
        this.dataModalDialog=true

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




    // Change admin Status
    statusChangeAdmin(data){
        // console.log('status', data.status)
        if(data.admin == 1){
            var text = "Are you want to remove Admin access ?"
            var btnText = "Remove"
           
        }else{
            var text = "Are you want to assign Admin access ?"
            var btnText = "Assign"
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
                this.form.post(this.currentUrl + '/status_admin/' + data.id ).then((response) => {
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

    // Change user Status
    statusChangeUser(data){
        // console.log('status', data.status)
        if(data.user == 1){
            var text = "Are you want to remove User access ?"
            var btnText = "Remove"
           
        }else{
            var text = "Are you want to assign User access ?"
            var btnText = "Assign"
        }

        Swal.fire({
            title: 'Are you sure?',
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: btnText,
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$Progress.start();
                this.form.post(this.currentUrl + '/status_user/' + data.id ).then((response) => {
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


    // get Zone Offices
    getZoneOffices(){
        axios.get(this.currentUrl+ '/zoneoffices').then(response=>{
            // console.log(response.data)
            this.allZoneOffices = response.data
        }).catch(error=>{
            console.log(error)
        })
    },

    // get Departments
    getDepartments(){
        axios.get(this.currentUrl+ '/departments').then(response=>{
            //console.log(response.data)
            this.allDepartments = response.data
        }).catch(error=>{
            console.log(error)
        })
    },



}