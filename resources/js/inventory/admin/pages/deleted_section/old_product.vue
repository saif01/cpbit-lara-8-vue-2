<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Old Product Deleted Data
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="20" small outlined class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
                        </v-btn>
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

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    Action
                                </th>
                                <th>
                                    Details
                                </th>
                                <th>Deleted By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td class="text-center">

                                    <v-btn class="ma-2" @click="deleteData(singleData.id, 'old')" color="error" elevation="20" small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>

                                    <v-btn class="ma-2" @click="restoreData(singleData.id, 'old')" color="success" elevation="20" small>
                                        <v-icon small>mdi-delete-restore</v-icon> Restore
                                    </v-btn>
                                </td>
                                <td>
                                    <div>
                                        <b>Product Name: </b>{{ singleData.name }}
                                    </div>
                                    <div>
                                        <b>Product Category: </b><span v-if="singleData.category">{{ singleData.category.name }}</span>
                                    </div>
                                    <div>
                                        <b>Product Subcategory: </b><span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                    </div>
                                    <div>
                                        <b>Product Serial: </b>{{ singleData.serial }}
                                    </div>
                                </td>
                                <td>
                                    
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults"
                        class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>


    </div>

</template>


<script>

    export default {


        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/delete/old-product',



                allCategory: [],
                allSubcategory: [],
                allCatData: '',


            }


        },

        methods: {

            // getAllCategory
            getAllCategory() {
                axios.get('/inventory/admin/category').then(response => {
                    this.allCatData = response.data
                    console.log(response.data)
                    for (let i = 0; i < response.data.length; i++) {
                        this.allCategory.push(response.data[i]);
                        this.allCategory[i] = {
                            value: response.data[i].id,
                            text: response.data[i].name
                        };
                    }
                }).catch(error => {
                    console.log(error)
                })
            },

            // getSubcategory
            getSubcategory() {
                // console.log('cat id', this.form.cat_id)

                this.allCatData.forEach(element => {
                    //console.log(element.id)

                    if (element.id == this.form.cat_id) {
                        //console.log(element)
                        this.allSubcategory = []
                        if (element.subcat.length > 0) {
                            for (let i = 0; i < element.subcat.length; i++) {
                                this.allSubcategory.push(element.subcat[i]);
                                this.allSubcategory[i] = {
                                    value: element.subcat[i].id,
                                    text: element.subcat[i].name
                                };
                            }

                        }
                    }
                })


            },


        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

            this.getAllCategory();

            this.$Progress.finish();
        },



    }

</script>

