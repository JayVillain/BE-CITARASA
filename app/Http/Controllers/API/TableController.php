<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        return response()->json(Table::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:tables',
            'capacity' => 'required|integer|min:1'
        ]);

        $table = Table::create($request->all());

        return response()->json([
            'message' => 'Meja berhasil ditambahkan',
            'data' => $table
        ], 201);
    }

    public function show($id)
    {
        $table = Table::findOrFail($id);
        return response()->json($table, 200);
    }

    public function update(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $request->validate([
            'status' => 'in:available,occupied,reserved,cleaning',
            'capacity' => 'integer|min:1'
        ]);

        $table->update($request->all());

        return response()->json([
            'message' => 'Meja berhasil diperbarui',
            'data' => $table
        ], 200);
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return response()->json(['message' => 'Meja berhasil dihapus'], 200);
    }
}
