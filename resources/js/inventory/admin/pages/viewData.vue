<template>
    <div>
        <v-dialog v-model="viewModal" persistent >
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            View Product Details
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
                            <th>Name</th>
                            <td>{{currentData.name}}</td>

                            <th>Category:</th>
                            <td>
                                <span v-if="category">
                                    {{ category }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Product Type:</th>
                            <td>
                                <span v-if="currentData.type">
                                    {{ currentData.type }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Subcategory:</th>
                            <td>
                                <span v-if="subcategory">
                                    {{ subcategory }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Product Serial:</th>
                            <td>
                                <span v-if="currentData.serial">
                                    {{ currentData.serial }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Invoice:</th>
                            <td>
                                <span v-if="currentData.invoice_num">
                                    {{ currentData.invoice_num }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Business Unit:</th>
                            <td>
                                <span v-if="currentData.business_unit">
                                    {{ currentData.business_unit }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Receiver Name:</th>
                            <td>
                                <span v-if="currentData.rec_name">
                                    {{currentData.rec_name}}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Purchase:</th>
                            <td>
                                <span v-if="currentData.purchase">
                                    {{ currentData.purchase }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Office:</th>
                            <td>
                                <span v-if="currentData.office">
                                    {{ currentData.office }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Receiver Contact:</th>
                            <td>
                                <span v-if="currentData.rec_contact">
                                    {{currentData.rec_contact}}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Bill Submit Date:</th>
                            <td>
                                <span v-if="currentData.bill_submit">
                                    {{ currentData.bill_submit }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Operation:</th>
                            <td>
                                <span v-if="operation"> {{operation}} </span>
                                <span v-else class="error--text"> N/A </span>
                            </td>

                            <th>Designation:</th>
                            <td>
                                <span v-if="currentData.rec_position">
                                    {{currentData.rec_position}}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>

                            <th>Req. Payment Num.:</th>
                            <td>
                                <span v-if="currentData.req_payment_num">
                                    {{ currentData.req_payment_num }}
                                </span>
                                <span v-else class="error--text">N/A</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Reamrks:</th>
                            <td colspan="5">
                                <span v-if="currentData.remarks" v-html="currentData.remarks"></span>
                                <span v-else class="error--text">N/A</span>
                            </td>
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