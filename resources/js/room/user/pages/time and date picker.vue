<template>
    <div>

    
        <v-row>
            <!-- date picker -->
            <v-col cols="12" md="6">
                <v-menu v-model="menu" min-width="auto" >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        v-model="date"
                        label="Start Date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        ></v-text-field>
                    </template>

                    <v-date-picker v-model="date" no-title scrollable >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">
                            Cancel
                        </v-btn>

                        <v-btn text color="success" >
                            Set Today
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>

            <v-col cols="12" md="6">
                <v-menu v-model="menu2" min-width="auto" >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        v-model="date2"
                        label="End Date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        ></v-text-field>
                    </template>

                    <v-date-picker v-model="date2" no-title scrollable >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu2 = false">
                            Cancel
                        </v-btn>

                        <v-btn text color="success" >
                            Set Today
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>



            <!-- time picker -->
            
            <v-col cols="12" md="6">
                <v-menu
                    ref="menu3"
                    v-model="menu3"
                    :close-on-content-click="false"
                    :return-value.sync="time"
                    max-width="290px"
                    min-width="290px"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                    v-model="time"
                    label="Start Time"
                    prepend-icon="mdi-clock-time-four-outline"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="menu3"
                    v-model="time"
                    full-width
                    @click:minute="$refs.menu3.save(time)"
                    ampm-in-title
                ></v-time-picker>
                </v-menu>
            </v-col>

            <v-col cols="12" md="6">
                <v-menu
                    ref="menu4"
                    v-model="menu4"
                    :close-on-content-click="false"
                    :return-value.sync="time"
                    max-width="290px"
                    min-width="290px"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                    v-model="time2"
                    label="End Time"
                    prepend-icon="mdi-clock-time-four-outline"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    ></v-text-field> 
                </template>
                <v-time-picker 
                    v-if="menu4" 
                    v-model="time2"
                    full-width 
                    @click:minute="$refs.menu4.save(time)"
                    ampm-in-title
                ></v-time-picker>
                </v-menu>
            </v-col>>
            
        </v-row>

    </div>
</template>





<script>
export default {
    data(){
        return{
            menu:false,
            menu2:false,
            menu3:false,
            menu4:false,
            date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            date2: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            time:'',
            time2:'',
        }
    }
}
</script>