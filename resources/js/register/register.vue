<template>
    <div>
        <!-- Header Component -->
        <reg-header></reg-header>
        <b-overlay :show="registerOverlay" variant="white" rounded="sm">
            <form @submit.prevent="storeData()">

                <div class="row">
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User AD ID:">
                            <b-form-input v-model="form.login" placeholder="Enter user AD ID" size="sm" required :class="{ 'is-invalid': form.errors.has('login') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Name:">
                            <b-form-input v-model="form.name" placeholder="Enter User name" size="sm" required :class="{ 'is-invalid': form.errors.has('name') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Department:">
                            <b-form-input v-model="form.department" placeholder="Enter User department" size="sm" :class="{ 'is-invalid': form.errors.has('department') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                        </b-form-group>
                    </div>

            
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Office ID:">
                            <b-form-input v-model="form.office_id" placeholder="Enter user office id" size="sm" :class="{ 'is-invalid': form.errors.has('office_id') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Office Contact:">
                            <b-form-input v-model="form.office_contact" placeholder="Enter User office contact" size="sm" :class="{ 'is-invalid': form.errors.has('office_contact') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_contact')" v-html="form.errors.get('office_contact')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Personal Contact:">
                            <b-form-input v-model="form.personal_contact" placeholder="Enter User personal contact" size="sm" :class="{ 'is-invalid': form.errors.has('personal_contact') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('personal_contact')" v-html="form.errors.get('personal_contact')" />
                        </b-form-group>
                    </div>
                
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Office Email:">
                            <b-form-input type="email" v-model="form.office_email" placeholder="Enter user office email" size="sm" :class="{ 'is-invalid': form.errors.has('office_email') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Personal Email:">
                            <b-form-input v-model="form.personal_email" placeholder="Enter User personal email" size="sm" :class="{ 'is-invalid': form.errors.has('personal_email') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                        </b-form-group>
                    </div>
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Office Location:">
                            <b-form-input v-model="form.office" placeholder="Enter User office location" size="sm" :class="{ 'is-invalid': form.errors.has('office') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                        </b-form-group>
                    </div>
                
                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Business Unit:">
                            <b-form-input v-model="form.business_unit" placeholder="Enter user business unit" size="sm" :class="{ 'is-invalid': form.errors.has('business_unit') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('business_unit')" v-html="form.errors.get('business_unit')" />
                        </b-form-group>
                    </div>

                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Manager Name:">
                            <b-form-input v-model="form.manager_name" placeholder="Enter user manager name" size="sm" :class="{ 'is-invalid': form.errors.has('manager_name') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('manager_name')" v-html="form.errors.get('manager_name')" />
                        </b-form-group>
                    </div>

                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Manager Email:">
                            <b-form-input type="email" v-model="form.manager_email" placeholder="Enter user manager email" size="sm" :class="{ 'is-invalid': form.errors.has('manager_email') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('manager_email')" v-html="form.errors.get('manager_email')" />
                        </b-form-group>
                    </div>

                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Business Unit Head Name:">
                            <b-form-input v-model="form.bu_name" placeholder="Enter user manager name" size="sm" :class="{ 'is-invalid': form.errors.has('bu_name') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('bu_name')" v-html="form.errors.get('bu_name')" />
                        </b-form-group>
                    </div>

                    <div class="col-lg-4 col-6">
                        <b-form-group label="User Business Unit Head Email:">
                            <b-form-input type="email" v-model="form.bu_email" placeholder="Enter business unit head email" size="sm" :class="{ 'is-invalid': form.errors.has('bu_email') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('bu_email')" v-html="form.errors.get('bu_email')" />
                        </b-form-group>
                    </div>

                    <div class="col-lg-4 col-12">
                        <b-form-group label="Purpose or Access or Other reasons:">
                            <b-form-input v-model="form.remarks" placeholder="Enter purpose or which access need or other reasons for apply" size="sm" :class="{ 'is-invalid': form.errors.has('business_unit') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('remarks')" v-html="form.errors.get('business_unit')" />
                        </b-form-group>
                    </div>

                    
                       <!-- User Image -->
                    <div class="col-lg-10 col-10">
                        <b-form-group label="Profile Image:">
                        <div class="row">
                            <div class="col-md-6">
                                <b-form-file v-on:input="uploadImageByName($event, 'image')"
                                    placeholder="Choose Profile Image" size="sm" accept=".jpg, .png, .jpeg" required>
                                </b-form-file>
                            </div>
                            <div class="col-md-6 mt-1">
                                <img :src="showImageByName('image')" class="rounded mx-auto d-block" height="100"  width="80"/>
                            </div>
                        </div>
                        </b-form-group>
                    </div>
                    
                </div>

                <b-button type="submit" class="mt-2 btn-block" variant="info"><i class="far fa-check-circle"></i> Submit</b-button>
            </form>
        </b-overlay>

       
    </div>
</template>

<script>

    import regHeader from './header.vue'

    // vform
    import Form from 'vform';

    export default {

        components:{
            'reg-header' : regHeader
        },
        
        props:['adData'],

        data(){
            return{
                registerOverlay:false,

                dataObj: this.adData,

                imageMaxSize: '2111775',
                imagePath: '/images/users/',
                imagePathSm: '/images/users/small/',

                // Form
                form: new Form({
                    login   : '',
                    name    : '',
                    image   : '',
                    department: '',
                    office_id: '',
                    office_contact: '',
                    personal_contact: '',
                    office_email:'',
                    personal_email:'',
                    office:'',
                    business_unit: '',
                    nid:'',
                    manager_name: '',
                    manager_email: '',
                    bu_name: '',
                    bu_email: '',
                    remarks: '',
                }),
            }
        },


        methods:{

            // image Upload by name
            uploadImageByName: function (event, currentFieldName) {

                let file = event.target.files[0];
                let reader = new FileReader();
                //console.log('Image upload: ', file['size'], 'imageMaxSize :', this.imageMaxSize, file )
                if (file['size'] < this.imageMaxSize) {
                    reader.onloadend = (file) => {
                        console.log('RESULT', reader.result)
                        this.form[currentFieldName] = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert('File size can not be bigger than 2 MB')
                }


            },

            // Selected Image Show
            showImageByName(currentFieldName) {

                if (this.form[currentFieldName]) {
                    let photo = (this.form[currentFieldName].length > 100) ? this.form[currentFieldName] : this
                        .imagePathSm + this.form[currentFieldName];
                    return photo;
                }
                return null;
            },

            //storeData
            async storeData() {

                this.registerOverlay = true

                // request send and get response
                const response = await this.form.post('/register/store')

                console.log(response.data)
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();



                if (response.data.status == 'success') {

                    this.registerOverlay = false

                   
                    if (response.data.code == 200) {

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function () {
                            // After click ok then redirect 
                            window.location.href = "/login"
                        });
                    }

                } else {
                    this.registerOverlay = false
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

        mounted(){

            this.form.login = this.dataObj.data.UserID
            this.form.name  = this.dataObj.data.UserName
            this.form.department = this.dataObj.data.Department
            this.form.office_id = this.dataObj.data.OfficeID
            this.form.office_contact = this.dataObj.data.OfficeMobile
            this.form.personal_contact = this.dataObj.data.PersonalMobile
            this.form.office_email = this.dataObj.data.OfficeEmail
            this.form.personal_email = this.dataObj.data.PersonalEmail
            this.form.office = this.dataObj.data.Office
            this.form.business_unit = this.dataObj.data.BusinessUnit
            this.form.nid = this.dataObj.data.NationalID

            this.form.bu_name = this.dataObj.data.Manager
           

        },

        created(){
            console.log('addd data', this.dataObj)
        }
    }
</script>