<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Employees Data 
                    </v-col>
                    <v-col cols="2">
                        <!-- <v-btn @click="addDataModel()" color="primary" small outlined class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
                        </v-btn> -->
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-inner-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..." outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Department
                                </th>
                                <th>
                                    Remarks
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    {{singleData.id_number}}

                                </td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.department }}</td>
                                <td>
                                    <span v-if="singleData.reamrks" v-text="singleData.reamrks"></span>
                                    <span v-else class="error--text">N/A</span>
                                </td>


                                <td class="text-center">

                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="success"
                                        depressed small>
                                        <v-icon small>mdi-check-circle-outline</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" color="warning" depressed small>
                                        <v-icon small>mdi-alert-circle-outline </v-icon> Inactive
                                    </v-btn>

                                    <!-- <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                        <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                    </v-btn> -->

                                    <v-btn @click="deleteDataDirict(singleData.id)" color="error" depressed small>
                                        <v-icon small>mdi-delete-empty</v-icon> Delete
                                    </v-btn>
                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By--
                                        {{ singleData.makby.name }}</span>
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

        data() {

            return {
                //current page url
                currentUrl: '/itemp/admin/all-employee',

            }


        },

        methods: {



        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>

<style scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

</style>
