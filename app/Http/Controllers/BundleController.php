<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Bundle;
use App\Models\BundleItem;

class BundleController extends Controller
{
    public function createForm() {
        return view('bundle.create');
    }

    public function create(Request $request) {

        // daftar bundle dulu
        $user_id = Auth::user()->id;
        $uuid_str = (string) Str::uuid();

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        // photo process
        $photo = $request->file('photo');
        $content = file_get_contents($photo->getRealPath());
        $photo_ext = $photo->getClientOriginalExtension();
        $file_name = 'bundle-' .$user_id . $uuid_str . '.' . $photo_ext;

        Storage::put('public/bundle_photos/' . $file_name, $content);

        $newBundleId = '';

        try {
            $newBundle = Bundle::create([
                'name' => $request->name,
                'uuid' => $uuid_str,
                'photo' => asset('storage/bundle_photos/' . $file_name),
                'description' => $request->description,
                'price' =>  $request->price,
                'status' => 'open',
                'stock' => $request->stock
            ]);

            $newBundleId = $newBundle->id;

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

        $item_name = $request->name_item;
        $item_desc = $request->description_item;
        $item_photos = $request->file('photo_item');

        foreach($item_name as $index => $item) {

            // photo process
            $photo = $item_photos[$index];
            $content = file_get_contents($photo->getRealPath());
            $photo_ext = $photo->getClientOriginalExtension();
            $file_name = 'bundle-item-' .$user_id . $uuid_str . '.' . $photo_ext;

            Storage::put('public/bundle_item_photos/' . $file_name, $content);

            try {
                $newBundle = BundleItem::create([
                    'name' => $item_name[$index],
                    'photo' => asset('storage/bundle_item_photos/' . $file_name),
                    'description' => $item_desc[$index],
                    'bundle_id' => $newBundleId
                ]);


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
        }

        return redirect()->back()->with('success', 'Bundle created successfully.');


    }
}
