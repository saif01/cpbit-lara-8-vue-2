<template>
    <v-app>
       <router-view></router-view>
    </v-app>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {
        data() {
            return {
               
                passwordType: false,
                loading:false,
                password: null,
                
                error:false,
                errorMsg:'',

               
                // Form
                form: new Form({
                    login: 'syful.isl',
                    password: 'Saif5683@5'
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
                    if(resData.status == 'error'){
                        
                        this.error = true
                        this.errorMsg = resData.msg
                      
                    }

                    // Success
                    if(resData.status == 'success'){

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
            register(){
                //redirect 
                window.location.href = "/register"
            }
        }
    }
</script>



<style scoped lang="scss">
.login_view{
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

.register{
    cursor:pointer;
}

/* animation */
.particle {
    position: absolute;
    border-radius: 50%;
}
@for $i from 1 through 30 {
    @keyframes particle-animation-#{$i} {
        100% {
            transform: translate3d(
                (random(90) * 1vw),
                (random(90) * 1vh),
                (random(100) * 20px)
            );
        }
    }

    .particle:nth-child(#{$i}) {
        animation: particle-animation-#{$i} 60s infinite;
        $size: random(5) + 5 + px;
        opacity: random(100) / 100;
        height: $size;
        width: $size;
        animation-delay: -$i * 0.2s;
        transform: translate3d(
            (random(90) * 1vw),
            (random(90) * 1vh),
            (random(100) * 1px)
        );
        background: hsl(random(360), 70%, 50%);
    }
}
</style>
