<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;


class GameController extends Controller
{
    public function index(){
        return response()->json(Game::all());
    }

    public function store(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $game = Game::create([
                'name' => $request->name,
            ]);

            if($request->has('description')){
                $game->description = $request->description;
            }
            $game->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Game created successfully',
                'data' => $game
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error while creating Game',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id){
        try{
            $game = Game::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Game fetched successfully',
                'data' => $game
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Game Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function update($id, Request $request){
        try{
            $game = Game::findOrFail($id);
            $game->name = $request->name;
            $game->description = $request->description;
            $game->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Game updated successfully',
                'data' => $game
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Game Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try{
            $game = Game::findOrFail($id);
            $game->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Game deleted successfully',
                'data' => $game
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Game Not found',
                'errors' => $e->errors()
            ], 404);
        }
    }
}
