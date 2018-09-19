<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\SoftwareResource;
use App\Helper\ResponseHelper;
use App\Models\Software;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SoftwareController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $softwares = Software::all();
        return ResponseHelper::success(SoftwareResource::collection($softwares));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $softwareId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($softwareId)
    {
        $software = Software::find($softwareId);
        if ($software === null) {
            throw new NotFoundHttpException('software id ' . $softwareId . ' not found');
        }

        return ResponseHelper::success(new SoftwareResource($software));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Software $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Software $software)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Software $software
     * @return \Illuminate\Http\Response
     */
    public function delete(Software $software)
    {
        //
    }

    public function minerDownload($softwareId)
    {
        $software = Software::find($softwareId);
        if ($software === null) {
            throw new NotFoundHttpException('software id ' . $softwareId . ' not found');
        }

        return response()->download(storage_path($software->path));
    }
}
