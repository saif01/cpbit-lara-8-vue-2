<template>
    <div class="mt-lg-2 mt-sm-0">
        <div class="background_color_2 box-shadow col-lg-11 col-12 m-auto py-4 rounded">
            <div>
                <p class="text-center h3">iVCA Audit Dashboard</p>
            </div>

            <div class="d-flex flex-wrap justify-content-around align-items-center adjust-gap">
                <div class="col-12 col-lg-6 m-auto responsive-gap">
                    <div class="d-flex flex-column align-items-center">
                        <div> 
                            <router-link :to="{ name:'ivca_mro_schedule' }">
                            <img src="/all-assets/common/logo/cpb/mro.png" alt="image" class="img-fluid images"
                            /></router-link>
                        </div>
                        <div class="h2 my-1">MRO</div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 m-auto">
                    <div class="d-flex flex-column align-items-center">
                        <div>
                            <router-link :to="{ name:'ivca_food_schedule' }">
                            <img src="/all-assets/common/logo/cpb/food.png" alt="image"
                                class="img-fluid images" />
                            </router-link>
                        </div>
                        <div class="h2 my-1">FOOD</div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</template>


<style scoped>
.background_color_2 {
    background: #aa4b6b;
    background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
}
.background_color {
    background: #16222a;
    background: -webkit-linear-gradient(to right, #3a6073, #16222a);
    background: linear-gradient(to right, #3a6073, #16222a);
    height: 100vh;
}
.box-shadow {
    color: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.images {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    transition: 0.3s;
}
.images:hover {
    transform: scale(1.1);
}
@media screen and (max-width: 500px) {
    .responsive-gap {
        padding-bottom: 1.5rem;
    }
}
</style>
