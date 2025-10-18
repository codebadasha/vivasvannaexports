<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\RoleModule;
use App\Models\ClientInvestor;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function($view){
            
            /**
             * admin role auth
             */
            if (Auth::guard('admin')->user()) {
                
                $checkPermission = RoleModule::where('role_id',Auth::guard('admin')->user()->role_id)->with(['moduleName'])->get();

                $module = array();
                $selectedAction = array();

                if(!is_null($checkPermission)){
                    foreach($checkPermission as $pk => $pv){
                        $module[] = $pv->moduleName->slug;
                        $selectedAction[$pv->moduleName->slug] = explode(',',$pv->action);
                    }
                }

                View::share('module',$module);
                View::share('selectedAction',$selectedAction);
            }

            /**
             * Investor client id
             */
            if (Auth::guard('investor')->user()) {

                $investorClient = ClientInvestor::where('investor_id',Auth::guard('investor')->user()->id)->pluck('client_id')->toArray();

                View::share('investorClient',$investorClient);
            }

        });
    }
}
