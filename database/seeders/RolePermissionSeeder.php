<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role create
        $role = Role::create(['name' => 'Super Admin']);

        $permissions = [

            //Super Admin permission
            [
                'group_name' => 'Admin',
                'permissions'=>
                [
                   'dashboard.view',
                    'user.list',
                    'create.user',
                    'edit.user',
                    'delete.user',
                    'role.list',
                    'create.role',
                    'edit.role',
                    'delete.role',
                    'settings'

                ]
            ],

            // Offer permission
            [
                'group_name' => 'JobOffers',
                'permissions'=>
                    [
                        'JobOffer.view',
                        'JobOffer.Create',
                        'JobOffer.Edit',
                        'JobOffer.Delete',

                    ]
            ],
            // Affiliate permission
            [
                'group_name' => 'Affiliate',
                'permissions'=>
                    [
                        'affiliate.view',
                        'affiliate.Create',
                        'affiliate.Edit',
                        'affiliate.Delete',

                    ]
            ],

            // Tutor permission

            [
                'group_name' => 'Tutor',
                'permissions'=>
                    [
                        'tutor.view',
                        'tutor.Create',
                        'tutor.Edit',
                        'tutor.Delete',

                    ]
            ],
            // Parents permission

            [
                'group_name' => 'Parents',
                'permissions'=>
                    [
                        'parent.view',
                        'parent.Create',
                        'parent.Edit',
                        'parent.Delete',

                    ]
            ],
            // Feature permission
            [
                'group_name' => 'Feature',
                'permissions'=>
                    [
                        'tutor.premium',
                        'tutor.featured',

                    ]
            ],

            // Blog permission

            [
                'group_name' => 'Blog',
                'permissions'=>
                    [
                        'Blog.view',
                        'Blog.Create',
                        'Blog.Edit',
                        'Blog.Delete',

                    ]
            ],

            // SMS permission

            [
                'group_name' => 'SMS',
                'permissions'=>
                    [
                        'SMS.module',

                    ]
            ],

            // Lead permission

            [
                'group_name' => 'Lead Module',
                'permissions'=>
                    [
                        'lead.module',

                    ]
            ],

            // web mail permission

            [
                'group_name' => 'webmail',
                'permissions'=>
                    [
                        'mail.module',

                    ]
            ],


        ];


        for ($i = 0; $i<count($permissions); $i++)
        {
           $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j<count($permissions[$i]['permissions']); $j++)
            {

                Permission::create(['name' => $permissions[$i]['permissions'][$j] , 'group_name'=> $permissionGroup]);
                $role->syncPermissions(Permission::all());
                $user = User::first();
                $user->assignRole($role);
            }
        }

//        foreach($permissions as $item)
//        {
//            Permission::create($item);
//        }
//        $role->syncPermissions(Permission::all());
//        $user = User::first();
//        $user->assignRole($role);
    }
}
