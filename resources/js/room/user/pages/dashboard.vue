<template>
    <div>
        <calendar-view></calendar-view>
    </div>
</template>

<script>

    import CalendarView from './calendar.vue'

    export default {
        components:{
            'calendar-view' : CalendarView
        },

        created(){
            console.log('I am room dashboard')
        }
    }
</script>