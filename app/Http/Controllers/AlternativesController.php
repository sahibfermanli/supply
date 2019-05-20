<?php

namespace App\Http\Controllers;

use App\AlternativeLogs;
use App\Alternatives;
use App\Countries;
use App\Currencies;
use App\Sellers;
use App\Units;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AlternativesController extends HomeController
{
    //show
    public function get_alternatives() {
        $alternatives = Alternatives::where(['deleted'=>0])->orderBy('id', 'DESC')->select('*')->paginate(30);
        $units = Units::where(['deleted' => 0])->orderBy('use_count', 'DESC')->select('id', 'Unit')->get();
        $countries = Countries::where('deleted', 0)->select(['id', 'country_code', 'country_name'])->get();
        $currencies = Currencies::where('deleted', 0)->select(['id', 'cur_name', 'cur_value', 'cur_rate'])->get();
        $companies = Sellers::where(['deleted'=>0])->select('id', 'seller_name as name')->orderBy('seller_name')->get();

        return view('backend.alternatives_list')->with(['alternatives'=>$alternatives, 'units' => $units, 'companies'=>$companies, 'countries'=>$countries, 'currencies'=>$currencies]);
    }

    public function post_alternatives(Request $request) {
        if ($request->type == 'delete') {
            //delete
            return $this->delete($request);
        }
        else if ($request->type == 'update') {
            //add
            return $this->update($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Id not found!']);
        }
        try {
            $id = $request->id;
            $date = Carbon::now();
            $delete = Alternatives::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date, 'deleted_by'=>Auth::id()]);
            if ($delete) {
                AlternativeLogs::create(['user_id'=>Auth::id(), 'alt_id'=>$id, 'type'=>'delete']);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Alternative silindi!', 'row_id'=>$request->id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Səhv baş verdi!']);
        }
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'unit_id' => 'required|integer',
            'Product' => 'required|string|max:300',
            'Brend' => 'required|string|max:255',
            'Model' => 'required|string|max:255',
            'PartSerialNo' => 'required|string|max:255',
            'date' => 'required|date',
            'cost' => 'required',
            'country_id' => 'required|integer',
            'currency_id' => 'required|integer',
            'company_id' => 'required|integer',
            'pcs' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun!']);
        }
        try {
            unset($request['_token'], $request['type']);
            $id = $request->id;
            unset($request['id']);

            $request = Input::except('page');

            $update = Alternatives::where('id', $id)->update($request);
            if ($update) {
                AlternativeLogs::create(['user_id'=>Auth::id(), 'alt_id'=>$id, 'type'=>'update']);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Məlumatlar dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
