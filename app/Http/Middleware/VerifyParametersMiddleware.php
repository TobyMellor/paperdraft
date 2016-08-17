<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CanvasHistoryController;

use Closure;
use Validator;

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
                $errorMessage .= $message . ' ';
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
            'class_id' => 'required|integer|ownsclass',
            'canvas_item' => 'array',
            'canvas_history' => 'array|max:' . $canvasHistoryCount,
            'canvas_action_undo_count' => 'integer|max:' . $canvasHistoryCount
        ]);
    }
}
