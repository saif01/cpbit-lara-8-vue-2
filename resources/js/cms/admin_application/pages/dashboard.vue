<template>
    <div>
        <h1>Application Admin Dashboard</h1>

    </div>
</template>

<script>
    export default {

        data() {
            return {

                //current page url
                currentUrl: '/room/booking',


            }
        },

        methods: {


        },

        created() {

            this.$Progress.start();

            this.$Progress.finish();
        }
    }

</script>
