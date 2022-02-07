<template>
    <div>
        <v-dialog v-model="userDilog" scrollable>

            <v-card class="bg_card">
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10" class="text-white">
                            User Details :
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="userDilog = false" color="error lighten-1" small text class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <!-- {{ userData }} -->

                    <v-row>
                        <v-col cols="9">

                            <v-row class="text-white">
                                <v-col cols="6">
                                    <div>
                                        Name: <span v-if="userData">{{ userData.name }}</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Personal Contact: <span
                                            v-if="userData.personal_contact">{{ userData.personal_contact }}</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Office Contact: <span
                                            v-if="userData.office_contact">{{ userData.office_contact }}</span> <span
                                            v-else class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Office ID: <span v-if="userData.office_id">{{ userData.office_id }}</span> <span
                                            v-else class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Office Email: <span
                                            v-if="userData.office_email">{{ userData.office_email }}</span> <span v-else
                                            class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Personal Email: <span
                                            v-if="userData.personal_email">{{ userData.personal_email }}</span> <span
                                            v-else class="error--text">Not Available !</span>
                                    </div>
                                </v-col>

                                <v-col cols="6">
                                    <div>
                                        Office: <span v-if="userData.office">{{ userData.office }}</span> <span v-else
                                            class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Zone Office: <span v-if="userData.zone_office">{{ userData.zone_office }}</span>
                                        <span v-else class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        NID: <span v-if="userData.nid">{{ userData.nid }}</span> <span v-else
                                            class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Designation: <span v-if="userData.department">{{ userData.department }}</span>
                                        <span v-else class="error--text">Not Available !</span>
                                    </div>
                                    <hr>
                                    <div>
                                        Business Unit: <span
                                            v-if="userData.business_unit">{{ userData.business_unit }}</span> <span
                                            v-else class="error--text">Not Available !</span>
                                    </div>
                                </v-col>
                            </v-row>

                        </v-col>

                        <v-col cols="3">
                            <v-img v-if="userData.image" :src="'/images/users/' + userData.image" alt="image" contain
                                max-height="350px"></v-img>
                        </v-col>
                    </v-row>


                </v-card-text>
            </v-card>

        </v-dialog>
    </div>
</template>

<script>
    export default {

        props: ['userData'],

        data() {
            return {
                userDilog: true,
            }
        },


        created() {
            this.$Progress.start()
            //console.log('User Details component', this.userData)
            this.$Progress.finish()
        }

    }

</script>


<style scoped>
    .bg_card {
        background: linear-gradient(120deg, rgb(46, 51, 49) 60%, rgb(49, 79, 44) 40%);
    }

</style>
