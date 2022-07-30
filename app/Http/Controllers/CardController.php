<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Column $column, Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'order' => ['required', 'int'],
        ]);
        return $column->cards()->create([
            'title' => $request->input('title'),
            'order' => $request->input('order'),
        ]);
    }

    public function moved(Column $column, Request $request) {
        $request->validate([
            'cards' => ['required', 'array'],
            'cards.*.id' => ['required', 'int'],
        ]);
        $cards = $request->input('cards');
        DB::transaction(function () use ($column, $cards) {
            foreach ($cards as $key => $card) {
                Card::where('id', '=', $card['id'])
                    ->update([
                        'order' => $key,
                        'column_id' => $column->id,
                    ]);
            }
        });
        return response()->noContent();
    }

    public function update(Request $request, Card $card)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        $card->update([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);
        return $card;
    }

    public function destroy(Card $card)
    {
        //
    }
}
