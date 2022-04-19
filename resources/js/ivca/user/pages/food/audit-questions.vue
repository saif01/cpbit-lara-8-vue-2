<template>
    <div>

        <p class="h3 text-center">PREMISE AUDIT CHECKLIST</p>

        <v-alert color="success" class="text-center h3" v-if="auditComplete" show><b>Successfully Audit Completed</b>
        </v-alert>


        <!-- 1. Building and facilities -->
        <div>
            <v-card :class="{ 'submit-complete': building_facilities_complete }">
                <v-card-title>1. Building and facilities</v-card-title>

                <v-form v-model="valid">
                    <form @submit.prevent="building_facilitiesDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.building_facilities_a }}
                            <div>
                                <v-select v-model="form.building_facilities_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('building_facilities_a') }"
                                    :rules="numberRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_a')"
                                    v-html="form.errors.get('building_facilities_a')" />
                                <v-textarea rows="1" outlined v-model="form.building_facilities_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_a_remarks')"
                                    v-html="form.errors.get('building_facilities_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'building_facilities_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('building_facilities_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.building_facilities_b }}
                            <div>
                                <v-select v-model="form.building_facilities_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('building_facilities_b') }"
                                    :rules="numberRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_b')"
                                    v-html="form.errors.get('building_facilities_b')" />
                                <v-textarea rows="1" outlined v-model="form.building_facilities_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_b_remarks')"
                                    v-html="form.errors.get('building_facilities_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'building_facilities_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('building_facilities_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.building_facilities_c }}
                            <div>
                                <v-select v-model="form.building_facilities_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('building_facilities_c') }"
                                    :rules="numberRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_c')"
                                    v-html="form.errors.get('building_facilities_c')" />
                                <v-textarea rows="1" outlined v-model="form.building_facilities_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_c_remarks')"
                                    v-html="form.errors.get('building_facilities_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'building_facilities_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('building_facilities_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.building_facilities_d }}
                            <div>
                                <v-select v-model="form.building_facilities_d" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('building_facilities_d') }"
                                    :rules="numberRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_d')"
                                    v-html="form.errors.get('building_facilities_d')" />
                                <v-textarea rows="1" outlined v-model="form.building_facilities_d_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_d_remarks')"
                                    v-html="form.errors.get('building_facilities_d_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'building_facilities_d_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('building_facilities_d_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>

                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.building_facilities_e }}
                            <div>
                                <v-select v-model="form.building_facilities_e" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('building_facilities_e') }"
                                    :rules="numberRules" required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_e')"
                                    v-html="form.errors.get('building_facilities_e')" />
                                <v-textarea rows="1" outlined v-model="form.building_facilities_e_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('building_facilities_e_remarks')"
                                    v-html="form.errors.get('building_facilities_e_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'building_facilities_e_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('building_facilities_e_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>


                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense
                                :loading="building_facilities_loading" small color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>

        <!-- 2. Equipment -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': equipment_complete }">
                <v-card-title>2. Equipment</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="equipmentDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.equipment_a }}
                            <div>
                                <v-select v-model="form.equipment_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('equipment_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('equipment_a')"
                                    v-html="form.errors.get('equipment_a')" />
                                <v-textarea rows="1" outlined v-model="form.equipment_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('equipment_a_remarks')"
                                    v-html="form.errors.get('equipment_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'equipment_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('equipment_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.equipment_b }}
                            <div>
                                <v-select v-model="form.equipment_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('equipment_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('equipment_b')"
                                    v-html="form.errors.get('equipment_b')" />
                                <v-textarea rows="1" outlined v-model="form.equipment_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('equipment_b_remarks')"
                                    v-html="form.errors.get('equipment_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'equipment_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('equipment_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.equipment_c }}
                            <div>
                                <v-select v-model="form.equipment_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('equipment_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('equipment_c')"
                                    v-html="form.errors.get('equipment_c')" />
                                <v-textarea rows="1" outlined v-model="form.equipment_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('equipment_c_remarks')"
                                    v-html="form.errors.get('equipment_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'equipment_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('equipment_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="equipment_loading" small
                                color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>

        <!-- 3. Personnel -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': personnel_complete }">

                <v-card-title>3. Personnel</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="personnelDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.personnel_a }}
                            <div>
                                <v-select v-model="form.personnel_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('personnel_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('personnel_a')"
                                    v-html="form.errors.get('personnel_a')" />
                                <v-textarea rows="1" outlined v-model="form.personnel_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('personnel_a_remarks')"
                                    v-html="form.errors.get('personnel_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'personnel_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('personnel_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.personnel_b }}
                            <div>
                                <v-select v-model="form.personnel_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('personnel_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('personnel_b')"
                                    v-html="form.errors.get('personnel_b')" />
                                <v-textarea rows="1" outlined v-model="form.personnel_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('personnel_b_remarks')"
                                    v-html="form.errors.get('personnel_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'personnel_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('personnel_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.personnel_c }}
                            <div>
                                <v-select v-model="form.personnel_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('personnel_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('personnel_c')"
                                    v-html="form.errors.get('personnel_c')" />
                                <v-textarea rows="1" outlined v-model="form.personnel_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('personnel_c_remarks')"
                                    v-html="form.errors.get('personnel_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'personnel_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('personnel_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="personnel_loading" small
                                color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>


        <!-- 4. Raw Materials -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': raw_materials_complete }">

                <v-card-title>4. Raw Materials</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="raw_materialsDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.raw_materials_a }}
                            <div>
                                <v-select v-model="form.raw_materials_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('raw_materials_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_a')"
                                    v-html="form.errors.get('raw_materials_a')" />
                                <v-textarea rows="1" outlined v-model="form.raw_materials_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_a_remarks')"
                                    v-html="form.errors.get('raw_materials_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'raw_materials_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('raw_materials_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.raw_materials_b }}
                            <div>
                                <v-select v-model="form.raw_materials_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('raw_materials_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_b')"
                                    v-html="form.errors.get('raw_materials_b')" />
                                <v-textarea rows="1" outlined v-model="form.raw_materials_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_b_remarks')"
                                    v-html="form.errors.get('raw_materials_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'raw_materials_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('raw_materials_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.raw_materials_c }}
                            <div>
                                <v-select v-model="form.raw_materials_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('raw_materials_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_c')"
                                    v-html="form.errors.get('raw_materials_c')" />
                                <v-textarea rows="1" outlined v-model="form.raw_materials_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_c_remarks')"
                                    v-html="form.errors.get('raw_materials_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'raw_materials_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('raw_materials_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.raw_materials_d }}
                            <div>
                                <v-select v-model="form.raw_materials_d" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('raw_materials_d') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_d')"
                                    v-html="form.errors.get('raw_materials_d')" />
                                <v-textarea rows="1" outlined v-model="form.raw_materials_d_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_d_remarks')"
                                    v-html="form.errors.get('raw_materials_d_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'raw_materials_d_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('raw_materials_d_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.raw_materials_e }}
                            <div>
                                <v-select v-model="form.raw_materials_e" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('raw_materials_e') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_e')"
                                    v-html="form.errors.get('raw_materials_e')" />
                                <v-textarea rows="1" outlined v-model="form.raw_materials_e_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('raw_materials_e_remarks')"
                                    v-html="form.errors.get('raw_materials_e_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'raw_materials_e_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('raw_materials_e_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="raw_materials_loading"
                                small color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>
            </v-card>
        </div>



        <!-- 5. Production -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': production_complete }">
                <v-card-title>5. Production</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="productionDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.production_a }}
                            <div>
                                <v-select v-model="form.production_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_a')"
                                    v-html="form.errors.get('production_a')" />
                                <v-textarea rows="1" outlined v-model="form.production_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_a_remarks')"
                                    v-html="form.errors.get('production_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_b }}
                            <div>
                                <v-select v-model="form.production_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_b')"
                                    v-html="form.errors.get('production_b')" />
                                <v-textarea rows="1" outlined v-model="form.production_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_b_remarks')"
                                    v-html="form.errors.get('production_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_c }}
                            <div>
                                <v-select v-model="form.production_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_c')"
                                    v-html="form.errors.get('production_c')" />
                                <v-textarea rows="1" outlined v-model="form.production_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_c_remarks')"
                                    v-html="form.errors.get('production_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_d }}
                            <div>
                                <v-select v-model="form.production_d" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_d') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_d')"
                                    v-html="form.errors.get('production_d')" />
                                <v-textarea rows="1" outlined v-model="form.production_d_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_d_remarks')"
                                    v-html="form.errors.get('production_d_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_d_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_d_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_e }}
                            <div>
                                <v-select v-model="form.production_e" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_e') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_e')"
                                    v-html="form.errors.get('production_e')" />
                                <v-textarea rows="1" outlined v-model="form.production_e_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_e_remarks')"
                                    v-html="form.errors.get('production_e_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_e_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_e_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.production_f }}
                            <div>
                                <v-select v-model="form.production_f" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('production_f') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('production_f')"
                                    v-html="form.errors.get('production_f')" />
                                <v-textarea rows="1" outlined v-model="form.production_f_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('production_f_remarks')"
                                    v-html="form.errors.get('production_f_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'production_f_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('production_f_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="production_loading" small
                                color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>
            </v-card>
        </div>


        <!-- 6. Records -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': records_complete }">
                <v-card-title>6. Records</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="recordsDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.records_a }}
                            <div>
                                <v-select v-model="form.records_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('records_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('records_a')"
                                    v-html="form.errors.get('records_a')" />
                                <v-textarea rows="1" outlined v-model="form.records_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('records_a_remarks')"
                                    v-html="form.errors.get('records_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'records_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('records_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.records_b }}
                            <div>
                                <v-select v-model="form.records_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('records_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('records_b')"
                                    v-html="form.errors.get('records_b')" />
                                <v-textarea rows="1" outlined v-model="form.records_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('records_b_remarks')"
                                    v-html="form.errors.get('records_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'records_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('records_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.records_c }}
                            <div>
                                <v-select v-model="form.records_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('records_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('records_c')"
                                    v-html="form.errors.get('records_c')" />
                                <v-textarea rows="1" outlined v-model="form.records_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('records_c_remarks')"
                                    v-html="form.errors.get('records_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'records_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('records_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.records_d }}
                            <div>
                                <v-select v-model="form.records_d" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('records_d') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('records_d')"
                                    v-html="form.errors.get('records_d')" />
                                <v-textarea rows="1" outlined v-model="form.records_d_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('records_d_remarks')"
                                    v-html="form.errors.get('records_d_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'records_d_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('records_d_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="records_loading" small
                                color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>


        <!-- 7. Labeling -->
        <div class="mt-5">
            <v-card :class="{ 'submit-complete': labeling_complete }">
                <v-card-title>7. Labeling</v-card-title>
                <v-form v-model="valid">
                    <form @submit.prevent="labelingDataUpdate()">

                        <v-card-text class="ml-2">
                            {{ templateData.labeling_a }}
                            <div>
                                <v-select v-model="form.labeling_a" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('labeling_a') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('labeling_a')"
                                    v-html="form.errors.get('labeling_a')" />
                                <v-textarea rows="1" outlined v-model="form.labeling_a_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('labeling_a_remarks')"
                                    v-html="form.errors.get('labeling_a_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'labeling_a_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('labeling_a_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.labeling_b }}
                            <div>
                                <v-select v-model="form.labeling_b" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('labeling_b') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('labeling_b')"
                                    v-html="form.errors.get('labeling_b')" />
                                <v-textarea rows="1" outlined v-model="form.labeling_b_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('labeling_b_remarks')"
                                    v-html="form.errors.get('labeling_b_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'labeling_b_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('labeling_b_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <v-card-text class="ml-2">
                            {{ templateData.labeling_c }}
                            <div>
                                <v-select v-model="form.labeling_c" :items="options"
                                    :class="{ 'is-invalid': form.errors.has('labeling_c') }" :rules="numberRules"
                                    required>
                                </v-select>
                                <div class="small text-danger" v-if="form.errors.has('labeling_c')"
                                    v-html="form.errors.get('labeling_c')" />
                                <v-textarea rows="1" outlined v-model="form.labeling_c_remarks"
                                    label="Enter Audit Remarks"></v-textarea>
                                <div class="small text-danger" v-if="form.errors.has('labeling_c_remarks')"
                                    v-html="form.errors.get('labeling_c_remarks')" />
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <v-file-input prepend-icon="mdi-camera"
                                            @change="uploadImageByName($event, 'labeling_c_image')"
                                            label="Choose or drop Image here..." accept=".jpg, .png, .jpeg">
                                        </v-file-input>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <img :src="showImageByName('labeling_c_image')"
                                            class="rounded mx-auto d-block image-thum-size" />
                                    </div>
                                </div>
                            </div>
                        </v-card-text>

                        <div class="col-12">
                            <v-btn v-if="!auditComplete" type="submit" block dense :loading="labeling_loading" small
                                color="primary">
                                <v-icon>mdi-pencil-outline</v-icon> Update
                            </v-btn>
                        </div>

                    </form>
                </v-form>

            </v-card>
        </div>


        <!-- Final Submit -->
        <div class="my-4 p-3 card">
            <form @submit.prevent="finalDataUpdate()">

                <div class="col-12">
                    <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'group_image')"
                        label="Group Image" small accept=".jpg, .png, .jpeg">
                    </v-file-input>
                    <div class="small text-danger" v-if="form.errors.has('group_image')"
                            v-html="form.errors.get('group_image')" />
                    <div class="mt-1">
                        <img :src="showImageByName('group_image')" class="rounded mx-auto d-block image-thum-size" />
                    </div>
                </div>

                <div class="col-12">
                    <v-btn v-if="!auditComplete" type="submit" block dense :loading="final_loading" color="error">
                        <v-icon>mdi-check-circle-outline </v-icon> Final Submit
                    </v-btn>
                </div>

            </form>

        </div>

        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {

        data() {
            return {
                // overlay
                overlay: false,
                valid: false,
                numberRules: [
                    v => v == 0 || v == 2 || 'This Field is required',
                ],

                token: this.$route.query.token,

                // current page url
                currentUrl: '/ivca/food/audit',

                templateData: {},
                selected: null,
                auditComplete: false,
                // userType:'',

                imageMaxSize: '5111775',
                imagePath: '/images/ivca/food/',
                imagePathSm: '/images/ivca/food/small/',


                options: [{
                        value: null,
                        text: 'Please select an option'
                    },
                    {
                        value: 0,
                        text: '0 (Zero)'
                    },
                    {
                        value: 2,
                        text: '2 (Two)'
                    },
                ],

                // Section Complete Status
                building_facilities_complete: false,
                equipment_complete: false,
                personnel_complete: false,
                raw_materials_complete: false,
                production_complete: false,
                records_complete: false,
                labeling_complete: false,

                // Loading Indecator
                building_facilities_loading: false,
                equipment_loading: false,
                personnel_loading: false,
                raw_materials_loading: false,
                production_loading: false,
                records_loading: false,
                labeling_loading: false,
                final_loading: false,


                // Form
                form: new Form({

                    id: '',
                    building_facilities_a: null,
                    building_facilities_a_remarks: null,
                    building_facilities_a_image: null,
                    building_facilities_b: null,
                    building_facilities_b_remarks: null,
                    building_facilities_b_image: null,
                    building_facilities_c: null,
                    building_facilities_c_remarks: null,
                    building_facilities_c_image: null,
                    building_facilities_d: null,
                    building_facilities_d_remarks: null,
                    building_facilities_d_image: null,
                    building_facilities_e: null,
                    building_facilities_e_remarks: null,
                    building_facilities_e_image: null,


                    equipment_a: null,
                    equipment_a_remarks: null,
                    equipment_a_image: null,
                    equipment_b: null,
                    equipment_b_remarks: null,
                    equipment_b_image: null,
                    equipment_c: null,
                    equipment_c_remarks: null,
                    equipment_c_image: null,



                    personnel_a: null,
                    personnel_a_remarks: null,
                    personnel_a_image: null,
                    personnel_b: null,
                    personnel_b_remarks: null,
                    personnel_b_image: null,
                    personnel_c: null,
                    personnel_c_remarks: null,
                    personnel_c_image: null,



                    raw_materials_a: null,
                    raw_materials_a_remarks: null,
                    raw_materials_a_image: null,
                    raw_materials_b: null,
                    raw_materials_b_remarks: null,
                    raw_materials_b_image: null,
                    raw_materials_c: null,
                    raw_materials_c_remarks: null,
                    raw_materials_c_image: null,
                    raw_materials_d: null,
                    raw_materials_d_remarks: null,
                    raw_materials_d_image: null,
                    raw_materials_e: null,
                    raw_materials_e_remarks: null,
                    raw_materials_e_image: null,



                    production_a: null,
                    production_a_remarks: null,
                    production_a_image: null,
                    production_b: null,
                    production_b_remarks: null,
                    production_b_image: null,
                    production_c: null,
                    production_c_remarks: null,
                    production_c_image: null,
                    production_d: null,
                    production_d_remarks: null,
                    production_d_image: null,
                    production_e: null,
                    production_e_remarks: null,
                    production_e_image: null,
                    production_f: null,
                    production_f_remarks: null,
                    production_f_image: null,



                    records_a: null,
                    records_a_remarks: null,
                    records_a_image: null,
                    records_b: null,
                    records_b_remarks: null,
                    records_b_image: null,
                    records_c: null,
                    records_c_remarks: null,
                    records_c_image: null,
                    records_d: null,
                    records_d_remarks: null,
                    records_d_image: null,



                    labeling_a: null,
                    labeling_a_remarks: null,
                    labeling_a_image: null,
                    labeling_b: null,
                    labeling_b_remarks: null,
                    labeling_b_image: null,
                    labeling_c: null,
                    labeling_c_remarks: null,
                    labeling_c_image: null,

                    group_image: null,
                }),


            }
        },

        methods: {

            // Template
            auditTempalte() {
                axios.post(this.currentUrl + '/tempalte').then(response => {
                    // console.log('Template', response.data)
                    this.templateData = response.data;
                }).catch(error => {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',
                    })
                    console.log(error)
                })
            },

            // Audit Data Refresh 
            auditDataRefresh() {
                axios.get(this.currentUrl + '/data/' + this.token).then(response => {
                    // console.log( 'auditDataRefresh', response.data.id)
                    if (response.data.id) {
                        this.form.fill(response.data)
                    }
                    // show complete submition all section
                    if (response.data.status == 1) {
                        this.auditComplete = true
                    }

                    //1 building_facilities_complete
                    if (response.data.building_facilities_status == 1) {
                        this.building_facilities_complete = true
                    }

                    //2 equipment_complete
                    if (response.data.equipment_status == 1) {
                        this.equipment_complete = true
                    }

                    //3 personnel_complete
                    if (response.data.personnel_status == 1) {
                        this.personnel_complete = true
                    }

                    //4 raw_materials_complete
                    if (response.data.raw_materials_status == 1) {
                        this.raw_materials_complete = true
                    }

                    //5 production_complete
                    if (response.data.production_status == 1) {
                        this.production_complete = true
                    }

                    //6 records_complete
                    if (response.data.records_status == 1) {
                        this.records_complete = true
                    }

                    //7 labeling_complete
                    if (response.data.labeling_status == 1) {
                        this.labeling_complete = true
                    }




                }).catch(error => {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',
                    })
                    console.log(error)
                })
            },


            // building_facilitiesDataUpdate
            building_facilitiesDataUpdate() {
                // Start loading
                this.building_facilities_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/building_facilities_store/' + this.token)
                    .then(response => {
                        this.building_facilities_loading = false
                        this.overlay = false
                        //console.log(response.data)

                        // Refresh all data
                        this.auditDataRefresh();

                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.building_facilities_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },

            // equipmentDataUpdate
            equipmentDataUpdate() {
                // Start loading
                this.equipment_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/equipment_store/' + this.token)
                    .then(response => {
                        this.equipment_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.equipment_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },

            // personnelDataUpdate
            personnelDataUpdate() {
                // Start loading
                this.personnel_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/personnel_store/' + this.token)
                    .then(response => {
                        this.personnel_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.personnel_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


            // raw_materialsDataUpdate
            raw_materialsDataUpdate() {
                // Start loading
                this.raw_materials_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/raw_materials_store/' + this.token)
                    .then(response => {
                        this.raw_materials_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.raw_materials_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


            // productionDataUpdate
            productionDataUpdate() {
                // Start loading
                this.production_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/production_store/' + this.token)
                    .then(response => {
                        this.production_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.production_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


            //recordsDataUpdate
            recordsDataUpdate() {
                // Start loading
                this.records_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/records_store/' + this.token)
                    .then(response => {
                        this.records_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.records_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


            // labelingDataUpdate
            labelingDataUpdate() {
                // Start loading
                this.labeling_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/labeling_store/' + this.token)
                    .then(response => {
                        this.labeling_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        })

                    }).catch(error => {
                        this.labeling_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


            // finalDataUpdate
            finalDataUpdate() {
                // Start loading
                this.final_loading = true
                this.overlay = true
                this.form.post(this.currentUrl + '/store/final_store/' + this.token)
                    .then(response => {
                        this.final_loading = false
                        this.overlay = false
                        //console.log(response.data)
                        this.auditDataRefresh();
                        // Alert
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.status,
                            text: response.data.msg,
                        }).then(() => {
                            // Redirect route
                            this.$router.push({
                                name: 'ivca_food_schedule'
                            })
                        })

                    }).catch(error => {
                        this.final_loading = false
                        this.overlay = false
                        // Error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!',
                            text: 'Sorry! Somthing going wrong',
                        })
                        console.log(error)
                    })
            },


        },


        created() {
            this.$Progress.start();
            // Template data
            this.auditTempalte();

            // Current Audit data
            this.auditDataRefresh()

            //console.log('Token type : ' + this.token, this.userType)

            this.$Progress.finish();
        }


    }

</script>

<style lang="scss" scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

    .submit-complete {
        background: rgb(123, 243, 123);
    }

</style>
