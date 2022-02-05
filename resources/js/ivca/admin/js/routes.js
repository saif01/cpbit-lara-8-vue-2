import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import admin_ivca_dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import admin_ivca_user_list from '../pages/user/list.vue'
import admin_ivca_user_role from '../pages/user/role.vue'
import admin_ivca_vendor_list from '../pages/vendor/list.vue'
import admin_ivca_vendor_black_list from '../pages/vendor/black-list.vue'


import admin_ivca_temp_mro_manufacturer from '../pages/template/mro-manufacturer.vue'
import admin_ivca_temp_mro_importer from '../pages/template/mro-importer.vue'
import admin_ivca_temp_mro_retailer from '../pages/template/mro-retailer.vue'
import admin_ivca_temp_food from '../pages/template/food.vue'

// schedule
import admin_ivca_schedule from '../pages/schedule.vue'
import admin_ivca_schedule_mro from '../pages/schedules/mro.vue'
import admin_ivca_schedule_food from '../pages/schedules/food.vue'


// Reports
import admin_ivca_reports_manufacturer from '../pages/reports/mro-manufacturer.vue'
import admin_ivca_reports_manufacturer_summary from '../pages/reports/mro-manufacturer-summary.vue'

import admin_ivca_reports_importer from '../pages/reports/mro-importer.vue'
import admin_ivca_reports_importer_summary from '../pages/reports/mro-importer-summary.vue'

import admin_ivca_reports_retailer from '../pages/reports/mro-retailer.vue'
import admin_ivca_reports_retailer_summary from '../pages/reports/mro-retailer-summary.vue'

import admin_ivca_reports_food from '../pages/reports/food.vue'
import admin_ivca_reports_food_summary from '../pages/reports/food-summary.vue'





const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/ivca/admin', 
            component: admin_ivca_dashboard,
            name: 'admin_ivca_dashboard',
            meta:{
                title: 'Admin IVCA Dashboard',
            },   
        },


        { 
            path: '/ivca/admin/user-list', 
            component: admin_ivca_user_list,
            name: 'admin_ivca_user_list',
            meta:{
                title: 'Admin iVCA User List',
            },   
        },
        { 
            path: '/ivca/admin/user-role', 
            component: admin_ivca_user_role,
            name: 'admin_ivca_user_role',
            meta:{
                title: 'Admin iVCA User Role',
            },   
        },
        { 
            path: '/ivca/admin/vendor-list', 
            component: admin_ivca_vendor_list,
            name: 'admin_ivca_vendor_list',
            meta:{
                title: 'Admin iVCA Vendor List',
            },   
        },
        { 
            path: '/ivca/admin/vendor-black-list', 
            component: admin_ivca_vendor_black_list,
            name: 'admin_ivca_vendor_black_list',
            meta:{
                title: 'Admin iVCA Vendor Blocked',
            },   
        },


        { 
            path: '/ivca/admin/template-mro-manufacturer', 
            component: admin_ivca_temp_mro_manufacturer,
            name: 'admin_ivca_temp_mro_manufacturer',
            meta:{
                title: 'Admin iVCA Template MRO Manufacturer',
            },   
        },
        { 
            path: '/ivca/admin/template-mro-importer', 
            component: admin_ivca_temp_mro_importer,
            name: 'admin_ivca_temp_mro_importer',
            meta:{
                title: 'Admin iVCA Template MRO Importer',
            },   
        },
        { 
            path: '/ivca/admin/template-mro-retailer', 
            component: admin_ivca_temp_mro_retailer,
            name: 'admin_ivca_temp_mro_retailer',
            meta:{
                title: 'Admin iVCA Template MRO Retailer',
            },   
        },
        { 
            path: '/ivca/admin/template-food', 
            component: admin_ivca_temp_food,
            name: 'admin_ivca_temp_food',
            meta:{
                title: 'Admin iVCA Template Food',
            },   
        },


        { 
            path: '/ivca/admin/schedule', 
            component: admin_ivca_schedule,
            name: 'admin_ivca_schedule',
            meta:{
                title: 'Admin iVCA Schedule',
            },   
        },

        { 
            path: '/ivca/admin/schedule-mro', 
            component: admin_ivca_schedule_mro,
            name: 'admin_ivca_schedule_mro',
            meta:{
                title: 'Admin iVCA Schedule',
            },   
        },
        { 
            path: '/ivca/admin/schedule-food', 
            component: admin_ivca_schedule_food,
            name: 'admin_ivca_schedule_food',
            meta:{
                title: 'Admin iVCA Schedule Food',
            },   
        },



        { 
            path: '/ivca/admin/reports-manufacturer', 
            component: admin_ivca_reports_manufacturer,
            name: 'admin_ivca_reports_manufacturer',
            meta:{
                title: 'Admin iVCA Reports Manufacturer',
            },   
        },

        { 
            path: '/ivca/admin/reports-manufacturer-summary', 
            component: admin_ivca_reports_manufacturer_summary,
            name: 'admin_ivca_reports_manufacturer_summary',
            meta:{
                title: 'Admin iVCA Reports Manufacturer Summary',
            },
            props:true,   
        },

        { 
            path: '/ivca/admin/reports-importer', 
            component: admin_ivca_reports_importer,
            name: 'admin_ivca_reports_importer',
            meta:{
                title: 'Admin iVCA Reports Importer',
            },   
        },

        { 
            path: '/ivca/admin/reports-importer-summary', 
            component: admin_ivca_reports_importer_summary,
            name: 'admin_ivca_reports_importer_summary',
            meta:{
                title: 'Admin iVCA Reports Importer Summary',
            },
            props:true,   
        },


        { 
            path: '/ivca/admin/reports-retailer', 
            component: admin_ivca_reports_retailer,
            name: 'admin_ivca_reports_retailer',
            meta:{
                title: 'Admin iVCA Reports Retailer',
            },   
        },

        { 
            path: '/ivca/admin/reports-retailer-summary', 
            component: admin_ivca_reports_retailer_summary,
            name: 'admin_ivca_reports_retailer_summary',
            meta:{
                title: 'Admin iVCA Reports Retailer Summary',
            },
            props:true,   
        },


        { 
            path: '/ivca/admin/reports-food', 
            component: admin_ivca_reports_food,
            name: 'admin_ivca_reports_food',
            meta:{
                title: 'Admin iVCA Reports Food',
            },
            props:true,   
        },
        { 
            path: '/ivca/admin/reports-food-summary', 
            component: admin_ivca_reports_food_summary,
            name: 'admin_ivca_reports_food_summary',
            meta:{
                title: 'Admin iVCA Reports Food Summary',
            },
            props:true,   
        },
        


        


        { 
            path: '/ivca/admin/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Super Admin 404',
            },   
        },

    ]
});


// Run brfore every route request
router.beforeEach( (to, from, next) => {
    // console.log(to, to.meta);
 
    let appName = 'CPB-IT';
    let title = to.meta && to.meta.title ? to.meta.title : '';
    // set current title
    document.title =`${ appName } ${ title }`;

    next();
});


export default router;