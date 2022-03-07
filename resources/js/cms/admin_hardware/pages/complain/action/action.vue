<template>
    <div>
        <v-card class="mb-5">
            <v-card-title>
                Hardware Complain Actions
            </v-card-title>
            <v-card-text v-if="complainDeta" class="table-responsive">

                <!-- Complain and user Details -->
                <table class="table mb-0">
                    <tr>
                        <th>Complain No:</th>
                        <td>
                            <div class="pa-1 info rounded-pill h6 text-white text-center">
                                {{ complainDeta.id }}</div>
                        </td>
                        <th>Category:</th>
                        <td><v-btn v-if="complainDeta.category" @click="modifyDialogShow()" color="info" small ><v-icon left>mdi-playlist-edit</v-icon> {{ complainDeta.category.name }}</v-btn></td>
                        <th>Subcategory:</th>
                        <td>
                        <v-btn v-if="complainDeta.subcategory" @click="modifyDialogShow()" color="info" small  ><v-icon left>mdi-playlist-edit</v-icon> {{ complainDeta.subcategory.name }}</v-btn></td>
                    </tr>

                    <tr>
                        <th>Complain By:</th>
                        <td>
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.makby"
                                @click="currentUserView(complainDeta.makby)">
                                <v-avatar size="20" @click="currentUserView(complainDeta.makby)">
                                    <img v-if="complainDeta.makby.image"
                                        :src="'/images/users/small/' + complainDeta.makby.image" alt="image">
                                </v-avatar> {{ complainDeta.makby.name }}
                            </button>
                        </td>
                        <th>Department:</th>
                        <td><span v-if="complainDeta.makby">{{ complainDeta.makby.department }}</span></td>
                        <th>Register:</th>
                        <td><span
                                v-if="complainDeta.created_at">{{ complainDeta.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                        </td>
                    </tr>
                </table>

                <!-- Final Status And Documents  -->
                <table class="table mb-0">
                    <tr>
                        <th>Final Status:</th>
                        <td>
                            <div class="pa-1 success rounded-pill h6 text-white text-center">
                                {{ complainDeta.process }}</div>
                        </td>

                        <th v-if="complainDeta.computer_name" >C. Name:</th>
                        <td v-if="complainDeta.computer_name">
                           {{ complainDeta.computer_name }}
                        </td>
                   
                        <th>Files:</th>
                        <td>
                            <a v-if="complainDeta.document" :href="docPath+complainDeta.document"
                                class="btn btn-info btn-sm text-white" download>
                                <v-icon color="white">mdi-download-network-outline</v-icon> Doc-1
                            </a>
                            <span v-else class="text-danger">Not Attached</span>
                        </td>
                        
                        
                    </tr>
                </table>
                
                <!-- Details -->
                <table class="table mb-0">
                    <tr v-if="complainDeta.accessories">
                        <th>Accessories: </th>
                        <td>{{ complainDeta.accessories }}</td>
                    </tr>
                    <tr>
                        <th>Details:</th>
                        <td>{{ complainDeta.details }}</td>
                    </tr>
                </table>

                <!-- All Remarks -->
                <div v-if="complainDeta.remarks" class="mb-2">
                    <div v-for="(item, index) in  complainDeta.remarks" :key="index">
                        <table class="table mb-0 bg-secondary text-white rounded">

                            <tr>
                                <th>Process: ({{ index+1 }})</th>
                                <td>
                                    <span v-if="(item.process == 'Damaged')" class="text-danger bg-white rounded">Damaged</span> 
                                    <span v-else-if="(item.process == 'Closed')" class="text-danger bg-white rounded">Closed</span> 
                                    <span v-else>{{ item.process }}</span> 
                                </td>
                                <th>Document:</th>
                                <td>
                                    <span v-if="item.document">
                                        <a v-if="item.document" :href="docPath+item.document"
                                            class="btn btn-info btn-sm text-white" download>
                                            <v-icon color="white" small>mdi-download-network-outline</v-icon> Document
                                        </a>
                                    </span>
                                    <span v-else class="text-warning">No Document's Send</span>
                                </td>
                            </tr>
                            <tr>
                                <th>By:</th>
                                <td>
                                    <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                        @click="currentUserView(item.makby)">
                                        <v-avatar size="20">
                                            <img v-if="item.makby.image" :src="'/images/users/small/' + item.makby.image"
                                                alt="image">
                                        </v-avatar> {{ item.makby.name }}
                                    </button>
                                </td>
                                <th>Action At:</th>
                                <td><span
                                        v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            </tr>
                            <!-- dam_apply -->
                            <!-- {{ complainDeta.dam_apply }} -->
                            <tr v-if="(item.process == 'Damaged') && complainDeta.dam_apply && complainDeta.dam_apply.apply_by" class="bg-info">
                                <th>Damage Apply:</th>
                                <td>Successfully </td>
                                <th>Apply At:</th>
                                <td><span v-if="complainDeta.dam_apply.apply_at" class="text-warning" >{{ complainDeta.dam_apply.apply_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            </tr>
                            <!-- Email send  -->
                            <tr v-if="item.mail">
                                <th>E-Mail:</th>
                                <td>
                                    <span v-if="item.mail.status" class="text-success">Successfully Sent</span>
                                    <span v-else class="text-warning">Sending</span> 
                                    <v-btn @click="mailSendManual(item.mail.id)" :loading="mailSendLoading" small class="float-right" ><v-icon>mdi-email-send</v-icon></v-btn>
                                </td>
                                <th>Send At:</th>
                                <td><span v-if="item.mail.status">{{ item.mail.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                <span v-else class="text-warning">Sending</span>
                                </td>
                            </tr>
                                
                    
                        </table>
                        <table class="table mb-1 bg-secondary text-white rounded border-bottom  border-danger">
                            <tr>
                                <th>Remarks:</th>
                                <td v-html="item.details"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Action Btn -->
                <div>
                    <v-btn v-if="checkActionBtnAccess()" :loading="actionBtnLoading" block class="success" @click="actionDialogShow()" elevation="20" >
                        <v-icon left>mdi-gesture-tap-button</v-icon> Action
                    </v-btn>
                </div>
                


            </v-card-text>
            <v-card-text v-else>
                <div v-if="dataLoading" class="p-5 my-5">
                    <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                        </v-icon>
                    </p>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>
            </v-card-text>

        </v-card>

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

        <!-- Modify Dialog -->
        <cat-sub-modify-dialog v-if="CurrentComDataModify" :comData="CurrentComDataModify" :key="comModifyDialogKey" @childToParent="childToParentCall"></cat-sub-modify-dialog>



        <!-- Not Process Action Dialog -->
        <action-dialog v-if="actionVal" :comData="CurrentComData" :key="comActionsDialogKey" @childToParent="childToParentCall"></action-dialog>

        <!-- Not Process Action Dialog -->
        <action-dialog-2 v-if="actionVal2" :comData="CurrentComData" :key="comActionsDialogKey" @childToParent="childToParentCall"></action-dialog-2>

    </div>
</template>

<script>
    // User Details Show By Dialog
    import userDetails from '../../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from '../../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from '../../../../../super_admin/pages/users/details/js/methods'

    import catSubModifyDialog from './cat_sub_modify.vue'
    import actionDialog from './dialog/action_dialog.vue'
    import actionDialog2 from './dialog/action_dialog_2.vue'
    



    export default {

        components: {
            'user-details': userDetails,
            'cat-sub-modify-dialog': catSubModifyDialog,
            'action-dialog': actionDialog,
            'action-dialog-2': actionDialog2,
        },

        data() {
            return {
                //current page url
                currentUrl: '/cms/h_admin/complain',

                docPath: '/images/hardware/',

                comId: this.$route.query.id,

                complainDeta: '',

                //Action Dialog
                actionBtnLoading:false,
                actionVal:false,
                actionVal2:false,
                comActionsDialogKey: 3,
                CurrentComData: '',

                // comModifyDialog
                comModifyDialogKey: 5,
                CurrentComDataModify: '',


                // Current User Show By Dilog
                ...userDetailsData,

                // Send Mail
                mailSendLoading: false,

                
            }
        },

        methods: {

            childToParentCall () {
                //console.log('child') // someValue
                // refresh data
                this.getComplainData();
            },

            // CurrentUserData
            ...userDetailsMethods,


            // check action btn access
            checkActionBtnAccess(){
               
              if(this.complainDeta.process == 'HO Service' ){
                   return true;
               }
               
               if(this.complainDeta.process != 'Closed'){
                   return true;
               }

                return false;
            },

            // getComplainData
            getComplainData() {
                this.dataLoading = true
                axios.get(this.currentUrl + '/action/' + this.comId).then(response => {
                    this.dataLoading = false

                    //console.log(response.data)
                    this.complainDeta = response.data

                }).catch(error => {
                    this.dataLoading = false
                    console.log(error)
                })

            },

           
            // modifyDialogShow
            modifyDialogShow() {
                this.comModifyDialogKey++
                this.CurrentComDataModify = this.complainDeta
            },

            // mailSendManual
            mailSendManual(val){
             this.mailSendLoading = true
             axios.get(this.currentUrl+'/send_rem_email?id=' + val )
                .then(response => {
                    //console.log(response.data);
                    this.getComplainData();
                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
                    })
                    this.mailSendLoading = false
                }).catch(error=>{
                    this.mailSendLoading = false
                    console.log(error);
                });

            },


            // actionDialogShow
            actionDialogShow() {
                this.actionBtnLoading = true

                //console.log('Process ', val)
                let currPro = this.complainDeta.process

                if(currPro == 'Not Process'){
                    this.actionVal = true
                    this.actionVal2 = false
                }
                
                if(currPro == 'Processing' || currPro == 'Send Service' || currPro == 'Back Service'|| currPro == 'Again Send Service'){
                    this.actionVal = false
                    this.actionVal2 = true 
                }

                this.comActionsDialogKey++
                this.CurrentComData = this.complainDeta

                // this.comActionsDialogKey++
                // this.CurrentComData = this.complainDeta

                this.actionBtnLoading = false
            },



        },

        created() {
            this.$Progress.start();
            this.getComplainData();
            //console.log(this.comId, this.$route.query.id)
            this.$Progress.finish();
        }

    }

</script>
