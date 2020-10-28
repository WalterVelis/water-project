<?php

namespace App\Http\Controllers;

use App\Project;
use App\Country;
use App\Format;
use App\Entity;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Format::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        // Select last id
        $lastInsertedId = Format::select('id')->orderBy('id', 'DESC')->pluck('id')->first();
        if($lastInsertedId == null){
            $lastInsertedId = 1;
        }
        $newId = $lastInsertedId + 1;
        $pageId = str_pad($newId, 4, '0', STR_PAD_LEFT);
        $page = "H2O-".$pageId."-".date("Y");

        // start a new empty project
        $format = new Format;
        $format->id = $newId;
        $format->page = $page;
        $format->date = "";
        $format->state = "";
        $format->municipality = "";
        $format->country_id = 0;
        $format->client = "";
        $format->main_contact = "";
        $format->position = "";
        $format->phone = "";
        $format->email = "";
        $format->structure = 0;
        $format->environment = 0;
        $format->has_educational_programs = "";
        $format->children = "";
        $format->classrooms = "";
        $format->colony = "";
        $format->zip_code = "";
        $format->street = "";
        $format->n_ext = "";
        $format->n_int = "";
        $format->users = "";
        $format->has_water_lack = "";
        $format->frequency = "";
        $format->obtaining_water = "";
        $format->water_consumption = "";
        $format->cost_average = "";
        $format->water_quality = "";
        $format->roof_type = "";
        $format->property_type = "";
        $format->current_year_resources = "";
        $format->resources_type = "";
        $format->planning_entity_id = "";
        $format->auth_entity_id = "";
        $format->implementation_date = "";
        $format->notes = "";
        $format->created_by = 1;
        $format->updated_by = 1;
        $format->status = 0;
        $format->save();
        return redirect()->to('projects/'.$newId.'/edit');
        $countries = Country::all();
        return view('projects.format', compact('countries', 'format'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Project::create($request->all());
        // return redirect()->route('projects.index')->with('success', 'Project Created');
    }

    /**
     * Display the specified resource (format).
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $countries = Country::all();
        $project->load('format');
        return view('projects.format', compact('project', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $format = Format::find($id);
        $countries = Country::all();
        return view('projects.format', compact('countries', 'format'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $structure = $request->structure;
        if ($structure === "0") {
            $structure = $request->structure_other;
        }

        $format = Format::find($id);
        $format->date = $request->date;
        $format->client = $request->client;
        $format->main_contact = $request->main_contact;
        $format->position = $request->position;
        $format->phone = $request->phone;
        $format->email = $request->email;
        $format->structure = $structure;
        $format->environment = $request->environment;
        $format->has_educational_programs = $request->has_educational_programs;
        $format->children = $request->children;
        $format->classrooms = $request->classrooms;
        $format->colony = $request->colony;
        $format->zip_code = $request->zip_code;
        $format->street = $request->street;
        $format->n_ext = $request->n_ext;
        $format->n_int = $request->n_int;
        $format->users = $request->users;
        $format->has_water_lack = $request->has_water_lack;
        $format->frequency = $request->frequency;
        $format->obtaining_water = $request->obtaining_water;
        $format->water_consumption = $request->water_consumption;
        $format->cost_average = $request->cost_average;
        $format->water_quality = $request->water_quality;
        $format->roof_type = $request->roof_type;
        $format->property_type = $request->property_type;
        $format->current_year_resources = $request->current_year_resources;
        $format->resources_type = $request->resources_type;
        $format->planning_entity_id = $request->planning_entity_id;
        $format->auth_entity_id = $request->auth_entity_id;
        $format->implementation_date = $request->implementation_date;
        $format->notes = $request->notes;

        $format->status = 1;

        $format->update();
        // dd(Project::find($project)->update($request->all()));
        // $project->update($request->all());
        // Project::find($project)->update($request->all());
        return redirect()->route('projects.index')->with('success', 'Project Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // * Validar que no tenga formato
        // Eliminar también el formato correspondiente
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project Deleted');
    }
}
