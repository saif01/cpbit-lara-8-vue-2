<template>
    <div>
        
        <div class="d-flex justify-content-between">
            <h4>Applications</h4>
            <v-btn outlined :to="{ name: 'Dashboard'}" class="text-decoration-none">
                <v-icon left>mdi-plus</v-icon> New
            </v-btn>
        </div>
        <v-row>
            <v-col xl="6" lg="4" v-for="(email, index) in emailData" :key="index">
                <v-card height="350">
                    <v-card-title class="d-flex justify-content-between">
                        <h4>Email Request</h4>
                        <strong>{{email.created_at | moment("MMM Do YYYY, h:mm a")}}</strong>
                    </v-card-title>
                    <v-card-text>
                        <div class="mt-5 mb-2">
                            <v-timeline align-top dense>
                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="email.manager_datetime != null">
                                                {{email.manager_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="email.manager_status != null">
                                                Approved by Manager
                                            </strong>
                                            <strong v-else>Waiting for Manage Approval</strong>
                                            <div v-if="email.manager_status != null" class="text-caption">
                                                {{email.manager_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="teal lighten-3" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="email.bu_datetime != null">
                                                {{email.bu_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="email.bu_status != null">
                                                Approved by BU Head
                                            </strong>
                                            <strong v-else>Waiting for BU Approval</strong>
                                            <div v-if="email.bu_status != null" class="text-caption">
                                                {{email.bu_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="email.it_datetime != null">
                                                {{email.it_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="email.it_status != null">
                                                Approved by CPB-IT
                                            </strong>
                                            <strong v-else>Waiting for IT Approval</strong>
                                            <div v-if="email.it_status != null" class="text-caption">
                                                {{email.it_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                            </v-timeline>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col xl="6" lg="4" v-for="(account, index) in accountData" :key="index">
                <v-card height="350">
                    <v-card-title class="d-flex justify-content-between">
                        <h4>Account Authority Request</h4>
                        <strong>{{account.created_at | moment("MMM Do YYYY, h:mm a")}}</strong>
                    </v-card-title>
                    <v-card-text>
                        <div class="mt-5 mb-2">
                            <v-timeline align-top dense>
                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="account.manager_datetime != null">
                                                {{account.manager_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="account.manager_status != null">
                                                Approved by Manager
                                            </strong>
                                            <strong v-else>Waiting for Manage Approval</strong>
                                            <div v-if="account.manager_status != null" class="text-caption">
                                                {{account.manager_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="teal lighten-3" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="account.bu_datetime != null">
                                                {{account.bu_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="account.bu_status != null">
                                                Approved by BU Head
                                            </strong>
                                            <strong v-else>Waiting for BU Approval</strong>
                                            <div v-if="account.bu_status != null" class="text-caption">
                                                {{account.bu_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="account.it_datetime != null">
                                                {{account.it_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="account.it_status != null">
                                                Approved by CPB-IT
                                            </strong>
                                            <strong v-else>Waiting for IT Approval</strong>
                                            <div v-if="account.it_status != null" class="text-caption">
                                                {{account.it_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                            </v-timeline>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col xl="6" lg="4" v-for="(internet, index) in internetData" :key="index">
                <v-card height="350">
                    <v-card-title class="d-flex justify-content-between">
                        <h4>Internet Access Request</h4>
                        <strong>{{internet.created_at | moment("MMM Do YYYY, h:mm a")}}</strong>
                    </v-card-title>
                    <v-card-text>
                        <div class="mt-5 mb-2">
                            <v-timeline align-top dense>
                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="internet.manager_datetime != null">
                                                {{internet.manager_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="internet.manager_status != null">
                                                Approved by Manager
                                            </strong>
                                            <strong v-else>Waiting for Manage Approval</strong>
                                            <div v-if="internet.manager_status != null" class="text-caption">
                                                {{internet.manager_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="teal lighten-3" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="internet.bu_datetime != null">
                                                {{internet.bu_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="internet.bu_status != null">
                                                Approved by BU Head
                                            </strong>
                                            <strong v-else>Waiting for BU Approval</strong>
                                            <div v-if="internet.bu_status != null" class="text-caption">
                                                {{internet.bu_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="internet.it_datetime != null">
                                                {{internet.it_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="internet.it_status != null">
                                                Approved by CPB-IT
                                            </strong>
                                            <strong v-else>Waiting for IT Approval</strong>
                                            <div v-if="internet.it_status != null" class="text-caption">
                                                {{internet.it_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                            </v-timeline>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col xl="6" lg="4" v-for="(guest, index) in guestData" :key="index">
                <v-card height="350">
                    <v-card-title class="d-flex justify-content-between">
                        <h4>Guest User Request</h4>
                        <strong>{{guest.created_at | moment("MMM Do YYYY, h:mm a")}}</strong>
                    </v-card-title>
                    <v-card-text>
                        <div class="mt-5 mb-2">
                            <v-timeline align-top dense>
                                
                                <v-timeline-item color="teal lighten-3" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="guest.bu_datetime != null">
                                                {{guest.bu_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="guest.bu_status != null">
                                                Approved by BU Head
                                            </strong>
                                            <strong v-else>Waiting for BU Approval</strong>
                                            <div v-if="guest.bu_status != null" class="text-caption">
                                                {{guest.bu_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                                <v-timeline-item color="pink" small>
                                    <v-row class="pt-1">
                                        <v-col cols="3">
                                            <strong v-if="guest.it_datetime != null">
                                                {{guest.it_datetime}}
                                            </strong>
                                            <strong v-else>Approval Time</strong>
                                        </v-col>
                                        <v-col>
                                            <strong v-if="guest.it_status != null">
                                                Received by CPB-IT
                                            </strong>
                                            <strong v-else>Waiting for IT Approval</strong>
                                            <div v-if="guest.it_status != null" class="text-caption">
                                                {{guest.it_name}}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-timeline-item>

                            </v-timeline>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
         </v-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {

                currentUrl: '/iaccess/status',

                emailData: '',
                internetData: '',
                accountData: '',
                guestData: '',

            }
        },

        methods: {

            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field
                    )
                    .then(response => {
                        this.emailData = response.data.emailRequest;
                        this.internetData = response.data.internetRequest;
                        this.accountData = response.data.accountRequest;
                        this.guestData = response.data.guestRequest;

                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;

                        // Loading Animation
                        this.dataLoading = false;

                    });
            },

        },

        mounted() {
            this.getResults();
        }
    }

</script>
