<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use File;
use Illuminate\Http\Request;
use Image;
use Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller {
	public function index($value = '') {
		return view('user/index');
	}

	public function store(Request $request) {
		$cek = Validator::make($request->all(), [
				'name'     => 'required|string|max:255',
				'email'    => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6|confirmed',
			]);

		if ($cek->passes()) {
			if (!empty($request->file('foto'))) {
				$image = time().$request->file('foto')->getClientOriginalName();
				$request->file('foto')->move('images/users/', $image);
				Image::make(public_path().'/images/users/'.$image)->crop(160, 160)->save();
			} else {
				$image = 'foto.jpg';
			}

			$save = User::create([
					'name'     => $request['name'],
					'email'    => $request['email'],
					'foto'     => $image,
					'password' => bcrypt($request['password']),
				]);
			return response()->json(['success' => '1']);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function edit($id) {
		$user = User::where('uuid', $id)->first();
		return response()->json($user);
	}

	public function update(Request $request) {
		$user = User::where('uuid', $request['uuid'])->first();
		$cek  = Validator::make($request->all(), [
				'name'     => 'required|string|max:255',
				'email'    => 'required|string|email|max:255|unique:users,email,'.$user->id,
				'password' => 'required|string|min:6|confirmed',
			]);

		if ($cek->passes()) {
			if (!empty($request->file('foto'))) {
				$image = time().$request->file('foto')->getClientOriginalName();
				$request->file('foto')->move('images/users/', $image);
				Image::make(public_path().'/images/users/'.$image)->crop(160, 160)->save();
				File::delete('images/users/'.$user->foto);
			} else {
				$image = $user->foto;
			}
			$user->update([
					'name'     => $request['name'],
					'email'    => $request['email'],
					'foto'     => $image,
					'password' => bcrypt($request['password']),
				]);
			return response()->json(['success' => '1']);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function data() {
		DB::statement(DB::raw('set @rownum=0'));
		$user = User::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'uuid',
				'name',
				'email',
				'foto',
				'created_at',
				'updated_at'])->orderBy('id', 'desc')->get();
		return DataTables::of($user)
			->addColumn('edit', function ($user) {
				return '<button type="button" onclick="editForm(\''.$user->uuid.'\')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></button>';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function show($id) {
		$user = User::where('uuid', $id)->first();
		return view('user.profil', compact('user'));
	}
}
