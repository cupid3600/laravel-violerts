<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# map endpoints
use Illuminate\Mail\Markdown;
Route::get('/maps/property/bis/complaints/{Id}', 'ComplaintController@getBISComplaints'); 
Route::get('/maps/property/bis/dob-violations/{Id}', 'DOBViolationController@getBISDOBViolations'); 
Route::get('/maps/property/bis/ecb-violations/{Id}', 'ECBViolationController@getBISECBViolations'); 
Route::get('/maps/property/bis/job-applications/{Id}', 'JobApplicationController@getJobApplications');
Route::get('/maps/property/open-data/acris-ppl/{Id}', 'ACRISController@getACRISPPL');
Route::get('/maps/property/open-data/acris-rpl/{Id}', 'ACRISController@getACRISRPL');
Route::get('/maps/property/open-data/complaints/{Id}', 'ComplaintController@getComplaints'); 
Route::get('/maps/property/open-data/dob-violations/{Id}', 'DOBViolationController@getDOBViolations'); 
Route::get('/maps/property/open-data/ecb-violations/{Id}', 'ECBViolationController@getECBViolations');
Route::get('/maps/property/open-data/job-applications/{Id}', 'JobApplicationController@getJobApplications'); 
Route::get('/maps/property/open-data/oath-cases/{Id}', 'OATHCaseController@getOATHCases');

Route::get('/admin/users', function () { 
    $request = request();
    $query = app(App\User::class)->where('id', '!=', '')->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('name', 'like', $value)
              ->orWhere('email', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});


Route::get('/portfolio/{id}', function($id) {
    $request = request();
    $query = app(App\Portfolio::class)
                    ->where('user_id', $id)
                    ->with(['property'])
                    ->get();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = collect($query)->all();
        }
    } else {
        $query = collect($query)->all();
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('address', 'like', $value)
                ->orWhere('bin', 'like', $value)
                ->orWhere('block', 'like', $value)
                ->orWhere('lot', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination =  app(App\Portfolio::class)
                    ->where('user_id', $id)
                    ->with(['property'])
                    ->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
        $pagination
    )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
    return $query;
});

Route::get('/property/map/{bin}', 'PropertyController@mapIndex');

Route::get('/property/open-data/complaints/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\Complaint::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('complaint_number', 'like', $value)
                ->orWhere('status', 'like', $value)
                ->orWhere('unit', 'like', $value)
                ->orWhere('date_entered', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/complaints/all/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISComplaint::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('complaint_number', 'like', $value)
                ->orWhere('status', 'like', $value)
                ->orWhere('description', 'like', $value)
                ->orWhere('date_entered', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/complaints/open/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISComplaint::class)->where('property_id', $Id)->where('active', true)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('complaint_number', 'like', $value)
                ->orWhere('status', 'like', $value)
                ->orWhere('description', 'like', $value)
                ->orWhere('date_entered', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/complaints/closed/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISComplaint::class)->where('property_id', $Id)->where('active', false)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('complaint_number', 'like', $value)
                ->orWhere('status', 'like', $value)
                ->orWhere('description', 'like', $value)
                ->orWhere('date_entered', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/dob-violations/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\DOBViolation::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('violation_number', 'like', $value)
                ->orWhere('issue_date', 'like', $value)
                ->orWhere('violation_category', 'like', $value)
                ->orWhere('disposition_comments', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/dob-violations/all/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISDOBViolation::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('number', 'like', $value)
                ->orWhere('type', 'like', $value)
                ->orWhere('issue_date', 'like', $value)
                ->orWhere('description', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/dob-violations/open/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISDOBViolation::class)->where('property_id', $Id)->where('active', true)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('number', 'like', $value)
                ->orWhere('type', 'like', $value)
                ->orWhere('issue_date', 'like', $value)
                ->orWhere('description', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/dob-violations/closed/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISDOBViolation::class)->where('property_id', $Id)->where('active', false)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('number', 'like', $value)
                ->orWhere('type', 'like', $value)
                ->orWhere('issue_date', 'like', $value)
                ->orWhere('description', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});


Route::get('/property/open-data/ecb-violations/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\ECBViolation::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('issue_date', 'like', $value)
                ->orWhere('hearing_date', 'like', $value)
                ->orWhere('violation_description', 'like', $value)
                ->orWhere('respondent_name', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/ecb-violations/all/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISECBViolation::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('viol_date', 'like', $value)
                ->orWhere('infraction_codes', 'like', $value)
                ->orWhere('ecb_penalty_due', 'like', $value)
                ->orWhere('ecb_number', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/ecb-violations/open/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISECBViolation::class)->where('property_id', $Id)->where('active', true)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('viol_date', 'like', $value)
                ->orWhere('infraction_codes', 'like', $value)
                ->orWhere('ecb_penalty_due', 'like', $value)
                ->orWhere('ecb_number', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/ecb-violations/closed/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISECBViolation::class)->where('property_id', $Id)->where('active', null)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('viol_date', 'like', $value)
                ->orWhere('infraction_codes', 'like', $value)
                ->orWhere('ecb_penalty_due', 'like', $value)
                ->orWhere('ecb_number', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/job-applications/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\JobApplication::class)->where('property_id', $Id)
                                            ->with(['job_application_ext'])
                                            ->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('job__', 'like', $value)
                ->orWhere('doc__', 'like', $value)
                ->orWhere('job_Status', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/job-applications/all/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISJobApplication::class)->where('property_id', $Id)->where('doc_number', '01')
                                            ->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('job_number', 'like', $value)
                ->orWhere('doc_number', 'like', $value)
                ->orWhere('applicant', 'like', $value)
                ->orWhere('in_audit', 'like', $value)
                ->orWhere('job_type', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/job-applications/closed/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISJobApplication::class)->where('property_id', $Id)->where('doc_number', '01')->where('job_status', 'X SIGNED OFF')
                                            ->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('job_number', 'like', $value)
                ->orWhere('doc_number', 'like', $value)
                ->orWhere('applicant', 'like', $value)
                ->orWhere('in_audit', 'like', $value)
                ->orWhere('job_type', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/job-applications/open/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISJobApplication::class)->where('property_id', $Id)->where('doc_number', '01')->where('job_status', '!=', 'X SIGNED OFF')->where('sec_24_comments', 'NOT LIKE', '%JOB WITHDRAWN%')
                                            ->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('job_number', 'like', $value)
                ->orWhere('doc_number', 'like', $value)
                ->orWhere('applicant', 'like', $value)
                ->orWhere('in_audit', 'like', $value)
                ->orWhere('job_type', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/oath-cases/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\OATHCase::class)->where('property_id', $Id)
                                     ->with(['oath_case_ext'])
                                     ->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('ticket_number', 'like', $value)
                ->orWhere('violation_date', 'like', $value)
                ->orWhere('issuing_agency', 'like', $value)
                ->orWhere('balance_due', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/acris-ppl/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\ACRISPPL::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('document_id', 'like', $value)
                ->orWhere('record_type', 'like', $value)
                ->orWhere('property_type', 'like', $value)
                ->orWhere('good_through_date', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/acris-rpl/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\ACRISRPL::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('document_id', 'like', $value)
                ->orWhere('record_type', 'like', $value)
                ->orWhere('property_type', 'like', $value)
                ->orWhere('good_through_date', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/open-data/311-complaints/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\TOOComplaint::class)->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('created_date', 'like', $value)
                ->orWhere('agency', 'like', $value)
                ->orWhere('agency_name', 'like', $value)
                ->orWhere('status', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/elevators/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISElevator::class)
                ->where('property_id', $Id)
                ->with(['inspections'])
                ->with(['violations'])
                ->get();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = collect($query)->all();
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('device_number', 'like', $value)
                ->orWhere('device_type', 'like', $value)
                ->orWhere('status_date', 'like', $value)
                ->orWhere('status', 'like', $value);
        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = app(App\BISElevator::class)
                    ->with(['inspections'])
                    ->with(['violations'])
                    ->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/elevators/inspections/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISElevatorInspection::class)
                ->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('device_number', 'like', $value)
                ->orWhere('inspection_date', 'like', $value)
                ->orWhere('inspection_type', 'like', $value)
                ->orWhere('inspection_disposition', 'like', $value)
                ->orWhere('inspected_by', 'like', $value);

        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/elevators/violations/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISElevatorViolation::class)
                ->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('device_number', 'like', $value)
                ->orWhere('violation_number', 'like', $value)
                ->orWhere('svr_code', 'like', $value)
                ->orWhere('disposition_code', 'like', $value)
                ->orWhere('disposition_date', 'like', $value)
                ->orWhere('disposition_badge', 'like', $value);

        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/permits/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISPermit::class)
                ->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('permit_number', 'like', $value)
                ->orWhere('job_number', 'like', $value)
                ->orWhere('fee', 'like', $value)
                ->orWhere('first_issue_date', 'like', $value)
                ->orWhere('last_issue_date', 'like', $value)
                ->orWhere('issued_date', 'like', $value);

        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/property/bis/illuminated-signs/{Id}', function ($Id) { 
    $request = request();
    $query = app(App\BISIlluminatedSign::class)
                ->where('property_id', $Id)->latest();
    // handle sort option
    if (request()->has('sort')) {
        // handle multisort
        $sorts = explode(',', request()->sort);
        foreach ($sorts as $sort) {
            list($sortCol, $sortDir) = explode('|', $sort);
            $query = $query->orderBy('id', 'asc');
        }
    } else {
        $query = $query->orderBy('id', 'asc');
    }
    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('job_number', 'like', $value)
                ->orWhere('seq_no', 'like', $value)
                ->orWhere('added_on', 'like', $value)
                ->orWhere('address', 'like', $value)
                ->orWhere('last_modified', 'like', $value)
                ->orWhere('last_billed_on', 'like', $value)
                ->orWhere('last_bill_amount', 'like', $value);

        });
    }
    $perPage = request()->has('per_page') ? (int) request()->per_page : null;
    $pagination = $query->paginate($perPage);
    $pagination->appends([
        'sort' => request()->sort,
        'filter' => request()->filter,
        'per_page' => request()->per_page
    ]);
    // The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
    // are to allow you to call this from any domain (see CORS for more info).
    // This is for local testing only. You should not do this in production server,
    // unless you know what it means.
    return response()->json(
            $pagination
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/permits/index/{Id}', 'PermitController@getPermits');

Route::get('/user/verification/{verification_code}', 'AuthController@verification');
Route::get('/{vue}', function () { 
	return view('welcome');
})->where('vue', '.*');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
