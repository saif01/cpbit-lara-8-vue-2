<template>
    <div class="bg_grad">
        <nav-bar headerText="Admin"></nav-bar>

        <v-row class="d-flex flex-wrap justify-content-around my-5" style="min-height: 100vh;">

            <v-col cols="6" lg="3" class="text-center" v-if="isSuperAdmin()">
                <a href="/super_admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/super-admin.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Super Admin</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isCarpoolAdmin()">
                <a href="/carpool/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/car.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Carpool</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isRoomAdmin()">
                <a href="/room/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/room.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Room</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isApplicationAdmin()">
                <a href="/cms/a_admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/application.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Appliaction</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isHardwareAdmin()">
                <a href="/cms/h_admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/hardware.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Hardware</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isInventory()">
                <a href="/inventory/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/inventory.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Inventory</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isSmsAdmin()">
                <a href="/sms/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/sms.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">SMS</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isPowerbiAdmin()">
                <a href="/pbi/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/powerbi.png" contain></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Power BI</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isIvcaAdmin()">
                <a href="/ivca/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/ivca.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iVCA</div>
                </a>
            </v-col>

            
            <v-col cols="6" lg="3" class="text-center" v-if="isNetwork()">
                <a href="/network/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/network.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Network</div>
                </a>
            </v-col>

           

            <v-col cols="6" lg="3" class="text-center" v-if="isItempAdmin()">
                <a href="/itemp/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/itemp.png" contain></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iTemp</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isAdministrator()">
                <a href="/mobile_app" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/mobileapp.png" contain></v-img>
                    </v-avatar>
                    <div class="h3 my-3">Mobile App</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center" v-if="isAdministrator()">
                <a href="/iaccess/admin" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/iaccess.png"></v-img>
                    </v-avatar>
                    <div class="h3 my-3">iAccess</div>
                </a>
            </v-col>

            <v-col cols="6" lg="3" class="text-center">
                <a href="/logout" class="text-decoration-none text-dark">
                    <v-avatar size="150">
                        <v-img src="/all-assets/common/icon/logout.png" contain></v-img>
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
        background: linear-gradient(to right, #F0C8BA, #F08D89);
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
