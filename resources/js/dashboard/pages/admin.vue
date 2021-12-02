<template>
    <div>
        <div class="area">
            <a href="/">
            <div class="d-flex justify-content-center align-items-center ">
                <img src="/all-assets/common/logo/cpb/cpbit.png" alt="header-logo" class="img-fluid header__logo">
                <div class="h3 font-weight-bold text-dark">CPB-IT Admin Dashboard</div>
            </div>
            </a>
            <div>
                <div class="bg_image_logo">
                    <img src="/all-assets/common/logo/cpb/cpbit.png" alt="background">
                </div>

                <div class="d-flex flex-wrap mt-5">
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="carpool"><img src="/all-assets/common/icon/car.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Carpool</li> 
                            </ul>
                        </a>
                        
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="helpDesk"><img src="/all-assets/common/icon/application.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">iHelp Desk</li>
                            </ul> 
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="application"><img src="/all-assets/common/icon/car.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Application</li> 
                            </ul>
                        </a>
                        
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="hardware"><img src="/all-assets/common/icon/hardware.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Hardware</li> 
                            </ul>
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-wrap mt-5">
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="inventory"><img src="/all-assets/common/icon/Inventory.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Inventory</li> 
                            </ul>
                        </a>
                        
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="powerBi"><img src="/all-assets/common/icon/powerbi.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Power BI</li>
                            </ul> 
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="network"><img src="/all-assets/common/icon/network.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Network</li> 
                            </ul>
                        </a>
                        
                    </div>
                    <div class="col-lg-3 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="room"><img src="/all-assets/common/icon/room.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Room</li> 
                            </ul>
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-wrap mt-5">
                    <div class="col-lg-6 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="audit"><img src="/all-assets/common/icon/audit.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">Audit</li> 
                            </ul>
                        </a>
                        
                    </div>
                    <div class="col-lg-6 col-6 d-flex justify-content-center align-items-center">
                        <a to="/userdashboard" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="sms"><img src="/all-assets/common/icon/sms.png" alt="background" class="img-fluid rotate_icon"></p></li>
                                <li class="h3 mt-3 pt-3 logo_text_response text-center font-weight-bold">SMS</li> 
                            </ul>
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-around mt-5 pb-5">
                    <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center">
                        <a href="/logout" class="text-decoration-none text-dark">
                            <ul>
                                <li><p class="logout"><img src="/all-assets/common/icon/logout.png" alt="background" class="img-fluid rotate_icon"></p></li>
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
