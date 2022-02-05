<template>
    <div>
        <div class="text-center">  
            <router-link :to="{name:'ivca_dashboard'}">
                <img src="/all-assets/common/logo/gif/404.gif" alt="404" class="img-fluid" />
            </router-link>
            <div>
                <router-link :to="{name:'ivca_dashboard'}" class="btn btn-danger">Go Home </router-link>
                <p>Oops! The Page you requested was not found!</p>
            </div>
        </div>

    </div>
</template>
