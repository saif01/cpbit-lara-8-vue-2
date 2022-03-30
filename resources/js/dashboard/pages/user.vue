<template>
    <div class="bg_grad">
        <nav-bar headerText="User"></nav-bar>
        <div style="min-height: 100vh;">
            <div class="d-flex flex-wrap justify-content-around">

                <div class="col-lg-3 col-6" v-if="isCarpool()">
                    <a href="/carpool" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="carpool img__logo"><img src="/all-assets/common/icon/car.png" alt="Carpool" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Carpool</div> 
                    </a>
                </div>

                <div class="col-lg-3 col-6" v-if="isRoom()">
                    <a href="/room" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="room img__logo"><img src="/all-assets/common/icon/room.png" alt="Room" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Room</div> 
                    </a>
                </div>

                <div class="col-lg-3 col-6" v-if="isCms()">
                    <a href="/cms" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="helpDesk img__logo"><img src="/all-assets/common/icon/application.png" alt="iHelp Desk" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">CMS</div> 
                    </a>
                </div>

                <div class="col-lg-3 col-6" v-if="isSms()">
                    <a href="/sms" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="sms img__logo"><img src="/all-assets/common/icon/sms.png" alt="SMS" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">SMS</div> 
                    </a>
                </div>


                
               
                
            </div>

            <div class="d-flex flex-wrap mt-5 justify-content-around">
                <div class="col-lg-3 col-6">
                    <a href="/pbi" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="powerBi img__logo"><img src="/all-assets/common/icon/powerbi.png" alt="Power BI" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">Power BI</div> 
                    </a>
                </div>
                <div class="col-lg-3 col-6" v-if="isIvca()">
                    <a href="/ivca" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="audit img__logo"><img src="/all-assets/common/icon/audit.png" alt="iVca" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">iVCA</div> 
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="/iaccess" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="audit img__logo"><img src="/all-assets/common/icon/audit.png" alt="iVca" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">iAccess</div> 
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="/itemp" class="text-decoration-none text-dark d-flex justify-content-center align-items-center flex-column">
                        <div class="logo_div">
                            <div class="network img__logo"><img src="/all-assets/common/icon/network.png" alt="Network" class="img-fluid rotate_icon"></div>
                        </div>
                        <div class="h3 mt-3 logo_text_response text-center font-weight-bold">iTemp</div> 
                    </a>
                </div>
            </div>

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

        </div>
        <footer-bar></footer-bar>
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

<style scoped>
    .bg_grad{
        background: -webkit-linear-gradient(to right, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        width: 100%;
    }
</style>