<?php

namespace App\Models;

use App\Models\RoleAbility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Role extends Model
{
    protected $guarded = [];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class);
    }

    public static function createWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $ability => $ability_type) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability' => $ability,
                    'type' => $ability_type,
                ]);
            };
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return $role;
    }

    public function updateWithAbilities(Request $request, $Role)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $ability => $ability_type) {
                RoleAbility::updateOrCreate([
                    'role_id' => $this->id,
                    'ability' => $ability,
                ], [
                    'type' => $ability_type,
                ]);
            };
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return $this;
    }
}
