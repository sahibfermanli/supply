<?php

namespace App\Http\Middleware;

use App\Accounts;
use App\Alternatives;
use App\Categories;
use App\Orders;
use App\Purchase;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Login
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
        //is login
        if (Auth::check() && Auth::user()->deleted_value()==0 && Auth::user()->confirmed() == 1) {
            //chiefs
            if (Auth::user()->chief() == 1) {
                $categories = Categories::where(['deleted'=>0])->orderBy('process')->select('id', 'process')->get();

                $i = 0;
                foreach ($categories as $category) {
                    $orders = Orders::where(['DepartmentID'=>Auth::user()->DepartmentID(), 'category_id'=>$category->id, 'confirmed'=>0, 'deleted'=>0])->where('situation_id', '<>', 9)->select('id')->get();
                    $count = count($orders);

                    $categories[$i]['orders_count'] = $count;
                    $i++;
                }

                View::share(['categories_for_chief'=>$categories]);
            }

            ///////// lawyers
            if (Auth::user()->authority() == 6) {
                //accounts
                $purchases = Purchase::where(['deleted'=>0, 'completed'=>0])->select('account_id')->get();
                if (Auth::user()->chief() == 0) {
                    //employee
                    $accounts = Accounts::leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0])->whereNull('accounts.lawyer_confirm')->orderBy('c.seller_name')->select('accounts.id', 'accounts.account_no', 'c.seller_name as company')->get();
                }
                else {
                    //chief
                    $accounts = Accounts::leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0, 'accounts.lawyer_confirm'=>1])->whereNull('accounts.lawyer_chief_confirm')->orderBy('c.seller_name')->select('accounts.id', 'accounts.account_no', 'c.seller_name as company')->get();
                }

                View::share(['accounts'=>$accounts]);
            }
            //////////// director
            else if (Auth::user()->authority() == 5) {
                //orders count for alternatives (categories)
                $categories = Categories::where(['deleted'=>0])->orderBy('process')->select('id', 'process')->get();

                $purchases = Purchase::where(['deleted'=>0])->select('AlternativeID')->distinct()->get();
                $alternatives = Alternatives::whereIn('id', $purchases)->where(['deleted'=>0])->select('OrderID')->get();

                $i = 0;
                foreach ($categories as $category) {
                    $orders = Alternatives::leftJoin('Orders as o', 'lb_Alternatives.OrderID', '=', 'o.id')->whereNull('lb_Alternatives.DirectorRemark')->whereNotIn('o.id', $alternatives)->where(['o.deleted' => 0, 'o.category_id' => $category->id, 'lb_Alternatives.deleted'=>0, 'lb_Alternatives.confirm_chief'=>1])->distinct()->select('o.id')->get();
                    $count = count($orders);

                    $categories[$i]['orders_count'] = $count;
                    $i++;
                }

                View::share(['categories'=>$categories]);

                // director lawyer
                if (Auth::user()->auditor() == 8) {
                    $purchases = Purchase::where(['deleted'=>0, 'completed'=>0])->select('account_id')->get();
                    $accounts = Accounts::leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0, 'accounts.lawyer_chief_confirm'=>1])->whereNull('accounts.director_lawyer_confirm')->orderBy('c.seller_name')->select('accounts.id', 'accounts.account_no', 'c.seller_name as company')->get();

                    View::share(['accounts'=>$accounts]);
                }
            }
            /////////// finance
            else if (Auth::user()->authority() == 7) {
                $purchases = Purchase::where(['deleted'=>0, 'completed'=>0])->select('account_id')->get();
                if (Auth::user()->chief() == 0) {
                    // employees
                    $accounts = Accounts::leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0, 'accounts.director_lawyer_confirm'=>1])->whereNull('accounts.finance_confirm')->orderBy('c.seller_name')->select('accounts.id', 'accounts.account_no', 'c.seller_name as company')->get();

                    View::share(['accounts'=>$accounts]);
                }
                else {
                    // chief
                    $accounts = Accounts::leftJoin('lb_sellers as c', 'accounts.company_id', '=', 'c.id')->whereIn('accounts.id', $purchases)->where(['accounts.send'=>1, 'accounts.deleted'=>0, 'accounts.finance_confirm'=>1])->whereNull('accounts.finance_chief_confirm')->orderBy('c.seller_name')->select('accounts.id', 'accounts.account_no', 'c.seller_name as company')->get();

                    View::share(['accounts'=>$accounts]);
                }
            }
            ////////////// supply
            else if (Auth::user()->authority() == 4) {
                $categories = Categories::where(['deleted'=>0])->orderBy('process')->select('id', 'process')->get();

                $i = 0;
                $purchases = Purchase::leftjoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.deleted'=>0])->select('a.OrderID')->get();

                foreach ($categories as $category) {
                    if (Auth::user()->chief() == 1) {
                        //not confirmed orders for chief
                        $orders = Orders::where(['DepartmentID'=>4, 'confirmed'=>0, 'deleted'=>0, 'category_id'=>$category->id])->count();
                        $categories[$i]['orders_count'] = $orders;

                        //alternatives for chief
                        $alts = Orders::where(['Orders.deleted' => 0, 'category_id' => $category->id, 'confirmed'=>1])->whereNotIn('id', $purchases)->count();
                        $categories[$i]['alts_count'] = $alts;
                    }
                    else {
                        //alternatives for supply user
                        $alts = Orders::where(['Orders.deleted' => 0, 'category_id' => $category->id, 'SupplyID'=>Auth::id(), 'confirmed'=>1])->whereNotIn('id', $purchases)->count();
                        $categories[$i]['alts_count'] = $alts;
                    }
                    $i++;
                }

                View::share(['categories_for_supply'=>$categories, 'categories'=>$categories]);
            }

            return $next($request);
        }

        return redirect('/logout');
    }
}
