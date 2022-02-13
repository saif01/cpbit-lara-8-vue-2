<template>
        <v-dialog v-model="carDetailsDialog" max-width="1000px">


            <v-card  v-if="currentCarId">
                
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                           {{currentCarId.name}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="carDetailsDialog = false" color="error white--text" small
                                class="float-right" icon>
                                <v-icon left dark>mdi-close-octagon</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>

                    <v-row>

                        <v-col cols="12" md="7">
                            <v-carousel :continuous="false" cycle :show-arrows="false" hide-delimiter-background delimiter-icon="mdi-minus" height="250">
                                <v-carousel-item :src="imagePath + currentCarId.image" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                                <v-carousel-item :src="imagePath + currentCarId.image2" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                                <v-carousel-item :src="imagePath + currentCarId.image3" reverse-transition="fade-transition" transition="fade-transition"></v-carousel-item>
                                {{currentCarId.name}}
                            </v-carousel>
                        </v-col>

                        <v-col cols="12" md="5">
                            <v-list dense>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>Aircondition</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch inset input-value="true" readonly dense></v-switch>
                                    </v-list-item-action>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>Auto Power Door Lock</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch inset input-value="true" readonly dense></v-switch>
                                    </v-list-item-action>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>Auto Gearbox</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch inset input-value="true" readonly dense></v-switch>
                                    </v-list-item-action>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>CD/DVD Player</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch inset input-value="true" readonly dense></v-switch>
                                    </v-list-item-action>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>CNG/Petrol</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch inset input-value="true" readonly dense></v-switch>
                                    </v-list-item-action>
                                </v-list-item>
                            </v-list>
                        </v-col>

                    </v-row>
                    
                </v-card-text>
            </v-card>

        </v-dialog>
</template>


<script>
    export default {

        props:['currentCarId'],



        data() {
            return {

                carDetailsDialog: true,

                imagePath: '/images/carpool/car/',
                imagePathSm: '/images/carpool/car/small/'
            }
        },

    }

</script>
