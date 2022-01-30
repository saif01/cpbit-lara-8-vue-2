<template>
    <div>
        <v-app-bar app flat dense color="transparent">
            <v-spacer></v-spacer>
            <v-app-bar-nav-icon>
                <v-img  src="/all-assets/common/logo/cpb/cpbit.png" alt="CPB-IT" max-height="40" max-width="40" contain></v-img>
            </v-app-bar-nav-icon>
            <v-app-bar-title>CPB-IT User Dashboard</v-app-bar-title>

            <v-spacer></v-spacer>


            <v-btn small color="primary" link @click="redirectToHome()">
                Home
            </v-btn>

        </v-app-bar>
    </div>
</template>


<style scoped>
.v-app-bar.v-app-bar--fixed {
  position: relative;
}
</style>