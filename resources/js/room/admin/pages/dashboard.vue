<template>
    <div>
        <h1>Room Admin</h1>

        Current ID: {{ auth.login }}
    </div>
</template>

<script>
export default {
    

    created(){
        console.log('I am room admin dashboard')
    }
}
</script>