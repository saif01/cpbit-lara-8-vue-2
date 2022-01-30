<template>
    <div>
        <div class="area">
            <nav-bar></nav-bar>
            <div>
                <div class="d-flex flex-wrap justify-content-around">
                    <div class="col-lg-3 col-12">
                        <a @click="$emit('showTemp', 'user')" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column m-auto">
                            <div class="logo_div">
                                <div class="user_section img__logo"><img src="/all-assets/common/icon/user-section.png" alt="background" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">User Section</div> 
                        </a>
                    </div>

                    <div class="col-lg-3 col-12 responsive_gap">
                        <a @click="$emit('showTemp', 'admin')" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="admin_section img__logo"><img src="/all-assets/common/icon/admin-section.png" alt="background" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Admin Section</div> 
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-around mt-4">
                    <div class="col-lg-3 col-12">
                        <a href="/logout" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="logout img__logo"><img src="/all-assets/common/icon/logout.png" alt="background" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Logout</div> 
                        </a>
                    </div>
                </div>
                <footer-bar></footer-bar>
            </div>
        </div>
    </div>
</template>

<script>
import navbar from "./navbar.vue"
import footer from "./footer.vue"
export default {
    components:{
        "nav-bar":navbar,
        "footer-bar":footer
    },
    methods:{
        redirectToHome(){
            window.location.href = '/';
        }
    }
}
</script>