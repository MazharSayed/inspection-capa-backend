<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Division;
use App\Models\Project;
use App\Models\SubActivity;
use App\Models\SubDivision;

class FilterController extends Controller
{
    public function index()
    {
        return response()->json([
            'projects' => Project::orderBy('name')->get(['id', 'name']),
            'divisions' => Division::orderBy('name')->get(['id', 'name']),
            'sub_divisions' => SubDivision::orderBy('name')->get(['id', 'division_id', 'name']),
            'activities' => Activity::orderBy('name')->get(['id', 'sub_division_id', 'name']),
            'sub_activities' => SubActivity::select('name')->distinct()->orderBy('name')->get(),
            'statuses' => ['open', 'closed', 'rejected'],
        ]);
    }
}
