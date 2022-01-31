export default{
    // Get table data
    getResults(page = 1) {
        this.dataLoading = true;
        axios.get(this.currentUrl + '/index?page=' + page +
                '&paginate=' + this.paginate +
                '&search=' + this.search +
                '&sort_direction=' + this.sort_direction +
                '&sort_field=' + this.sort_field +
                '&search_field=' + this.search_field +
                '&zone_office=' + this.zone_office +
                '&department=' + this.department

            )
            .then(response => {
                //console.log(response.data.data);
                //console.log(response.data.from, response.data.to);
                this.allData = response.data;
                this.totalValue = response.data.total;
                this.dataShowFrom = response.data.from;
                this.dataShowTo = response.data.to;
                this.currentPageNumber = response.data.current_page
                // Loading Animation
                this.dataLoading = false;

            });
    },

    // get Zone Offices
    getZoneOffices() {
        axios.get('/super_admin/user/zoneoffices').then(response => {
            // console.log(response.data)
            this.allZoneOffices = response.data
        }).catch(error => {
            console.log(error)
        })
    },

    // get Departments
    getDepartments() {
        axios.get('/super_admin/user/departments').then(response => {
            // console.log(response.data)
            this.allDepartments = response.data
        }).catch(error => {
            console.log(error)
        })
    },



}