<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DataTables;

use Illuminate\Http\Request;

use App\Models\Item;

class ItemController extends Controller
{
    public function createForm() {
        return view('item.create');
    }

    public function create(Request $request) {
        // dd($request);

        $user_id = Auth::user()->id;
        $uuid_str = (string) Str::uuid();

        $this->validate($request, [
            'item_name' => 'required',
            'item_description' => 'required',
            'item_price' => 'required',
            'item_stock' => 'required'
        ]);

        // photo process
        $photo = $request->file('item_photo');
        $content = file_get_contents($photo->getRealPath());
        $photo_ext = $photo->getClientOriginalExtension();
        $file_name = 'item-' .$user_id . $uuid_str . '.' . $photo_ext;

        Storage::put('public/item_photos/' . $file_name, $content);

        try {
            $newItem = Item::create([
                'name' => $request->item_name,
                'uuid' => $uuid_str,
                'photo' => asset('storage/item_photos/' . $file_name),
                'description' => $request->item_description,
                'price' =>  $request->item_price,
                'status' => 'open',
                'stock' => $request->item_stock
            ]);


            return redirect('/admin/item/data')->with('success', $newItem->name . ' created successfully.');

        }catch(\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMsg = $e->errorInfo[2];
            if ($errorCode == 1062) {
                return redirect('/');
            }

            dd($errorMsg);
        } catch (\Exception $e) {

            dd($e->getMessage());
        }

        return redirect()->back()->with('error', 'Something bad happened :(');
    }

    public function getItems(Request $request) {

        if ($request->ajax()) {
            $data = Item::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getItemsv2(Request $request) {

        if ($request->ajax()) {
            $data = Item::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<button type="button" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Edit</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $item = new Item;
        $data = $item::find($id);

        $html = '<div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$data->name.'">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" id="editDescription">'.$data->description.'
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" name="price" id="editPrice" value="'.$data->price.'">
                </div>
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="text" class="form-control" name="stock" id="editStock" value="'.$data->stock.'">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" name="status" id="editStatus" value="'.$data->status.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $item = new Item;
        $item::find($id)->update($request->all());

        return response()->json(['success'=>'Item updated successfully']);
    }

    public function destroy($id)
    {
        $item = new Item;
        $item::find($id)->delete();

        return response()->json(['success'=>'Item deleted successfully']);
    }
}
