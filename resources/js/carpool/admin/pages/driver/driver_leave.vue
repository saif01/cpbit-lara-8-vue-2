<template>
    <div>
        <v-dialog persistent v-model="driverLeaveDilog" max-width="800">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Diver Leave Action
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="driverLeaveDilog = false, resetForm()" elevation="20" color="error white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <v-row v-if="currentCarDriver">
                        <v-col cols="3">
                            <v-img v-if="currentCarDriver.car.image" :src="imagePathSm + currentCarDriver.car.image"
                                alt="image" max-height="100px" class="rounded-lg"></v-img>
                        </v-col>
                        <v-col cols="3" class="small">
                            <span v-if="currentCarDriver.car.name">
                                <b>Name:</b> {{ currentCarDriver.car.name}}
                            </span>
                            <br>
                            <span v-if="currentCarDriver.car.number">
                                <b>Number:</b> {{ currentCarDriver.car.number}}
                            </span><br>
                            <span v-if="currentCarDriver.car.capacity">
                                <b>Capacity:</b> {{ currentCarDriver.car.capacity}}
                            </span><br>
                            <span v-if="currentCarDriver.car.temporary==0">
                                <b>Type:</b> Temporary
                            </span><br>
                            <span v-if="currentCarDriver.car.temporary==1">
                                <b>Type:</b> Regular
                            </span>
                        </v-col>
                       
                        <v-col cols="3">
                            <v-img v-if="currentCarDriver.image" :src="imagePathSmDriver + currentCarDriver.image" alt="image" max-height="100px" class="rounded-lg"></v-img> 
                        </v-col>
                        <v-col cols="3" class="small">
                             <span v-if="currentCarDriver.name">
                                <b>Name:</b> {{ currentCarDriver.name}}
                            </span><br>
                            <span v-if="currentCarDriver.contact">
                                <b>Number:</b> {{ currentCarDriver.contact}}
                            </span><br>
                            <span v-if="currentCarDriver.license">
                                <b>License:</b> {{ currentCarDriver.license}}
                            </span><br>
                            <span v-if="currentCarDriver.nid">
                                <b>NID:</b> {{ currentCarDriver.nid}}
                            </span>
                        </v-col>
                       
                    </v-row>

                    <v-form v-model="valid">
                        <form @submit.prevent="storeData()">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <!-- start_date -->
                                    <div class="text-danger" v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
                                    <v-menu v-model="menu" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_date" label="Start Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="[v => !!v || 'Start date is required!']" required >
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_date')"
                                                v-html="form.errors.get('start_date')" />
                                        </template>

                                        <v-date-picker v-model="form.start_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false"> Cancel</v-btn>
                                            <v-btn text color="success"> Set Today</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <!-- end_date -->
                                    <div class="text-danger" v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" />
                                    <v-menu v-model="menu2" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_date" :rules="[v => !!v || 'End date is required!']" label="End Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"
                                                required>
                                            </v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_date')"
                                                v-html="form.errors.get('end_date')" />
                                        </template>

                                        <v-date-picker v-model="form.end_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false"> Cancel</v-btn>
                                            <v-btn text color="success">  Set Today </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>


                                <v-col cols="12" md="6">
                                    <!-- start_time -->
                                    <v-menu ref="menu3" v-model="menu3" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start_time" label="Start Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"
                                                id="Start_Time" 
                                                required></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('start_time')"
                                                v-html="form.errors.get('start_time')" />
                                        </template>
                                        <v-time-picker v-if="menu3" v-model="form.start_time" full-width
                                            @click:minute="$refs.menu3.save(time)"></v-time-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu ref="menu4" v-model="menu4" :close-on-content-click="false"
                                        :return-value.sync="time" max-width="290px" min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.end_time" label="End Time"
                                                prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" required></v-text-field>
                                            <div class="small text-danger" v-if="form.errors.has('end_time')"
                                                v-html="form.errors.get('end_time')" />
                                        </template>
                                        <v-time-picker v-if="menu4" v-model="form.end_time" full-width
                                            @click:minute="$refs.menu4.save(time)"></v-time-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12">
                                    <div class="text-danger" v-if="form.errors.has('type')" v-html="form.errors.get('type')" />
                                    <v-select v-model="form.type" :items="leaveTypes" item-text="name" item-value="value" placeholder="Please, Select types" :rules="[v => !!v || 'Leave Type is required!']" required></v-select>
                                </v-col>
                            </v-row>


                            <v-btn type="submit" block color="teal" class="white--text" :loading="dataModalLoading">
                                <v-icon>mdi-fountain-pen-tip</v-icon> Submit
                            </v-btn>

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

    props:['currentCarDriver'],

    data(){
        return{
            driverLeaveDilog: true,

            currentUrl: '/carpool/admin/driver',

            // time and date picker
            menu:  false,
            menu2: false,
            menu3: false,
            menu4: false,
            time: '',

            valid: false,

            loadingLeaveAction: false,

            datePickerHeader: true,

            imageMaxSize: '5111775',
            imagePath: '/images/carpool/car/',
            imagePathSm: '/images/carpool/car/small/',

            imagePathDriver: '/images/carpool/driver/',
            imagePathSmDriver: '/images/carpool/driver/small/',

            leaveTypes:[
                {
                    name: 'Select Leave Type',
                    value: null
                },
                {
                    name: 'Personal Leave',
                    value: 'lev'
                },
                {
                    name: 'Police Requisition',
                    value: 'req'
                },
                {
                    name: 'Car Maintenances',
                    value: 'mant'
                },
            ],

            

            // Form
            form: new Form({
                start_date: '',
                start_time: '00:01:00',
                end_date: '',
                end_time: '23:59:00',
                car_id: '',
                driver_id: '',
                type: '',
            }),
        }
    },

    methods:{

        check(){
            this.form.car_id = this.currentCarDriver.car_id;
            this.form.driver_id = this.currentCarDriver.id;
        },

        storeData(){
            this.dataModalLoading = true

            this.form.post( this.currentUrl + '/store_leave').then(response=>{
                this.$Progress.start();
                this.dataModalLoading = false;
                this.driverLeaveDilog = false;
                
                // Parent to child
                this.$emit('childToParent')

                this.$Progress.finish()
                Swal.fire({
                    icon: response.data.icon,
                    title: response.data.msg,
                });
               

            }).catch(error=>{
                this.dataModalLoading = false;
                console.log(error)
            })



        }

    }, 

    mounted(){
        this.check();
    }


}
</script>