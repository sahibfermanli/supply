<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\Orders;
use App\Purchase;
use Illuminate\Support\Facades\View;

class Supply
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
        if (Auth::user()->authority() == 4) {
          $categories = Categories::where(['deleted'=>0])->orderBy('process')->select('id', 'process')->get();

          $i = 0;
          $purchases = Purchase::leftjoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->where(['Purchases.deleted'=>0])->select('a.OrderID')->get();

          foreach ($categories as $category) {
            if (Auth::user()->chief() == 1) {
                $orders = Orders::where(['deleted' => 0, 'category_id' => $category->id, 'confirmed'=>1])->whereNotIn('id', $purchases)->count();
            }
            else {
                $orders = Orders::where(['Orders.deleted' => 0, 'category_id' => $category->id, 'SupplyID'=>Auth::id(), 'confirmed'=>1])->whereNotIn('id', $purchases)->count();
            }

            $categories[$i]['orders_count'] = $orders;
            $i++;
          }

          View::share(['categories'=>$categories]);

          return $next($request);
        }
        return redirect('/');
    }
}
