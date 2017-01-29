<?php

namespace App\Http\Controllers;

use App\SettingValue;
use App\Setting;

use Auth;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the users preferences.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPreferences()
    {
        $userPreferences = SettingValue::where('user_id', Auth::id())->get();

        return $userPreferences;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userPreferences = $request->input('user_preferences');
        $settingNames = array_keys($userPreferences);
        $settingIds = Setting::whereIn('setting_name', $settingNames)->pluck('id');

        foreach ($settingIds as $key => $id) {
            $currentSettingValue = SettingValue::where('user_id', Auth::id())
                ->where('setting_id', $id);

            if ($currentSettingValue->count() > 0) {
                $currentSettingValue->update([
                        'setting_value' => $userPreferences[$settingNames[$key]]
                ]);
            } else {
                $settingValue = new SettingValue;

                $settingValue->user_id      = Auth::id();
                $settingValue->setting_id   = $id;
                $settingValue->setting_value = $userPreferences[$settingNames[$key]];

                $settingValue->save();
            }
        }

        return response()->json([
            'error'   => 0,
            'message' => trans('api.setting.success.store')
        ]);
    }
}
