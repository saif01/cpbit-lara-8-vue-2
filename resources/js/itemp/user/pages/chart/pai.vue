<script>

 // Pie, Doughnut, Line, Bar

  import { Pie } from 'vue-chartjs'

  export default {

    props:['chartData'],

    extends: Pie,
    data () {
      return {

        
        datacollection: {
           labels: this.chartData.labels,

          datasets: [
            {
              label: 'Data One',
              backgroundColor: this.randColors(this.chartData.labels.length),
              pointBackgroundColor: 'white',
              borderWidth: 1,
              pointBorderColor: '#29465B',
              data: this.chartData.data,
            }
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              },
              gridLines: {
                display: true
              }
            }],
            xAxes: [ {
              gridLines: {
                display: false
              }
            }]
          },
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }


      }
    },


    methods:{
      // random color generator
      randColors(val=2){
        // empty Array
        const colors = [];
        for(let i=1; i <= val; i++){
          let color = '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
          // colors push in array
          colors.push(color);
        }
        return colors;
      },

    },

    

    mounted () {
      this.renderChart(this.datacollection, this.options)
    },

  }
</script>