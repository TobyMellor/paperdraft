<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CanvasHistoryController;

use App\SchoolClass;

use Closure;
use Validator;
use Auth;

class VerifyParametersMiddleware
{
    private $canvasHistoryController;

    public function __construct(CanvasHistoryController $canvasHistoryController)
    {
        $this->canvasHistoryController = $canvasHistoryController;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = [
            'class_id'                 => $request->input('class_id'),
            'canvas_item'              => $request->input('canvas_item'),
            'canvas_items'             => $request->input('canvas_items'),
            'canvas_history'           => $request->input('canvas_history'),
            'canvas_action_undo_count' => $request->input('canvas_action_undo_count')
        ];

        $validation = $this->validator($data);

        $validation->after(function($validation) use ($data) {
            $loggedInUser = Auth::guard('api');

            if ($data['class_id'] !== null) {
                $class = SchoolClass::where('id', $data['class_id'])
                    ->where(function($query) use ($data, $loggedInUser) {
                        if ($query->where('id', $data['class_id'])->first()->institution_id !== null) {
                            $query->where('user_id', $loggedInUser->id())
                                  ->orWhere('institution_id', $loggedInUser->user()->institution_id);
                        } else {
                            $query->where('user_id', $loggedInUser->id());
                        }
                    });

                if ($class->count() === 0) {
                    $validation->errors()->add('checkbox', 'You do not have permission to modify that class. Try refreshing if the issue persists.');
                }
            }
        });

        if ($validation->fails()) {
            $errorMessage = '';
            
            foreach ($validation->errors()->all() as $message) {
                $errorMessage .= $message . '<br />';
            }

            return response()->json([
                'error' => 1,
                'message' => $errorMessage
            ]);
        }

        return $next($request);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        $canvasHistoryCount = $this->canvasHistoryController->getCanvasHistoryCount();

        return Validator::make($data, [
            'canvas_item'              => 'nullable|array',
            'canvas_history'           => 'nullable|array|max:' . $canvasHistoryCount,
            'canvas_action_undo_count' => 'nullable|integer|max:' . $canvasHistoryCount
        ]);
    }
}

