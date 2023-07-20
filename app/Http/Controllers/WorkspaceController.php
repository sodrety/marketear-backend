<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    public function getWorkspace () {
        $workspace = \App\Models\Workspace::where('user_id', Auth::user()->id)->get();
        return response()->json($workspace,200);
    }
}
