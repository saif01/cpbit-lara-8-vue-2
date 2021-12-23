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

                    <!-- Super Admin -->
                    <div class="col-lg-3 col-6" v-if="isSuperAdmin()">
                        <a href="/super_admin" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="helpDesk img__logo"><img src="/all-assets/common/icon/super-admin.png" alt="iHelp Desk" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Super Admin</div> 
                        </a>
                    </div>

                    <!-- Room -->
                    <div class="col-lg-3 col-6" v-if="isRoomAdmin()">
                        <a href="/room/admin" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="room img__logo"><img src="/all-assets/common/icon/room.png" alt="Room" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Room</div> 
                        </a>
                    </div>

                    <!-- <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="carpool img__logo"><img src="/all-assets/common/icon/car.png" alt="Carpool" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Carpool</div> 
                        </a>
                    </div>
                   
                    <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="hardware img__logo"><img src="/all-assets/common/icon/hardware.png" alt="Hardware" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Hardware</div> 
                        </a>
                    </div> -->
                </div>

                <!-- <div class="d-flex flex-wrap justify-content-around mt-5">
                    <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="inventory img__logo"><img src="/all-assets/common/icon/inventory.png" alt="Inventory" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Inventory</div> 
                        </a>
                        
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="powerBi img__logo"><img src="/all-assets/common/icon/powerbi.png" alt="Power BI" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Power BI</div> 
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="network img__logo"><img src="/all-assets/common/icon/network.png" alt="Network" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Network</div> 
                        </a>
                    </div>

                     <div class="col-lg-3 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="application img__logo"><img src="/all-assets/common/icon/application.png" alt="Application" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Application</div> 
                        </a>
                    </div>
                   
                </div> -->

                <!-- <div class="d-flex flex-wrap mt-5 justify-content-around">
                    <div class="col-lg-6 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="audit img__logo"><img src="/all-assets/common/icon/audit.png" alt="Audit" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Audit</div> 
                        </a>
                    </div>
                    <div class="col-lg-6 col-6">
                        <a href="/userdashboard" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="sms img__logo"><img src="/all-assets/common/icon/sms.png" alt="SMS" class="img-fluid rotate_icon"></div>
                            </div>
                            <div class="h3 mt-3 logo_text_response text-center font-weight-bold">SMS</div> 
                        </a>
                    </div>
                </div> -->

                <div class="d-flex flex-wrap justify-content-around mt-5 pb-5">
                    <div class="col-lg-6 col-12">
                        <a href="/logout" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                            <div class="logo_div">
                                <div class="logout img__logo"><img src="/all-assets/common/icon/logout.png" alt="Logout" class="img-fluid rotate_icon"></div>
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