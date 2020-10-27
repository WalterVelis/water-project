<?php

namespace App\Http\Controllers;

use App\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{

    public function store(Request $request) // Mass storage
    {
        return Entity::create($request->all());
    }


    public function destroy(Entity $entity)
    {
        return $entity->delete();
    }

    /**
     * Returns table with specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function getEntities($projectId = 4, $type = 0)
    {
        $entities = Entity::where(['entity_type' => $type, 'project_id'=> $projectId])->get();
        return view('layouts.project-table', compact('entities'));
    }
}
