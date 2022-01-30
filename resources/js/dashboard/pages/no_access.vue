<template>
    <div class="area">
        <nav-bar></nav-bar>
        <div>
            <div class="bg_image_logo">
                <img src="/all-assets/common/logo/cpb/cpbit.png" alt="background">
            </div>
            <div class="d-flex flex-wrap justify-content-around mt-5">

                <h1 class="text-danger">Sorry!! You have No Access. Contact with IT</h1>

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
            <footer-bar></footer-bar>
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
}
</script>
