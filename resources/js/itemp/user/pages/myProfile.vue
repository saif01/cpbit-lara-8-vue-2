<template>
    <div>
        <div class="position-relative mb-1">
            <div class="background_color w-100" style="height:25vh">
            </div>
            <div class="profile_image d-flex flex-column align-items-center">
                <img src="all-assets/image/image0.jpeg" alt="image" class="rounded-circle bg-white p-1 profile_image_size">
            </div>

        </div>
        <div class="text_content col-lg-9 col-md-7 ml-auto">
            
            <table class="table table-bordered">
                <tr>
                    <th>Login-ID</th>
                    <td>{{data.login}}</td>

                    <th>Full Name</th>
                    <td>{{data.name}}</td>
                </tr>

                <tr>
                    <th>Office-ID</th>
                    <td>{{data.office_id}}</td>

                    <th>Personal Email</th>
                    <td>{{data.personal_email}}</td>
                </tr>

                <tr>
                    <th>Designation</th>
                    <td>{{data.department}}</td>

                    <th>Office Email</th>
                    <td>
                        <span v-if="data.office_email">
                            {{data.office_email}}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Personal Contact</th>
                    <td>
                        <span v-if="data.personal_contact">
                            {{data.personal_contact}}
                        </span>
                    </td>

                    <th>Office</th>
                    <td>{{data.office}}</td>
                </tr>

                <tr>
                    <th>Office Contact</th>
                    <td>
                        <span v-if="data.office_contact">
                            {{data.office_contact}}
                        </span>
                    </td>

                    <th>Business Unit</th>
                    <td>
                        <span v-if="data.business_unit">
                            {{data.business_unit}}
                        </span>
                    </td>
                </tr>
                
            </table>
        </div>

    </div>
</template>


<script>
export default {
    data(){
        return{
            data: '',
        }
    },

    methods:{

        // getUser() {
        //     axios.get(this.currentUrl + '/check_point').then(response => {

        //         this.checkPoint = response.data;

        //     }).catch(error => {
        //         console.log(error)
        //     })
        // },

    },

    mounted(){
        this.data = this.auth;
    }
}
</script>

<style scoped>
    .background_color{
        background: #134E5E;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #71B280, #134E5E);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #71B280, #134E5E); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }
    .profile_image_size {
        height: 152px;
        width: 152px;
    }

    .profile_image {
        position: absolute;
        bottom: -40%;
        left: 13%;
    }


    @media all and (min-width:700px) and (max-width:810px) {

        .profile_image_size {
            height: 132px;
            width: 132px;
        }

        .profile_image {
            bottom: -21%;
            left: 5%;
        }
    }

    @media all and (min-width:300px) and (max-width:510px) {

        .text_content {
            margin-top: 3.5rem !important;
        }

        .profile_image_size {
            height: 120px;
            width: 120px;
        }

        .profile_image {
            bottom: -25%;
        }
    }

</style>
