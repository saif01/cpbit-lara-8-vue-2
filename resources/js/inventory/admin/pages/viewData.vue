<template>
    <div>
        <v-dialog v-model="viewModal" persistent max-width="800px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            View Record
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="viewModal = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>

                    <table class="table">
                        <tr>
                            <th>Category Name</th>
                            <td>{{category}}</td>

                            <th>Product Type</th>
                            <td>{{currentData.type}}</td>
                        </tr>
                        
                        <tr>
                            <th>Subcategory</th>
                            <td>{{subcategory}}</td>

                            <th>Product Serial</th>
                            <td>{{currentData.serial}}</td>
                        </tr>

                        <tr>
                            <th>Business Unit</th>
                            <td>{{currentData.business_unit}}</td>

                            <th>Receiver Name</th>
                            <td>
                                <span v-if="currentData.rec_name">
                                    {{currentData.rec_name}}
                                </span>

                                <span v-else>N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Office</th>
                            <td>{{currentData.office}}</td>

                            <th>Receiver Contact</th>
                            <td>
                                <span v-if="currentData.rec_contact">
                                    {{currentData.rec_contact}}
                                </span>

                                <span v-else>N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Operation</th>
                            <td>
                                <span v-if="operation"> {{operation}} </span>
                                <span v-else class="error--text"> N/A </span>
                            </td>

                            <th>Designation</th>
                            <td>
                                <span v-if="currentData.rec_position">
                                    {{currentData.rec_position}}
                                </span>

                                <span v-else>N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Reamrks</th>
                            <td>
                                <span v-if="currentData.remarks">
                                    {{currentData.remarks}}
                                </span>

                                <span v-else>N/A</span>
                            </td>

                            <th></th>
                            <td></td>
                        </tr>

                        
                    </table>

                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props:['currentData','category', 'subcategory', 'operation'],


    data(){
        return{

            viewModal:  true,

        }
    },
    
}
</script>