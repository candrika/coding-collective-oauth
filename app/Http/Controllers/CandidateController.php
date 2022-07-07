<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public $user;
    public $roles;

    public function __construct()
    {
        $this->middleware(
            'auth:api',
        );

        $this->user = Auth::guard('api')->user();
        $this->roles = Auth::guard('api')->user()->roles;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidate = Candidate::all();
        return response()->json([
            'success' => true,
            'data' => $candidate
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resume =   $request->file('resume') != '' ? 'resume/' . 'pdf' . '/' . $request->file('resume')->getClientOriginalName() : null;


        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'birthday' => 'required|date',
                'education' => 'required',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'resume' => 'mimes:pdf',
                'email' => 'required|email',
                'top_skills' => 'json',
                'phohe' => 'numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->file('resume')) {
            $request->file('resume')->storeAs('resume', $resume);
        }

        if ($this->roles->roles_name === 'Senior HRD') {
            $candidate = Candidate::create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'education' => $request->education,
                'experience' => $request->experience,
                'last_position' => $request->last_position,
                'applied_position' => $request->applied_position,
                'top_skills' => $request->top_skills,
                'email' => $request->email,
                'phone' => $request->phone,
                'resume' => $resume,
                'user_id' => $this->user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Storing data successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry you unauthorized to save this data'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);

        if ($candidate) {
            return response()->json([
                'success' => true,
                'data' => $candidate
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => $candidate,
                'message' => 'Candiddate not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $candidate = Candidate::find($id);
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'birthday' => 'required|date',
                'education' => 'required',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'resume' => 'mimes:pdf',
                'email' => 'required|email',
                'top_skills' => 'json',
                'phohe' => 'numeric'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($candidate) {
            if ($this->roles->roles_name === 'Senior HRD') {
                Candidate::where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'birthday' => $request->birthday,
                        'education' => $request->education,
                        'experience' => $request->experience,
                        'last_position' => $request->last_position,
                        'applied_position' => $request->applied_position,
                        'top_skills' => $request->top_skills,
                        'email' => $request->email,
                        'phone' => $request->phone,
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'updating data successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry you unauthorized to update this data'
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Opps, sorry updating data failed'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate = Candidate::find($id);

        if ($candidate) {
            if ($this->roles->roles_name === 'Senior HRD') {
                Storage::delete($candidate->resume);

                $candidate->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'deleting data successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Opps, sorry updating data failed'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'data' => $candidate,
                'message' => 'Candiddate not found'
            ], 404);
        }
    }
}
