import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

import Category from './../pages/others/category/index.vue'
import Subcategory from './../pages/others/subcategory/index.vue'
import Acsosoris from './../pages/others/acsosoris/index.vue'

import User from './../pages/user/index.vue'
import Role from './../pages/user/role.vue'

import Draft from './../pages/draft/index.vue'

import NotProcess from './../pages/complain/not_process.vue'
import Processing from './../pages/complain/processing.vue'
import Closed from './../pages/complain/closed.vue'
import Action from './../pages/complain/action/action.vue'
import Service from './../pages/complain/service.vue'

// delivery
import Deliverable from './../pages/complain/delivery/deliverable.vue'
import Delivered from './../pages/complain/delivery/delidered.vue'


// Damaged
import AllDamaged from './../pages/complain/damaged/all.vue'
import ApplicableDamaged from './../pages/complain/damaged/applicable/damaged.vue'
import ApplicablePartialDamaged from './../pages/complain/damaged/applicable/partial_damaged.vue'
import NotApplicableDamaged from './../pages/complain/damaged/not_applicable/damaged.vue'
import NotApplicablePartialDamaged from './../pages/complain/damaged/not_applicable/partial_damaged.vue'

// H O Service
import HOServiceIndex from './../pages/complain/h_o_service/index.vue'

// Reports
import ReportIndex from './../pages/reports/index.vue'
import ReportDamaged from './../pages/reports/damaged.vue'
import ReportDamagedReplace from './../pages/reports/damaged_replace.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/cms/h_admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Hardware Dashboard',
            },   
        },
        { 
            path: '/cms/h_admin/category', 
            component: Category,
            name: 'Category',
            meta:{
                title: 'Hardware Category Admin',
            },   
        },
        { 
            path: '/cms/h_admin/subcategory', 
            component: Subcategory,
            name: 'Subcategory',
            meta:{
                title: 'Hardware Subcategory Admin',
            },   
        },
        { 
            path: '/cms/h_admin/cat_dependency', 
            component: Acsosoris,
            name: 'Acsosoris',
            meta:{
                title: 'Hardware Acsosoris Admin',
            },   
        },
        { 
            path: '/cms/h_admin/user', 
            component: User,
            name: 'User',
            meta:{
                title: 'Hardware User Admin',
            },   
        },
        { 
            path: '/cms/h_admin/role', 
            component: Role,
            name: 'Role',
            meta:{
                title: 'Hardware Role Admin',
            },   
        },
        { 
            path: '/cms/h_admin/not_process', 
            component: NotProcess,
            name: 'NotProcess',
            meta:{
                title: 'Hardware Not Process Admin',
            },   
        },
        { 
            path: '/cms/h_admin/processing', 
            component: Processing,
            name: 'Processing',
            meta:{
                title: 'Hardware Processing Admin',
            },   
        },
        { 
            path: '/cms/h_admin/closed', 
            component: Closed,
            name: 'Closed',
            meta:{
                title: 'Hardware Closed Admin',
            },   
        },


        { 
            path: '/cms/h_admin/deliverable', 
            component: Deliverable,
            name: 'Deliverable',
            meta:{
                title: 'Hardware Deliverable Admin',
            },   
        },
        { 
            path: '/cms/h_admin/delivered', 
            component: Delivered,
            name: 'Delivered',
            meta:{
                title: 'Hardware Delivered Admin',
            },   
        },

        { 
            path: '/cms/h_admin/action', 
            component: Action,
            name: 'Action',
            meta:{
                title: 'Hardware Action Admin',
            },   
        },
        { 
            path: '/cms/h_admin/service', 
            component: Service,
            name: 'Service',
            meta:{
                title: 'Hardware Service Admin',
            },   
        },
        { 
            path: '/cms/h_admin/draft', 
            component: Draft,
            name: 'Draft',
            meta:{
                title: 'Hardware Draft Admin',
            },   
        },
        { 
            path: '/cms/h_admin/damaged_all', 
            component: AllDamaged,
            name: 'AllDamaged',
            meta:{
                title: 'Hardware All Damaged Admin',
            },   
        },
        { 
            path: '/cms/h_admin/damaged_acclicable', 
            component: ApplicableDamaged,
            name: 'ApplicableDamaged',
            meta:{
                title: 'Hardware Applicable Damaged Admin',
            },   
        },
        { 
            path: '/cms/h_admin/partial_damaged_acclicable', 
            component: ApplicablePartialDamaged,
            name: 'ApplicablePartialDamaged',
            meta:{
                title: 'Hardware Applicable Partial Damaged Admin',
            },   
        },
        { 
            path: '/cms/h_admin/damaged_not_acclicable', 
            component: NotApplicableDamaged,
            name: 'NotApplicableDamaged',
            meta:{
                title: 'Hardware Not Applicable Damaged Admin',
            },   
        },
        { 
            path: '/cms/h_admin/partial_damaged_not_acclicable', 
            component: NotApplicablePartialDamaged,
            name: 'NotApplicablePartialDamaged',
            meta:{
                title: 'Hardware Not Applicable Partial Damaged Admin',
            },   
        },

        // H O
        { 
            path: '/cms/h_admin/ho_service', 
            component: HOServiceIndex,
            name: 'HOServiceIndex',
            meta:{
                title: 'Hardware H O Service Admin',
            },   
        },

        // Reports
        { 
            path: '/cms/h_admin/reports', 
            component: ReportIndex,
            name: 'ReportIndex',
            meta:{
                title: 'Hardware Report Index Admin',
            },   
        },
        { 
            path: '/cms/h_admin/damaged_reports', 
            component: ReportDamaged,
            name: 'ReportDamaged',
            meta:{
                title: 'Hardware Report Index Admin',
            },   
        },
        { 
            path: '/cms/h_admin/damaged_replace', 
            component: ReportDamagedReplace,
            name: 'ReportDamagedReplace',
            meta:{
                title: 'Hardware Report Index Admin',
            },   
        },
        

        


        


        { 
            path: '/demo/admin/*', 
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