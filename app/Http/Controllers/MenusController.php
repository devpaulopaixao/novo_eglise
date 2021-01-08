<?php

namespace App\Http\Controllers;

use App\Igreja;
use App\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function renderMenus(Request $request)
    {
        $igreja = getIgreja($request);
        $menus = $igreja->menus()->where('menu_id', null)->orderBy('ordem','ASC')->get();
        return view('admin.menu-tree-eglise', compact('menus'))->render();
    }

    public function create(Request $request)
    {
        try {
            $igreja = getIgreja($request);

            $igreja->menus()->create($request->except(['id', '_token']));

            return response()->json([
                'message' => 'Menu cadastrado com sucesso!',
                'html' => $this->renderMenus($request),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $igreja = getIgreja($request);

            $igreja->menus()->where('id',$request->id)->update($request->except(['id', '_token']));

            return response()->json([
                'message' => 'Menu atualizado com sucesso!',
                'html' => $this->renderMenus($request),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Menu::where('id', $id)->delete();

            return response()->json([
                'message' => 'Menu excluído com sucesso!',
                'html' => $this->renderMenus($request),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ], 400);
        }
    }
}
