<?php

namespace App\Http\Controllers;

use App\Institution;
use App\User;

use Auth;

use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institutionName = $request->input('institution_name');

        if (Auth::user()->institution_id === null) {
            $institution = new Institution;

            $institution->name             = $institutionName;
            $institution->institution_code = $this->generateNewRandomCode();

            $institution->save();

            $user = User::where('id', Auth::id())
                ->update([
                    'institution_id' => $institution->id
                ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.institution.success.store')
            ]);
        }

        if (Auth::user()->priviledge === 1) {
            Institution::where('id', Auth::user()->institution_id)
                ->update([
                    'name' => $institutionName
                ]);

            return response()->json([
                'error'   => 0,
                'message' => trans('api.institution.success.update')
            ]);
        }

        return response()->json([
            'error'   => 1,
            'message' => trans('api.institution.failure.update')
        ]);
    }

    public function generateNewRandomCode()
    {
        $randomCode = strtoupper(str_random(8));

        if (Institution::where('institution_code', $randomCode)->count() > 0) {
            return $this->generateNewRandomCode();
        }

        return $randomCode;
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|between:1,50|regex:/^[a-zA-Z0-9\s-]+$/'
        ]);
    }
}
