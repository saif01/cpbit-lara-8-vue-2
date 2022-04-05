<template>
    <div>
        <v-app-bar app flat dense dark class="nav-color">

            <v-app-bar-nav-icon href="/">
                <v-img  src="/all-assets/common/icon/powerbi.png" alt="room" max-height="40" max-width="40" contain class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                Dashboard
            </v-btn>

            <!-- <v-btn v-for="(item, index) in pbis" :key="index" text link route :to="{ name: 'Dashboard'}" small exact>
                {{}}
            </v-btn> -->

            <!-- <v-btn text link route :to="{ name: 'Booked'}" small>
                My Booked
            </v-btn> -->

             <v-menu offset-y>
          <template v-slot:activator="{ on }">
            <v-btn
              dark
              icon
              v-on="on"
            >
              <v-icon color="primary">notifications</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-list dense>
              <v-subheader>Notifications</v-subheader>
              <v-divider></v-divider>
              <v-list-tile
                v-for="notification in notifications"
                :key="`notification-key-${notification.id}`"
              >
                <v-list-tile-title>
                  {{ notification.title }}
                </v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-card>
        </v-menu>

           
            <v-btn text link route href="/logout" small>
                Logout
            </v-btn>

        </v-app-bar>
    </div>
</template>

<script>

    export default{
        data(){
            return{

                 notifications: [
        { id: 1, title: 'Click Me' },
        { id: 2, title: 'Click Me' },
        { id: 3, title: 'Click Me' },
        { id: 4, title: 'Click Me 2' }
      ]

            }
        },

        methods:{

            getUserAccess(){

            }

        },

        created(){


        }


    }

    
</script>

<style scoped>
    .v-btn--active{
        color: #fff;
        background: linear-gradient(90deg,#aa4b6b,#6b6b83,#3b8d99);
    }
    
    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .nav-logo-bg{
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover{
        text-decoration: none;
    }


</style>
