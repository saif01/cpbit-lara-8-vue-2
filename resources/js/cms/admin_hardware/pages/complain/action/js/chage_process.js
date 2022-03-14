export default{
    changeProcess() {
        // current process
       let crpro = this.form.process
       this.applicableOptions = []
       this.closedoptions = []
       this.showDamagedReson = false
       

       if (crpro == 'Damaged' || crpro == 'Partial Damaged') {
           this.showDamagedReson = true
           this.applicableOptions = [{
                   label: 'Applicable for User (Non-stock)',
                   value: 'Applicable',
                   color: 'success'
               },
               {
                   label: 'Not Applicable for User (Stock)',
                   value: 'Not Applicable',
                   color: 'error'
               }
           ]
       }

       // Closed
       if (crpro == 'Closed') {
           this.closedoptions = [{
                   label: 'Deliverable',
                   value: 'Deliverable',
                   color: 'success'
               },
               {
                   label: 'Not Deliverable',
                   value: 'Not Deliverable',
                   color: 'info'
               }
           ]
       }
   },
}