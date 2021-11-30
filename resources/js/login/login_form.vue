<template>
     <div class="container py-5">
        <form @submit.prevent="login()">
            <div class="form-group">
                <label for="exampleInputlogin1">login ID</label>
                <input type="login" v-model="form.login" class="form-control" id="exampleInputlogin1" aria-describedby="emailHelp">
               
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        

    </div>
</template>

<script>
    // vform
    import Form from 'vform';


    export default {
        data() {
            return {
                active: false,
                showPassword: false,
                password: null,

                // Form
                form: new Form({
                    login: 'syful.isl',
                    password: '123'

                }),
            };
        },

        methods: {
            toggleShow() {
                this.showPassword = !this.showPassword;
            },

            // Store Data
            login() {
                this.form.post('/login_action').then(response => {

                    console.log(response);

                    // redirect with reload
                    window.location.href = "/"

                }).catch(error => {
                    console.log(error)
                })
            },
        },
    };

</script>

<style scoped lang="scss">
    .login_view {
        width: 100vw;
    }

    .div_center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .cpb_logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
        opacity: 20%;
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
