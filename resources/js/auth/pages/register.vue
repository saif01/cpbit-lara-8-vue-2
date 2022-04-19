<template>
    <div class="bg_gradientColor">
        <v-flex class="d-flex justify-center align-center" style="height:100vh;">
            <v-col cols="12" md="6">
                <v-form>

                    <v-card class="pb-4">
                        <v-card-title class="justify-center">
                            <v-avatar>
                                <img src="/all-assets/common/logo/cpb/cpbit.png"  alt="CPB-IT">
                            </v-avatar>
                            CPB-IT Portal Register
                        </v-card-title>

                        <form @submit.prevent="check()">
                            <v-card-text>
                                <v-text-field type="text" label="AD Login ID"
                                    :rules="[v => !!v || 'Login ID is required!']" v-model="form.login"
                                    prepend-icon="mdi-account-alert-outline" required></v-text-field>
                                <div v-if="form.errors.has('login')" v-html="form.errors.get('login')" />



                                <v-text-field :type="passwordType ?'text': 'password'"
                                    :append-icon="passwordType ?'mdi-eye':'mdi-eye-remove'"
                                    @click:append="passwordType=!passwordType" label="Password"
                                    :rules="[v => !!v || 'Password is required!']" v-model="form.password"
                                    prepend-icon="mdi-lock-alert-outline" required></v-text-field>
                                <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />


                                <v-btn block depressed class="light-blue darken-4 text-white" :loading="loading"
                                    type="submit">
                                    <v-icon dense>
                                        mdi-account-plus
                                    </v-icon>
                                    Register Check
                                </v-btn>



                            </v-card-text>
                        </form>

                        <div class="text-center">Do you want to back ?<router-link :to="{ name: 'Login' }"
                            class="text_color"> <button class="teal--text"><v-icon size="16">
                                    mdi-login</v-icon> Login </button> </router-link>
                        </div>
                    </v-card>
                </v-form>
            </v-col>


        </v-flex>



        <register-form :key="registerRerendarKey" v-if="registerFrmShow" :adData="adData"></register-form>






    </div>
</template>

<script>
    import registerForm from './register_form.vue'

    // vform
    import Form from 'vform';


    export default {

        components: {
            'register-form': registerForm
        },

        data() {
            return {

                passwordType: false,
                loading: false,
                password: null,

                registerFrmShow: false,
                adData: '',

                // Form
                form: new Form({
                    login: '',
                    password: '',
                }),

            }
        },

        methods: {

            // check
            async check() {

                this.loading = true

                // request send and get response
                const response = await this.form.post('/register_check')

                //console.log(response.data)
                // Input field make empty
                this.form.reset();
                this.form.errors.clear();



                if (response.data.status == 'success') {

                    this.loading = false

                    if (response.data.code == 202) {

                        // Data found in local server User tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(()=> {
                            // After click ok then redirect 
                           // window.location.href = "/login"
                           this.$router.push({name:'Login'})
                        });

                    } else if (response.data.code == 208) {

                        // Data found in local server UserRegister tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(()=> {
                            // After click ok then redirect 
                           this.$router.push({name:'Login'})
                        });

                    } else if (response.data.code == 203) {

                        // Data found in local server UserRegister tbl
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        }).then(()=> {
                            // After click ok then redirect 
                           this.$router.push({name:'Login'})
                        });

                    } else if (response.data.code == 200) {

                        // Data found in AD Server
                        // Show register form
                        this.registerFrmShow = true
                        this.registerRerendarKey++
                        this.adData = response.data.data
                        // Toast alert
                        Toast.fire({
                            icon: response.data.icon,
                            title: response.data.msg
                        });

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Done',
                        })
                    }


                } else {
                    this.loading = false
                    this.registerFrmShow = false
                    this.adData = ''
                    // swal alert
                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.msg,
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
    .bg_gradientColor {
        background: #E55D87;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #5FC3E4, #E55D87);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #5FC3E4, #E55D87);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }

</style>
