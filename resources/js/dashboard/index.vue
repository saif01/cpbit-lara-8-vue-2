<template>
    <div>

        <choose-dashboard></choose-dashboard>
        <user-dashboard></user-dashboard>
        <admin-dashboard></admin-dashboard>
        <a href="/logout" >Logout</a>
    </div>
</template>

<script>

import chooseDashboard from './pages/choose.vue'
import userDashboard from './pages/user.vue'
import adminDashboard from './pages/admin.vue'

export default {

    components:{
        'choose-dashboard'  : chooseDashboard,
        'user-dashboard'    : userDashboard,
        'admin-dashboard'   : adminDashboard,
    }
    
}
</script>