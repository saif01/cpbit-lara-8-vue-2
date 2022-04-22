<template>

    <div v-if="singleAuditReportShow" class="p-0">
        <div class="mb-1">
            
        </div>
        <div class="d-flex flex-wrap">
            <div class="col-lg-12 col-12 pl-1">
                <div class="mb-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    Vendor Details :
                                </div>
                                <div class="col-md-6">

                                    <v-btn v-if="!pdfDownLoading" @click="downloadPdf()" color="error" small><v-icon>mdi-file-document-outline </v-icon> Download PDF</v-btn>
                                    <v-btn v-else color="success" small>><v-icon>mdi-download-circle-outline</v-icon> Downloading ..</v-btn>
                                    
                                    <!-- v-if="isAdministrator()" -->
                                    <a  :href="currentUrl+'/pdf/view/'+audit_id" class="btn btn-sm mr-2" target="_blank">PDF View</a>

                                    <v-btn outlined elevation="5" small @click="exportExcel()" :loading="exportLoading">
                                        <v-icon left color="success">mdi-file-excel</v-icon>
                                        Export
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                        <div class="card-body m-auto">
                            <table>
                                <tr>
                                    <th class="text-right">Date of survey : </th>
                                    <td>{{ auditData.date }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right font-weight-bold">Name of the company : </th>
                                    <td v-if="auditData.vendor">{{ auditData.vendor.suppier_name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right font-weight-bold">Location of the company : </th>
                                    <td v-if="auditData.vendor">{{ auditData.vendor.address }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right font-weight-bold">Name of Owner / Manager :</th>
                                    <td v-if="auditData.vendor">{{ auditData.vendor.contact_name }}</td>
                                </tr>
                                <tr class="text-right font-weight-bold">
                                    <th>Vendor Code : </th>
                                    <td class="text-left" v-if="auditData.vendor">{{ auditData.vendor.vendor_number }}</td>
                                </tr>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="font-weight-bold pl-1">
            Name and position of audit committee Member:
        </div>
        <div class="d-flex flex-wrap ">
            <div class="col-lg-12 col-12 p-0">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="font-weight-bold">Surveyer:</td>
                            <td v-if="auditData.auditordata">{{ auditData.auditordata.name }}</td>
                            <td class="font-weight-bold">Position:</td>
                            <td v-if="auditData.auditordata">{{ auditData.auditordata.designation }}</td>
                            <td class="font-weight-bold">Department:</td>
                            <td v-if="auditData.auditordata">{{ auditData.auditordata.business_unit }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="font-weight-bold text-center mt-2">
            <u>Scoring</u>
        </div>
        <div class="d-flex justify-content-around">
            <div class="font-weight-bold">
                Very Good = 4 points
            </div>
            <div class="font-weight-bold">
                Good = 3 points
            </div>
            <div class="font-weight-bold">
                Fair = 2 points
            </div>
            <div class="font-weight-bold">
                Update = 1
            </div>
        </div>



        <div class="table-responsive mt-2">
            <table class="text-center table table-bordered">
                <tr>
                    <th rowspan="2" class="pt-4">Post assesment</th>
                    <th colspan="2">Assesment Score</th>
                    <th rowspan="2" class="pt-4 ">Suggestions / problems encountered</th>
                </tr>
                <tr>
                    <th>Full</th>
                    <th>Actually</th>
                </tr>
                <tr>
                    <th class="text-left bg-gray"><u>Place of Production / storage location</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.storage_1 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.storage_1 }}</td>
                    <td>{{ singleAuditReport.auditData.storage_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.storage_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.storage_2 }}</td>
                    <td>{{ singleAuditReport.auditData.storage_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.storage_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.storage_3 }}</td>
                    <td>{{ singleAuditReport.auditData.storage_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.storage_4 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.storage_4 }}</td>
                    <td>{{ singleAuditReport.auditData.storage_4_remarks }}</td>
                </tr>
                <tr>
                    <th class="text-right font-weight-bold">
                        Total
                    </th>
                    <td>{{ singleAuditReport.storageSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.storageSection.totalActualVal }}</td>
                    <td></td>

                </tr>

                <tr>
                    <th class="text-left bg-gray"><u>Production planning / control product quality and service</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.production_qs_1 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.production_qs_1 }}</td>
                    <td>{{ singleAuditReport.auditData.production_qs_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.production_qs_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.production_qs_2 }}</td>
                    <td>{{ singleAuditReport.auditData.production_qs_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.production_qs_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.production_qs_3 }}</td>
                    <td>{{ singleAuditReport.auditData.production_qs_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.production_qs_4 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.production_qs_4 }}</td>
                    <td>{{ singleAuditReport.auditData.production_qs_4_remarks }}</td>
                </tr>
                <tr>
                    <th class="text-right font-weight-bold">
                        Total
                    </th>
                    <td>{{ singleAuditReport.production_qsSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.production_qsSection.totalActualVal }}</td>
                    <td></td>
                </tr>

                <tr>
                    <th class="text-left bg-gray"><u>Safety</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.safety_1 }}
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.safety_1 }}</td>
                    <td>{{ singleAuditReport.auditData.safety_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.safety_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.safety_2 }}</td>
                    <td>{{ singleAuditReport.auditData.safety_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.safety_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.safety_3 }}</td>
                    <td>{{ singleAuditReport.auditData.safety_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.safety_4 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.safety_4 }}</td>
                    <td>{{ singleAuditReport.auditData.safety_4_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">
                        Total
                    </td>
                    <td>{{ singleAuditReport.safetySection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.safetySection.totalActualVal }}</td>
                    <td></td>
                </tr>

                <tr>
                    <th class="text-left bg-gray"><u>Environment and Surrounding condition</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.env_sur_con_1 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_1 }}</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.env_sur_con_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_2 }}</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.env_sur_con_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_3 }}</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.env_sur_con_4 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_4 }}</td>
                    <td>{{ singleAuditReport.auditData.env_sur_con_4_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">
                        Total
                    </td>
                    <td>{{ singleAuditReport.env_sur_conSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.env_sur_conSection.totalActualVal }}</td>
                    <td></td>
                </tr>

                <tr>
                    <th class="text-left bg-gray"><u>Machinery Equipment</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.equipment_1 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.equipment_1 }}</td>
                    <td>{{ singleAuditReport.auditData.equipment_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.equipment_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.equipment_2 }}</td>
                    <td>{{ singleAuditReport.auditData.equipment_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.equipment_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.equipment_3 }}</td>
                    <td>{{ singleAuditReport.auditData.equipment_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">
                        Total
                    </td>
                    <td>{{ singleAuditReport.equipmentSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.equipmentSection.totalActualVal }}</td>
                    <td></td>
                </tr>

                <tr>
                    <th class="text-left bg-gray"><u>To cooperate with the company</u></th>
                    <td class="bg-gray"></td>
                    <td class="bg-gray"></td>
                    <td class=" bg-gray"></td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.cooperate_1 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.cooperate_1 }}</td>
                    <td>{{ singleAuditReport.auditData.cooperate_1_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.cooperate_2 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.cooperate_2 }}</td>
                    <td>{{ singleAuditReport.auditData.cooperate_2_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-left">{{ templateData.cooperate_3 }}</td>
                    <td>4</td>
                    <td>{{ singleAuditReport.auditData.cooperate_3 }}</td>
                    <td>{{ singleAuditReport.auditData.cooperate_3_remarks }}</td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">
                        Total
                    </td>
                    <td>{{ singleAuditReport.cooperateSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.cooperateSection.totalActualVal }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">Sum Total</td>
                    <td>{{ singleAuditReport.sumOfSectionMaxVal }}</td>
                    <td>{{ singleAuditReport.sumOfSectionActualVal }}</td>
                    <td rowspan="2"></td>
                </tr>
                <tr>
                    <td class="text-right font-weight-bold">Average %</td>
                    <td colspan="2">{{ singleAuditReport.avgSectionPercentageVal.toFixed(2) }} %</td>
                </tr>
            </table>
        </div>

        <div class="table-responsive mt-2">
            <table class="text-center table_posts table table-bordered">
                <tr>
                    <td rowspan="2" class="pt-4">Assesment topics</td>
                    <td colspan="3">Point</td>
                </tr>
                <tr>
                    <td class="th_bg">Full</td>
                    <td class="th_bg">Actually</td>
                    <td class="th_bg ">%</td>
                </tr>
                <tr>
                    <td class="text-left">1. Place of production and storage location</td>
                    <td>{{ singleAuditReport.storageSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.storageSection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.storageSection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-left">2. Production planning/ control product quality and service
                    </td>
                    <td>{{ singleAuditReport.production_qsSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.production_qsSection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.production_qsSection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-left">3. Safety</td>
                    <td>{{ singleAuditReport.safetySection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.safetySection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.safetySection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-left">4. Environment</td>
                    <td>{{ singleAuditReport.env_sur_conSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.env_sur_conSection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.env_sur_conSection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-left">5. Machinery Equipment</td>
                    <td>{{ singleAuditReport.equipmentSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.equipmentSection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.equipmentSection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-left">6. To Operate with the company</td>
                    <td>{{ singleAuditReport.cooperateSection.totalMaxVal }}</td>
                    <td>{{ singleAuditReport.cooperateSection.totalActualVal }}</td>
                    <td>{{ singleAuditReport.cooperateSection.avgSectionVal }} %</td>
                </tr>
                <tr>
                    <td class="text-right">Total</td>
                    <td>{{ singleAuditReport.sumOfSectionMaxVal }}</td>
                    <td>{{ singleAuditReport.sumOfSectionActualVal }}</td>
                    <td>{{ singleAuditReport.avgSectionPercentageVal.toFixed(2) }} %</td>
                </tr>
            </table>

        </div>


    </div>

    <div v-else>
        <div v-if="singleAuditDtaLoading" class="p-5 my-5">
            <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
        </div>
    </div>

</template>

<script>
    export default {

        props: ['audit_id'],

        data() {

            return {

                // current page url
                currentUrl: '/ivca/admin/reports/manufacturer',

                auditData: {},
                templateData: {},
                singleAuditReport: '',
                singleAuditReportShow: false,
                singleAuditDtaLoading: true,

                pdfDownLoading: false,

                // exportLoading
                exportLoading: false,


            }
        },

        methods: {

            // singleAuditData
            singleAuditData(auditId) {
                axios.get(this.currentUrl + '/single_audit_data/' + auditId).then(response => {
                    console.log(response.data)

                    if (response.data.singleAuditReport.auditData.status == 1) {
                        this.templateData = response.data.templateData;
                        this.singleAuditReport = response.data.singleAuditReport;
                        this.auditData = response.data.singleAuditReport.auditData;
                        // data loading off
                        this.singleAuditDtaLoading = false;
                        this.singleAuditReportShow = true;
                      
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Audit not completed !!',
                        })
                    }



                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Somthing going wrong !!',
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
                        url: this.currentUrl+'/pdf/download/'+ this.audit_id,
                        responseType: 'blob', // important
                    }).then((response) => {

                        console.log(response.data)
                        //stop Loading
                        this.pdfDownLoading = false

                        if( response.status == 200 ){
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            let fileName = this.auditData.vendor.vendor_number+'-audit.pdf' 
                            link.setAttribute('download', fileName);
                            document.body.appendChild(link);
                            link.click();
                            
                       }else{
                           this.$refs['data_view_modal'].hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error !!',
                                text: 'Data Not Found !!'
                            })
                        }
                        
                    }).catch( error=>{
                        this.$refs['data_view_modal'].hide();
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
                    url: this.currentUrl + '/export_single_audit_data/' + this.audit_id,

                    responseType: 'blob', // important
                }).then((response) => {

                    if (response.status == 200) {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        let fileName = this.auditData.vendor.vendor_number + '-audit.xlsx'
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
            // console.log('audit_id', this.audit_id)
            this.singleAuditData(this.audit_id);
        }


    }

</script>
