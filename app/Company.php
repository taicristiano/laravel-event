<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'address', 'website', 'email'];

    public static function getCompanies($data)
    {
        $conditions = self::orderBy($data['field'], $data['order']);
        if ($data['search']) {
            $conditions = $conditions->where('name', 'like', '%' . $data['search'] . '%')
                                    ->orWhere('address', 'like', '%' . $data['search'] . '%')
                                    ->orWhere('website', 'like', '%' . $data['search'] . '%')
                                    ->orWhere('email', 'like', '%' . $data['search'] . '%');
        }
        return $conditions->paginate($data['limit'], ['*'], 'page', $data['page']);
    }
}
