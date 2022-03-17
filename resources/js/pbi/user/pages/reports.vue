<template>
    <div>
       <div class="powerbi-view">
           <iframe :key="ifreamIndexKey" :src="currentLink" frameborder="0" allowFullScreen="true"></iframe>
        <p v-if="!currentLink && !overlay" class="text-danger h1 text-center">Sorry !!!! You have no access. Contact with IT team</p>
        
       </div>
        
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
export default {
    data() {
        return {
            operationName: this.$route.query.name,
            currentLink :'',
            ifreamIndexKey: 0,
            overlay: false
        }  
    },

 
    methods:{
        getLink(){
            this.overlay = true
            axios.post('/pbi/report', {name: this.operationName}).then(response=>{
                console.log(response.data)
                this.ifreamIndexKey++;
                this.currentLink = response.data.link;
                this.$store.commit('setReportName', this.$route.query.name )
                //console.log('Reports : Auth-', this.$route.query.name );
                this.overlay = false
            }).catch(error=>{
                console.log(error)
                this.overlay = false
            })
        }

    },

    watch:{

        '$route.query.name':function(){
            this.$Progress.start();
            this.getLink()
            this.$Progress.finish();  
        }

    },

    created(){
        this.$Progress.start();

        this.getLink()
      
        console.log('Reports : ', this.operationName, this.reportName );

        this.$Progress.finish();  
    }
}
</script>


<style scoped>
     .powerbi-view {
            position: relative;
            padding-bottom: 61%;
            height: 0;
            overflow: hidden;
        }

        .powerbi-view iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }
        .sitemessage {
                display: inline-block;
                white-space: nowrap;
                animation: floatText 20s infinite linear;
                padding-left: 100%; /*Initial offset*/
            }
        .sitemessage:hover {
            animation-play-state: paused;
        }
        @keyframes floatText {
            to {
                transform: translateX(-100%);
            }
        }
</style>