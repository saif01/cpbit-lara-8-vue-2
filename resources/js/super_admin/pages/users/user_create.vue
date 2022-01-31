<template>
    <div>
        <v-dialog v-model="dialog">


            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                             {{ dataModelTitle }}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dialog = false" color="red lighten-1" small text
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <v-form v-model="valid">
                        <form @submit.prevent="storeData()">
                            <v-row>
                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User AD ID"
                                        :rules="[v => !!v || 'AD ID is required!']" v-model="form.login" required>
                                    </v-text-field>
                                    <div v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Name"
                                        :rules="[v => !!v || 'User Name is required!']" v-model="form.name" required>
                                    </v-text-field>
                                    <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Department"
                                        :rules="[v => !!v || 'Department is required!']" v-model="form.department"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office ID"
                                        :rules="[v => !!v || 'Office ID is required!']" v-model="form.office_id"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office Contact" v-model="form.office_contact">
                                    </v-text-field>
                                    <div v-if="form.errors.has('office_contact')"
                                        v-html="form.errors.get('office_contact')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Personal Contact"
                                        v-model="form.personal_contact"></v-text-field>
                                    <div v-if="form.errors.has('personal_contact')"
                                        v-html="form.errors.get('personal_contact')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Office Email"
                                        :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                        v-model="form.office_email"></v-text-field>
                                    <div v-if="form.errors.has('office_email')"
                                        v-html="form.errors.get('office_email')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Personal Email"
                                        :rules="[v => /.+@.+/.test(v) || 'E-mail must be valid',]"
                                        v-model="form.personal_email"></v-text-field>
                                    <div v-if="form.errors.has('personal_email')"
                                        v-html="form.errors.get('personal_email')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Office Location"
                                        :rules="[v => !!v || 'Office Location is required!']" v-model="form.office"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Business Unit"
                                        :rules="[v => !!v || 'Business Unit is required!']" v-model="form.business_unit"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('business_unit')"
                                        v-html="form.errors.get('business_unit')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User Manager Name"
                                        :rules="[v => !!v || 'Manager Name is required!']" v-model="form.manager_name"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('manager_name')"
                                        v-html="form.errors.get('manager_name')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User Manager Email" :rules="emailRules"
                                        v-model="form.manager_email" required></v-text-field>
                                    <div v-if="form.errors.has('manager_email')"
                                        v-html="form.errors.get('manager_email')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="User BU Head Name"
                                        :rules="[v => !!v || 'BU Head Name is required!']" v-model="form.bu_name"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('bu_name')" v-html="form.errors.get('bu_name')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field type="email" label="User BU Head Email" :rules="emailRules"
                                        v-model="form.bu_email" required></v-text-field>
                                    <div v-if="form.errors.has('bu_email')" v-html="form.errors.get('bu_email')" />
                                </v-col>


                                <v-col cols="12" md="4">
                                    <v-text-field type="text" label="Purpose of Access"
                                        :rules="[v => !!v || 'Purpose of Access is required!']" v-model="form.remarks"
                                        required></v-text-field>
                                    <div v-if="form.errors.has('remarks')" v-html="form.errors.get('remarks')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-file-input :rules="imageRules" accept="image/png, image/jpeg, image/bmp"
                                        placeholder="Pick an image" prepend-icon="mdi-camera" label="Choose Image"
                                        @change="onFileChange" required></v-file-input>
                                    <div v-if="form.errors.has('image')" v-html="form.errors.get('image')" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-img :src="imageUrl" class="rounded rounded-circle" height="100px" width="100px"
                                        alt="Image" />

                                </v-col>

                            </v-row>

                            <v-btn block blockdepressed :loading="loading" color="primary mt-3" type="submit">
                                <v-icon left dark>
                                    mdi-cloud-upload
                                </v-icon>
                                Submit
                            </v-btn>

                        </form>

                    </v-form>

                </v-card-text>
            </v-card>

        </v-dialog>
    </div>
</template>

<script>
    import Form from 'vform'
    export default {

        props:[''],
        data() {
            return {

                valid: false,
                dialog: true,
                imageUrl: '',

                loading:false,
               

                form: new Form({
                    login: '',
                    name: '',
                    image: '',
                    department: '',
                    office_id: '',
                    office_contact: '',
                    personal_contact: '',
                    office_email: '',
                    personal_email: '',
                    office: '',
                    business_unit: '',
                    nid: '',
                    manager_name: '',
                    manager_email: '',
                    bu_name: '',
                    bu_email: '',
                    remarks: '',
                }),

                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
                imageRules: [
                    v => !!v || 'Image is required',
                    v => !v || v.size < 2000000 || 'Avatar size should be less than 2 MB!',
                ]
            }
        },
        methods: {
            createImage(file) {
                const reader = new FileReader();

                reader.onload = e => {
                    this.imageUrl = e.target.result;
                    this.form.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            onFileChange(file) {
                if (!file) {
                    return;
                }
                this.createImage(file);
            },



            //storeData
            async storeData() {

                this.loading = true

                // request send and get response
                const response = await this.form.post('/register_store')

                console.log(response.data)
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();

                this.loading = false
                this.dialog = false


                if (response.data.status == 'success') {

                   
                    if (response.data.code == 200) {

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function () {
                            // After click ok then redirect 
                            //window.location.href = "/login"
                            this.$router.push({name:'Login'})
                        });
                    }

                } else {
            
                    this.registerFrmShow = false
                    this.adData = ''
                    // swal alert
                    Swal.fire({
                        icon: response.data.icon,
                        title: 'Sorry!!<br><small>' + response.data.msg + '</small>',
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                    console.log(response.data);
                }

            },


        },

        // mounted() {

        //     this.form.login = this.dataObj.data.UserID
        //     this.form.name = this.dataObj.data.UserName
        //     this.form.department = this.dataObj.data.Department
        //     this.form.office_id = this.dataObj.data.OfficeID
        //     this.form.office_contact = this.dataObj.data.OfficeMobile
        //     this.form.personal_contact = this.dataObj.data.PersonalMobile
        //     this.form.office_email = this.dataObj.data.OfficeEmail
        //     this.form.personal_email = this.dataObj.data.PersonalEmail
        //     this.form.office = this.dataObj.data.Office
        //     this.form.business_unit = this.dataObj.data.BusinessUnit
        //     this.form.nid = this.dataObj.data.NationalID

        //     this.form.bu_name = this.dataObj.data.Manager


        // },

        created() {
            console.log('addd data')
        }
    }

</script>
