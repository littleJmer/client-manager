<?php

namespace App\Http\Controllers;

use App\Client;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{

    // .. can be better
    private function requestValidation($request)
    {
        $request->validate($rules = [
            'first_name' => [
                'required',
                Rule::unique('clients')->where(function ($query) use ($request) {
                    return $query->where('first_name', $request->first_name)
                        ->where('last_name', $request->last_name)
                        ->where('id', '!=', $request->id)
                        ->where('user_id', Auth::id())
                        ->where('deleted_at', null);
                }),
            ],
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|numeric',
            'email' => 'required|email',
            // 'work_phone'    => 'regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g',
            // 'cell_phone'    => 'regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g',
        ]);
    }

    // .... refactoring soon
    private function simpleValidation($data)
    {
        return Validator::make($data, [
            'first_name' => [
                'required',
                Rule::unique('clients')->where(function ($query) use ($data) {
                    return $query->where('first_name', $data['first_name'])
                        ->where('last_name', $data['last_name'])
                        ->where('user_id', Auth::id())
                        ->where('deleted_at', null);
                }),
            ],
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date_format:Y/m/d',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|numeric',
            'email' => 'required|email',
            // 'work_phone'    => 'regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g',
            // 'cell_phone'    => 'regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g',
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $clients = $user->clients()->orderBy('id', 'DESC')->paginate(10);
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $this->requestValidation($request);

        $client = new Client([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'email' => $request->email,
            'work_phone' => $request->work_phone,
            'cell_phone' => $request->cell_phone,
            'user_id' => Auth::id(),
        ]);

        $client->save();

        $request->session()->flash('sysmsg', 'Client created successfully!');
        return response()->json(['message' => 'Client created successfully'], 201);
    }

    public function update($id, Request $request)
    {
        $this->requestValidation($request);

        $client = Client::find($id);

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->gender = $request->gender;
        $client->date_of_birth = $request->date_of_birth;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->zip_code = $request->zip_code;
        $client->email = $request->email;
        $client->work_phone = $request->work_phone;
        $client->cell_phone = $request->cell_phone;

        $client->save();

        $request->session()->flash('sysmsg', 'Client updated successfully!');
        return response()->json(['message' => 'Client updated successfully'], 200);
    }

    public function destroy($id, Request $request)
    {
        Client::find($id)->delete();
        $request->session()->flash('sysmsg', 'Client deleted successfully!');
        return response()->json(['message' => 'Client deleted successfully'], 200);
    }

    public function import(Request $request)
    {
        $path = $request->file('fileCsv')->getRealPath();
        $user_id = Auth::id();
        $fp = fopen($path, 'r');

        $first = true;
        $bulk = [];
        $errors = [];
        $line = 1;

        // UTC from app.config
        $now = Carbon::now()->toDateTimeString();

        while ($row = fgetcsv($fp)) {
            if (!$first) {

                if (count($row) != 11) {
                    continue;
                }

                /*
                 *
                 * Array
                 * (
                 *  [0] => first_name
                 *  [1] => last_name
                 *  [2] => gender
                 *  [3] => date_of_birth
                 *  [4] => address
                 *  [5] => city
                 *  [6] => state
                 *  [7] => zip_code
                 *  [8] => email
                 *  [9] => work_phone
                 *  [10] => cell_phone
                 * )
                 *
                 * */

                $data = [
                    "first_name" => $row[0],
                    "last_name" => $row[1],
                    "gender" => $row[2],
                    "date_of_birth" => $row[3],
                    "address" => $row[4],
                    "city" => $row[5],
                    "state" => $row[6],
                    "zip_code" => $row[7],
                    "email" => $row[8],
                    "work_phone" => $row[9],
                    "cell_phone" => $row[10],
                    "user_id" => $user_id,
                    "updated_at" => $now,
                    "created_at" => $now,
                ];

                $validator = $this->simpleValidation($data);

                if ($validator->fails()) {
                    
                    $errors[] = [
                        "line" => $line,
                        "errors" => $validator->errors()
                    ];

                } else {
                    $bulk[] = $data;
                }

            }
            $first = false;
            $line++;
        }

        if(count($errors)) {
            return response()->json(['errors' => $errors], 500);
        }

        if (count($bulk)) {
            Client::insert($bulk);
            $request->session()->flash('sysmsg', count($bulk) . ' clients was imported successfully!');
            return response()->json(['message' => 'Clients imported successfully'], 201);
        } else {
            return response()->json(['message' => '0 Clients imported'], 200);
        }

    }

    public function export()
    {
        $filename = date("Y_m_d") . "_clients.csv";

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $user = Auth::user();
        $clients = $user->clients->toArray();

        array_unshift($clients, array_keys($clients[0]));

        $callback = function () use ($clients) {
            $FH = fopen('php://output', 'w');
            foreach ($clients as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

}
