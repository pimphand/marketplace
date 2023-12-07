<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceVacanciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $data = Service::with('getCity.province')->orderBy('created_at', 'desc');

        if ($request->search != null) {
            $data = $data->whereLike(['title', 'company', 'type'], $request->search);
            $sort_search = $request->search;
        }
        if ($request->status != null) {
            $data = $data->where('status', 'like', '%' . $request->status . '%');
        }

        $data =  $data->paginate(10);

        return view('backend.service.index', compact('data', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
            'start_salary' => 'required|numeric',
            'end_salary' => 'required|numeric|gte:start_salary',
        ]);

        $file = $request->file('logo');
        $path = 'uploads/logo/';
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $fileName);

        Service::create([
            "title" => $request->title,
            "logo" => $path . $fileName,
            "company" => $request->company,
            "slug" => Str::slug($request->title),
            "type" => $request->type,
            "start_salary" => $request->start_salary,
            "end_salary" => $request->end_salary,
            "payment_type" => $request->payment_type,
            "province" => $request->province,
            "city" => $request->city,
            "end_date" => $request->end_date,
            "description" => $request->description,
            "qualification" => $request->qualification,
            "status" => 1,
        ]);

        flash(translate('Services has been created successfully'))->success();
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Service::destroy($id);

        flash(translate('Services has been deleted successfully'))->success();
        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Service::with('getCity.province')->find($id);
        return view('backend.service.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_type' => 'required',
            'start_salary' => 'required|numeric',
            'end_salary' => 'required|numeric|gte:start_salary',
        ]);

        $service = Service::find($id);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = 'uploads/logo/';
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $fileName);
        }

        $service->update([
            "title" => $request->title,
            "slug" => Str::slug($request->title),
            "company" => $request->company,
            "logo" => $request->hasFile('logo') ? $path . $fileName : $service->logo,
            "type" => $request->type,
            "start_salary" => $request->start_salary,
            "end_salary" => $request->end_salary,
            "payment_type" => $request->payment_type,
            "province" => $request->province,
            "city" => $request->city,
            "end_date" => $request->end_date,
            "description" => $request->description,
            "qualification" => $request->qualification,
            "status" => 1,
        ]);

        flash(translate('Services has been updated successfully'))->success();
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::destroy($id);

        flash(translate('Services has been deleted successfully'))->success();
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        Service::whereIn('id', $request->id)->delete();

        return '1';
    }

    public function status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        Service::find($request->id)->update([
            'status' => $request->status
        ]);


        return '1';
    }
}
