<template>
    <div>
        <v-card class="col-lg-8 col-12 m-auto">
            <v-card-text>
                <div class="d-flex justify-content-between">
                    <h4>Applications</h4>
                    <v-btn outlined :to="{ name: 'Dashboard'}" class="text-decoration-none"><v-icon left>mdi-plus</v-icon> New</v-btn>
                </div>
                
                <div class="mt-5 mb-2">
                    <div class="table-responsive mt-1">
                        <table class="table">
                            <tr>
                                <th style="border-top:none">Application Type</th>
                                <th style="border-top:none">Apply Date</th>
                                <th style="border-top:none">Status</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data(){
        return{

            currentUrl: '/iaccess/status',
        }
    },

    methods:{

    },

    mounted(){
        this.getResults();
    }
}
</script>