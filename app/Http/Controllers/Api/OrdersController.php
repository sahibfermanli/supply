<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Messages as MessagesResource;
use App\Orders;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Orders as OrderResource;

class OrdersController extends ApiController
{
    public function get_orders() {
        try {
            $orders = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')
                ->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')
                ->leftJoin('accounts', 'Purchases.account_id', '=', 'accounts.id')
                ->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')
                ->leftJoin('lb_sellers', 'accounts.company_id', '=', 'lb_sellers.id')
                ->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.delivered'=>1, 'o.DepartmentID'=>1, 'o.send_api'=>0])
                ->select('o.id as id', 'a.Product', 'a.Brend', 'a.Model', 'a.PartSerialNo', 'a.Remark', 'a.image', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'o.created_at', 'lb_sellers.seller_name', 'accounts.account_no')
                ->orderBy('o.id')
                ->get();

            $order_arr = array();
            foreach ($orders as $order) {
                array_push($order_arr, $order->id);
            }

            if (count($order_arr) > 0) {
                Orders::whereIn('id', $order_arr)->update(['send_api'=>1]);
            }

            return OrderResource::collection($orders);
        } catch (\Exception $e) {
            $response_arr['status'] = 500;
            $response_arr['type'] = 'Error';
            $response_arr['message'] = 'Sorry, An error occurred...';

            $response_obj = (object) $response_arr;

            return new MessagesResource($response_obj);
        }
    }
}
