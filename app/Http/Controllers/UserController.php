<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        //$this->middleware('permission:list-users', ['only' => ['index']]);
        //$this->middleware('permission:create-user,', ['only' => ['store']]);
        //$this->middleware('permission:show-user,', ['only' => ['show']]);
        //$this->middleware('permission:edit-user,', ['only' => ['update']]);
        //$this->middleware('permission:delete-user,', ['only' => ['destroy']]);
    }

    protected $validationRules = [
        'username' => 'nullable|alpha_num|unique:users,username|max:255',
        'first_name' => 'nullable|regex:/[a-z\- ]+/i|max:255',
        'last_name' => 'nullable|regex:/[a-z\- ]+/i|max:255',
        'email' => 'email|unique:users,email|max:255',
        'phone' => 'nullable|regex:/^[0-9\-\+\(\), ]+/|max:255',
        'password' => 'min:6',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $users = User::latest()->paginate();

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \App\Http\Resources\UserResource
     */
    public function show($id)
    {
        $user = User::with(['profile'])->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\UserResource|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'username' => request('username'),
            'phone' => request('username'),
            'email' => request('email'),
            'status' => 'pending_activation',
            'register_ip' => $request->ip(),
        ]);

        if (request('phone')) {
            $phone = trim(request('phone'));
            $phone = str_replace([' ', '(', ')'], '-', $phone); // remove space and brackets
            $phone = preg_replace('/-+/', '-', $phone); // remove repeating dashes
            $phone = trim($phone, '-');
            $user->phone = $phone;
        }

        $user->password = bcrypt(request('password'));
        $user->activation_token = Uuid::uuid4();

        $groups = Group::findMany($request->input('groups'));
        $user->groups()->attach($groups);

        $user->save();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \App\Http\Resources\UserResource|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if (request('phone')) {
            $phone = trim(request('phone'));
            $phone = str_replace([' ', '(', ')'], '-', $phone); // remove space and brackets
            $phone = preg_replace('/-+/', '-', $phone); // remove repeating dashes
            $phone = trim($phone, '-');
            $user->update(['phone' => $phone]);
        }

        $user->update($request->except('phone'));

        return response()->json(['message' => 'User updated!',
            'data' => new UserResource($user->load(['profile'])), ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return string
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json('User Deleted.');
    }

    public function updateProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
        }

        $org = JWTAuth::parseToken()->authenticate();
        $profile = $org->Profile;

        $profile->first_name = request('first_name');
        $profile->last_name = request('last_name');
        $profile->date_of_birth = request('date_of_birth');
        $profile->gender = request('gender');
        $profile->twitter_profile = request('twitter_profile');
        $profile->facebook_profile = request('facebook_profile');
        $profile->google_plus_profile = request('google_plus_profile');
        $profile->save();

        return response()->json(['message' => 'Your profile has been updated!', 'org' => $org]);
    }

    public function updateAvatar(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'avatar' => 'required|image',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->messages()->first()], 422);
        }

        $org = JWTAuth::parseToken()->authenticate();
        $profile = $org->Profile;

        if ($profile->avatar && \File::exists($this->avatar_path.$profile->avatar)) {
            \File::delete($this->avatar_path.$profile->avatar);
        }

        $extension = $request->file('avatar')->getClientOriginalExtension();
        $filename = uniqid();
        $file = $request->file('avatar')->move($this->avatar_path, $filename.'.'.$extension);
        $img = \Image::make($this->avatar_path.$filename.'.'.$extension);
        $img->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($this->avatar_path.$filename.'.'.$extension);
        $profile->avatar = $filename.'.'.$extension;
        $profile->save();

        return response()->json(['message' => 'Avatar updated!', 'profile' => $profile]);
    }

    public function removeAvatar(Request $request)
    {
        $org = JWTAuth::parseToken()->authenticate();

        $profile = $org->Profile;
        if (! $profile->avatar) {
            return response()->json(['message' => 'No avatar uploaded!'], 422);
        }

        if (\File::exists($this->avatar_path.$profile->avatar)) {
            \File::delete($this->avatar_path.$profile->avatar);
        }

        $profile->avatar = null;
        $profile->save();

        return response()->json(['message' => 'Avatar removed!']);
    }
}
