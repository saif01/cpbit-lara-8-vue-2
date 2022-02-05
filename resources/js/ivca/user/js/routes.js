import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ivca_dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'

// reports
import ivca_reports_all_audits from '../pages/reports/all-audit-reports.vue'

import ivca_check from '../pages/check.vue'


// Mro
import ivca_mro_schedule from '../pages/mro/schedule.vue'
import ivca_mro_choose_template from '../pages/mro/choose-template.vue'
import ivca_mro_audit_questions from '../pages/mro/audit-questions.vue'




// Food
import ivca_food_schedule from '../pages/food/schedule.vue'
import ivca_food_audit_questions from '../pages/food/audit-questions.vue'



const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/ivca/', 
            component: ivca_dashboard,
            name: 'ivca_dashboard',
            meta:{
                title: 'IVCA Dashboard',
            },   
        },

        { 
            path: '/ivca/mro-schedule', 
            component: ivca_mro_schedule,
            name: 'ivca_mro_schedule',
            meta:{
                title: 'iVCA MRO Schedule',
            },   
        },
        { 
            path: '/ivca/mro-choose-template', 
            component: ivca_mro_choose_template,
            name: 'ivca_mro_choose_template',
            meta:{
                title: 'iVCA MRO Audit Choose Template',
            },
            props: true   
        },

        { 
            path: '/ivca/mro-audit-start', 
            component: ivca_mro_audit_questions,
            name: 'ivca_mro_audit_questions',
            meta:{
                title: 'iVCA Audit Questions',
            },
            props: true   
        },
        
       

        



        //Food Audit
        { 
            path: '/ivca/food-schedule', 
            component: ivca_food_schedule,
            name: 'ivca_food_schedule',
            meta:{
                title: 'iVCA Food Schedule',
            },   
        },
        { 
            path: '/ivca/audit-start-food', 
            component: ivca_food_audit_questions,
            name: 'ivca_food_audit_questions',
            meta:{
                title: 'iVCA Food Audit Questions',
            },
            props: true   
        },


        { 
            path: '/ivca/reports-audits-all', 
            component: ivca_reports_all_audits,
            name: 'ivca_reports_all_audits',
            meta:{
                title: 'iVCA Audit Reports',
            },
            props: true   
        },

    

        






        { 
            path: '/ivca/check', 
            component: ivca_check,
            name: 'ivca_check',
            meta:{
                title: 'iVCA Blank',
            },   
        },
        // { 
        //     path: '/ivca/blank', 
        //     component: ivca_blank,
        //     name: 'ivca_blank',
        //     meta:{
        //         title: 'iVCA Blank',
        //     },
        //     props: true   
        // },
        







        { 
            path: '/room/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Room 404',
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