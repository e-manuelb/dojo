<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ListUsersController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json($this->sqlList());
    }

    private function eloquentList(): Collection
    {
        $users = User::with('address', 'address.city')->get();

        return $users->map(function ($item) {
            return [
                'user' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'address' => [
                        'name' => $item->address->name,
                        'number' => $item->address->number,
                        'city_name' => $item->address->city->name
                    ]
                ],

            ];
        });
    }

    private function queryBuilderList(): Collection
    {
        $columns = [
            'u.id as user_id',
            'u.name as user_name',
            'u.email as user_email',
            'a.name as address_name',
            'a.number as address_number',
            'c.name as city_name'
        ];

        $data = DB::table('users as u')
            ->join('addresses as a', 'a.user_id', '=', 'u.id')
            ->join('cities as c', 'c.id', '=', 'a.city_id')
            ->select($columns)
            ->get();

        return $data->map(function ($item) {
            return [
                'user' => [
                    'id' => $item->user_id,
                    'name' => $item->user_name,
                    'email' => $item->user_email,
                    'address' => [
                        'name' => $item->address_name,
                        'number' => $item->address_number,
                        'city_name' => $item->city_name
                    ]
                ],
            ];
        });
    }

    private function sqlList(): Collection
    {
        $query = "SELECT u.id as user_id,
                   u.name as user_name,
                   u.email as user_email,
                   a.name as address_name,
                   a.number address_number,
                   c.name as city_name
                    FROM users u
                    JOIN addresses a on u.id = a.user_id
                    JOIN cities c on a.city_id = c.id";

        $data = collect(DB::select($query));

        return $data->map(function ($item) {
            return [
                'user' => [
                    'id' => $item->user_id,
                    'name' => $item->user_name,
                    'email' => $item->user_email,
                    'address' => [
                        'name' => $item->address_name,
                        'number' => $item->address_number,
                        'city_name' => $item->city_name
                    ]
                ],
            ];
        });
    }
}
