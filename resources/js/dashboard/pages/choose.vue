<template>
    <div>
        <div class="area">
            <b-navbar class="shadow py-0" variant="dark">
                <b-navbar-brand @click="redirectToHome()" class="m-auto d-flex align-items-center py-0">
                    <img src="/all-assets/common/logo/cpb/cpbit.png" alt="header-logo" class="img-fluid header__logo">
                    <div class="h3 font-weight-bold text-white nav_text">CPB-IT Dashboard</div>
                </b-navbar-brand>
                <b-navbar-nav>
                    <b-nav-item>
                            <b-button @click="redirectToHome()" variant="primary"><i class="fas fa-tachometer-alt"></i> Home</b-button>
                    </b-nav-item>
                </b-navbar-nav>
            </b-navbar>
            <div>
                <div class="d-flex flex-wrap justify-content-around mt-5">
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
                <div class="footer fixed-bottom text-center dashboard_footer_bg">
                    Copyright © Powered By CPB-IT
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
    methods:{
        redirectToHome(){
            window.location.href = '/';
        }
    }
}
</script>