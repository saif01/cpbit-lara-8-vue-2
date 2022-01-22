<template>
    <div>
        <div id="sidebar-container" class="sidebar-container">
            <b-nav vertical>
                <a href="/">
                    <div class="d-flex align-items-center text-white my-2">
                        <img src="/all-assets/common/logo/cpb/cpbit.png" alt="logo"
                            class="img-fluid admin_logo_sidenav ml-2 mr-3" />
                        <div class="h4 pt-3">Room Admin</div>
                    </div>
                </a>
                <ul class="list-unstyled">
                    <b-nav-item>
                        <router-link :to="{ name: 'Dashboard' }">
                            <li><i class="fas fa-tachometer-alt "></i>
                                Dashboard
                            </li>
                        </router-link>
                    </b-nav-item>

                    <b-nav-item>
                        <router-link :to="{ name: 'RoomIndex' }">
                            <li><i class="fas fa-home"></i>
                                Rooms
                            </li>
                        </router-link>
                    </b-nav-item>

                    <b-nav-item>
                        <router-link :to="{ name: 'ReportIndex' }">
                            <li><i class="fas fa-book"></i>
                                Reports
                            </li>
                        </router-link>
                    </b-nav-item>

                  


                    <b-nav-item @click="logout()">
                        <router-link to="/logout">
                            <li><i class="fas fa-sign-out-alt text-danger"></i>
                                Logout
                            </li>
                        </router-link>
                    </b-nav-item>







                </ul>
            </b-nav>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            logout() {
                window.location.href = "/logout"
            }
        }
    }

</script>

<style scoped>
    .admin_logo_sidenav {
        height: 30px;
        width: 30px;
    }

    .sidebar-container {
        height: 100vh;
        left: 0;
        background: #44a08d;
        background: -webkit-linear-gradient(to bottom, #093637, #44a08d);
        background: linear-gradient(to bottom, #093637, #44a08d);
    }

    ul li {
        transition: 0.1s;
        color: #ffffff;
    }

    ul li:hover {
        background-color: #44a08d;
        /* background-color: #093637; */
        color: white;
        border-radius: 8px;
        margin: 0 0.1rem;
    }

    a {
        text-decoration: none;
    }

    i {
        font-size: large;
        margin-right: .25rem;
    }

    .drop-element-2 {
        margin-left: 1.5rem;
    }

    .drop-element {
        margin-left: 1rem;
    }

    .collapsed:after {
        float: right;
        content: "\f067";
        font-family: "Font Awesome\ 5 Free";
        font-weight: 900;
    }

    .not-collapsed:after {
        float: right;
        content: "\f068";
        font-family: "Font Awesome\ 5 Free";
        font-weight: 900;
    }

    .router-link-exact-active {
        color: #2bed0f !important;
        /* text-decoration: none;
        border-bottom: 2px solid; */
    }

    .router-link-exact-active li  {
        border-radius: 10px;
        border-bottom: 4px solid #f02471;
        color: white;
    }

</style>
