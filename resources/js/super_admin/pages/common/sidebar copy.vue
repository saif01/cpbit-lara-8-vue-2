<template>
    <div>
        <div id="sidebar-container" class="sidebar-container">
            <b-nav vertical>
                <a href="/">
                    <div class="d-flex align-items-center text-white my-2">
                        <img src="/all-assets/common/logo/cpb/cpbit.png" alt="logo"
                            class="img-fluid admin_logo_sidenav ml-2 mr-3" />
                        <div class="h4 pt-3">S. Admin</div>
                    </div>
                </a>
                <ul class="list-unstyled">
                    <b-nav-item>
                        <router-link :to="{ name: 'Dashboard' }">
                            <li><i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </li>
                        </router-link>
                    </b-nav-item>

                    <!-- <b-nav-item>
                        <router-link to="" v-b-toggle.collapse-1>
                            <li>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div> <i class="fab fa-buromobelexperte mr-3"></i> Dashboard
                                    </div><i class="fas fa-angle-right"></i>
                                </div>
                            </li>
                        </router-link>
                    </b-nav-item>
                    <b-collapse id="collapse-1" class="drop-element">
                        <ul class="list-unstyled">
                            <b-nav-item>
                                <router-link :to="{ name: 'home' }">
                                    <li><i class="fab fa-buromobelexperte mr-3"></i>dash</li>
                                </router-link>
                            </b-nav-item>
                            <b-nav-item v-b-toggle.collapse-2>
                                <li><div class="d-flex align-items-center justify-content-between">
                                        <div><i class="fab fa-buromobelexperte mr-3"></i> Dash2</div>
                                        <i class="fas fa-angle-right"></i>
                                    </div>
                                </li>
                            </b-nav-item>
                        </ul>
                        <b-collapse id="collapse-2" class="drop-element-2">
                            <ul class="list-unstyled">
                                <b-nav-item>
                                    <router-link :to="{ name: 'home' }">
                                        <li><i class="fab fa-buromobelexperte mr-3"></i>dash </li>
                                    </router-link>
                                </b-nav-item>
                            </ul>
                        </b-collapse>
                    </b-collapse> -->


                    <b-nav-item>
                        <li v-b-toggle.collapse-2>
                            <i class="fas fa-users-cog"></i> User Manage
                        </li>
                    </b-nav-item>
                    <b-collapse id="collapse-2" class="drop-element">
                        <ul class="list-unstyled">
                            <b-nav-item v-if="isUserManagement()">
                                <router-link :to="{ name: 'Users' }">
                                    <li><i class="fas fa-users "></i>All User</li>
                                </router-link>
                            </b-nav-item>
                            <b-nav-item v-if="isUserManagement()">
                                <router-link :to="{ name: 'Registered' }">
                                    <li><i class="fas fa-users "></i>All Registered</li>
                                </router-link>
                            </b-nav-item>
                            <b-nav-item v-if="isRoleManage()">
                                <router-link :to="{ name: 'Roles' }">
                                    <li><i class="fab fa-r-project "></i>All Roles</li>
                                </router-link>
                            </b-nav-item>
                        </ul>
                    </b-collapse>

                     <b-nav-item>
                        <li v-b-toggle.collapse-3>
                           <i class="fas fa-building"></i> Zone Manage
                        </li>
                    </b-nav-item>
                    <b-collapse id="collapse-3" class="drop-element">
                        <ul class="list-unstyled">
                            <b-nav-item>
                                <router-link :to="{ name: 'Zones' }">
                                    <li><i class="fas fa-grip-horizontal"></i>All Zones</li>
                                </router-link>
                            </b-nav-item>
                            <b-nav-item>
                                <router-link :to="{ name: 'ZoneOffices' }">
                                    <li><i class="fas fa-grip-horizontal"></i>Zone Offices</li>
                                </router-link>
                            </b-nav-item>
                           
                        </ul>
                    </b-collapse>

                    <b-nav-item @click="logout()">
                        <router-link to="/logout">
                            <li><i class="fas fa-sign-out-alt  text-danger"></i>
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
        margin-right: 0.25rem;
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
