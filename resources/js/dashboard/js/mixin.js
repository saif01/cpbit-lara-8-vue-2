import { mapGetters } from 'vuex'
import globalRolePermissions from './../../role_permissions'


export default{

    data(){
        return{
            
        }
    },


    methods: {

        // globalRolePermissions
        ...globalRolePermissions,

    },



    computed : {
        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth'      : 'getAuth',
            'roles'     : 'getRoles',
        }),
    },

}