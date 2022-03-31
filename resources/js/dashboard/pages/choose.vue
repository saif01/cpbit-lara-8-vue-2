<template>
    <div>
        <div class="area">
            <nav-bar></nav-bar>

            <v-row class="d-flex flex-wrap justify-content-around my-5" style="min-height: 100vh;">
                <v-col cols="6" lg="6" class="text-center">
                    <a @click="$emit('showTemp', 'user')" class="text-decoration-none text-dark">
                        <v-avatar size="150">
                            <v-img src="/all-assets/common/icon/user-section.png"></v-img>
                        </v-avatar>
                        <div class="h3 my-3">User Section</div>
                    </a>
                </v-col>

                <v-col cols="6" lg="6" class="text-center">
                    <a @click="$emit('showTemp', 'admin')" class="text-decoration-none text-dark">
                        <v-avatar size="150">
                            <v-img src="/all-assets/common/icon/admin-section.png"></v-img>
                        </v-avatar>
                        <div class="h3 my-3">Admin Section</div>
                    </a>
                </v-col>

                <v-col cols="12" class="text-center">
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
