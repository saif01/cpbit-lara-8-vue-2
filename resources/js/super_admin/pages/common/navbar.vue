<template>
    <div>
        <div id="navbar-container" class="shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div id="collapseIcon" class="btn ml-1" @click="(active = !active), response(active)">
                    <i class="fas fa-bars"></i>
                </div>

                <div>
                    <span v-if="isAdministrator()" class="text-danger">Administrator</span>
                </div>

                <div class="d-flex flex-items align-items-center">
                    <div class="d-flex align-items-center" :class="{ 'icon-hide-reponsive': active }">
                        <div class="mx-2">
                            <i class="fas fa-search"></i>
                        </div>
                        <b-dropdown variant="none" no-caret>
                            <template #button-content><i class="far fa-comment-dots"></i></template>
                            <b-dropdown-item href="#">An item</b-dropdown-item>
                            <b-dropdown-item href="#">Another item</b-dropdown-item>
                        </b-dropdown>
                        <b-dropdown variant="none" no-caret>
                            <template #button-content><i class="far fa-bell"></i><span class="badge badge-warning badge_notification">9</span>
                            </template>
                            <b-dropdown-item href="#">An item</b-dropdown-item>
                            <b-dropdown-item href="#">Another item</b-dropdown-item>
                        </b-dropdown>
                        <div class="mx-2">
                            <i :class="{'fas fa-compress': fullMode,'fas fa-compress-arrows-alt': !fullMode,}" @click="(fullMode = !fullMode), toggle()"></i>
                        </div>
                    </div>
                     <b-dropdown variant="none" no-caret>
                        <template #button-content>
                            <img src="https://www.w3schools.com/howto/img_avatar.png" class="avatar" alt="User Image" />
                            <span style="color: black">{{ auth.name }}</span>
                        </template>
                        <b-dropdown-item href="/logout">Sign Out</b-dropdown-item>
                    </b-dropdown>
                   
                </div>
            </div>
        </div>
    </div>
</template>


<script>

export default {
    data() {
        return {
            active: false,
            fullMode: true,
        };
    },
    props: {
        response: Function,
    },
    methods: {
        toggle() {
            if (!this.fullMode) {
                this.expand();
            } else {
                this.exitExpand();
            }
        },
        expand() {
            var elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            }
        },
        exitExpand() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        },
    },

    watch:{
        $route (to, from){
            const size= window.innerWidth ;
            if(size < 700){
                document.getElementById("collapseIcon").click();
            }else{
                
            }
        }
    },

};
</script>


<style scoped>
#navbar-container {
    background-color: #ffffff;
}

.avatar {
    vertical-align: middle;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

i {
    font-size: large;
    cursor: pointer;
}

a {
    text-decoration: none;
}

.badge_notification{
    position: absolute ;
    top: 0px ;
    left: 21px ;
}

.btn_border:focus{
    outline: none !important;
    border: none !important;
}
@media screen and (max-width: 800px) {
    .icon-hide-reponsive {
        display: none !important;
    }
}
</style>