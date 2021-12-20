<template>
    <div>

        <div>
             <form @submit.prevent="register()">

                <div class="row">
                    <div class="col-md-4">
                        <b-form-group label="User AD ID:">
                            <b-form-input v-model="form.login" placeholder="Enter user AD ID" size="sm" required :class="{ 'is-invalid': form.errors.has('login') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('login')" v-html="form.errors.get('login')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Name:">
                            <b-form-input v-model="form.name" placeholder="Enter User name" size="sm" required :class="{ 'is-invalid': form.errors.has('name') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Department:">
                            <b-form-input v-model="form.department" placeholder="Enter User department" size="sm" :class="{ 'is-invalid': form.errors.has('department') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('department')" v-html="form.errors.get('department')" />
                        </b-form-group>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <b-form-group label="User Office ID:">
                            <b-form-input v-model="form.office_id" placeholder="Enter user office id" size="sm" :class="{ 'is-invalid': form.errors.has('office_id') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_id')" v-html="form.errors.get('office_id')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Office Contact:">
                            <b-form-input v-model="form.office_contact" placeholder="Enter User office contact" size="sm" :class="{ 'is-invalid': form.errors.has('office_contact') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_contact')" v-html="form.errors.get('office_contact')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Personal Contact:">
                            <b-form-input v-model="form.personal_contact" placeholder="Enter User personal contact" size="sm" :class="{ 'is-invalid': form.errors.has('personal_contact') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('personal_contact')" v-html="form.errors.get('personal_contact')" />
                        </b-form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <b-form-group label="User Office Email:">
                            <b-form-input type="email" v-model="form.office_email" placeholder="Enter user office email" size="sm" :class="{ 'is-invalid': form.errors.has('office_email') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office_email')" v-html="form.errors.get('office_email')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Personal Email:">
                            <b-form-input v-model="form.personal_email" placeholder="Enter User personal email" size="sm" :class="{ 'is-invalid': form.errors.has('personal_email') }" required></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('personal_email')" v-html="form.errors.get('personal_email')" />
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group label="User Office Location:">
                            <b-form-input v-model="form.office" placeholder="Enter User office location" size="sm" :class="{ 'is-invalid': form.errors.has('office') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('office')" v-html="form.errors.get('office')" />
                        </b-form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <b-form-group label="User Business Unit:">
                            <b-form-input v-model="form.business_unit" placeholder="Enter user business unit" size="sm" :class="{ 'is-invalid': form.errors.has('business_unit') }" ></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('business_unit')" v-html="form.errors.get('business_unit')" />
                        </b-form-group>
                    </div>
                   
                </div>

                <b-button type="submit" >Submit</b-button>
             </form>
        </div>

        <!-- {{ dataObj }} -->
    </div>
</template>

<script>

    // vform
    import Form from 'vform';

    export default {
        props:['adData'],

        data(){
            return{
                dataObj: this.adData,

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
                }),
            }
        },

        methods:{

            // register
            // register
            async register() {
               
                // request send and get response
                const response = await this.form.post('/register/store')

                console.log(response.data)
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();
               
               

                if (response.data.status == 'success') {
                    
                    // Data found in local server
                    if(response.data.code == 202){

                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function() {
                            window.location.href = "/login"
                        });

                        
                        
                    }

                    // Data found in AD Server
                    if(response.data.code == 200){

                        this.registerFrmShow = true
                        this.adData = response.data.data

                        Toast.fire({
                            icon: response.data.icon,
                            title: response.data.msg
                        });
                    }

                
                } else {
                    this.registerFrmShow = false
                    this.adData =''
                    Swal.fire({
                        icon: response.data.icon,
                        title: 'Sorry!! Data Not Found<br><small>'+ response.data.msg +'</small>',
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


        },

        created(){
            console.log('addd data', this.dataObj)
        }
    }
</script>