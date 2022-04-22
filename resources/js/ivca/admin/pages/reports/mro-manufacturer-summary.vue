<template>
    <div>
        <div class="mx-2">
            <div class="row">
                <div class="col-md-8">
                    <p class="font-weight-bold mb-2 h3">
                        The survey report of the supplier or service provider
                    </p>
                </div>
                <div class="col-md-4">
                    <!-- v-if="isAdministrator()" -->
                    <a  :href="currentUrl+'/pdf/view_summary/'+$route.query.token" class="btn btn-sm mr-2" target="_blank">PDF View</a>

                    <v-btn v-if="!pdfDownLoading" @click="downloadPdf()" color="error" small><v-icon>mdi-file-document-outline </v-icon> Download PDF</v-btn>
                    <v-btn v-else color="success" small><v-icon>mdi-download-circle-outline</v-icon> Downloading ..</v-btn>


                    <v-btn outlined elevation="5" small @click="exportExcel()" :loading="exportLoading">
                        <v-icon left color="success">mdi-file-excel</v-icon>
                        Export
                    </v-btn>

                </div>

            </div>

            <div class="d-flex align-items-center flex-wrap">
                <div class="col-lg-7 col-12">
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th class="text-right">Name of the company :</th>
                                <td v-if="singleData.vendor">{{ singleData.vendor.suppier_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Description of the company :</th>
                                <td v-if="singleData.vendor">{{ singleData.vendor.address }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Name of Owner/Manager :</th>
                                <td v-if="singleData.vendor">{{ singleData.vendor.contact_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Vendor Code :</th>
                                <td v-if="singleData.vendor">{{ singleData.vendor.vendor_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <img v-if="singleData.vendor_image" :src="singleData.imglgpath + singleData.vendor_image"
                        alt="Image" class="img-fluid image_vendor">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-7 col-12">
                    <div class="font-weight-bold">Name and position of audit commitee Members</div>
                    <div class="table-responsive">
                        <table class="vendor_table_survey">
                            <tr v-for="(item, i) in auditdata" :key="i">
                                <th>{{ i+1 }}. Surveyor:</th>
                                <td v-if="item.auditordata">{{ item.auditordata.name }}</td>
                                <th>Position : </th>
                                <td v-if="item.auditordata">{{ item.auditordata.designation }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <img v-if="singleData.group_image" :src="singleData.imglgpath + singleData.group_image" alt="Image" class="img-fluid image_vendor">
                </div>
            </div>


            <div class="d-flex my-3">
                <div class="table-responsive">
                    <table class="table text-center table-striped table-bordered">
                        <tr>
                            <td rowspan="2" style="padding-top: 1.7rem">
                                Assesment topics
                            </td>
                            <td colspan="3">Point</td>
                        </tr>
                        <tr>
                            <td class="th_bg">Full</td>
                            <td class="th_bg">Actually</td>
                            <td class="th_bg">%</td>
                        </tr>
                        <tr>
                            <td class="text-left">1. Place of production and storage location</td>
                            <td>16</td>
                            <td>{{ avg_storage_actual_val }}</td>
                            <td>{{ avg_storage_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-left">2. Production planning/ control product quality and service</td>
                            <td>16</td>
                            <td>{{ avg_production_qs_actual_val }}</td>
                            <td>{{ avg_production_qs_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-left">3. Safety</td>
                            <td>16</td>
                            <td>{{ avg_safety_actual_val }}</td>
                            <td>{{ avg_safety_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-left">4. Environment and Surrounding condition</td>
                            <td>16</td>
                            <td>{{ avg_env_sur_con_actual_val }}</td>
                            <td>{{ avg_env_sur_con_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-left">5. Machinery Equipment</td>
                            <td>12</td>
                            <td>{{ avg_equipment_actual_val }}</td>
                            <td>{{ avg_equipment_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-left">6. To Operate with the company</td>
                            <td>12</td>
                            <td>{{ avg_cooperate_actual_val }}</td>
                            <td>{{ avg_cooperate_percentage_val }} %</td>
                        </tr>
                        <tr>
                            <td class="text-right">Total</td>
                            <th>{{ total_max_section_val }}</th>
                            <td>{{ total_actual_val }}</td>
                            <td>{{ total_percentage_val }} %</td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="mt-3">
                <div class="pb-3 pl-2">
                    <span class="font-weight-bold">COMMENTS :</span>

                    <!-- storage remarks and image-->
                    <div>
                        <u class="font-weight-bold">1. Place of Production / storage location :</u>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- storage remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.storage_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.storage_1_remarks }},</span>
                                    <span v-if="item.storage_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.storage_2_remarks }},</span>
                                    <span v-if="item.storage_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.storage_3_remarks }},</span>
                                    <span v-if="item.storage_4_remarks"><span class="text-muted">QR-4:</span>
                                        {{ item.storage_4_remarks }}</span>
                                    <div
                                        v-if="item.storage_1_remarks || item.storage_2_remarks || item.storage_3_remarks || item.storage_4_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.storage_image"
                                    :src="singleData.imglgpath + singleData.storage_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>

                    <!-- production_qs remarks and image-->
                    <div>
                        <u class="font-weight-bold">2. Production planning / control product quality and
                            service :</u>

                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- production_qs remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.production_qs_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.production_qs_1_remarks }},</span>
                                    <span v-if="item.production_qs_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.production_qs_2_remarks }},</span>
                                    <span v-if="item.production_qs_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.production_qs_3_remarks }},</span>
                                    <span v-if="item.production_qs_4_remarks"><span class="text-muted">QR-4:</span>
                                        {{ item.production_qs_4_remarks }}</span>
                                    <div v-if="item.production_qs_1_remarks || item.production_qs_2_remarks || item.production_qs_3_remarks || item.production_qs_4_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.production_qs_image"
                                    :src="singleData.imglgpath + singleData.production_qs_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>

                    <!-- safety remarks and image-->
                    <div>
                        <u class="font-weight-bold">3. Safety :</u>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- safety remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.safety_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.safety_1_remarks }},</span>
                                    <span v-if="item.safety_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.safety_2_remarks }},</span>
                                    <span v-if="item.safety_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.safety_3_remarks }},</span>
                                    <span v-if="item.safety_4_remarks"><span class="text-muted">QR-4:</span>
                                        {{ item.safety_4_remarks }}</span>
                                    <div
                                        v-if="item.safety_1_remarks || item.safety_2_remarks || item.safety_3_remarks || item.safety_4_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.safety_image"
                                    :src="singleData.imglgpath + singleData.safety_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>

                    <!-- env_sur_con remarks and image-->
                    <div>
                        <u class="font-weight-bold">4. Environment and Surrounding condition :</u>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- env_sur_con remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.env_sur_con_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.env_sur_con_1_remarks }},</span>
                                    <span v-if="item.env_sur_con_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.env_sur_con_2_remarks }},</span>
                                    <span v-if="item.env_sur_con_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.env_sur_con_3_remarks }},</span>
                                    <span v-if="item.env_sur_con_4_remarks"><span class="text-muted">QR-4:</span>
                                        {{ item.env_sur_con_4_remarks }}</span>
                                    <div
                                        v-if="item.env_sur_con_1_remarks || item.env_sur_con_2_remarks || item.env_sur_con_3_remarks || item.env_sur_con_4_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.env_sur_con_image"
                                    :src="singleData.imglgpath + singleData.env_sur_con_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>

                    <!-- equipment remarks and image-->
                    <div>
                        <u class="font-weight-bold">5. Machinery Equipment :</u>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- equipment remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.equipment_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.equipment_1_remarks }},</span>
                                    <span v-if="item.equipment_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.equipment_2_remarks }},</span>
                                    <span v-if="item.equipment_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.equipment_3_remarks }}</span>
                                    <div
                                        v-if="item.equipment_1_remarks || item.equipment_2_remarks || item.equipment_3_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.equipment_image"
                                    :src="singleData.imglgpath + singleData.equipment_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>

                    <!-- cooperate remarks and image-->
                    <div>
                        <u class="font-weight-bold">6. To cooperate with the company :</u>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <!-- cooperate remarks -->
                                <div class="ml-2" v-for="(item, i) in auditdata" :key="i">
                                    <span v-if="item.cooperate_1_remarks"><span class="text-muted">QR-1:</span>
                                        {{ item.cooperate_1_remarks }}, </span>
                                    <span v-if="item.cooperate_2_remarks"><span class="text-muted">QR-2:</span>
                                        {{ item.cooperate_2_remarks }}, </span>
                                    <span v-if="item.cooperate_3_remarks"><span class="text-muted">QR-3:</span>
                                        {{ item.cooperate_3_remarks }}</span>
                                    <div
                                        v-if="item.cooperate_1_remarks || item.cooperate_2_remarks || item.cooperate_3_remarks">
                                        <span v-if="item.auditordata" class="text-muted small ml-2"> --
                                            {{ item.auditordata.name }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <img v-if="singleData.cooperate_image"
                                    :src="singleData.imglgpath + singleData.cooperate_image" alt="image"
                                    class="img-fluid manfacturer_QR" />
                            </div>
                        </div>
                    </div><hr>
                </div>
            </div>



        </div>


    </div>
</template>

<script>
    export default {

        data() {
            return {

                // current page url
                currentUrl: '/ivca/admin/reports/manufacturer',

                token: '',
                auditdata: '',
                singleData: '',

                fullDataObj: {},
                pdfDownLoading: false,

                number_of_audit: 0,
                total_max_section_val: '',
                total_percentage_val: '',
                total_actual_val: '',

                avg_storage_percentage_val: '',
                avg_storage_actual_val: '',

                avg_production_qs_percentage_val: '',
                avg_production_qs_actual_val: '',

                avg_safety_percentage_val: '',
                avg_safety_actual_val: '',

                avg_env_sur_con_percentage_val: '',
                avg_env_sur_con_actual_val: '',

                avg_equipment_percentage_val: '',
                avg_equipment_actual_val: '',

                avg_cooperate_percentage_val: '',
                avg_cooperate_actual_val: '',


                // exportLoading
                exportLoading: false,

            }

        },

        methods: {

            // auditSummaryData
            auditSummaryData() {

                axios.post(this.currentUrl + '/summary_audit_data', {
                    token: this.$route.query.token
                }).then(response => {
                    console.log(response.data)

                    if (response.data.status == 204) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry ! Data not found',
                        })
                        // Redirect
                        this.$router.push({
                            name: 'admin_ivca_reports_manufacturer',
                        })

                    } else {

                        this.singleData = response.data.allData[0]
                        this.auditdata = response.data.allData

                        // Number of audits
                        this.number_of_audit = response.data.length

                        // // Total percentage value
                        this.total_max_section_val = response.data.totalmaxSectionValue

                        // // Total actual value
                        this.total_actual_val = (response.data.totalavgActualvalue).toFixed(2)

                        // // Total percentage value
                        //this.total_percentage_val = (response.data.totalavgPercentagevalue).toFixed()
                        this.total_percentage_val = (response.data.totalavgPercentagevalue).toFixed(2)


                        // Single sections values
                        this.avg_storage_percentage_val = response.data.storage_result.percentageResult
                        this.avg_storage_actual_val = response.data.storage_result.avgActualvalue

                        this.avg_production_qs_percentage_val = response.data.production_qs_result
                            .percentageResult
                        this.avg_production_qs_actual_val = response.data.production_qs_result.avgActualvalue

                        this.avg_safety_percentage_val = response.data.safety_result.percentageResult
                        this.avg_safety_actual_val = response.data.safety_result.avgActualvalue

                        this.avg_env_sur_con_percentage_val = response.data.env_sur_con_result.percentageResult
                        this.avg_env_sur_con_actual_val = response.data.env_sur_con_result.avgActualvalue

                        this.avg_equipment_percentage_val = response.data.equipment_result.percentageResult
                        this.avg_equipment_actual_val = response.data.equipment_result.avgActualvalue

                        this.avg_cooperate_percentage_val = response.data.cooperate_result.percentageResult
                        this.avg_cooperate_actual_val = response.data.cooperate_result.avgActualvalue

                    }



                }).catch(error => {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry ! Somthing going wrong',
                    })

                    // Redirect
                    this.$router.push({
                        name: 'admin_ivca_reports_manufacturer',
                    })

                    console.log(error)
                })

            },


            // downloadPdf
            downloadPdf(){
                    //start Loading
                    this.pdfDownLoading = true

                    axios({
                        method: 'get',
                        url: this.currentUrl+'/pdf/download_summary/'+ this.$route.query.token,
                        responseType: 'blob', // important
                    }).then((response) => {

                        console.log(response.data)
                        //stop Loading
                        this.pdfDownLoading = false

                        if( response.status == 200 ){
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            let fileName = this.singleData.vendor.vendor_number+'-audit-summary.pdf' 
                            link.setAttribute('download', fileName);
                            document.body.appendChild(link);
                            link.click();
                            
                       }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error !!',
                                text: 'Data Not Found !!'
                            })
                        }
                        
                    }).catch( error=>{
                        //stop Loading
                        this.pdfDownLoading = false
                        console.log(error)
                        Swal.fire({
                                icon: 'error',
                                title: 'Error !!',
                                text: 'Somthing going wrong !!'
                            })
                    })

            },



            // exportExcel
            exportExcel() {
                this.exportLoading = true;

                axios({
                    method: 'get',
                    url: this.currentUrl + '/export_summary_audit_data/' + this.$route.query.token,

                    responseType: 'blob', // important
                }).then((response) => {

                    if (response.status == 200) {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        let fileName = this.singleData.vendor.vendor_number+'-audit-summary.xlsx'
                        link.setAttribute('download', fileName);
                        document.body.appendChild(link);
                        link.click();

                        this.exportLoading = false;

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Data Not Found !!'
                        })
                        this.exportLoading = false;
                    }

                }).catch(error => {
                    //stop Loading
                    this.exportLoading = false
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Somthing going wrong !!'
                    })
                })


            },


        },



        created() {
            this.$Progress.start();
            this.auditSummaryData();
            console.log('token', this.$route.query.token)
            this.$Progress.finish();
        }
    }

</script>
