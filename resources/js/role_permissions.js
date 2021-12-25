export default{
  
    // Single role check
    checkSingleRole(singleRole) {
        return this.roles.includes(singleRole)
    },

    // Function definiton with passing two arrays
    checkAnyRoleOfArray(array2) {
        if(this.roles){
            let allRoles = this.roles
            // Loop for array1
            for(let i = 0; i < allRoles.length; i++) {
                // Loop for array2
                for(let j = 0; j < array2.length; j++) {
                    // Compare the element of each and every element from both of the
                    if(allRoles[i] === array2[j]) {
                        // Return if common element found
                        return true;
                    }
                }
            }
        }
        // Return if no common element exist
        return false; 
    },

    // All Role permisions

    // Check role by value
    isRole( val=null ){
        if(val){
            return this.checkSingleRole(val);
        }
        return false; 
       
    },
    // Check role by array value
    isAnyRole( val =[] ){
        if(val){ 
            return this.checkAnyRoleOfArray(val);
        }
        return false;
        
    },

    isAdministrator(){
        return this.checkSingleRole('Administrator');
    },

    isViewAccess(){
        //console.log(this.userPermission)
        return this.checkAnyRoleOfArray(['Administrator', 'View']);
    },
    isAddAccess(){
        return this.checkAnyRoleOfArray(['Administrator', 'Add']);
    },
    isEditAccess(){
        return this.checkAnyRoleOfArray(['Administrator', 'Edit']);
    },
    isDeleteAccess(){
        return this.checkAnyRoleOfArray(['Administrator', 'Delete']);
    },

    // All Super Admin Role
    isSuperAdmin(){
        return this.checkAnyRoleOfArray(['Administrator', 'Super-admin']);
    },
    isRoleManage(){
        return this.checkAnyRoleOfArray(['Administrator', 'Role-manage']);
    },
    isUserManagement(){
        return this.checkAnyRoleOfArray(['Administrator', 'User-management']);
    },


    // Room
    isRoomAdmin(){
        return this.checkAnyRoleOfArray(['Administrator', 'Room-admin']);
    },
    isRoom(){
        return this.checkAnyRoleOfArray(['Administrator', 'Room']);
    }









    
}