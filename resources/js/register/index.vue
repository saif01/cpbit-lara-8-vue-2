<template>
    <div>

        <b-card class="card_position col-lg-5 col-md-7 col-11" v-if="!registerFrmShow">

            <!-- Header Component -->
            <reg-header></reg-header>

            
            <b-overlay :show="registerOverlay" rounded="sm" variant="white">

                <b-card-text :class="registerField">
                    <form @submit.prevent="check()">
                        <b-form-group label="Your AD ID:">
                            <b-form-input v-model="form.login" placeholder="Enter Your AD or Internet ID"
                                :class="{ 'is-invalid': form.errors.has('login') }"></b-form-input>
                            <div class="small text-danger" v-if="form.errors.has('login')"
                                v-html="form.errors.get('login')" />
                        </b-form-group>

                        <b-form-group label="Your Current Password:">
                            <b-input-group>
                                <b-form-input :type="typeChange" v-model="form.password"
                                    placeholder="Enter Your AD  Current Password"
                                    :class="{ 'is-invalid': form.errors.has('password') }"></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('password')"
                                    v-html="form.errors.get('password')" />

                                <template #append>
                                    <b-input-group-text class="input-group-text bg-transparent">
                                        <i :class="{'fa fa-eye': active, 'fa fa-eye-slash': !active,}" @click="
                                                    (active = !active), toggleShow()"></i>
                                    </b-input-group-text>
                                </template>
                            </b-input-group>
                        </b-form-group>

                        <b-form-group v-if="!form.progress">
                            <b-button class="btn-block" type="submit" variant="success">Register <i
                                    class="far fa-address-book"></i></b-button>
                        </b-form-group>
                    </form>
                </b-card-text>

            </b-overlay>


        </b-card>

        <b-card class="mx-auto my-3 col-lg-10 col-md-11 col-12" v-if="registerFrmShow">
            <b-card-text>
                <register-form :adData="adData"></register-form>
            </b-card-text>
        </b-card>


    </div>
</template>

<script>
    import regHeader from './header.vue'
    import registerForm from './register.vue'

    // vform
    import Form from 'vform';


    export default {

        components: {
            'reg-header': regHeader,
            'register-form': registerForm
        },

        data() {
            return {

                registerOverlay: false,
                registerDataField: 'd-none',
                registerField: 'd-block',
                typeChange: 'password',
                active: false,

                registerFrmShow: false,
                adData: '',

                // Form
                form: new Form({
                    login: 'syful.isl',
                    password: 'Saif5683@5',
                }),

            }
        },

        methods: {

            // toggleShow
            toggleShow() {
                if (this.typeChange == 'password') {
                    this.typeChange = 'text'
                } else {
                    this.typeChange = 'password'
                }
            },

            // check
            async check() {

                this.registerOverlay = true

                // request send and get response
                const response = await this.form.post('/register/check')

                console.log(response.data)
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();



                if (response.data.status == 'success') {

                    this.registerOverlay = false

                   
                    if (response.data.code == 202) {

                        // Data found in local server User tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function () {
                            // After click ok then redirect 
                            window.location.href = "/login"
                        });

                    }else if (response.data.code == 208) {

                        // Data found in local server UserRegister tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function () {
                            // After click ok then redirect 
                            window.location.href = "/login"
                        });

                    }
                    else if (response.data.code == 203) {

                        // Data found in local server UserRegister tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(function () {
                            // After click ok then redirect 
                            window.location.href = "/login"
                        });

                    } else if (response.data.code == 200) {

                        // Data found in AD Server
                        // Show register form
                        this.registerFrmShow = true
                        this.adData = response.data.data
                        // Toast alert
                        Toast.fire({
                            icon: response.data.icon,
                            title: response.data.msg
                        });

                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Done',
                        })
                    }


                } else {
                    this.registerOverlay = false
                    this.registerFrmShow = false
                    this.adData = ''
                    // swal alert
                    Swal.fire({
                        icon: response.data.icon,
                        title: 'Sorry!! Data Not Found<br><small>' + response.data.msg + '</small>',
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                    console.log(response.data);
                }

            },

        }
    }

</script>




<style scoped>
    .card_position {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

</style>
