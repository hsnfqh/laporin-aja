<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed role & permission tables from spatie/permission package.
     */
    public function run(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        $rolesTable = $tableNames['roles'] ?? 'roles';
        $permissionsTable = $tableNames['permissions'] ?? 'permissions';
        $roleHasPermissionsTable = $tableNames['role_has_permissions'] ?? 'role_has_permissions';
        $modelHasRolesTable = $tableNames['model_has_roles'] ?? 'model_has_roles';

        if (
            ! Schema::hasTable($rolesTable)
            || ! Schema::hasTable($permissionsTable)
            || ! Schema::hasTable($roleHasPermissionsTable)
            || ! Schema::hasTable($modelHasRolesTable)
        ) {
            return;
        }

        $teamKey = $columnNames['team_foreign_key'] ?? 'team_id';
        $hasTeams = Schema::hasColumn($rolesTable, $teamKey);
        $rolePivot = $columnNames['role_pivot_key'] ?? 'role_id';
        $permissionPivot = $columnNames['permission_pivot_key'] ?? 'permission_id';
        $modelMorphKey = $columnNames['model_morph_key'] ?? 'model_id';
        $guardName = 'web';
        $now = now();

        $permissions = [
            'dashboard.view',
            'laporan.view',
            'laporan.update',
            'laporan.assign',
            'laporan.reply',
            'relawan.manage',
            'operator.manage',
            'daerah.manage',
        ];

        $permissionRows = array_map(static fn (string $permission) => [
            'name' => $permission,
            'guard_name' => $guardName,
            'created_at' => $now,
            'updated_at' => $now,
        ], $permissions);

        DB::table($permissionsTable)->upsert(
            $permissionRows,
            ['name', 'guard_name'],
            ['updated_at']
        );

        $roleNames = ['admin', 'operator', 'user'];
        $roleRows = [];

        foreach ($roleNames as $roleName) {
            $row = [
                'name' => $roleName,
                'guard_name' => $guardName,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($hasTeams) {
                $row[$teamKey] = null;
            }

            $roleRows[] = $row;
        }

        DB::table($rolesTable)->upsert(
            $roleRows,
            $hasTeams ? [$teamKey, 'name', 'guard_name'] : ['name', 'guard_name'],
            ['updated_at']
        );

        $permissionsByName = DB::table($permissionsTable)
            ->where('guard_name', $guardName)
            ->pluck('id', 'name')
            ->all();

        $rolesByName = DB::table($rolesTable)
            ->where('guard_name', $guardName)
            ->pluck('id', 'name')
            ->all();

        $permissionsByRole = [
            'admin' => $permissions,
            'operator' => [
                'dashboard.view',
                'laporan.view',
                'laporan.update',
                'laporan.reply',
            ],
            'user' => [],
        ];

        $rolePermissionRows = [];
        foreach ($permissionsByRole as $roleName => $permissionNames) {
            if (! isset($rolesByName[$roleName])) {
                continue;
            }

            foreach ($permissionNames as $permissionName) {
                if (! isset($permissionsByName[$permissionName])) {
                    continue;
                }

                $rolePermissionRows[] = [
                    $permissionPivot => $permissionsByName[$permissionName],
                    $rolePivot => $rolesByName[$roleName],
                ];
            }
        }

        if ($rolePermissionRows !== []) {
            DB::table($roleHasPermissionsTable)->insertOrIgnore($rolePermissionRows);
        }

        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'role')) {
            return;
        }

        $hasTeamOnModelRole = Schema::hasColumn($modelHasRolesTable, $teamKey);
        $modelRoleRows = [];

        foreach (User::query()->select(['id', 'role'])->get() as $user) {
            if (! isset($rolesByName[$user->role])) {
                continue;
            }

            $row = [
                $rolePivot => $rolesByName[$user->role],
                'model_type' => User::class,
                $modelMorphKey => $user->id,
            ];

            if ($hasTeamOnModelRole) {
                $row[$teamKey] = null;
            }

            $modelRoleRows[] = $row;
        }

        if ($modelRoleRows !== []) {
            DB::table($modelHasRolesTable)->insertOrIgnore($modelRoleRows);
        }
    }
}
