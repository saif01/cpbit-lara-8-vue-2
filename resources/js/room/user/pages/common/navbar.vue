<template>
    <div>
        <b-navbar toggleable="lg" type="dark" class="nav-color shadow-lg">
            <b-navbar-brand href="/">
                <img src="/all-assets/common/logo/cpb/cpbgroup.png"
                    alt="iVCA" class="img-fluid logo" />
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <!-- <a href="/dashboard" class="nav-link mr-5">Home</a>  -->

                   <b-nav-item>
                       <router-link :to="{ name: 'Dashboard'}"><span>Dashboard</span></router-link>
                    </b-nav-item>


                    <!-- <b-nav-item-dropdown text="Lang" right>
                        <b-dropdown-item href="#">EN</b-dropdown-item>
                        <b-dropdown-item href="#">ES</b-dropdown-item>
                        <b-dropdown-item href="#">RU</b-dropdown-item>
                        <b-dropdown-item href="#">FA</b-dropdown-item>
                    </b-nav-item-dropdown> -->

                    <!-- <b-nav-item-dropdown right>
                        <template #button-content>
                            <img
                                src="/all-assets/image/Admin.png"
                                alt="logo"
                                class="img-fluid drodown-image"
                            />
                        </template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown> -->

                    <a href="/user-logout" class="nav-link">Logout</a>


                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<style>
.logo{
    height: 40px;
    width: 40px;
    background: white;
    border-radius: 25%;
}
.drodown-image {
    height: 40px;
    width: 40px;
    border-radius: 50%;
}


.nav-color {
    background: #aa4b6b;
    background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
}
/* ul li:hover {
    border-bottom: 1px solid #5d97e2;
    color: white;
    margin: 0 !important;
    background-color: transparent !important;
    border-radius: 0px !important;
} */
ul {
    align-items: center;
}
/* a {
    color: #c2c7d0 !important;
} */
</style>
