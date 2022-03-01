<template>
    <div>
        <v-app-bar app flat dense dark class="nav-color">

            <v-app-bar-nav-icon href="/dashboard">
                <v-img src="/all-assets/common/logo/cpb/cpbit.png" alt="iVCA" max-height="40" max-width="40" contain
                    class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-btn small text link route exact :to="{ name: 'ivca_dashboard'}">
                Dashboard
            </v-btn>

            <!-- <v-btn small text link route href="/ivca">
                Dashboard
            </v-btn> -->
            
            <!-- v-if="isMro()" -->
            <v-btn  small text link route :to="{ name: 'ivca_mro_schedule'}">
                Mro Schedules
            </v-btn>

            <!-- v-if="isFood()" -->
            <v-btn  small text link route :to="{ name: 'ivca_food_schedule'}">
                Food Schedules
            </v-btn>

            <v-btn small text link route href="/user-logout">
                Logout
            </v-btn>

        </v-app-bar>
    </div>
</template>

<style>
    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .v-btn--active {
        color: #fff;
        background: linear-gradient(to right, #aa4b6b, #6b6b83, #3b8d99);
    }

    a:hover {
        text-decoration: none;
    }

    .nav-logo-bg {
        background-color: white !important;
        border-radius: 8px;
    }

</style>
