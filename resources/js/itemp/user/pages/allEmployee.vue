<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Employees Data 
                    </v-col>
                    <v-col cols="2">
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-inner-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..." outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Department
                                </th>
                                <th>
                                    Temparature
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    {{singleData.id_number}}

                                </td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.department }}</td>
                                <td>
                                    <span v-if="singleData.temp">
                                        <span v-if="singleData.temp.temp_final > 100">
                                            <v-btn class="error">{{singleData.temp.temp_final}}</v-btn>
                                        </span>

                                        <span v-else>
                                            <v-btn class="success">{{singleData.temp.temp_final}}</v-btn>
                                        </span>
                                    </span>

                                    <span v-else class="error--text">Not Available</span>
                                </td>


                                <td class="text-center">

                                    <v-btn @click="addDataModel(singleData)" color="info" depressed small>
                                        <v-icon small>mdi-plus</v-icon> Add Temp
                                    </v-btn>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults"
                        class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>






        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="600px" persistent>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false,resetForm()" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row>
                                
                                <v-col cols="12">
                                    <v-text-field v-model="form.today_temp" label="Enter Today Temparature" :rules="allRules" required outlined dense></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-select v-model="form.checkPoint" label="Choose Check Point" item-text="name" item-value="name" :items="checkPoint" :rules="allRules" outlined dense></v-select>
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea v-model="form.remarks_all" label="Remarks if any" outlined dense></v-textarea>
                                </v-col>

                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="additemp" color="primary"><v-icon>mdi-edit</v-icon> Update</v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="additemp" color="primary"><v-icon>mdi-save</v-icon> Create</v-btn>
                            

                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>



    </div>

</template>


<script>
// vform
import Form from 'vform';

export default {

    data() {

        return {
            //current page url
            currentUrl: '/itemp/all-employee',

            // dialog
            dataModalDialog:false,

            // loader
            additemp:false,

            allRules:[v => !!v || 'This field is required!'],

            // Form
            form: new Form({
                id: '',
                id_number: '',
                name: '',
                department: '',
                today_temp: '',
                checkPoint: '',
                remarks_all: '',

            }),


            checkPoint: [],

        }


    },

    methods: {


        // get all checkpoint data
        getCheckpointData() {
            axios.get(this.currentUrl + '/check_point').then(response => {

                this.checkPoint = response.data;

            }).catch(error => {
                console.log(error)
            })
        },



        // Add Data Model
        addDataModel(data) {

            this.form.id = data.id;
            this.form.id_number = data.id_number;
            this.form.name = data.name;
            this.form.department = data.department;

            this.form.fill(data);
            this.editmode = false;
            //this.$refs['data-modal'].show();
            this.dataModalDialog = true;
        },



    },

    mounted(){

        this.getCheckpointData();

    },


    created() {
        this.$Progress.start();
        // Fetch initial results
        this.getResults();
        this.$Progress.finish();
    },



}

</script>

<style scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
