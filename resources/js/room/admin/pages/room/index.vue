<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="card-title">Rooms Table</h3>
                    </div>
                    <div class="col-6">
                        <b-button variant="outline-primary" size="sm" pill class="float-right" @click="addDataModel"><i
                                class="far fa-plus-square"></i>
                            Add</b-button>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div v-if="allData.data">
                    <div class="row mb-2">
                        <div class="col form-inline small">
                            <select v-model="paginate" class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col">
                            <input v-model="search" class="form-control form-control-sm" type="text"
                                placeholder="Search by any data at the table...">
                        </div>
                    </div>

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
                                    <img v-if="singleData.image"
                                    :src="imagePathSm + singleData.image" alt="image" class="img-fluid m-1" height="50" width="80">
                                    <img v-if="singleData.image2"
                                    :src="imagePathSm + singleData.image2" alt="image" class="img-fluid m-1" height="50" width="80">
                                    <img v-if="singleData.image3"
                                    :src="imagePathSm + singleData.image3" alt="image" class="img-fluid m-1" height="50" width="80">

                                </td>
                                <td>{{ singleData.name }}</td>
                                <td>{{ singleData.capacity }} Persons</td>
                                <td><span v-if="singleData.projector == 1" >Yes</span><span v-else>No</span> </td>
                               
                        
                                <td class="text-center">
                                    
                                    <button v-if="singleData.status" @click="statusChange(singleData)" class="btn btn-success btn-sm m-1">
                                        <i class="far fa-check-circle"></i> Active
                                    </button>
                                    <button v-else @click="statusChange(singleData)" class="btn btn-warning btn-sm m-1">
                                        <i class="far fa-times-circle"></i> Inactive
                                    </button>
                                    
                                    <button @click="editDataModel(singleData)" class="btn btn-warning btn-sm m-1">
                                        <i class="fa fa-edit blue"></i> Edit
                                    </button>

                                    <button @click="deleteDataTemp(singleData.id)" class="btn btn-danger btn-sm m-1">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>  
                                    <br>
                                    <span v-if="singleData.makby" class="small text-muted">Create By-- {{ singleData.makby.name }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>


        <!-- Modal -->
        <b-modal ref="data-modal" :title="dataModelTitle" size="lg" hide-footer>
            <b-overlay :show="overlayshow" spinner-variant="success" rounded="sm">
                <form @submit.prevent="editmode ? updateData() : createData()">

                    <div class="row">
                        <div class="col-md-4">
                            <b-form-group label="Room Name:">
                                <b-form-input v-model="form.name" placeholder="Enter Room Name" :class="{ 'is-invalid': form.errors.has('name') }" required></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </b-form-group>
                        </div>
                        
                        <div class="col-md-4">
                            <b-form-group label="Room capacity:">
                                <b-form-input type="number" v-model="form.capacity" placeholder="Enter Room capacity" :class="{ 'is-invalid': form.errors.has('capacity') }" required></b-form-input>
                                <div class="small text-danger" v-if="form.errors.has('capacity')" v-html="form.errors.get('capacity')" />
                            </b-form-group>
                        </div>

                        <div class="col-md-4">
                            <b-form-group label="Room projector:" v-slot="{ ariaDescribedby2 }">
                                <b-form-radio-group  
                                    v-model="form.projector"
                                    :options="activeOptions"
                                    :aria-describedby="ariaDescribedby2"
                                    required
                                ></b-form-radio-group>
                                <div class="small text-danger" v-if="form.errors.has('projector')" v-html="form.errors.get('projector')" />
                            </b-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <b-form-group label="Room Remarks:">
                                <b-form-textarea v-model="form.remarks" placeholder="Enter Room Details .." :class="{ 'is-invalid': form.errors.has('remarks') }"></b-form-textarea>
                                <div class="small text-danger" v-if="form.errors.has('remarks')" v-html="form.errors.get('remarks')" />
                            </b-form-group>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Image 1 -->
                        <div class="col-md-4">
                            <b-form-group label="1st Image:">
                                <b-form-file v-on:input="uploadImageByName($event, 'image')"
                                    placeholder="Choose 1st Image" size="sm" accept=".jpg, .png, .jpeg">
                                </b-form-file>
                            </b-form-group>
                        </div>
                        <!-- Image 2 -->
                        <div class="col-md-4">
                            <b-form-group label="2nd Image:">
                                <b-form-file v-on:input="uploadImageByName($event, 'image2')"
                                    placeholder="Choose 2nd Image" size="sm" accept=".jpg, .png, .jpeg">
                                </b-form-file>
                            </b-form-group>
                        </div>
                        <!-- Image 1 -->
                        <div class="col-md-4">
                            <b-form-group label="3rd Image:">
                                <b-form-file v-on:input="uploadImageByName($event, 'image3')"
                                    placeholder="Choose 3rd Image" size="sm" accept=".jpg, .png, .jpeg">
                                </b-form-file>
                            </b-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <img :src="showImageByName('image')" class="rounded mx-auto d-block image-thum-size" />
                        </div>
                        <div class="col-md-4">
                            <img :src="showImageByName('image2')" class="rounded mx-auto d-block image-thum-size" />
                        </div>
                        <div class="col-md-4">
                            <img :src="showImageByName('image3')" class="rounded mx-auto d-block image-thum-size" />
                        </div>
                    </div>
                    

                
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <b-form-group v-if="!form.progress">
                                <b-button v-show="editmode" type="submit" class="btn-block" variant="primary"><i class="fa fa-edit blue"></i> Update</b-button>
                                <b-button v-show="!editmode" type="submit" class="btn-block" variant="primary"><i class="far fa-check-circle"></i> Create </b-button>
                            </b-form-group>
                        </div>
                    </div>
                    

                </form>
            </b-overlay>
        </b-modal>


    </div>

</template>


<script>
    // vform
    import Form from 'vform';
   

    export default {
      
        data() {

            return {

                //current page url
                currentUrl: '/room/admin/room',

                activeOptions: [
                    { text: 'Yes', value: '1' },
                    { text: 'No', value: '0' },
                ],

              
                // Form
                form: new Form({
                    id: '',
                    name: '',
                    capacity: '',
                    projector: '1',
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


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>

<style scoped>
    .image-thum-size{
        height: 50px;
        width: 100px;
    }
</style>
