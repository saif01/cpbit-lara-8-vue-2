<template>
    <div>
        <main id="main">

            <section class="content-404">
                <div class="container text-center ">


                    <h1 class="head"><span>404</span></h1>
                    <p>Oops! The Page you requested was not found!</p>
                    <router-link :to="{name:'admin_ivca_dashboard'}" class="btn-outline">Back to Dashboard</router-link>

                </div>
            </section>




        </main><!-- End #main -->
    </div>
</template>



<script>
   
    export default {
        data() {
            return {}
        },

        methods: {

        },

        mounted() {
            // Store Visitor Log
           // this.$store.dispatch('visitor_log')
        },


        created() {
            this.$Progress.start();

            console.log('404 Component');

            this.$Progress.finish();

        },


    }

</script>



<style>
    .content-404 {
        height: 100%;
        width: 100%;
        background: #AA076B;
        background: -webkit-linear-gradient(to top, #aa076b, #61045f);
        background: linear-gradient(to top, #aa076b, #61045f);
        letter-spacing: 1px;
    }

    .content-404 .head {
        color: #fff;
        font-size: 250px;
        font-weight: 900;
        letter-spacing: 25px;
        margin: 10px 0 0 0;
    }

    .content-404 h1.head {
        font-size: 250px;
        font-weight: 900;
        letter-spacing: 25px;
        margin: 10px 0 0 0;
    }

    .content-404 h1.head span {
        position: relative;
        display: inline-block;
    }

    .content-404 h1.head span:before,
    .content-404 h1.head span:after {
        position: absolute;
        top: 50%;
        width: 50%;
        height: 1px;
        background: #fff;
        content: '';
    }

    .content-404 h1.head span:before {
        left: -55%;
    }

    .content-404 h1.head span:after {
        right: -55%;
    }

    .btn-outline {
        border: 2px solid #fff;
        color: #fff;
        padding: 12px 40px;
        border-radius: 25px;
        margin-top: 25px;
        display: inline-block;
        font-weight: 600;
    }

    .btn-outline:hover {
        color: #aa076b;
        background: #fff;
    }


    @media (max-width: 1024px) {

        .content-404 h1.head {
            font-size: 200px;
            letter-spacing: 25px;
        }

    }

    @media (max-width: 768px) {

        .content-404 h1.head {
            font-size: 150px;
            letter-spacing: 25px;
        }

        .bwt-footer-copyright .left-text {
            text-align: center;
            margin: 10px 0;
        }

        .bwt-footer-copyright .right-text {
            text-align: center;
            margin: 10px 0;
        }

    }

    @media (max-width: 640px) {

        .content-404 h1.head {
            font-size: 150px;
            letter-spacing: 0;
        }

    }

    @media (max-width: 480px) {

        .brand h3 {
            font-size: 20px;
        }

        .content-404 h1.head {
            font-size: 130px;
            letter-spacing: 0;
        }

        .content-404 h1.head span:before,
        .content-404 h1.head span:after {
            width: 40%;
        }

        .content-404 h1.head span:before {
            left: -45%;
        }

        .content-404 h1.head span:after {
            right: -45%;
        }

        p {
            font-size: 18px;
        }

    }

    @media (max-width: 320px) {

        .brand h3 {
            font-size: 16px;
        }

        .content-404 h1.head {
            font-size: 100px;
            letter-spacing: 0;
        }

        .content-404 h1.head span:before,
        .content-404 h1.head span:after {
            width: 25%;
        }

        .content-404 h1.head span:before {
            left: -30%;
        }

        .content-404 h1.head span:after {
            right: -30%;
        }

    }

</style>


