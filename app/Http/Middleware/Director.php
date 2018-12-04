<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Categories;
use App\Purchase;
use App\Alternatives;
use Illuminate\Support\Facades\View;

class Director
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
        if (Auth::user()->authority() == 5) {
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

          return $next($request);
        }
        return redirect('/');
    }
}
