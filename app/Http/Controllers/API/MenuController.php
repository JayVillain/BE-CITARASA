<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * GET /api/menus
     * Ambil semua menu (public)
     */
    public function index()
    {
        $menus = Menu::with('category')->get();
        return response()->json($menus, 200);
    }

    /**
     * POST /api/menus
     * Tambah menu baru (butuh auth)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'menu_category_id' => 'required|exists:menu_categories,id',
        ]);

        $menu = Menu::create($request->all());

        return response()->json([
            'message' => 'Menu berhasil ditambahkan',
            'data' => $menu
        ], 201);
    }

    /**
     * GET /api/menus/{id}
     * Ambil detail 1 menu (public)
     */
    public function show(string $id)
    {
        $menu = Menu::with('category')->findOrFail($id);
        return response()->json($menu, 200);
    }

    /**
     * PUT /api/menus/{id}
     * Update menu (butuh auth)
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'menu_category_id' => 'sometimes|required|exists:menu_categories,id',
        ]);

        $menu->update($request->all());

        return response()->json([
            'message' => 'Menu berhasil diperbarui',
            'data' => $menu
        ], 200);
    }

    /**
     * DELETE /api/menus/{id}
     * Hapus menu (butuh auth)
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus'
        ], 200);
    }
}
