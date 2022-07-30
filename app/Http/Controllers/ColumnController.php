<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function index()
    {
        return Column::with(['cards' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'order' => ['required', 'int', 'min:0']
        ]);
        $column = Column::create([
            'title' => $request->input('title'),
            'order' => $request->input('order'),
        ]);
        return $column->load('cards');
    }

    public function update(Request $request, Column $column)
    {
        //
    }

    public function destroy(Column $column)
    {
        return $column->delete();
    }
}
