<template>
    <div>
        <h1>Super Admin</h1>

        Current ID: {{ auth.login }}
    </div>
</template>

<script>
export default {
    

    created(){
        console.log('I am super admin dashboard')
    }
}
</script>