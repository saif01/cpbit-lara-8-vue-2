<template>
    <div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Importer Audit Report</h3>
                    </div>
        
                </div>
            </div>

            <div class="card-body">
                <div v-if="allData.data">
                    <div class="row mb-2">
                        <div class="col form-inline small">
                            <select v-model="paginate" class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col">
                            <input v-model="search" class="form-control form-control-sm" type="text"
                                placeholder="Search by any data at the table...">
                        </div>
                    </div>

                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">ID</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>

                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('date')">Audit Date</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'date'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'date'">&darr;</span>
                                </th>

                                <th>Vendor Number</th>
                                <th>Suppier Name</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Single Report</th>
                                <th>Summary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>{{ singleData.id }}</td>
                                <td>{{ singleData.date }}</td>
                                <td>{{ singleData.vendor.vendor_number }}</td>
                                <td>{{ singleData.vendor.suppier_name }}</td>
                                <td>{{ singleData.vendor.address }}</td>
                                <td>{{ singleData.vendor.telephone }}</td>
                                <td>
                                    <span v-for="(item, i) in singleData.audits_importer" :key="i">
                                        <!-- {{ item.id }}, -->
                                        <v-btn v-if="item.status == 1" @click="singleAuditShow(item.id)" small class="info m-1">Audit by {{ item.auditordata.name }}</v-btn>
                                    </span>
                                </td>

                                <td>

                                    <!-- {{ singleData.audits_importer.length }} -->
                                    <v-btn v-if="singleData.audits_importer.length > 0"
                                        @click="auditReportShow(singleData.token)" small class="info">Summary</v-btn>
                                </td>


                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>

        <!-- Modal -->
        <v-dialog v-model="data_view_modal" max-width="1100px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Single Audit Report
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="data_view_modal = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <!-- Data show by component -->
                    <single-audi-report :audit_id="currentAuditId"></single-audi-report>
                </v-card-text>
            </v-card>

        </v-dialog>


    </div>

</template>


<script>

    import singleAuditReport from './single-report/importer.vue';
    
    export default {

        components:{
           'single-audi-report'  : singleAuditReport
        },

        data() {
            return {
                // dialog
                data_view_modal:false,
                // current page url
                currentUrl: '/ivca/admin/reports/importer',

                auditData: {},
                templateData: {},
                singleAuditReport: '',
                singleAuditReportShow: false,

                currentAuditId:'',
              
            }
        },

        methods: {

            // Get table data
            getDirectResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;

                        // console.log(response.data)

                        // if(response.data.audits_importer){

                        //     if(response.data.audits_importer[0].status == 1){
                        //         this.checkAuditData = true
                        //     }
                        // }else{
                        //     this.checkAuditData = false
                        // }


                        // Loading Animation
                        this.dataLoading = false;

                    });
            },


            // singleAuditShow
            singleAuditShow(auditId) {
   
                this.currentAuditId = auditId;
                //this.$refs['data_view_modal'].show();
                this.data_view_modal=true
            },

            // AuditReportShow
            auditReportShow(token) {
                this.$router.push({
                    name: 'admin_ivca_reports_importer_summary',
                    query: {
                        token: token
                    }
                })
            },

           




        },





        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getDirectResults();
            this.$Progress.finish();
        },



    }

</script>

