<?php

namespace App\Http\Middleware;

use App\Accounts;
use App\Purchase;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LawyerChief
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->authority() == 6 && Auth::user()->chief() == 1) {
            $purchases = Purchase::where(['deleted'=>0, 'completed'=>0])->select('account_id')->get();
            $accounts = Accounts::leftJoin('companies as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0, 'lawyer_confirm'=>1])->whereNull('lawyer_chief_confirm')->orderBy('c.name')->select('accounts.id', 'accounts.account_no', 'c.name as company')->get();

            View::share(['accounts'=>$accounts]);

            return $next($request);
        }
        return redirect('/');
    }
}
