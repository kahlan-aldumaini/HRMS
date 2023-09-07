<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        return inertia()->render(component: 'Dashboard/Management/index', props: []);
    }
}
