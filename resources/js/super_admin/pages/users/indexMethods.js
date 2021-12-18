export default{

    manegerName(newValue) {

        let fianlArray = [];

               
        if(newValue){
            var allDataArr = this.allData.data;
            // Text split in array
            var managerId = newValue.split(',')
            //console.log(managerId, myarr, singleData.manager_id);
            
            // Manager ID check in all Data
            for (var key in allDataArr) {
                var value = allDataArr[key];
                // Check manager ID in Current Data
                for(var key2 in managerId){
                    var value2 = managerId[key2];
                    // Single value check
                    if(value2 == value.id){
                       // console.log('value found', value.id, value.name)
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

        return fianlArray;
        
       
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


    // second Modal Show
    modal2ndShow(){
        this.userModal2ndShowHide = true
    },
  


    // Create Data
    async createDataDirect() {
        console.log('Form submited');
        this.$Progress.start()
        // request send and get response
        const response = await this.form.post(this.currentUrl +'/store'+ '');
        // Input field make empty
        this.form.reset();
        this.form.errors.clear();
        // Hide model
        this.$refs['data-modal'].hide();
        // Refresh Tbl Data with current page
        this.getResults(this.currentPageNumber);

        // makeEmptyVariables
        this.makeEmptyVariables();

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


    // Edit Data Modal
    editDataModelDirect(singleData){
        //console.log('singleData', singleData)
        if(singleData.manager_id){
            // Make Empty
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

        this.editmode = true;
        this.dataModelTitle = 'Update Data'
        this.form.reset();
        this.form.fill(singleData);
        this.$refs['data-modal'].show();
    },


    // Update data
    async updateDataDirect() {

        //console.log('Edit Form submited', this.form.id);
        this.$Progress.start();
        // request send and get response
        const response = await this.form.put(this.currentUrl + '/update/' + this.form.id);
        // Input field make empty
        this.form.reset();
        // Hide model
        this.$refs['data-modal'].hide();
        // Refresh Tbl Data with current page
        this.getResults(this.currentPageNumber);

        // makeEmptyVariables
        this.makeEmptyVariables();
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





    // showSingleUserDetails
    showSingleUserDetails(singleData){

        this.singleUserModalShow = true

        this.singleUserModalData = singleData

        console.log(singleData)

    },



}