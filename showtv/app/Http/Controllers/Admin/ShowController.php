<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $shows = Show::withCount('episodes')->paginate(20);
        return view('admin.shows.index', compact('shows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'airing_time' => 'required|string',
        ]);

        Show::create($request->only(['title', 'description', 'airing_time']));

        return redirect()->route('admin.shows.index')->with('success', 'Show created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Show $show)
    {
        return redirect()->route('admin.shows.edit', $show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Show $show)
    {
        return view('admin.shows.edit', compact('show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Show $show)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'airing_time' => 'required|string',
        ]);

        $show->update($request->only(['title', 'description', 'airing_time']));

        return redirect()->route('admin.shows.index')->with('success', 'Show updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Show $show)
    {
        $show->delete();
        return redirect()->route('admin.shows.index')->with('success', 'Show deleted successfully');
    }
}
