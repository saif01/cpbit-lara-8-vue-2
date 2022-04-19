<template>

    <div class="login_view bg-dark">
        <div id="particle-container">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        <div class="col-lg-4 col-md-8 col-12 div_center">
            <v-form>

                <v-card class="pb-4">
                    <v-card-title class="justify-center">
                        <v-avatar>
                            <img src="/all-assets/common/logo/cpb/cpbit.png" alt="CPB-IT">
                        </v-avatar>
                        CPB-IT Portal Login
                    </v-card-title>
                    <v-card-text>
                        <!-- Error -->
                        <v-alert v-if="error" shaped prominent type="error" dismissible>
                            {{ errorMsg }}
                        </v-alert>


                        <form @submit.prevent="login()">

                            <v-text-field type="text" label="Login ID" :rules="[v => !!v || 'Login ID is required!']"
                                v-model="form.login" prepend-icon="mdi-account-alert-outline" required></v-text-field>
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
                                    mdi-login
                                </v-icon>
                                Login
                            </v-btn>

                        </form>

                    </v-card-text>

                    <div class="text-center">Not registered yet ? <router-link :to="{ name: 'Register' }"
                            class="text_color"> <button class="teal--text ml-2">Create an account <v-icon size="16">
                                    mdi-account-plus</v-icon></button> </router-link>
                    </div>
                </v-card>

            </v-form>
        </div>
    </div>

</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        data() {
            return {

                passwordType: false,
                loading: false,
                password: null,

                error: false,
                errorMsg: '',


                // Form
                form: new Form({
                    login: '',
                    password: ''
                }),
            }
        },
        methods: {

            // Login
            login() {
                this.loading = true
                this.form.post('/login_action').then(response => {


                    console.log(response.data);

                    let resData = response.data;

                    // Error
                    if (resData.status == 'error') {
                        console.log(resData)
                        this.error = true
                        this.errorMsg = resData.msg

                    }

                    // Success
                    if (resData.status == 'success') {
                        console.log(resData)
                        this.error = false

                        // redirect with reload
                        window.location.href = "/"

                    }

                    this.loading = false

                }).catch(error => {
                    this.loading = false

                    console.log(error)
                })
            },


            //register
            register() {
                //redirect 
                window.location.href = "/register"
            }
        }
    }

</script>



<style scoped lang="scss">
    .login_view {
        position: relative;
        width: 100vw;
        height: 100vh;
    }

    .div_center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    .cpb_logo {
        height: 50px;
        // position: absolute;
        // top: 50%;
        // left: 50%;
        // transform: translate(-50%, -50%);
        // z-index: -1;
        // opacity: 0.1;
    }

    .usericon {
        height: 22px;
        width: 22px;
        fill: #555;
    }

    .passicon {
        height: 22px;
        width: 22px;
        fill: #555;
    }

    .input_password:focus,
    .input_id:focus {
        border-color: #ddd;
        box-shadow: none;
        outline: none;
    }

    .input-group-text {
        border-radius: 8px;
    }

    .input_id,
    .input_password {
        padding-left: 0.5rem;
        border-left: none;
        border-radius: 8px;
        background-color: transparent;
    }

    .input_password {
        border-right: none !important;
    }

    .register {
        cursor: pointer;
    }

    /* animation */
    .particle {
        position: absolute;
        border-radius: 50%;
    }

    @for $i from 1 through 30 {
        @keyframes particle-animation-#{$i} {
            100% {
                transform: translate3d((random(90) * 1vw),
                        (random(90) * 1vh),
                        (random(100) * 20px));
            }
        }

        .particle:nth-child(#{$i}) {
            animation: particle-animation-#{$i} 60s infinite;
            $size: random(5) + 5 + px;
            opacity: random(100) / 100;
            height: $size;
            width: $size;
            animation-delay: -$i * 0.2s;
            transform: translate3d((random(90) * 1vw),
                    (random(90) * 1vh),
                    (random(100) * 1px));
            background: hsl(random(360), 70%, 50%);
        }
    }

</style>
