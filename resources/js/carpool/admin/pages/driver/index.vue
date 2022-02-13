<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Carpool Driver's Table
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" small outlined class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
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
                                    Driver Information
                                </th>
                                <th>
                                    Car Information
                                </th>
                                <th>
                                    Driver Status
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <v-hover v-slot="{ hover }">
                                        <v-card class="mx-auto" color="grey lighten-4">
                                            <v-img v-if="singleData.image" :src="imagePathSmDriver + singleData.image" max-height="180" max-width="230">
                                                <v-expand-transition>
                                                    <div v-if="hover" class="transition-fast-in-fast-out teal darken-2 v-card--reveal white--text d-flex flex-column justify-center align-center" style="height: 100%;">

                                                        <div>
                                                            Driver Name: {{ singleData.name}}
                                                        </div>
                                                        <div>
                                                            Driver Number: {{ singleData.contact}}
                                                        </div>
                                                        <div>
                                                            Driver License: {{ singleData.license}}
                                                        </div>
                                                        <div>
                                                            Driver NID:{{ singleData.nid}}
                                                        </div>
                                                        
                                                    </div>
                                                </v-expand-transition>
                                            </v-img>
                                        </v-card>
                                    </v-hover>
                                </td>
                                <td>
                                    <v-hover v-slot="{ hover }">
                                        <v-card class="mx-auto" color="grey lighten-4">
                                            <v-img v-if="singleData.car.image" :src="imagePathSm + singleData.car.image" max-height="180" max-width="230" >
                                                <v-expand-transition>
                                                    <div v-if="hover" class="transition-fast-in-fast-out teal darken-2 v-card--reveal white--text d-flex flex-column justify-center align-center" style="height: 100%;">

                                                        <div v-if="singleData.car.name">
                                                            Car Name: {{ singleData.car.name}}
                                                        </div>
                                                        <div v-if="singleData.car.number">
                                                            Car Number: {{ singleData.car.number}}
                                                        </div>
                                                        <div v-if="singleData.car.capacity">
                                                            Car Capacity: {{ singleData.car.capacity}}
                                                        </div>
                                                        <div v-if="singleData.car.temporary==0">
                                                            Car Type: Temporary
                                                        </div>
                                                        <div v-if="singleData.car.temporary==1">
                                                            Car Type: Regular
                                                        </div>
                                                    </div>
                                                </v-expand-transition>
                                            </v-img>
                                        </v-card>
                                    </v-hover>
                                </td>

                                <td v-if="singleData.leave.length > 0" class="col-3 text-center align-middle">
                                    <div v-for="leave in singleData.leave" :key="leave.id">

                                        <div v-if="leave.type=='lev'">
                                            <b>Leave Type: </b>Personal Leave
                                        </div>
                                        <div v-else-if="leave.type=='req'">
                                            <b>Leave Type: </b>Police Requisition
                                        </div>
                                        <div v-else-if="leave.type=='mant'">
                                            <b>Leave Type: </b>Car in Maintenances
                                        </div>
                                        
                                        <div v-if="leave.start">
                                            <b>From</b> {{ leave.start }} <b>to</b> {{ leave.end }}
                                        </div>

                                    </div>
                                </td>


                                <td v-else class="col-3 text-center align-middle">
                                    <div class="error--text">
                                        Not Available!!
                                    </div>
                                </td>


                                <td class="text-center col-3">
                                    <v-btn @click="driverLeave(singleData)" color="info" depressed small class="m-1">
                                        <v-icon left>mdi-ship-wheel</v-icon> Leave Action
                                    </v-btn>

                                    <v-btn v-if="singleData.car.status" @click="statusChange(singleData.car)"
                                        color="success" depressed small class="m-1">
                                        <v-icon small>mdi-check-circle-outline</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData.car)" color="warning" depressed small class="m-1">
                                        <v-icon small>mdi-alert-circle-outline </v-icon> Inactive
                                    </v-btn>

                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small class="m-1">
                                        <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteDataTemp(singleData.id)" color="error" depressed small class="m-1">
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>

                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By--
                                        {{ singleData.makby.name }}</span>
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>
            </v-card-text>
        </v-card>


        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="1100px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1 white--text" small
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
                                    <v-text-field v-model="form.name" label="Enter Driver Name" :rules="driverRules"
                                        required></v-text-field>
                                </v-col>

                                <v-col md="6" cols="12">
                                    <v-text-field v-model="form.contact" label="Enter Driver Number"
                                        :rules="driverRules" required></v-text-field>
                                </v-col>

                            </v-row>

                            <v-row>

                                <v-col md="6" cols="12">
                                    <v-text-field v-model="form.license" label="Enter Driver License"></v-text-field>
                                </v-col>

                                <v-col md="6" cols="12">
                                    <v-text-field v-model="form.nid" label="Enter Driver NID"></v-text-field>
                                </v-col>

                            </v-row>
                            <v-row>

                                <v-col cols="12" md="6">
                                    <v-select label="Driver Status" v-model="form.status" :items="statusOptions"
                                        :rules="driverRulesOption" required>
                                    </v-select>
                                </v-col>
                                <v-col md="6" cols="12">
                                    <v-select v-model="form.car_id" :items="carData" label="All Cars Data"></v-select>
                                    <!-- <v-text-field v-model="form.status" label="Driver Car" ></v-text-field> -->
                                </v-col>

                            </v-row>


                            <v-row>
                                <!-- Image 1 -->
                                <v-col md="6">
                                    <v-file-input prepend-icon="mdi-camera" show-size
                                        @change="uploadImageByName($event, 'image')" label="Choose an Image"
                                        :rules="imageRules" accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>
                                <v-col md="6">
                                    <img :src="showImageByName('image')"
                                        class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="addCarpoolLoader"
                                color="primary">
                                <v-icon>mdi-edit</v-icon> Update
                            </v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="addCarpoolLoader"
                                color="primary">
                                <v-icon>mdi-save</v-icon> Create
                            </v-btn>


                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- Driver Leave -->
        <driver-leave-action v-if="currentCarDriver" :currentCarDriver="currentCarDriver" :key="leaveActionKey" ></driver-leave-action>



    </div>

</template>


<script>
    // vform
    import Form from 'vform';

    //  leave component
    import driverLeaveAction from './driver_leave.vue'


    export default {
        components:{
            "driver-leave-action": driverLeaveAction,
        },

        data() {

            return {

                // v-form
                valid: false,
                // dialog
                dataModalDialog: false,

                // loader
                addCarpoolLoader: false,

                driverRules: [v => !!v || 'This field is required!'],

                driverRulesOption: [
                    v => v == 0 || v == 1 || 'This field is required!'
                ],

                imageRules: [
                    v => !v || v.size < 2000000 || 'Image size should be less than 2 MB!',
                ],

                //current page url
                //currentUrl: '/room/admin/room',

                currentUrl: '/carpool/admin/driver',

                activeOptions: [{
                        text: 'Yes',
                        value: 1
                    },
                    {
                        text: 'No',
                        value: 0
                    },
                ],


                // Form
                form: new Form({
                    id: '',
                    name: '',
                    contact: '',
                    license: '',
                    nid: '',
                    status: '',
                    image: '',
                    car_id: null

                }),

                imageMaxSize: '5111775',
                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/',

                imagePathDriver: '/images/carpool/driver/',
                imagePathSmDriver: '/images/carpool/driver/small/',


                // statusOptions
                statusOptions: [{
                        value: 1,
                        text: 'Active'
                    },
                    {
                        value: 0,
                        text: 'Inactive'
                    },
                ],


                // all car data
                carData: [],

                // Driver leave
                driverLeaveDilog: false,
                currentCarDriver: '',
                leaveActionKey:0,

            }


        },

        methods: {

            // get all car data
            getCarData() {
                axios.get(this.currentUrl + '/car-data').then(response => {

                    for (let i = 0; i < response.data.length; i++) {
                        this.carData.push(response.data[i]);
                        this.carData[i] = {
                            value: response.data[i].id,
                            text: response.data[i].name + ' || ' + response.data[i].number
                        };

                    }


                }).catch(error => {
                    console.log(error)
                })
            },

            // driverLeave
            driverLeave(val) {
                this.leaveActionKey++
                this.currentCarDriver = val
            },

        },


        mounted() {

            this.getCarData();
        },

        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        }



    }

</script>

<style scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
