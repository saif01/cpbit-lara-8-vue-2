<template>
    <div>
        <v-card class="mt-8">
            <v-card-title class="justify-center h2">
                SMS Reports of C.P. Bangladesh
            </v-card-title>
            <v-card-text>

                <v-form>
                    <form @submit.prevent="downloadReports()">

                        <v-row>
                            <v-col>
                                <v-autocomplete solo :items="allOperations" v-model="form.code" label="Operation"
                                    placeholder="Select One Operation" :rules="[v => !!v || 'Operation is required!']"
                                    required></v-autocomplete>
                                <div class="small text-danger" v-if="form.errors.has('code')"
                                    v-html="form.errors.get('code')" />
                            </v-col>
                            <v-col>
                                <v-autocomplete solo :items="reportTypes" item-text="name" item-value="value"
                                    v-model="form.type" label="SMS Type" placeholder="Choose SMS Type"
                                    :rules="[v => !!v || 'Type is required!']" required></v-autocomplete>
                                <div class="small text-danger" v-if="form.errors.has('type')"
                                    v-html="form.errors.get('type')" />
                            </v-col>

                            <!-- Date Picker -->
                            <v-col>
                                <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                    :return-value.sync="date" offset-y min-width="auto" outlined dense>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.date" label="Report Date"
                                            prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" required
                                            :rules="[v => !!v || 'Report Date is required!']"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.date" scrollable outlined dense>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">
                                            Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.menu.save(date)">
                                            OK </v-btn>
                                    </v-date-picker>
                                    <div class="small text-danger" v-if="form.errors.has('date')"
                                        v-html="form.errors.get('date')" />
                                </v-menu>
                            </v-col>
                        </v-row>


                        <v-btn block blockdepressed :loading="BtnLoading" color="primary mt-3" type="submit" x-large>
                            <template v-slot:loader>
                                <span>
                                    <v-icon left color="white">mdi mdi-loading mdi-spin</v-icon> Downloading...
                                </span>
                            </template>
                            <v-icon left dark>mdi-file-excel</v-icon> Download Reports
                        </v-btn>


                    </form>
                </v-form>

            </v-card-text>

        </v-card>
    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {

        data() {

            return {

                // timepicker
                menu: false,
                date: '',


                // current page url
                currentUrl: '/sms',

                allOperations: [],
                allUsers: [],

                selected: null,
                datePickerHeader: true,

                BtnLoading: false,

                reportTypes: [{
                        value: 'Sales_Order',
                        name: 'Sales Order'
                    },
                    {
                        value: 'Sales_Payment',
                        name: 'Sales Payment'
                    }
                ],

                // Form
                form: new Form({
                    date: '',
                    code: '',
                    type: '',
                }),

            }


        },

        methods: {

            // All Operations
            getOperations() {
                axios.get(this.currentUrl + '/operations').then(response => {
                    // console.log(response.data)
                    //this.allOperations = response.data

                    for (let i = 0; i < response.data.length; i++) {
                        this.allOperations.push(response.data[i]);
                        this.allOperations[i] = {
                            value: response.data[i].code,
                            text: response.data[i].code + ' || ' + response.data[i].name
                        };

                    }

                }).catch(error => {
                    console.log(error)
                })
            },

            // Download
            downloadReports() {

                //start Loading
                this.BtnLoading = true

                axios({
                    method: 'get',
                    url: this.currentUrl + '/report_download/?code=' + this.form.code +
                        '&type=' + this.form.type +
                        '&date=' + this.form.date,

                    responseType: 'blob', // important
                }).then((response) => {

                    console.log(response.data)
                    //stop Loading
                    this.BtnLoading = false

                    let repName = this.form.type + '_' + this.form.code + '_' + this.form.date;

                    const url = URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', `${repName}.xlsx`)
                    document.body.appendChild(link)
                    link.click()

                }).catch(error => {
                    //stop Loading
                    this.BtnLoading = false
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Somthing going wrong !!'
                    })
                })

            }

        },

        created() {
            //this.$Progress.start()
            console.log('I am demo dashboard')
            this.getOperations()
            //this.$Progress.finish()
        }
    }

</script>
