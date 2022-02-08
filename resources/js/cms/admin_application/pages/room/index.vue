<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Rooms Table
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" small outlined class="float-right">
                            <v-icon left dark>mdi-plus-circle-outline </v-icon> Add
                        </v-btn>

                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="10">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>
                                    Images
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('capacity')">Capacity</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'capacity'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'capacity'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('projector')">Projector</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'projector'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'projector'">&darr;</span>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="singleData in allData.data" :key="singleData.id">
                                <td>
                                    <img v-if="singleData.image" :src="imagePathSm + singleData.image" alt="image"
                                        class="img-fluid m-1" height="50" width="80">
                                    <img v-if="singleData.image2" :src="imagePathSm + singleData.image2" alt="image"
                                        class="img-fluid m-1" height="50" width="80">
                                    <img v-if="singleData.image3" :src="imagePathSm + singleData.image3" alt="image"
                                        class="img-fluid m-1" height="50" width="80">

                                </td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.capacity }} Persons</td>
                                <td><span v-if="singleData.projector == 1">Yes</span><span v-else>No</span> </td>


                                <td class="text-center">

                                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="success"
                                        depressed small>
                                        <v-icon small>mdi-check-circle-outline</v-icon> Active
                                    </v-btn>
                                    <v-btn v-else @click="statusChange(singleData)" color="warning" depressed small>
                                        <v-icon small>mdi-alert-circle-outline </v-icon> Inactive
                                    </v-btn>

                                    <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                        <v-icon small>mdi-pencil-box-multiple-outline</v-icon> Edit
                                    </v-btn>

                                    <v-btn @click="deleteDataTemp(singleData.id)" color="error" depressed small>
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


        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="700px">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row align-content="center">

                                <v-col md="4">
                                    <v-text-field v-model="form.name" label="Enter Room Name" :rules="roomRules"
                                        required></v-text-field>
                                </v-col>

                                <v-col md="4">
                                    <v-text-field type="number" v-model="form.capacity" label="Enter Room capacity"
                                        :rules="roomRules" required></v-text-field>
                                </v-col>

                                <v-col md="4">
                                    <v-radio-group v-model="form.projector" :rules="roomRulesFeature" required
                                        label="Projector Faciilty" row>
                                        <v-radio v-for="n in activeOptions" :key="n.value" :label="n.text"
                                            :value="n.value"></v-radio>
                                    </v-radio-group>
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea outlined rows="2" v-model="form.remarks" label="Enter Room Details">
                                    </v-textarea>
                                </v-col>
                            </v-row>


                            <v-row>
                                <!-- Image 1 -->
                                <v-col md="4">
                                    <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'image')"
                                        label="Choose 1st Image" size="sm" accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>
                                <!-- Image 2 -->
                                <v-col md="4">
                                    <v-file-input prepend-icon="mdi-camera"
                                        @change="uploadImageByName($event, 'image2')" label="Choose 2nd Image" size="sm"
                                        accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>
                                <!-- Image 2 -->
                                <v-col md="4">
                                    <v-file-input prepend-icon="mdi-camera"
                                        @change="uploadImageByName($event, 'image3')" label="Choose 3rd Image" size="sm"
                                        accept=".jpg, .png, .jpeg">
                                    </v-file-input>
                                </v-col>
                            </v-row>

                            <v-row class="mb-2">
                                <v-col md="4">
                                    <img :src="showImageByName('image')"
                                        class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                                <v-col md="4">
                                    <img :src="showImageByName('image2')"
                                        class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                                <v-col md="4">
                                    <img :src="showImageByName('image3')"
                                        class="rounded mx-auto d-block image-thum-size" />
                                </v-col>
                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="addRoomsLoader"
                                color="primary">
                                <v-icon>mdi-edit</v-icon> Update
                            </v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="addRoomsLoader"
                                color="primary">
                                <v-icon>mdi-save</v-icon> Create
                            </v-btn>


                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>


    </div>

</template>


<script>
    // vform
    import Form from 'vform';


    export default {

        data() {

            return {

                // v-form
                valid: false,
                // dialog
                dataModalDialog: false,

                // loader
                addRoomsLoader: false,

                roomRules: [v => !!v || 'This field is required!'],

                roomRulesFeature: [
                    v => v == 0 || v == 1 || 'This field is required!'
                ],

                //current page url
                currentUrl: '/room/admin/room',

                activeOptions: [{
                        text: 'Yes',
                        value: 1
                    },
                    {
                        text: 'No',
                        value: 0
                    },
                ],


                // Form
                form: new Form({
                    id: '',
                    name: '',
                    capacity: '',
                    projector: '',
                    remarks: '',
                    image: '',
                    image2: '',
                    image3: '',

                }),

                imageMaxSize: '5111775',
                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

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
