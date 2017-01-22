<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CanvasHistoryController;

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

        if ($validation->fails()) {
            $errorMessage = '';
            
            foreach ($validation->errors()->all() as $message) {
<<<<<<< HEAD
                $errorMessage .= $message . '<br />';
=======
                $errorMessage .= $message . ' ';
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
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
<<<<<<< HEAD
            'class_id' => 'nullable|integer|exists:classes,id,user_id,' . Auth::id(),
            'canvas_item' => 'nullable|array',
            'canvas_history' => 'nullable|array|max:' . $canvasHistoryCount,
            'canvas_action_undo_count' => 'nullable|integer|max:' . $canvasHistoryCount
        ]);
    }
}

=======
            'class_id' => 'required|integer|exists:classes,id,user_id,' . Auth::user()->id,
            'canvas_item' => 'array',
            'canvas_history' => 'array|max:' . $canvasHistoryCount,
            'canvas_action_undo_count' => 'integer|max:' . $canvasHistoryCount
        ]);
    }
}
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
