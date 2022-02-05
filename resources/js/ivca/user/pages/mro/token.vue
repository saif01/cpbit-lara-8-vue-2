<template>
    <div>
      
        <b-modal ref="token_check_model" title="Check Token and Start Audit" size="sm" hide-footer>
            <form @submit.prevent="putTokenByUser()">

                <b-form-group label="Check Token:">
                    <b-form-input v-model="form.token" placeholder="Enter role token"
                         :class="{ 'is-invalid': form.errors.has('token') }"></b-form-input>
                    <div class="small text-danger" v-if="form.errors.has('token')" v-html="form.errors.get('token')" />
                </b-form-group>

                <b-form-group v-if="form.progress">
                    <b-progress :value="form.progress.percentage" variant="success" striped animated>
                    </b-progress>
                </b-form-group>

                <b-form-group v-if="!form.progress">
                    <b-button type="submit" class="btn-block" variant="primary">Check And Start Audit</b-button>
                </b-form-group>


            </form>


        </b-modal>
    </div>
</template>

<script>
    // vform
    import Form from 'vform';

    export default {

        data(){

            return {

                // current page url
                currentUrl     : '/ivca/audit/mro',

                // Form 
                form: new Form({
                    id: '',
                    token: '',
                    vendor_id: '',
                }),
            }

        },



        methods:{

            // Put Token By User
            putTokenByUser(){

                this.form.post( this.currentUrl+'/token/check_by_user').then(response=>{
                    console.log(response.data)

                    // Hide Model
                    this.hideModal()

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.status,
                        text: response.data.msg,  
                    })

                    if(response.data.status == 'Success'){

                        // Redirect
                        this.$router.push({
                            name:'ivca_audit_questions', 
                            query: { 
                                token: response.data.token, 
                            } 
                        })
                        
                    }

                    

                }).catch(error=>{
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Sorry! Somthing going wrong',  
                    })
                    console.log(error)
                })

            },

            // Show Modal
            showModal(singleData) {
                console.log(singleData.vendor_id)
                //this.form.token = singleData.activetoken.token
                this.form.vendor_id = singleData.vendor_id
                // this.form.fill(singleData)
                this.$refs['token_check_model'].show();
            },

            // Hide Modal
            hideModal(){
                this.$refs['token_check_model'].hide();
            }

            
        },

        // computed: {
        //     // a computed getter
        //     checkRunAudit: function (data) {
        //         // `this` points to the vm instance
        //         console.log('computed'+data)

        //         return data
        //     }
        // },

        created(){
            this.$Progress.start();
            // Fetch initial results
        
            // this.generateToken();
            // this.userList();
            this.$Progress.finish();

            console.log('Today',  this.todayDate )
        }
        
    }
</script>


