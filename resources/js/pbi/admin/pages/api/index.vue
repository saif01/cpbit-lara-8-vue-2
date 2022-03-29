<template>
    <div>
        <v-card class="col-8 m-auto">
            <v-card-title>
                Data store and show
            </v-card-title>
            <v-card-text>
                <form @submit.prevent="action()">

                <v-row>

                    <v-col cols="12" lg="6">
                        <div class="small text-danger" v-if="form.errors.has('start')"
                            v-html="form.errors.get('start')" />
                        <v-menu v-model="menu" min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.start" label="Select Start Date"
                                    prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense>
                                </v-text-field>
                            </template>
                            <v-date-picker v-model="form.start" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu = false">
                                    Cancel
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                        <!-- <v-text-field type="date" dense
                            v-model="form.start" label="Select Start Date"
                            :rules="[v => !!v || 'Select start date is required!']" required></v-text-field> -->
                    </v-col>
                    <v-col cols="12" lg="6">
                        <div class="small text-danger" v-if="form.errors.has('end')"
                            v-html="form.errors.get('end')" />
                        <v-menu v-model="menu2" min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.end" label="Select Start Date"
                                    prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense>
                                </v-text-field>
                            </template>
                            <v-date-picker v-model="form.end" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu2 = false">
                                    Cancel
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                        <!-- <v-text-field type="date" dense
                            v-model="form.end" label="Select End Date"
                            :rules="[v => !!v || 'Select end date is required!']" required></v-text-field> -->
                    </v-col>

                  
                    <v-col cols="12" lg="6">
                        <div class="small text-danger" v-if="form.errors.has('tbl_model')"
                            v-html="form.errors.get('tbl_model')" />
                        <v-autocomplete :items="tblOptions" dense
                            v-model="form.tbl_model" label="Select Table Name"
                            :rules="[v => !!v || 'Table name is required!']" required></v-autocomplete>
                    </v-col>

                    <v-col cols="12" lg="6">
                        <div class="small text-danger" v-if="form.errors.has('type')"
                            v-html="form.errors.get('type')" />
                        <v-autocomplete :items="typeOptions" dense
                            v-model="form.type" label="Select Type"
                            :rules="[v => !!v || 'Select type is required!']" required></v-autocomplete>
                    </v-col>

                
                </v-row>

                 <v-row class="mt-2">
                                <v-btn type="submit" block :loading="dataModalLoading" elevation="20" color="primary">
                                    <v-icon left dark>mdi-shape-polygon-plus</v-icon> Submit
                                </v-btn>
                            </v-row>

                </form>



            </v-card-text>
        </v-card>

        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
    // vform
    import Form from 'vform';
    import tblOptions from './js/tbl_options'
    import apiUrlGenerate from './js/api_url_generate'

    export default {
        data() {
            return {

                //current page url
                currentUrl: '/pbi/admin/api',

                reqRules: [v => !!v || 'This field is required!'],


                // Form
                form: new Form({
                    start: '',
                    end: '',
                    type: '',
                    tbl_model: '',
                }),

                typeOptions: [{
                        text: 'Store',
                        value: 'store'
                    },
                    {
                        text: 'Show',
                        value: 'show'
                    },
                ],

                // tblOptions
                ...tblOptions,

                // datepicker
                menu: '',
                menu2: '',
               
            }
        },

        methods:{
             // actionStore
            action() {
               
                // Check Start DateTime After End DateTime
                let dateTimeIsAfter = this.$moment(this.form.start).isAfter(this.form.end)
                if (dateTimeIsAfter) {
                    // Start Date Grater
                    Swal.fire({
                        icon: "error",
                        title: "Sorry! Start time can't be greater than the end time",
                    });
                    return false;
                }

                if(this.form.type == 'show'){
                    this.redirectToBlank()
                    return false;
                }

                // Loading
                this.dataModalLoading = true
                this.overlay = true
               
                this.form.post(this.currentUrl + '/action').then(response => {
                    console.log(response.data)

                    // Loading
                    this.dataModalLoading = false
                    this.overlay = false

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
                    })

                }).catch(error => {
                    // Loading
                    this.dataModalLoading = false
                    this.overlay = false
                    console.log(error)
                })

            },

            // apiUrlGenerate as per table select
            ...apiUrlGenerate,

            // redirectToBlank as per url as blank
            redirectToBlank() {
                var apiUrl = this.apiUrlGenerate(this.form.tbl_model)
                if(apiUrl){
                    let baseUrl = window.location.origin 
                    const route = baseUrl +'/api/powerbi-get/'+apiUrl+'?start='+ this.form.start +
                    '&end=' + this.form.end 
                    //console.log(baseUrl)
                    window.open(route, '_blank');
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Sorry! Somthing going wrong",
                    });
                }
                
            },

            
        },



    }

</script>
