<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Deadlines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends HomeController
{
    //show
    public function get_purchases() {
        $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->leftJoin('companies as c', 'Purchases.company_id', '=', 'c.id')->leftJoin('users', 'Purchases.delivery_person_id', '=', 'users.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.hesab_doc', 'Purchases.hesab_doc_date', 'Purchases.odenish_date', 'Purchases.qaime_doc', 'Purchases.qaime_doc_date', 'Purchases.AWB_Akt_doc', 'Purchases.AWB_Akt_doc_date', 'Purchases.icrachi_doc', 'Purchases.icrachi_doc_date', 'c.name as company', 'c.phone', 'c.address', 'users.name', 'users.surname', 'Purchases.delivery_date', 'Purchases.Verilib_MHIS', 'Purchases.Verilib_MHIS_date', 'Verilib_MS', 'Verilib_MS_date', 'Purchases.Remark', 'o.deadline', 'Purchases.created_at')->paginate(30);

        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');

        return view('backend.purchases')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date]);
    }

    //delete
    public function post_delete_purchase_for_supply(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'row_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id tapılmadı!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            Purchase::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Silinmə zamanı səhv baş verdi!']);
        }
    }

    //for supply
    public function get_purchases_for_supply() {
        $deadlines = Deadlines::where(['deleted'=>0])->select('type', 'deadline', 'color')->get();
        $current_date = Carbon::now()->format('Y-m-d');

        if (Auth::user()->chief() == 1) {
            //supply chief
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'Purchases.odenish_date', 'Purchases.qaime_doc', 'Purchases.qaime_doc_date', 'Purchases.AWB_Akt_doc', 'Purchases.AWB_Akt_doc_date', 'Purchases.icrachi_doc', 'Purchases.icrachi_doc_date', 'Purchases.delivery_date', 'Purchases.Verilib_MHIS', 'Purchases.Verilib_MHIS_date', 'Verilib_MS', 'Verilib_MS_date', 'Purchases.Remark', 'o.deadline', 'Purchases.created_at')->paginate(30);
        }
        else {
            //supply user
            $purchases = Purchase::leftJoin('lb_Alternatives as a', 'Purchases.AlternativeID', '=', 'a.id')->leftJoin('Orders as o', 'a.OrderID', '=', 'o.id')->leftJoin('lb_units_list as u', 'a.unit_id', '=', 'u.id')->rightJoin('accounts as ac', 'Purchases.account_id', '=', 'ac.id')->where(['Purchases.deleted'=>0, 'a.deleted'=>0 ,'o.deleted'=>0, 'o.SupplyID'=>Auth::id()])->orderBy('Purchases.id', 'DESC ')->select('Purchases.id as id', 'o.Product', 'a.Brend', 'a.Model', 'a.cost', 'a.total_cost', 'a.pcs', 'u.Unit', 'Purchases.account_id', 'ac.account_no', 'ac.created_at as account_date', 'ac.account_doc', 'Purchases.odenish_date', 'Purchases.qaime_doc', 'Purchases.qaime_doc_date', 'Purchases.AWB_Akt_doc', 'Purchases.AWB_Akt_doc_date', 'Purchases.icrachi_doc', 'Purchases.icrachi_doc_date', 'Purchases.delivery_date', 'Purchases.Verilib_MHIS', 'Purchases.Verilib_MHIS_date', 'Verilib_MS', 'Verilib_MS_date', 'Purchases.Remark', 'o.deadline', 'Purchases.created_at')->paginate(30);
        }

        return view('backend.purchases_for_supply')->with(['purchases'=>$purchases, 'deadlines'=>$deadlines, 'current_date'=>$current_date]);
    }
}
