<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends HomeController
{
    public function get_settings() {
        $settings = Settings::where(['id'=>1])->select('*')->first();

        return view('backend.settings')->with(['settings'=>$settings]);
    }

    public function update_settings(Request $request) {
        try {
            unset($request['_token']);

            Settings::where(['id'=>1])->update($request->all());

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Uğurlu!']);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Səhv!', 'content' => 'Xəta baş verdi!']);
        }
    }
}
