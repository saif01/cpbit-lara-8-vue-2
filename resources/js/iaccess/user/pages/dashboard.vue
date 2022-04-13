<template>
    <div>
        <v-card class="mt-8">
            <v-card-title class="justify-center">
                <span style="letter-spacing: 0.27em;">
                    Choose Your Form
                </span>
            </v-card-title>
            <v-card-text>

                <v-row>
                    <v-col lg="6" cols="6">
                        <v-hover>
                            <template v-slot:default="{ hover }">
                                <v-card @click="emailModal = true, emailActionKey++;">
                                    <v-card-title>Official Email Request Form</v-card-title>
                                    <v-img
                                    class="align-end font-weight-bold bg-info"
                                    contain
                                    src="/all-assets/common/icon/email_request.png"
                                    :height="bgImgHeight"
                                    >
                                    </v-img>

                                    <v-fade-transition>
                                        <v-overlay
                                            v-if="hover"
                                            absolute
                                            color="#036358"
                                        >
                                        <v-btn>
                                            Apply
                                        </v-btn>
                                        </v-overlay>
                                    </v-fade-transition>
                                </v-card>
                            </template>
                        </v-hover>
                    </v-col>

                    <v-col lg="6" cols="6">
                        <v-hover>
                            <template v-slot:default="{ hover }">
                                <v-card @click="accountModal = true, accountActionKey++ ">
                                    <v-card-title>Account Authority Request Form</v-card-title>
                                    <v-img
                                    class="align-end font-weight-bold bg-info"
                                    contain
                                    src="/all-assets/common/icon/account_authority.png"
                                    :height="bgImgHeight"
                                    >
                                    </v-img>

                                    <v-fade-transition>
                                        <v-overlay
                                            v-if="hover"
                                            absolute
                                            color="#036358"
                                        >
                                            <v-btn>Apply</v-btn>
                                        </v-overlay>
                                    </v-fade-transition>
                                </v-card>
                            </template>
                        </v-hover>
                    </v-col>

                    <v-col lg="6" cols="6">
                        <v-hover>
                            <template v-slot:default="{ hover }">
                                <v-card @click="internetModal = true, internetActionKey++ ">
                                    <v-card-title>Internet/Web Access Request Form</v-card-title>
                                    <v-img
                                    class="align-end font-weight-bold bg-info"
                                    contain
                                    src="/all-assets/common/icon/internet_access.png"
                                    :height="bgImgHeight"
                                    >
                                    </v-img>

                                    <v-fade-transition>
                                        <v-overlay
                                            v-if="hover"
                                            absolute
                                            color="#036358"
                                        >
                                            <v-btn>Apply</v-btn>
                                        </v-overlay>
                                    </v-fade-transition>
                                </v-card>
                            </template>
                        </v-hover>
                    </v-col>

                    <v-col lg="6" cols="6">
                        <v-hover>
                            <template v-slot:default="{ hover }">
                                <v-card @click="guestModal = true, guestActionKey++ ">
                                    <v-card-title>Guest User Request Form</v-card-title>
                                    <v-img
                                    class="align-end font-weight-bold bg-info"
                                    contain
                                    src="/all-assets/common/icon/guest_request.png"
                                    :height="bgImgHeight"
                                    >
                                    </v-img>

                                    <v-fade-transition>
                                        <v-overlay
                                            v-if="hover"
                                            absolute
                                            color="#036358"
                                        >
                                            <v-btn>Apply</v-btn>
                                        </v-overlay>
                                    </v-fade-transition>
                                </v-card>
                            </template>
                        </v-hover>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>


        <!-- email form -->
        <email-form v-if="emailModal" :key="emailActionKey"></email-form>

        <!-- internet form -->
        <internet-form v-if="internetModal" :key="internetActionKey"></internet-form>

        <!-- account form -->
        <account-form v-if="accountModal" :key="accountActionKey"></account-form>

        <!-- guest form -->
        <guest-form v-if="guestModal" :key="guestActionKey"></guest-form>



    </div>
</template>

<script>
import emailForm from "./Form/emailRequestForm.vue"
import internetForm from "./Form/internetAccessRequest.vue"
import accountForm from "./Form/accountRequest.vue"
import guestForm from "./Form/guestUserRequest.vue"
export default {
    components:{
        'email-form':emailForm,
        'internet-form':internetForm,
        'account-form':accountForm,
        'guest-form':guestForm,
    },

    data() {

        return {

            bgImgHeight: 200,

            options:[
                {
                    value:'Smart Soft',
                    text: 'Smart Soft'
                },
                {
                    value:'Win Feed',
                    text: 'Win Feed'
                },
                {
                    value:'Win Farm (Poultry)',
                    text: 'Win Farm (Poultry)'
                },
                {
                    value:'Win Farm (Aqua)',
                    text: 'Win Farm (Aqua)'
                },
                {
                    value:'Win Food',
                    text: 'Win Food'
                },
                {
                    value:'Sampan VAT',
                    text: 'Sampan VAT'
                },
                {
                    value:'Internet ID',
                    text: 'Internet ID'
                },
                {
                    value:'Internet Web Access',
                    text: 'Internet Web Access'
                },
                {
                    value:'Guest Internet ID',
                    text: 'Guest Internet ID'
                },
                {
                    value:'Smart N/R',
                    text: 'Smart N/R'
                },
                {
                    value:'Smart iLab',
                    text: 'Smart iLab'
                },
            ],

            // email component
            emailModal: '',
            emailActionKey:0,

            // internet component
            internetModal: '',
            internetActionKey:0,

            // account component
            accountModal: '',
            accountActionKey:0,

            // guest component
            guestModal: '',
            guestActionKey:0,


            

        }


    },

    methods: {

        // email(){
        //     this.emailModal = true;
        //     this.emailActionKey++;
            
        // }


        
        
    },

}

</script>
