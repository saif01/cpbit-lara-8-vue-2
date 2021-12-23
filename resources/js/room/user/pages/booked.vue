<template>
    <div>
        <div v-for="item in allData" :key="item.id">

            <b-card no-body class="overflow-hidden my-2" >
                <b-row no-gutters>
                <b-col md="6">
                    <b-card-img v-if="item.room.image" :src="imagePath+item.room.image" height="150" width="200" alt="Image" class="rounded-0"></b-card-img>
                    <b-card-img v-else src="/all-assets/common/img/no-image.png" height="150" width="200" alt="Image" class="rounded-0"></b-card-img>
                </b-col>
                <b-col md="6">
                    <b-card-body title="">
                    <b-card-text>
                       <table class="table table-sm text-center">
                            <tr>
                               <th>Name:</th>
                               <td><span v-if="item.room">{{ item.room.name }}</span></td>
                            </tr>
                            <tr>
                               <th>Purpose:</th>
                               <td>{{ item.purpose }}</td>
                            </tr>
                            <tr>
                               <th>Booked:</th>
                               <td>{{ item.start | moment("MMM Do YYYY, h:mm a") }} - To - {{ item.start | moment("MMM Do YYYY, h:mm a") }}</td>
                            </tr>
                            <tr >
                               <b-button size="sm" variant="warning" class="text-center">Modify</b-button>
                            </tr>
                       </table>
                    </b-card-text>
                    </b-card-body>
                </b-col>
                </b-row>
            </b-card>
          
        </div>
        
    </div>
</template>

<script>
    export default {
        data(){
            return{

                //current page url
                currentUrl: '/room/booked',

                imagePath: '/images/room/',
                imagePathSm: '/images/room/small/',

                allData:'',

            }
        },

        methods:{

            getBookedData(){
                axios.get( this.currentUrl + '/data').then(response=>{
                    console.log(response.data)
                    this.allData = response.data

                }).catch(error=>{
                    console.log(error)
                })
            }

        },

        created(){
            this.$Progress.start();
            // Fetch initial results
            this.getBookedData();
            this.$Progress.finish();
            
        }
    }
</script>