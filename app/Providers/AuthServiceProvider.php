<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

          //Check One Role
          Gate::define('oneRole', function($user, $data){
            return $user->hasRole($data);
        });


        //Define Gates
        Gate::define('manageUser', function($user){
            return $user->hasAnyRoles(['Administrator', 'User-management']);
        });


        //Administrator
        Gate::define('administration', function($user){
            return $user->hasRole(['Administrator']);
        });

        //Role manage
        Gate::define('roleManage', function($user){
            return $user->hasAnyRoles(['Administrator', 'Role-manage']);
        });

        //Add Access
        Gate::define('insert', function($user){
            return $user->hasAnyRoles(['Administrator', 'Add']);
        });

        //Edit Access
        Gate::define('edit', function($user){
            return $user->hasAnyRoles(['Administrator', 'Edit']);
        });

        //Delete
        Gate::define('delete', function($user){
            return $user->hasAnyRoles(['Administrator', 'Delete']);
        });



        //Super Admin Project
        Gate::define('superadmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Super-admin']);
        });


        //Inventory Project
        Gate::define('inventory', function($user){
            return $user->hasAnyRoles(['Administrator', 'Inventory-admin']);
        });

        //Network Moniror Project
        Gate::define('network', function($user){
            return $user->hasAnyRoles(['Administrator', 'Network-monitor']);
        });




        //iHelpDesk Project's Gate

        //Hardware-admin
        Gate::define('hardAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Hardware-admin']);
        });

        //Hardware-admin
        Gate::define('appAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Application-admin']);
        });

        //cms-user
        Gate::define('cms', function($user){
            return $user->hasAnyRoles(['Administrator', 'cms']);
        });


        //Room Booking Project's Gate

        //Room User
        Gate::define('room', function($user){
            return $user->hasAnyRoles(['Administrator', 'Room']);
        });
        //Room Admin
        Gate::define('roomAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Room-admin']);
        });


        //Carpool Booking Project's Gate

        //Carpool User
        Gate::define('car', function($user){
            return $user->hasAnyRoles(['Administrator', 'Carpool']);
        });
        //Carpool Admin
        Gate::define('carAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Carpool-admin']);
        });




        //Power BI Project's Gate

        //Powerbi User
        Gate::define('powerbi', function($user){
            return $user->hasAnyRoles(['Administrator', 'Powerbi']);
        });
        //Powerbi Admin
        Gate::define('powerbiAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Powerbi-admin']);
        });




        //SMS Project's Gate

        //SMS User
        Gate::define('SMS', function($user){
            return $user->hasAnyRoles(['Administrator', 'Sms']);
        });
        //SMS Admin
        Gate::define('SMSAdmin', function($user){
            return $user->hasAnyRoles(['Administrator', 'Sms-admin']);
        });




        //Iqscm Project's Gate

        //Iqscm User
        Gate::define('iqscmUserSection', function($user){
            return $user->hasAnyRoles(['Administrator', 'Iqscm']);
        });
        //Iqscm Admin
        Gate::define('iqscmAdminSection', function($user){
            return $user->hasAnyRoles(['Administrator', 'Iqscm-admin']);
        });


        //Iqscm manager
        Gate::define('iqscmAdmin', function($user){
            return $user->iqscm_hasRole(['Admin']);
        });

        //Iqscm manager
        Gate::define('iqscmManager', function($user){
            return $user->iqscm_hasAnyRoles(['Admin', 'Manager']);
        });

        //Iqscm Officer
        Gate::define('iqscmOfficer', function($user){
            return $user->iqscm_hasAnyRoles(['Admin', 'Officer']);
        });


        //Ivca User
        Gate::define('ivcaUserSection', function($user){
            return $user->hasAnyRoles(['Administrator', 'Ivca']);
        });
        //Ivca Admin
        Gate::define('ivcaAdminSection', function($user){
            return $user->hasAnyRoles(['Administrator', 'Ivca-admin']);
        });

    }
}
