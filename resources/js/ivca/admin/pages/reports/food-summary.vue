<template>

  <div class="card p-2">
          <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    Food Audit Report :
                </div>
                <div class="col-md-6">
                        
                    <v-btn v-if="!pdfDownLoading" @click="downloadPdf()" color="error" small> <v-icon>mdi-file-document-outline </v-icon> Download PDF</v-btn>
                    <v-btn v-else color="success" small><v-icon>mdi-download-circle-outline</v-icon> Downloading ..</v-btn>

                    <!-- v-if="isAdministrator()" -->
                    <a  :href="currentUrl+'/pdf/view/'+audit_id" class="btn btn-sm mr-2" target="_blank">PDF View</a>

                    <v-btn outlined elevation="5" small @click="exportExcel()" :loading="exportLoading">
                        <v-icon left color="success">mdi-file-excel</v-icon>
                        Export
                    </v-btn>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between my-2">
            <div>
                CP Food (Bangladesh) Co., Ltd.
            </div>
            <div>
                QC Department
            </div>
        </div>

        <div>


            <div class="text-center font-weight-bold mb-1">
                PREMISE AUDIT CHECKLIST
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>Name of Organization</td>
                        <td><span v-if="auditData.vendor">{{ auditData.vendor.vendor_number }} - {{ auditData.vendor.suppier_name }}</span></td>
                        <td>
                            <div>Audit Date: {{ auditData.date }}</div>
                            <div>Time: {{ auditData.created_at | moment("MMM Do YYYY, h:mm a") }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Types of Business</td>
                        <td v-if="auditData.schedule">{{ auditData.schedule.business_type }}</td>
                        
                        <td>Purchased Product:
                        <span v-if="auditData.schedule">{{ auditData.schedule.purchased_product }}</span></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td v-if="auditData.vendor">{{ auditData.vendor.address }}</td>
                        <td>Auditor(s): <span v-if="auditData.auditordata">{{ auditData.auditordata.name }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- 1. Building & facilities (Total Score 10 points) -->
        <div>
            <div class="font-weight-bold">1. Building & facilities (Total Score 10 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>

                    <tr>
                        <td>{{ templateData.building_facilities_a }}</td>
                        <td><img v-if="auditData.building_facilities_a_image"
                                    :src="auditData.imglgpath + auditData.building_facilities_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.building_facilities_a }}</b> <hr>
                            {{ auditData.building_facilities_a_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.building_facilities_b }}</td>
                        <td><img v-if="auditData.building_facilities_b_image"
                                    :src="auditData.imglgpath + auditData.building_facilities_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.building_facilities_b }}</b> <hr>
                            {{ auditData.building_facilities_b_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.building_facilities_c }}</td>
                        <td><img v-if="auditData.building_facilities_c_image"
                                    :src="auditData.imglgpath + auditData.building_facilities_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.building_facilities_c }}</b> <hr>
                            {{ auditData.building_facilities_c_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.building_facilities_d }}</td>
                        <td><img v-if="auditData.building_facilities_d_image"
                                    :src="auditData.imglgpath + auditData.building_facilities_d_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.building_facilities_d }}</b> <hr>
                            {{ auditData.building_facilities_d_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.building_facilities_e }}</td>
                        <td><img v-if="auditData.building_facilities_e_image"
                                    :src="auditData.imglgpath + auditData.building_facilities_e_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.building_facilities_e }}</b> <hr>
                            {{ auditData.building_facilities_e_remarks }}
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- 2. Equipment (Total Score 6 points) -->
        <div>
            <div class="font-weight-bold">2. Equipment (Total Score 6 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>
                    <tr>
                        <td>{{ templateData.equipment_a }}</td>
                        <td><img v-if="auditData.equipment_a_image"
                                    :src="auditData.imglgpath + auditData.equipment_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.equipment_a }}</b> <hr>
                            {{ auditData.equipment_a_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.equipment_b }}</td>
                        <td><img v-if="auditData.equipment_b_image"
                                    :src="auditData.imglgpath + auditData.equipment_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.equipment_b }}</b> <hr>
                            {{ auditData.equipment_b_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.equipment_c }}</td>
                        <td><img v-if="auditData.equipment_c_image"
                                    :src="auditData.imglgpath + auditData.equipment_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.equipment_c }}</b> <hr>
                            {{ auditData.equipment_c_remarks }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- 3. Personnel (Total Score 6 points) -->
        <div>
            <div class="font-weight-bold">3. Personnel (Total Score 6 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                     <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>
                    <tr>
                        <td>{{ templateData.personnel_a }}</td>
                        <td><img v-if="auditData.personnel_a_image"
                                    :src="auditData.imglgpath + auditData.personnel_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.personnel_a }}</b> <hr>
                            {{ auditData.personnel_a_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.personnel_b }}</td>
                        <td><img v-if="auditData.personnel_b_image"
                                    :src="auditData.imglgpath + auditData.personnel_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.personnel_b }}</b> <hr>
                            {{ auditData.personnel_b_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.personnel_c }}</td>
                        <td><img v-if="auditData.personnel_c_image"
                                    :src="auditData.imglgpath + auditData.personnel_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.personnel_c }}</b> <hr>
                            {{ auditData.personnel_c_remarks }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- 4. Raw materials (Total Score 10 points) -->
        <div>
            <div class="font-weight-bold">4. Raw materials (Total Score 10 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>

                    <tr>
                        <td>{{ templateData.raw_materials_a }}</td>
                        <td><img v-if="auditData.raw_materials_a_image"
                                    :src="auditData.imglgpath + auditData.raw_materials_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.raw_materials_a }}</b> <hr>
                            {{ auditData.raw_materials_a_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.raw_materials_b }}</td>
                        <td><img v-if="auditData.raw_materials_b_image"
                                    :src="auditData.imglgpath + auditData.raw_materials_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.raw_materials_b }}</b> <hr>
                            {{ auditData.raw_materials_b_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.raw_materials_c }}</td>
                        <td><img v-if="auditData.raw_materials_c_image"
                                    :src="auditData.imglgpath + auditData.raw_materials_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.raw_materials_c }}</b> <hr>
                            {{ auditData.raw_materials_c_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.raw_materials_d }}</td>
                        <td><img v-if="auditData.raw_materials_d_image"
                                    :src="auditData.imglgpath + auditData.raw_materials_d_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.raw_materials_d }}</b> <hr>
                            {{ auditData.raw_materials_d_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.raw_materials_e }}</td>
                        <td><img v-if="auditData.raw_materials_e_image"
                                    :src="auditData.imglgpath + auditData.raw_materials_e_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.raw_materials_e }}</b> <hr>
                            {{ auditData.raw_materials_e_remarks }}
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- 5. Production (Total Score 12 points) -->
        <div>
            <div class="font-weight-bold">5. Production (Total Score 12 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_a }}</td>
                        <td><img v-if="auditData.production_a_image"
                                    :src="auditData.imglgpath + auditData.production_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_a }}</b> <hr>
                            {{ auditData.production_a_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_b }}</td>
                        <td><img v-if="auditData.production_b_image"
                                    :src="auditData.imglgpath + auditData.production_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_b }}</b> <hr>
                            {{ auditData.production_b_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_c }}</td>
                        <td><img v-if="auditData.production_c_image"
                                    :src="auditData.imglgpath + auditData.production_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_c }}</b> <hr>
                            {{ auditData.production_c_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_d }}</td>
                        <td><img v-if="auditData.production_d_image"
                                    :src="auditData.imglgpath + auditData.production_d_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_d }}</b> <hr>
                            {{ auditData.production_d_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_e }}</td>
                        <td><img v-if="auditData.production_e_image"
                                    :src="auditData.imglgpath + auditData.production_e_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_e }}</b> <hr>
                            {{ auditData.production_e_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.production_f }}</td>
                        <td><img v-if="auditData.production_f_image"
                                    :src="auditData.imglgpath + auditData.production_f_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.production_f }}</b> <hr>
                            {{ auditData.production_f_remarks }}
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- 6. Records (Total Score 8 points) -->
        <div>
            <div class="font-weight-bold">6. Records (Total Score 8 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>

                    <tr>
                        <td>{{ templateData.records_a }}</td>
                        <td><img v-if="auditData.records_a_image"
                                    :src="auditData.imglgpath + auditData.records_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.records_a }}</b> <hr>
                            {{ auditData.records_a_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.records_b }}</td>
                        <td><img v-if="auditData.records_b_image"
                                    :src="auditData.imglgpath + auditData.records_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.records_b }}</b> <hr>
                            {{ auditData.records_b_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.records_c }}</td>
                        <td><img v-if="auditData.records_c_image"
                                    :src="auditData.imglgpath + auditData.records_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.records_c }}</b> <hr>
                            {{ auditData.records_c_remarks }}
                        </td>
                    </tr>

                    <tr>
                        <td>{{ templateData.records_d }}</td>
                        <td><img v-if="auditData.records_d_image"
                                    :src="auditData.imglgpath + auditData.records_d_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.records_d }}</b> <hr>
                            {{ auditData.records_d_remarks }}
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- 7. Labelings (Total Score 6 points) -->
        <div>
            <div class="font-weight-bold">7. Labelings (Total Score 6 points)</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                     <tr>
                        <th class="text-center">Audit Guidelines</th>
                        <th class="text-center">Evidence</th>
                        <th class="Text-Center">Note</th>
                    </tr>
                    <tr>
                        <td>{{ templateData.labeling_a }}</td>
                        <td><img v-if="auditData.labeling_a_image"
                                    :src="auditData.imglgpath + auditData.labeling_a_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.labeling_a }}</b> <hr>
                            {{ auditData.labeling_a_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.labeling_b }}</td>
                        <td><img v-if="auditData.labeling_b_image"
                                    :src="auditData.imglgpath + auditData.labeling_b_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.labeling_b }}</b> <hr>
                            {{ auditData.labeling_b_remarks }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ templateData.labeling_c }}</td>
                        <td><img v-if="auditData.labeling_c_image"
                                    :src="auditData.imglgpath + auditData.labeling_c_image" alt="image" class="img-fluid evidence"></td>
                        <td>
                            Get Point: <b>{{ auditData.labeling_c }}</b> <hr>
                            {{ auditData.labeling_c_remarks }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            <div class="font-weight-bold">Group Image</div>
            
            <img v-if="auditData.group_image" :src="auditData.imglgpath + auditData.group_image" alt="image" class="img-fluid evidence">
        </div>

        <!-- <div class="d-flex justify-content-between">
            <div class="d-flex flex-column align-items-center">
                <div class="font-weight-bold">Auditee Name:</div>
                <div>.............................................</div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <div class="font-weight-bold">Auditors:</div>
                <div>.............................................</div>
            </div>
        </div> -->


    </div>

</template>

<script>
    export default {

        data() {

            return {

                // current page url
                currentUrl: '/ivca/admin/reports/food',

                auditData: {},
                templateData: {},
                audit_id:this.$route.query.id,

                pdfDownLoading: false,

                // exportLoading
                exportLoading: false,


            }
        },

        methods: {

            // auditData
            getaAuditData() {
                axios.get(this.currentUrl + '/food_summery/' + this.audit_id).then(response => {
                    //console.log(response.data.auditData)

                    this.templateData = response.data.templateData;
                    this.auditData = response.data.auditData;
                      
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
                    url: this.currentUrl + '/export_summary_audit_data/' + this.audit_id,
                    responseType: 'blob', // important
                    
                }).then((response) => {

                    if (response.status == 200) {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        let fileName = this.auditData.vendor.vendor_number+'-audit.xlsx' 
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
            // Fetch initial results
            this.getaAuditData();
            this.$Progress.finish();
            // console.log('audit_id', this.audit_id)
            
        }


    }

</script>


<style scoped>

    .evidence {
        height: 150px;
        width: 500px
    }
   
</style>
