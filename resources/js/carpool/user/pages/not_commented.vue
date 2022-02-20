<template>
    <div>
        <div v-if="commentData.length > 0">
            <v-card v-for="singleData in commentData" :key="singleData.id" class="my-5">
                <v-card-text>
                    <v-row>
                        <v-col md="5">
                            <v-img v-if="singleData.car" :src="imagePath + singleData.car.image" max-height="250" class="rounded-lg" @click="carDetails(singleData.car)" style="cursor:pointer"></v-img>
                        </v-col>

                        <v-col md="7">
                            <div class="d-flex justify-content-between align-center flex-wrap">
                                <div v-if="singleData.car">
                                    <v-btn @click="carDetails(singleData.car)" depressed text color="indigo">
                                        {{singleData.car.name}} || {{singleData.car.number}}
                                    </v-btn>
                                </div>

                                <div> 
                                    <v-badge :content="`Booked For `+ durationCal(singleData.start, singleData.end)+ ` Hours`" inline></v-badge>
                                </div>
                            </div>

                            <v-col cols="12">Destination : {{singleData.destination}}</v-col>
                            <v-col cols="12">Purpose : {{singleData.purpose}}</v-col>
                            <v-col cols="12">{{singleData.start}} -- To -- {{singleData.end}} </v-col>

                            <v-btn block color="teal white--text" @click="comment(singleData.id)">Comment</v-btn>
                            
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </div>

        

        <div v-else>
            <div v-if="dataLoading" class="p-5 my-5">
                <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                    </v-icon>
                </p>
            </div>
        </div>

        <h1 v-if="!dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>



        <!-- comment data modal -->

        <v-dialog v-model="dataModalDialog" max-width="700px">
            <v-card>
                <v-card-title justify-center>
                    <v-row>
                        <v-col cols="10">
                            Put Car Using Data
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1 white--text" small class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>

                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form >
                        
                            <v-row class="mb-5">
                                <v-col cols="12" md="6">
                                    <v-text-field label="Start Mileage" type="number" v-model="form.start_mileage" @input="validate(0)" :rules="firstValidation"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="End Mileage" type="number" v-model="form.end_mileage" @input="validate(1)" :rules="secondValidation"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="CNG Bill" type="number" v-model="form.gas"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="Octane Bill" type="number" v-model="form.octane"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Toll Bill" type="number" v-model="form.toll"></v-text-field>
                                </v-col>
                                <v-col cols="12" class="text-center">
                                    <span class="h5"> Give Rating </span>
                                    <v-rating
                                    v-model="form.driver_rating"
                                    background-color="teal lighten-3"
                                    color="teal"
                                    large
                                    ></v-rating>
                                </v-col>
                            </v-row>

                            <v-btn color="indigo" @click="updateData(1)">Update</v-btn>
                            <v-btn class="float-right" color="error" @click="updateData(2)">Close Permanently</v-btn>

                        </form>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>





        <!-- car details -->
        <car-details-action v-if="currentCarId" :currentCarId="currentCarId" :key="leaveActionKey" ></car-details-action>



    </div>
</template>


<script>
import Form from 'vform';
import carDetails from './car-details';

export default {
    components:{
        "car-details-action":carDetails
    },
    data(){
        return{
            // form valid
            valid: false,

            // loading data
            dataLoading: false,

            // modal
            dataModalDialog: false,

            // car details dialog
            carDetailsDialog: false,

            imagePath: '/images/carpool/car/',
            imagePathSm: '/images/carpool/car/small/',
            
            currentUrl:'/carpool/comment',

            // fetch uncommented car data
            commentData:{},

            // validation
            firstValidation: [true],
            secondValidation: [true],

            form: new Form({
                id:'',
                start_mileage: null,
                end_mileage: null,
                gas: null,
                octane: null,
                toll: null,
                driver_rating: null
            }),



            // car details
            currentCarId: '',
            leaveActionKey:0,

        }
    },
    methods:{
        
        getCarData(){
            this.dataLoading = true;

            axios.get(this.currentUrl + '/index' ).then(response => {
            
                this.commentData = response.data
                // this.carNotCommented();
                
                

            }).catch(error => {
                console.log(error)
            })
        },

        comment(id){


            this.form.id = id;

            this.dataModalDialog = true;

            axios.get(this.currentUrl + '/prev_comment/' + id ).then(response => {
            
                this.form.fill(response.data)
                console.log(response.data);

            }).catch(error => {
                console.log(error)
            })
        },


        

        // validate input mileage
        validate(index) {
            if(this.form.end_mileage != null){
                const valid = (this.form.start_mileage - this.form.end_mileage) < 0
                if (valid) {
                    this.firstValidation = [true];
                    this.secondValidation = [true];
                    return;
                }
                if (index > 0)
                    this.secondValidation = ["Must be greater than Start Mileage"];
                else
                    this.firstValidation = ["Must be less than End Mileage"];

            }
            
        },


         // Update data
        updateData(val) {
            
            // check if close permanent
            if(val==2){

                if(this.form.start_mileage == null || this.form.end_mileage == null || this.form.gas == null || this.form.octane == null || this.form.toll == null){
                    Swal.fire({
                        icon: 'error',
                        title: 'Field is required',
                        customClass: 'text-danger'
                    });
                    return false
                }

            }

           
            
            // request send and get response
            this.form.put(this.currentUrl + '/update_comment?id=' + this.form.id +
                '&submit=' + val 
                ).then(response=>{
                    this.getCarData();
                // Input field make empty
                this.form.reset();
                // Hide model
                this.dataModalDialog = false;
              
                // carNotCommented
                this.carNotCommented();
                //location.reload();
    
                Toast.fire({
                    icon: response.data.icon,
                    title: response.data.msg
                });

            }).catch((data) => {
                // Loading Animation
                this.dataModalLoading = false
                Swal.fire({
                    icon: 'error',
                    title: 'Somthing Going Wrong<br>'+data.message,
                    customClass: 'text-danger'
                });
                //Swal.fire("Failed!", data.message, "warning");
            });
       
        
        },



        carDetails(val) {
            this.leaveActionKey++
            this.currentCarId = val
        },



        // duration cal
        durationCal(time1, time2){
            let now  = time1;
            let then = time2;

            let duration = this.$moment.utc(this.$moment(now,"YYYY/MM/DD HH:mm:ss").diff(this.$moment(then,"YYYY/MM/DD HH:mm:ss"))).format("HH") ;

            return duration

        }
  

        
        
    },


    created(){
        this.$Progress.start();

        this.getCarData();

        this.$Progress.finish();
    }
}
</script>

<style scoped>
a:hover{
    text-decoration: none;
}
</style>