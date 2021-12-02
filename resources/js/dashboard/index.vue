<template>
    <div>
        <choose-dashboard v-if="dashboard" @showTemp="conponentShow"></choose-dashboard>
        <user-dashboard  v-if="userDashboard"></user-dashboard>
        <admin-dashboard  v-if="adminDashboard"></admin-dashboard>
        <no-access v-if="noAccess"></no-access>
    </div>
</template>

<script>

import chooseDashboard from './pages/choose.vue'
import userDashboard from './pages/user.vue'
import adminDashboard from './pages/admin.vue'
import noAccess from './pages/no_access.vue'

export default {

    props:['authuser'],

    components:{
        'choose-dashboard'  : chooseDashboard,
        'user-dashboard'    : userDashboard,
        'admin-dashboard'   : adminDashboard,
        'no-access'         : noAccess,
    },

    data(){
        return{
            auth: JSON.parse(this.authuser),

            dashboard       : false,
            userDashboard   : false,
            adminDashboard  : false,
            noAccess        : false
           
        }
    },

    methods:{

        // Data come from child Component
        conponentShow(val){

            //alert(val);

            if(val == 'user'){
                //Show User Dashboard
                this.dashboard = false
                this.userDashboard= true
                this.adminDashboard= false

            }else if(val == 'admin'){
                // Admin Dashboard
                this.dashboard = false
                this.userDashboard= false
                this.adminDashboard= true
                
            }else{
                // Admin User Both Dashboard
                this.dashboard = true
                this.userDashboard = false
                this.adminDashboard = false
            }
          
        },

        // Check User Role
        checkUserRoleForDashboard(){
            if( this.auth.user == 1 && this.auth.admin == 1 ){

                // Admin User Both Access
                this.dashboard = true
                this.userDashboard = false
                this.adminDashboard = false

            }else if( this.auth.user != 1 && this.auth.admin == 1){

                // Only Admin Access
                this.dashboard = false
                this.userDashboard= false
                this.adminDashboard= true

            }else if( this.auth.user == 1 && this.auth.admin != 1){

                // Only User Access
                this.dashboard = false
                this.userDashboard= true
                this.adminDashboard= false
            }else{
                // No Access
                this.noAccess = true
            }


        }
    },

    created(){

        this.$Progress.start();

        //checkUserRole
        this.checkUserRoleForDashboard();
        console.log('auth user', this.auth);

        this.$Progress.finish();  
    }
    
}
</script>



<style lang="scss">
    /* header */
    .header__logo {
        height: 50px;
    }

    .blink {
        animation-name: blinker;
        animation-duration: 0.6s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
        animation-direction: alternate;
    }

    @keyframes blinker {
        from {
            opacity: 1.0;
        }

        to {
            opacity: 0.0;
        }
    }

    /* background */
    .area {
        background-color: #85FFBD;
        background-image: linear-gradient(45deg, #85FFBD 0%, #FFFB7D 99%);
        width: 100%;
        min-height: 100vh;
    }

    .bg_image_logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.3;
    }

    /* icon and logo */
    ul {
        padding: 0;
    }

    ul li {
        list-style: none;
    }

    ul li p {
        position: relative;
        display: block;
        width: 120px;
        height: 120px;
        background: #ebe8e8;
        text-align: center;
        transform: perspective(1000px) rotate(-30deg) skew(25deg) translate(0, 0);
        transition: .5s;
        box-shadow: -30px 30px 10px rgba(0, 0, 0, .5);
    }

    ul li p:before {
        content: '';
        position: absolute;
        top: 10px;
        left: -20px;
        height: 100%;
        width: 20px;
        background: #93a092;
        transition: .5s;
        transform: rotate(0deg) skewY(-45deg);
    }

    ul li p:after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: -10px;
        height: 20px;
        width: 100%;
        background: #D3D3D3;
        transition: .5s;
        transform: rotate(0deg) skewX(-45deg);
    }

    ul li p:hover {
        transform: perspective(1000px) rotate(-30deg) skew(25deg) translate(20px, -20px);
        box-shadow: -50px 50px 50px rgba(0, 0, 0, .5);
    }

    .rotate_icon {
        transform: rotate(40deg);
    }

    // color logo
    /* carpool */
    ul li:hover .carpool {
        background: #ffc107;
    }

    ul li:hover .carpool:before {
        background: #ebbe37;
    }

    ul li:hover .carpool:after {
        background: #e4b52a;
    }

    /* help-desk */
    ul li:hover .helpDesk {
        background: #17a2b8;
    }

    ul li:hover .helpDesk:before {
        background: #28c3db;
    }

    ul li:hover .helpDesk:after {
        background: #28c3db;
    }

    /* application */
    ul li:hover .application {
        background: #ffc107;
    }

    ul li:hover .application:before {
        background: #ebbe37;
    }

    ul li:hover .application:after {
        background: #e4b52a;
    }

    /* hardware */
    ul li:hover .hardware {
        background: #007bff;
    }

    ul li:hover .hardware:before {
        background: #3596fd;
    }

    ul li:hover .hardware:after {
        background: #3596fd;
    }

    /* inventory */
    ul li:hover .inventory {
        background: #28a745;
    }

    ul li:hover .inventory:before {
        background: #3cc95d;
    }

    ul li:hover .inventory:after {
        background: #3cc95d;
    }

    /* powerBi */
    ul li:hover .powerBi {
        background: #17a2b8;
    }

    ul li:hover .powerBi:before {
        background: #28c3db;
    }

    ul li:hover .powerBi:after {
        background: #28c3db;
    }

    /* network */
    ul li:hover .network {
        background: #007bff;
    }

    ul li:hover .network:before {
        background: #3596fd;
    }

    ul li:hover .network:after {
        background: #3596fd;
    }

    /* room */
    ul li:hover .room {
        background: #ffc107;
    }

    ul li:hover .room:before {
        background: #ebbe37;
    }

    ul li:hover .room:after {
        background: #e4b52a;
    }

    /* audit */
    ul li:hover .audit {
        background: #17a2b8;
    }

    ul li:hover .audit:before {
        background: #28c3db;
    }

    ul li:hover .audit:after {
        background: #28c3db;
    }

    /* sms */
    ul li:hover .sms {
        background: #28a745;
    }

    ul li:hover .sms:before {
        background: #3cc95d;
    }

    ul li:hover .sms:after {
        background: #3cc95d;
    }

    ul li:hover .logout {
        background: #dc3545;
    }

    ul li:hover .logout:before {
        background: #db4857;
    }

    ul li:hover .logout:after {
        background: #b62e3b;
    }

    @media all and (max-width:900px) {
        ul li p {
            width: 80px;
            height: 80px;
        }

        .rotate_icon {
            height: 80px;
        }

        .logo_text_response {
            font-size: 18px;
        }

        .responsive_gap {
            margin-top: 2rem;
        }
    }


    /* footer */
    .dashboard_footer_bg {
        background: #141e30;
        color: white;
    }

    // dashboard css
    ul li:hover .user_section {
        background: #3b5999;
    }

    ul li:hover .user_section:before {
        background: #5E77AB;
    }

    ul li:hover .user_section:after {
        background: #1e3d59;
    }

    ul li:hover .admin_section {
        background: #236949;
    }

    ul li:hover .admin_section:before {
        background: #329265;
    }

    ul li:hover .admin_section:after {
        background: #20744c;
    }

</style>
