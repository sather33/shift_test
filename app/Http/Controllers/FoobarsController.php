<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Foobars;

class FoobarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Foobars $foobars)
    {
        $foobars->name();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Foobars  $foobars
     * @return \Illuminate\Http\Response
     */
    public function show(Foobars $foobars)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Foobars  $foobars
     * @return \Illuminate\Http\Response
     */
    public function edit(Foobars $foobars)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Foobars  $foobars
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Foobars $foobars)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Foobars  $foobars
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foobars $foobars)
    {
        //
    }
}
