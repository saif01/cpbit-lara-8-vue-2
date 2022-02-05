<template>
    <div>
        <v-app-bar app flat dense dark class="nav-color">

            <v-app-bar-nav-icon href="/">
                <v-img  src="/all-assets/common/logo/cpb/cpbgroup.png" alt="room" max-height="40" max-width="40" contain class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                Dashboard
            </v-btn>

            <v-btn text link route :to="{ name: 'Booked'}" small>
                My Booked
            </v-btn>

            <v-btn text link route :to="{ name: 'Canceled'}" small>
                My Cancelled
            </v-btn>

            <v-btn text link route href="/logout" small>
                Logout
            </v-btn>

        </v-app-bar>
    </div>
</template>

<style scoped>
    .v-btn--active{
        color: #fff;
        background: linear-gradient(90deg,#b86883,#9796f0);
    }
    
    .nav-color {
        background: linear-gradient(to right, #9796f0, #b86883 );
    }

    .nav-logo-bg{
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover{
        text-decoration: none;
    }
</style>
