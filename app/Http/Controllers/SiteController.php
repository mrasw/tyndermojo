<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{   
    public function index(){
        // $user = User::all();
        
        if (Auth::user()->role == 'admin') {
            $user = User::where('role', '=' ,'user')->get();
            // dd($user);
            return view('page.admin.index',[
                'users'  =>  $user,
            ]);
        }else {
            $user = User::where('role', '=' ,'user')->where('kelamin', '!=', Auth::user()->kelamin)->get();
            // dd($user);
            return view('page.index',[
                'users'  =>  $user,
            ]);
        }
        
    }

    public function show($id)
    {
        $user = auth()->user();
        $accessedUser = User::find($id);

        // Jika gender berbeda, log akses
        try {

            if ($user->role == 'admin') {

                return response()->json([
                    'id' => $accessedUser->id,
                    'nama' => $accessedUser->nama,
                    'tgl_lahir' => $accessedUser->tgl_lahir,
                    'pekerjaan' => $accessedUser->pekerjaan,
                    'foto' => $accessedUser->getFoto(),
                ]);

            } else {
                if ($user->kelamin != $accessedUser->kelamin) {
    
                    $checkAccessLog = AccessLog::where('accessor_id', $user->id)
                                ->where('accessed_id', $accessedUser->id)
                                ->first();
                    if ($checkAccessLog) {
                        return response('Access Denied. You have already accessed this user.', 403);
                    } else {
    
                        $accessLog = AccessLog::create([
                            'accessor_id' => $user->id,
                            'accessed_id' => $accessedUser->id,
                        ]);
            
                        if ($accessLog) {
                            return response()->json([
                                'id' => $accessedUser->id,
                                'nama' => $accessedUser->nama,
                                'tgl_lahir' => $accessedUser->tgl_lahir,
                                'pekerjaan' => $accessedUser->pekerjaan,
                                'foto' => $accessedUser->getFoto(),
                            ]);
                        } else {
                            return response()->json('Failed to log access', 500);
                        }
                    }
                }
                
            }


        } catch (\Throwable $th) {
            // throw $th;
            return response()->json($th->getMessage());
        }

    }

    public function update(Request $request){
        $validatedData = $request->validate([
            // 'nama' => 'required|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u',
            'nama' => 'required',
            // 'foto' => 'image',
            'tgl_lahir' => 'date|required',
            'pekerjaan' => 'required',
        ]);

        try {
            $user = User::findOrFail($request->id);
            if($request->file('foto')){
                $validatedData['foto'] = $request->file('foto')->store('user-foto');
                if($user->foto){
                    $oldPhotoPath = $user->foto;
                }
            } elseif($user->foto) {
                $validatedData['foto'] = $user->foto;
            } else {
                $validatedData['foto'] = '';
            }
            

            if($user){
                $user['nama'] = $validatedData['nama'];
                $user['foto'] = $validatedData['foto'];
                $user['tgl_lahir'] = $validatedData['tgl_lahir'];
                $user['pekerjaan'] = $validatedData['pekerjaan'];
                // $user->save();

                if($user->save()){
                    if($oldPhotoPath){
                        Storage::delete($oldPhotoPath);
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'User updated successfully!',
                        'user' => $user,
                        'validatedData' => $validatedData,
                    ]);

                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to update user.',
                        'user' => $user,
                        'validatedData' => $validatedData,
                    ], 500);
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user. ' . $th->getMessage(),
                'user' => $user,
                'validatedData' => $validatedData,
            ], 500);
        }
    }

    public function create(Request $request){
        $request->validate([
            'create-nama' => 'required|regex:/^[A-Za-z\s\']+$/',
            // ''
            'create-tgl_lahir' => 'required',
            'create-pekerjaan' => 'required',
            'create-no_hp' => 'required',
            'create-kelamin' => 'required',
            'foto' => 'nullable|image',
        ]);

        try {
            $exist = User::where('no_hp', $request['create-no_hp'])->exists();
            if($exist){
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor Hp sudah terdaftar',
                ], 500);
            }

            $request['password'] = str_replace('-', '', $request['create-tgl_lahir']);

            if($request->file('foto')){
                $image = $request->file('foto')->store('user-foto');
                $request['foto-path'] = $image;
            }

            $user = new User;
            $user->foto = $request['foto-path'];
            $user->nama = $request['create-nama'];
            $user->kelamin = $request['create-kelamin'];
            $user->tgl_lahir = Carbon::createFromFormat('d/m/Y', $request['create-tgl_lahir'])->format('Y-m-d');
            $user->pekerjaan = $request['create-pekerjaan'];
            $user->no_hp = $request['create-no_hp'];
            $user->password = bcrypt($request['password']);
            $user->role = 'user';

            if($user->save()){
                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully!',
                    'user' => $user,
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user. ' . $th->getMessage(),
                'validatedData' => $request->all(),
            ], 500);
        }
    }
}
