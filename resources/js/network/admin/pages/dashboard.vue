<template>
    <div>
        <v-row>
            <v-col cols="6">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">

                        <div class="d-flex justify-content-between">
                            Total Main-IP
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{totalMainIP}}
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="6">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        
                        <div class="d-flex justify-content-between">
                            Total Sub-IP
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{totalSubIP}}
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="6">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Main-IP Ping
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{totalMainPing}}
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="6">
                <v-card class="bg_card">
                    <v-card-text class="h5 white--text">
                        <div class="d-flex justify-content-between">
                            Total Sub-IP Ping
                            <span>
                                <v-icon color="white" size="40">mdi-cellphone-message</v-icon>
                                {{totalSubPing}}
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>


<script>
export default {
    data(){
        return{
            currentUrl: '/network/admin',

            totalMainIP: '',
            totalSubIP: '',
            totalMainPing: '',
            totalSubPing: '',
        }
    },

    methods:{

        getData(){

            axios.get(this.currentUrl + '/dashboard_all').then((response) => {
                this.totalMainIP = response.data.totalMainIP,
                this.totalSubIP = response.data.totalSubIP,
                this.totalMainPing = response.data.totalMainPing,
                this.totalSubPing = response.data.totalSubPing

            });
        }
        

    },
    mounted(){
        this.getData();
    },
}
</script>

<style scoped>
.bg_card{
    background: linear-gradient(120deg, rgba(245,97,67,255) 60%, rgba(37,40,59,255) 40%);
}
</style>
