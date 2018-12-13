<?php

namespace App\Http\Controllers;

use App\Accounts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AccountController extends HomeController
{
    public function get_accounts_for_supply() {
        $accounts = Accounts::where(['deleted'=>0])->select()->paginate(30);

        return view('backend.accounts')->with(['accounts'=>$accounts]);
    }

    public function post_accounts_for_supply(Request $request) {
        if ($request->type == 'delete') {
            //delete
            return $this->delete_account($request);
        }
        else if ($request->type == 'add') {
            //add
            return $this->add_account($request);
        }
        else if ($request->type == 'update') {
            //update
            return $this->update_account($request);
        }
        else if ($request->type == 'update_doc') {
            //update document
            return $this->update_document($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //delete account
    public function delete_account(Request $request) {
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
            Accounts::where(['id'=>$id])->update(['deleted'=>1, 'deleted_at'=>$date]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Silindi!', 'row_id'=>$request->row_id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Silinmə zamanı səhv baş verdi!']);
        }
    }

    //add account
    public function add_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_no' => 'required|string|max:50',
            'company' => 'required|string|max:50',
            //'file' => 'required|mimes:doc,docx,pdf',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun (fayl formatı: *.doc, *.docx, *.pdf)!']);
        }
        try {
            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'account_' . $request->account_no . '_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/accounts');
            $file->move('uploads/files/accounts/', $file_name);
            $file_address = '/uploads/files/accounts/' . $file_name;

            $request->merge(['account_doc' => $file_address]);

            $request = Input::except('file');

            Accounts::create($request);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hesab əlavə edildi!', 'type' => 'add_account']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //update account
    public function update_account(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'account_no' => 'required|string|max:50',
            'company' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Bütün xanaları doldurun!']);
        }
        try {
            $id = $request->id;
            unset($request['id'], $request['_token'], $request['type']);

            Accounts::where(['id'=>$id])->update($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Hesab məlumatları dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }

    //update document
    public function update_document(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'account_no' => 'required|string|max:50',
        ]);
        try {
            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'account_' . $request->account_no . '_' . str_random(4) . '_' . microtime() . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/accounts');
            $file->move('uploads/files/accounts/', $file_name);
            $file_address = '/uploads/files/accounts/' . $file_name;

            Accounts::where(['id'=>$request->id])->update(['account_doc'=>$file_address]);

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Faly dəyişdirildi!', 'type' => 'update_doc']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Səhv baş verdi!']);
        }
    }
}
