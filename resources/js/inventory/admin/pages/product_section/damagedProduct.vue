<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Damaged Product
                    </v-col>
                    <v-col cols="2">
                        
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col lg="2" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="10" cols="8">
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                hide-details
                                class="mb-5"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Product Model</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('office')">Office</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'office'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'office'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('business_unit')">Business Unit</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'business_unit'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'business_unit'">&darr;</span>
                                </th>
                                <th>Operation</th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('serial')">Serial</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'serial'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'serial'">&darr;</span>
                                </th>
                                <th>View</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td>
                                        <span v-if="singleData.name">{{singleData.name}}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.office">{{ singleData.office }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.business_unit">{{ singleData.business_unit }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.operation">{{ singleData.operation.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.serial">{{ singleData.serial }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td class="text-center">
                                        <v-btn @click="view(singleData)" color="teal" depressed small>
                                            <v-icon small>mdi-eye</v-icon> View
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>


        <!-- view product -->
        <view-product v-if="currentData" :currentData="currentData" :category="currentCategory" :subcategory="currentSubcategory" :operation="currentOperation" :key="leaveActionKey" ></view-product>

    </div>
</template>



<script>
import viewProduct from './../viewData.vue'

    export default {
      
        data() {

            return {
                // dialog
                dataModalDialog:false,

                // loader
                addNetworklLoader:false,


                //current page url
                currentUrl: '/inventory/admin/product/given-product',


                // view details
                currentData: '',
                leaveActionKey:0,
                currentCategory:'',
                currentSubcategory:'',
                currentOperation:'',
            }


        },

        components:{
            "view-product":viewProduct
        },

        methods: {

            // view
            view(data){
                if(data.category){
                    this.currentCategory = data.category.name
                }
                if(data.subcategory){
                    this.currentSubcategory = data.subcategory.name
                }
                if(data.operation){
                    this.currentOperation = data.operation.name
                }
                
                this.leaveActionKey++
                this.currentData = data
            },



        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>