<template>
    <div>
        <div class="area">
            <div class="d-flex justify-content-center align-items-center  blink">
                <img src="/all-assets/common/logo/cpb/cpbit.png" alt="header-logo" class="img-fluid header__logo">
                <div class="h3 font-weight-bold text-dark">CPB-IT Dashboard</div>
            </div>
            <div>
                <div class="bg_image_logo">
                    <img src="/all-assets/common/logo/cpb/cpbit.png" alt="background">
                </div>
                <div class="d-flex flex-wrap justify-content-around mt-5">
                    <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center">
                        <a @click="$emit('showTemp', 'user')" class="text-decoration-none text-dark">
                            <ul>
                                <li>
                                    <p class="user_section"><img src="/all-assets/common/icon/user-section.png"
                                            alt="background" class="img-fluid rotate_icon"></p>
                                </li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">User Section
                                </li>
                            </ul>
                        </a>
                    </div>

                    <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center responsive_gap">
                        <a @click="$emit('showTemp', 'admin')" class="text-decoration-none text-dark">
                            <ul>
                                <li>
                                    <p class="admin_section"><img src="/all-assets/common/icon/admin-section.png"
                                            alt="background" class="img-fluid rotate_icon"></p>
                                </li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Admin Section
                                </li>
                            </ul>
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-around mt-4">
                    <div class="col-lg-6 col-6 d-flex justify-content-center align-items-center">
                        <a href="/logout" class="text-decoration-none text-dark">
                            <ul>
                                <li>
                                    <p class="logout"><img src="/all-assets/common/icon/logout.png" alt="background"
                                            class="img-fluid rotate_icon"></p>
                                </li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Logout</li>
                            </ul>
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

