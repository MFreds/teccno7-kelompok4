<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Service;

class ServiceController extends Controller
{

    public function createForm() {
        return view('product.create');
    }

    public function create(Request $request) {

        $user_id = Auth::user()->id;
        $uuid_str = (string) Str::uuid();

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'max_revision' => 'required',
        ]);

        // photo process
        $photo = $request->file('photo');
        $content = file_get_contents($photo->getRealPath());
        $photo_ext = $photo->getClientOriginalExtension();
        $file_name = $user_id . $uuid_str . '.' . $photo_ext;

        Storage::put('public/product_photos/' . $file_name, $content);

        try {
            Service::create([
                'name' => $request->name,
                'uuid' => $uuid_str,
                'photo' => asset('storage/product_photos/' . $file_name),
                'description' => $request->description,
                'price' =>  $request->price,
                'max_revision' =>  $request->max_revision,
                'status' => 'open',
            ]);
            
            return redirect()->back()->with('success', 'Post created successfully.');


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

    
}
