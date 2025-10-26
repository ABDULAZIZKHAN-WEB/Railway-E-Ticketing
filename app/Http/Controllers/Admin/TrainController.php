<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    /**
     * Display a listing of the trains.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Train::query();
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('train_number', 'like', "%{$search}%")
                  ->orWhere('train_name', 'like', "%{$search}%")
                  ->orWhere('train_name_bn', 'like', "%{$search}%");
            });
        }
        
        // Handle type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('train_type', $request->type);
        }
        
        $trains = $query->get();
        
        return view('admin.trains', compact('trains'));
    }

    /**
     * Show the form for creating a new train.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trains.create');
    }

    /**
     * Store a newly created train in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'train_number' => 'required|unique:trains',
            'train_name' => 'required',
            'train_type' => 'required|in:express,mail,local,intercity',
            'total_coaches' => 'required|integer|min:1',
        ]);

        Train::create($request->all());

        return redirect()->route('admin.trains')->with('success', 'Train created successfully.');
    }

    /**
     * Show the form for editing the specified train.
     *
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function edit(Train $train)
    {
        return view('admin.trains.edit', compact('train'));
    }

    /**
     * Update the specified train in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Train $train)
    {
        $request->validate([
            'train_number' => 'required|unique:trains,train_number,'.$train->id,
            'train_name' => 'required',
            'train_type' => 'required|in:express,mail,local,intercity',
            'total_coaches' => 'required|integer|min:1',
        ]);

        $train->update($request->all());

        return redirect()->route('admin.trains')->with('success', 'Train updated successfully.');
    }

    /**
     * Remove the specified train from storage.
     *
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function destroy(Train $train)
    {
        $train->delete();

        return redirect()->route('admin.trains')->with('success', 'Train deleted successfully.');
    }
}