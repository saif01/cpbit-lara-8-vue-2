<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                
                <v-col cols="12" lg="4">
                    <v-autocomplete :items="operation" v-model="operation_id"
                        label="Select Operation" :rules="[v => !!v || 'Operation is required!']"
                        dense required></v-autocomplete>
                </v-col>


                <v-row>
                    <v-col cols="10">
                        All Product Count List
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
                                <th>Category</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    
                                    <td>
                                        <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>{{singleData.total}}</td>
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
    </div>
</template>


<script>
export default {
    data(){
        return{
            operation_id: '',



            operation: [],
            search_operation:'',


            currentUrl: '/inventory/admin/report',
        }
    },

    methods:{
        report(){
            axios.post(this.currentUrl + '/index?id=' + this.operation_id).then((response) => {});
        },


        // getOperation
        getOperation() {
            axios.get(this.currentUrl+'/operation').then(response => {

                // operation
                response.data.forEach(element => {
                    this.operation.push({
                        value: element.id,
                        text: element.name
                    }) ;
                });

            }).catch(error => {
                console.log(error)
            })
        },




        getResults(page = 1) {
            this.dataLoading = true;
            axios.get(this.currentUrl+'/index?page=' + page +
                    '&paginate=' + this.paginate +
                    '&search=' + this.search +
                    '&sort_direction=' + this.sort_direction +
                    '&sort_field=' + this.sort_field +
                    '&search_field=' + this.search_field +
                    '&search_operation=' + this.search_operation
                )
                .then(response => {
                    //console.log(response.data.data);
                    //console.log(response.data.from, response.data.to, response.data.current_page);
                    this.allData = response.data;
                    this.totalValue = response.data.total;
                    this.dataShowFrom = response.data.from;
                    this.dataShowTo = response.data.to;
                    this.currentPageNumber  = response.data.current_page
                    // Loading Animation
                    this.dataLoading = false;

                });
        },
    },

    watch:{
        //Excuted When make change value 
        search_operation: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }
    },

    mounted(){
        this.getOperation()
    }
}
</script>