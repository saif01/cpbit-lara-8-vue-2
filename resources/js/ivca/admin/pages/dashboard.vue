<template>
    <div class="p-2">

        <div class="row">
            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">iVCA Users</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="fas fa-users mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.allRoleUser }}/</span><span class="h5">{{ dataObj.allUser }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.userPercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.userPercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">iVCA Admins</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="fas fa-users-cog mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.allRoleAdmin }}/</span><span class="h5">{{ dataObj.allUser }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.adminPercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.adminPercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">Active Vendors</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="fas fa-user-check mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.activeVendor }}/</span><span class="h5">{{ dataObj.vendor }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.activeVendorPercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.activeVendorPercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">Blacklisted Vendors</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="fas fa-user-times mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.blacklisVendor }}/</span><span class="h5">{{ dataObj.vendor }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.blacklisVendorPercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.blacklisVendorPercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>

        </div>

        <div class="row mt-3">

            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">MRO Audit Status</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="far fa-calendar-check mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.mroaAuditDoneSchedule }}/</span><span class="h5">{{ dataObj.mroSchedule }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.activeMroSchedulePercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.activeMroSchedulePercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card class="card_gradient">
                    <v-card-text>
                        <h6 class="mb-4 text-light font-weight-bold h5">Food Audit Status</h6>
                        <div class="d-flex align-items-center text-light">
                            <div class="col-9">
                                <p class="f-w-300 d-flex align-items-center m-b-0 h2">
                                    <i class="far fa-calendar-check mr-2 fa-lg h3"></i><span class="h3">{{ dataObj.foodaAuditDoneSchedule }}/</span><span class="h5">{{ dataObj.foodSchedule }}</span>
                                </p>
                            </div>
                            <div class="col-3 text-right"><p>{{ dataObj.activeFoodSchedulePercent }} %</p></div>
                        </div>
                        <div class="progress m-t-30" style="height: 7px">
                            <div class="progress-bar progress-c-theme" role="progressbar" :style="'width:'+ dataObj.activeFoodSchedulePercent +'%'"></div>
                        </div>
                    </v-card-text>
                </v-card>
            </div>

          
            
        </div>

     
    </div>
</template>

<script>
export default {

    data(){
        return{
            dataObj:''
        }
    },

    methods:{

        // getDashboardData
        getDashboardData(){
            axios.get('/ivca/admin/dashboard_data').then(response=>{
                // console.log(response.data);
                this.dataObj = response.data;

            }).catch(error=>{
                console.log(error);
            })
        }

    },

    created(){

        this.$Progress.start();
        this.getDashboardData();
        // console.log('main iVCA_app created', this.authuser)
        this.$Progress.finish();

    }
    
}
</script>


<style>
    img {
        width: 100%;
        display: block;
    }

    .right-1 img {
        height: 200px;
    }

    .containers {
        border: 2px solid black;
    }

    .table th,
    .table td {
        padding: 0.50rem;
    }

    .asses_topic {
        padding-top: 0px;
    }

    @media all and (max-width: 600px) {
        .right-1 {
            margin: 1rem 0;
        }
    }

     .vendor_thead_bg {
        background-color: #f2f2f2;
    }

    .vendor_table_survey {
        width: 100%;
    }

    .vendor_table_survey tr td {
        padding: 0.75rem;
    }

    img {
        width: 100%;
        height: auto;
    }

    ul {
        padding-left: 0.5rem;
    }

    ul li {
        list-style: none;
        margin: 0.5rem 0.5 0.5rem 0;
        padding-right: 0.5rem;
    }

    .head_border {
        border: 1px solid black;
    }

    .head_border_2,
    .head_border_3 {
        border-left: 1px solid black;
    }

    .image_vendor {
        height: 200px;
        width: 300px;
    }


    .text-c-green {
        color: #1de9b6;
    }
    .card_gradient {
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #121213, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 20s ease infinite;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    @media all and (max-width: 700px) {
        .card_gradient {
            margin: 0.5rem 0;
        }
    }
</style>
