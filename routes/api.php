<?php

use App\Models\Experience;
use App\Models\GeneralInfo;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('homePage', function () {
    $generalInfo = GeneralInfo::first();

    return response()->json($generalInfo->name ?? '');
});

Route::get('aboutPage', function () {
    // Fetch skills
    $skills = Skill::orderBy('order', 'asc')->get();
    $formattedSkills = $skills->map(function ($skill) {
        return [
            'imageUrl' => Storage::disk('s3')->url($skill->image_url),
            'name' => $skill->name,
            'type' => $skill->type,
        ];
    });

    // Fetch experiences with descriptions
    $experiences = Experience::with(['descriptions' => function ($query) {
        $query->orderBy('order', 'asc');
    }])->orderBy('order', 'asc')->get();

    $formattedExperiences = $experiences->map(function ($experience) {
        return [
            'title' => $experience->title,
            'company_name' => $experience->company_name,
            'icon' => Storage::disk('s3')->url($experience->icon_url),
            'iconBg' => $experience->icon_bg,
            'date' => $experience->date,
            'points' => $experience->descriptions->pluck('description')->toArray(),
        ];
    });

    // Fetch general info
    $generalInfo = GeneralInfo::first();

    // Format the response
    $response = [
        'skills' => $formattedSkills,
        'experiences' => $formattedExperiences,
        'leadership_description' => $generalInfo->leadership_description ?? '',
        'about_description' => $generalInfo->about_description ?? '',
        'name' => $generalInfo->name ?? '',
    ];

    return response()->json($response);
});

Route::get('projects', function () {
    // Fetch projects
    $projects = Project::orderBy('order', 'asc')->get();
    $formattedProjects = $projects->map(function ($project) {
        return [
            'iconUrl' => Storage::disk('s3')->url($project->icon_url),
            'theme' => $project->theme,
            'name' => $project->name,
            'description' => $project->description,
            'link' => $project->link,
        ];
    });

    // Fetch general info for projects_description
    $generalInfo = GeneralInfo::first();

    // Format the response
    $response = [
        'projects' => $formattedProjects,
        'projects_description' => $generalInfo->projects_description ?? '',
    ];

    return response()->json($response);
});

Route::get('footer', function () {
    $socialLinks = SocialLink::orderBy('order', 'asc')->get()->map(function ($link) {
        return [
            'name' => $link->name,
            'link' => $link->link,
            'iconUrl' => Storage::disk('s3')->url($link->icon_url),
        ];
    });

    $generalInfo = GeneralInfo::select('name')->first();

    return response()->json([
        'socialLinks' => $socialLinks,
        'name' => $generalInfo->name,
    ]);
});
