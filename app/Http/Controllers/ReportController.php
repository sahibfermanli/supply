<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Reports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Image;

class ReportController extends HomeController
{
    //select reports
    public function get_reports()
    {
        $reports = Reports::leftJoin('lb_status as s', 'Reports.status_id', '=', 's.id')->where(['Reports.deleted' => 0, 'Reports.DepartmentID' => Auth::user()->DepartmentID()])->select('Reports.id', 'Reports.ReportNo', 'Reports.Subject', 'Reports.Text', 'Reports.ReportDocument', 'Reports.created_at', 's.status', 's.color')->orderBy('Reports.id', 'DESC')->paginate(30);

        return view('backend.reports')->with(['reports' => $reports]);
    }

    //delete report
    public function post_delete_report(Request $request)
    {
        if ($request->type == 1) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'row_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'İd tapılmadl!']);
            }
            try {
                $id = $request->id;
                $date = Carbon::now();
                Reports::where(['id' => $id])->update(['deleted' => 1, 'deleted_at' => $date]);

                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Raport silindi!', 'row_id' => $request->row_id]);
            } catch (\Exception $e) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Raport silinirkən səhv baş verdi!']);
            }
        }
        else if($request->type == 2) {
            //report add to order
            $validator = Validator::make($request->all(), [
                'report_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Raport tapılmadı!']);
            }
            $success = 0;
            $error = 0;
            $orders = $request->order_id;
            $report_id = $request->report_id;
            $situation_id = 2;

            if (count($orders) == 0) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sifariş tapılmadı!']);
            }
            for ($i=0; $i<count($orders); $i++) {
                if (ctype_digit($orders[$i]) && $orders[$i] != 0) {
                    $update = Orders::where(['id'=>$orders[$i], 'deleted'=>0, 'ReportID'=>null])->update(['ReportID'=>$report_id, 'situation_id'=>$situation_id]);
                    if ($update) {
                        $success++;
                    }
                    else {
                        $error++;
                    }
                }
                else {
                    $error++;
                }
            }

            return response(['case' => 'success', 'title' => 'Finished!', 'type'=>'add_order', 'orders'=>$orders, 'content' => $success.' success; '.$error.' error.']);
        }
        else if($request->type == 3) {
            //show orders
            $validator = Validator::make($request->all(), [
                'report_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Raport tapılmadı!']);
            }
            $report_id = $request->report_id;
            $orders = Orders::leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->where(['Orders.ReportID'=>$report_id, 'Orders.deleted'=>0, 'Orders.DepartmentID'=>Auth::user()->DepartmentID()])->select('Orders.id', 'Orders.Product', 'Orders.Pcs', 'u.Unit')->get();

            return response(['case' => 'success', 'orders'=>$orders]);
        }
        else if($request->type == 4) {
            //get orders for add order form
            $validator = Validator::make($request->all(), [
                'report_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Raport tapılmadı!']);
            }

            $report_id = $request->report_id;
            $orders = Orders::leftJoin('lb_units_list as u', 'Orders.unit_id', '=', 'u.id')->where(['Orders.ReportID'=>null, 'Orders.deleted'=>0, 'Orders.DepartmentID'=>Auth::user()->DepartmentID()])->select('Orders.id', 'Orders.Product', 'Orders.Pcs', 'u.Unit')->get();

            return response(['case' => 'success', 'orders'=>$orders]);
        }
        else if($request->type == 5) {
            return $this->add_report($request);
        }
        else {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Xəta baş verdi!']);
        }
    }

    //update report
    public function get_update_report($id)
    {
        $report = Reports::where(['id' => $id, 'deleted' => 0, 'DepartmentID' => Auth::user()->DepartmentID()])->select('ReportNo', 'ReportDate', 'Subject', 'Remark', 'ReportDocument')->first();
        if (count($report) == 0) {
            return redirect('/reports');
        }

        return view('backend.report_update')->with(['report' => $report]);
    }

    public function post_update_report(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ReportNo' => 'required|integer',
            'ReportDate' => 'required|date',
            'Subject' => 'required|string|max:10',
            'Remark' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımı xanaları doldurun!']);
        }

        if (isset($request->file)) {
            $validator_file = Validator::make($request->all(), [
                'file' => 'mimes:doc,docx,pdf',
            ]);
            if ($validator_file->fails()) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Fayl formatı bunlardan biri olmalıdır: dox, docx, pdf.']);
            }

            $file = Input::file('file');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = 'report_' . $request->ReportNo . '_' . str_random(4) . '.' . $file_ext;
            Storage::disk('uploads')->makeDirectory('files/reports');
            $file->move('uploads/files/reports/', $file_name);
            $file_address = '/uploads/files/reports/' . $file_name;

            $reportDocument = $file_address;
            $request->merge(['ReportDocument' => $reportDocument]);
        }

        try {
            $request = Input::except('file');
            unset($request['_token']);

            Reports::where(['id' => $id, 'deleted' => 0])->update($request);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Raport dəyişdirildi!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Raport dəyişdirilərkən səhv baş verdi!']);
        }
    }

    //add report
    public function get_add_report()
    {
        return view('backend.report_add');
    }

    public function add_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:doc,docx,pdf|required',
            'Subject' => 'required|string|max:200',
            'Text' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Lazımı xanaları doldurun! Və ya fayl formatı yanlışdır! Fayl tipləri: (*.doc, *docx, *.pdf)']);
        }

        $file = Input::file('file');
        $file_ext = $file->getClientOriginalExtension();
        $file_name = 'report_' . str_random(4) . '.' . $file_ext;
        Storage::disk('uploads')->makeDirectory('files/reports');
        $file->move('uploads/files/reports/', $file_name);
        $file_address = '/uploads/files/reports/' . $file_name;

        try {
            $mainPerson = Auth::id();
            $departmentId = Auth::user()->DepartmentID();
            $reportDocument = $file_address;
            $status_id = 1; //pending

            unset($request['file']);
            $request->merge(['MainPerson' => $mainPerson, 'DepartmentId' => $departmentId, 'deleted' => 0, 'ReportDocument' => $reportDocument, 'status_id'=>$status_id]);

            unset($request['type']);

            $add = Reports::create($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Raport yaradıldı!', 'last_ins_id'=>$add->id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Xəta!', 'content' => 'Xəta baş verdi!']);
        }
    }
}
