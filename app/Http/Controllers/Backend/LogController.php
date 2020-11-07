<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Log;

class LogController extends Controller
{
    protected $model;

    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $logs = $this->model::with('user')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('backend.log.index', compact('logs'));
    }
}
