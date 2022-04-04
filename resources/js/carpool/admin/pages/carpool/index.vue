<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Carpool Car's Table
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="10"  small outlined
                            class="float-right">
                            <v-icon small>mdi-card-plus</v-icon> Add
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    Images
                                </th>
                                <th>
                                    Car Details
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <img v-if="singleData.image"
                                    :src="imagePathSm + singleData.image" alt="image" class="m-1" height="100" width="100">
                                    <img v-if="singleData.image2"
                                    :src="imagePathSm + singleData.image2" alt="image" class="m-1" height="100" width="100">
                                    <img v-if="singleData.image3"
                                    :src="imagePathSm + singleData.image3" alt="image" class="m-1" height="100" width="100">

                                </td>
                                <td>
                                    <div v-if="singleData.name">
                                        <b>Car Name:</b> {{ singleData.name}}
                                    </div>
                                    <div v-if="singleData.number">
                                        <b>Car Number:</b> {{ singleData.number}}
                                    </div>
                                    <div v-if="singleData.capacity">
                                        <b>Capacity:</b> {{ singleData.capacity}}
                                    </div>
                                    <div v-if="singleData.temporary==1">
                                        <b>Car Type:</b> Temporary

                                        <v-btn depressed small color="indigo white--text" class="d-flex flex-end" @click="temporaryChange(singleData)">
                                            <v-icon small>mdi-check</v-icon> Temporary
                                        </v-btn>

                                    </div>
                                    <div v-if="singleData.temporary==0">
                                        <b>Car Type:</b> Regular

                                        <v-btn depressed small color="cyan white--text" class="d-flex flex-end" @click="temporaryChange(singleData)">
                                            <v-icon small>mdi-check</v-icon> Regular
                                        </v-btn>
                                    </div>
                                    <div v-if="singleData.remarks">
                                        <b>Remarks</b> {{ singleData.remarks}}
                                    </div>
                                    <div v-if="singleData.last_use">
                                        <b>Use Deadline:</b> {{ singleData.last_use}}
                                        <v-btn depressed small color="blue-grey white--text" class="d-flex flex-end" @click="deadlineClear(singleData.id)">
                                            <v-icon small>mdi-close</v-icon> Clear Deadline
                                        </v-btn>
                                    </div>
                                </td>
                               
                        
                                <td class="text-center">
                                    
                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="success" depressed small class="m-1">
                                        <v-icon left>mdi-check-circle-outline</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" color="warning" depressed small class="m-1">
                                        <v-icon left>mdi-alert-circle-outline </v-icon> Inactive
                                    </v-btn>
                                    
                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small class="m-1">
                                        <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteDataTemp(singleData.id)" color="error" depressed small class="m-1">
                                        <v-icon left>mdi-delete-empty</v-icon> Delete
                                    </v-btn>

                                    <v-btn depressed small color="grey white--text" @click="deadlineModal(singleData)" class="m-1">
                                        <v-icon left>mdi-plus-circle-outline</v-icon> Deadline
                                    </v-btn>

                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By-- {{ singleData.makby.name }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults" class="justify-content-end">
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
        <v-dialog persistent v-model="dataModalDialog" max-width="1100px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            <span v-if="editmode">Update Car Information</span>
                            <span v-else>Add New Car Information</span>
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false, resetForm()" color="red lighten-1 white--text" small
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
                                <v-col md="6" cols="12">
                                    <div class="text-danger" v-if="form.errors.has('number')" v-html="form.errors.get('number')" />
                                    <v-text-field v-model="form.number" label="Enter Car Number" :rules="carRules" required></v-text-field>
                                </v-col>

                                <v-col md="6" cols="12">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Enter Car Name" :rules="carRules" required></v-text-field>
                                </v-col>
                            </v-row>
                            
                            <v-row>
                                <v-col cols="12" md="6">
                                    <div class="text-danger" v-if="form.errors.has('remarks')" v-html="form.errors.get('remarks')" />
                                    <v-textarea outlined rows="2" v-model="form.remarks" label="Enter Car Details" ></v-textarea>
                                </v-col>

                                
                                
                                <v-col cols="12" md="6">
                                    <div class="text-danger" v-if="form.errors.has('capacity')" v-html="form.errors.get('capacity')" />
                                    <v-text-field type="number" v-model="form.capacity" label="Enter Car capacity" :rules="carRules" required></v-text-field>
                                </v-col>

                                

                                <v-col md="6" cols="12">
                                    <div class="text-danger" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                                    <v-select label="Car Status (Default Active)" v-model="form.status" :items="statusOptions" :rules="carRulesOption" required>
                                    </v-select>
                                </v-col>
                                <v-col md="6" cols="12">
                                    <div class="text-danger" v-if="form.errors.has('temporary')" v-html="form.errors.get('temporary')" />
                                    <v-select label="Car Type" v-model="form.temporary" :items="typeOptions" :rules="carRulesOption" required>
                                    </v-select>
                                </v-col>
 
                            </v-row>


                            <v-row>
                                <!-- Image 1 -->
                                <v-col md="4">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'image')"
                                            label="Choose 1st Image" accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                </v-col>
                                <!-- Image 2 -->
                                <v-col md="4">
                                        <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'image2')"
                                            label="Choose 2nd Image" accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                </v-col>
                                <!-- Image 2 -->
                                <v-col md="4">
                                    <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'image3')"
                                        label="Choose 3rd Image" accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>
                            </v-row>

                            <v-row class="mb-2">
                                <v-col md="4">
                                    <img :src="showImageByName('image')" class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                                <v-col md="4">
                                    <img :src="showImageByName('image2')" class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                                <v-col md="4">
                                    <img :src="showImageByName('image3')" class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="dataModalLoading" color="primary"><v-icon>mdi-edit</v-icon> Update</v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="dataModalLoading" color="primary"><v-icon>mdi-save</v-icon> Create</v-btn>
                            
                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- mdoal car deadline -->
        <v-dialog persistent v-model="deadlineDialog" max-width="600px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Car Deadline
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="deadlineDialog = false,resetForm()" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="createDeadlineData()">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field label="Car Name" v-model="form.name" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="Car Name" v-model="form.number" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-menu v-model="menu" min-width="auto" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                            v-model="form.last_use"
                                            label="Enter Last Use Date"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                            :rules="carRules" required
                                            ></v-text-field>
                                        </template>

                                        <v-date-picker v-model="form.last_use" no-title scrollable >
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                            </v-col>
                                <v-btn type="submit" block depressed :loading="addCarpoolLoader" color="primary"><v-icon>mdi-edit</v-icon> Save</v-btn>
                            </v-row>
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

                // calendar
                menu:"false",
                date:'',

                // v-form
                valid:false,
                // dialog
                dataModalDialog:false,
                deadlineDialog: false,

                // loader
                addCarpoolLoader:false,

                carRules:[v => !!v || 'This field is required!'],

                carRulesOption:[
                    v => v==0 || v==1 || 'This field is required!'
                ],

                //current page url
                //currentUrl: '/room/admin/room',

                currentUrl: '/carpool/admin/car',

                activeOptions: [
                    { text: 'Yes', value: 1 },
                    { text: 'No', value: 0 },
                ],

              
                // Form
                form: new Form({
                    id: '',
                    name: '',
                    number: '',
                    remarks: '',
                    capacity: '',
                    status: 1,
                    temporary: '',
                    image: '',
                    image2: '',
                    image3: '',
                    last_use: ''

                }),

                imageMaxSize: '5111775',
                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/',


                // statusOptions
                statusOptions: [
                    {
                        value: 1,
                        text: 'Active'
                    },
                    {
                        value: 0,
                        text: 'Inactive'
                    },
                ],

                // typeOptions
                typeOptions: [
                    {
                        value: 1,
                        text: 'Regular'
                    },
                    {
                        value: 0,
                        text: 'Temporary'
                    },
                ],

            }


        },

        methods: {


        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>

<style scoped>
    .image-thum-size{
        height: 50px;
        width: 100px;
    }
</style>
