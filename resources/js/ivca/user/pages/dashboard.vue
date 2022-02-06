<template>
    <div>

        <mro-food-choose v-if="isFood() && isMro()"></mro-food-choose>

        <mro-schedule v-if="!isFood() && isMro()"></mro-schedule>
        
        <food-schedule v-if="isFood() && !isMro()"></food-schedule>

        <no-access v-if="!isFood() && !isMro()"></no-access>

        <!-- <div v-if="isAdministrator()">
            <p>isUser: {{ isUser() }}, isAdmin: {{ isAdmin() }}, isAuditor: {{ isAuditor() }}, isFood: {{ isFood() }},
            isMro: {{ isMro() }}</p> 
        </div> -->
        
    </div>
</template>

<script>
  
    import moment from 'moment';

    import mroFoodChoose from './mro-food-choose.vue';
    import mroSchedule from './mro/schedule.vue';
    import foodSchedule from './food/schedule.vue';
    import noAccess from './common/no-access.vue';

    export default {

        components: {
            'mro-food-choose'   : mroFoodChoose,
            'mro-schedule'      : mroSchedule,
            'food-schedule'     : foodSchedule,
            'no-access'         : noAccess,
        },

        data() {

            return {
                
                // current page url
                currentUrl: '/ivca/audit',
                sort_direction: 'asc',
                sort_field: 'date',
                allVendors: {},
                todayDate: moment().format("Y-MM-DD"),
            }

        },


        methods: {

        },


        created() {
            this.$Progress.start();

            console.log('Today', this.todayDate, this.isFood(), this.isMro())

            this.$Progress.finish();
        }

    }

</script>


<style>
    .link-hobar {
        cursor: pointer;
    }

    .link-hobar-disabled {
        cursor: not-allowed;
    }

    .spacing {
        letter-spacing: 5px;
    }


</style>
