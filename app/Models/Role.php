<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Role extends Model
{
    protected $guarded = [];

    public static function createWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $ability) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability_id' => $ability,
                    'type' => 'allow',
                ]);
            };
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return $role;
    }

    public function updateWithAbilities(Request $request, $role)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $ability) {
                RoleAbility::updateOrCreate([
                    'role_id' => $this->id,
                    'ability_id' => $ability,
                ], [
                    'type' => 'allow',
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
