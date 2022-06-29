<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function show()
    {
        $id = request('id');
        return Permission::findOrFail($id);
    }
}
