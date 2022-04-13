<template>
    <div class="bg_grad">
        <nav-bar headerText="User"></nav-bar>
        <v-row class="d-flex flex-wrap justify-content-around my-5" style="min-height: 100vh;">
            <v-col cols="6" lg="3" class="text-center" v-if="isCarpool()">
                <a href="/carpool" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/car.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Carpool</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isRoom()">
                <a href="/room" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/room.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Room</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isCms()">
                <a href="/cms" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/cms.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">CMS</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isSms()">
                <a href="/sms" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/sms.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">SMS</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isPowerbi()">
                <a href="/pbi" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/powerbi.png" contain></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Power BI</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isIvca()">
                <a href="/ivca" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/ivca.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iVCA</div>
                </a>
            </v-col>

        
            <v-col cols="6" lg="3" class="text-center" v-if="isItemp()">
                <a href="/itemp" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/itemp.png" contain></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iTemp</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isAdministrator()">
                <a href="/iaccess" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/iaccess.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iAccess</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center">
                <a href="/logout" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/logout.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Logout</div>
                </a>
            </v-col>

        </v-row>

        <footer-bar></footer-bar>

    </div>
</template>

<script>
    import navbar from "./navbar.vue"
    import footer from "./footer.vue"
    export default {
        components: {
            "nav-bar": navbar,
            "footer-bar": footer
        },

        methods: {
            redirectToHome() {
                window.location.href = '/';
            }
        }
    }

</script>

<style scoped>
    .bg_grad {
        background: linear-gradient(90deg, #eaecc6, #2bc0e4);
        width: 100%;
        min-height: 100vh;
    }

    .v-avatar {
        box-shadow: 0px 10px 7px rgb(0 0 0 / 42%);
        transition: .5s;
        border: 3px solid black;
    }

    .v-avatar:hover {
        transform: scale(1.2);
    }

    @media all and (max-width:800px) {
        .v-avatar {

            height: 100px !important;
            min-width: 100px !important;
            width: 100px !important;

        }
        .v-avatar + div{
            font-size: 1.2rem !important;

        }
    }

</style>
