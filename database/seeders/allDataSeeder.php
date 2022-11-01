<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;
use App\Models\SubCategory;
use App\Models\Submenus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class allDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultTimestamp = null;
        // $defaultTimestamp = date("y\-m\-d h:i:s");
        $menus = [
            // `menu`, `icon`, `route`, `deleted_at`, `created_at`, `updated_at`
            [
                // 1
                'menu' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'home',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 2
                'menu' => 'Category',
                'icon' => 'fas fa-atlas',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 3
                'menu' => 'Subcategory',
                'icon' => 'fas fa-scroll',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 4
                'menu' => 'Post',
                'icon' => 'fas fa-blog',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 5
                'menu' => 'Role',
                'icon' => 'fas fa-id-card-alt',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 6
                'menu' => 'User',
                'icon' => 'fas fa-users',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 7
                'menu' => 'Message',
                'icon' => 'far fa-envelope',
                'route' => 'message.index',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 8
                'menu' => 'Menu',
                'icon' => 'fas fa-bars',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 9
                'menu' => 'Submenu',
                'icon' => 'fas fa-list-ul',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                // 10
                'menu' => 'Permission',
                'icon' => 'fas fa-key',
                'route' => 'none',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ],
        ];

        foreach ($menus as $menu) {
            $data['menu'] = $menu['menu'];
            $data['icon'] = $menu['icon'];
            $data['route'] = $menu['route'];
            $data['route'] = $menu['route'];
            $data['route'] = $menu['route'];
            $data['deleted_at'] = $menu['deleted_at'];
            $data['created_at'] = $menu['created_at'];
            $data['updated_at'] = $menu['updated_at'];
            Menu::create($data);
        }

        /**
         * Submenu data
         * `menu_id`, `title`, `route`, `icon`, `active`, `deleted_at`, `created_at`, `updated_at`
         */
        $submenus = [
            [
                'menu_id' => 2,
                'title' => 'View Category',
                'route' => 'categories.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 2,
                'title' => 'Create Category',
                'route' => 'categories.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 2,
                'title' => 'Category Trash',
                'route' => 'categories.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 3,
                'title' => 'View Subcategory',
                'route' => 'subcategories.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 3,
                'title' => 'Create Subcategory',
                'route' => 'subcategories.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 3,
                'title' => 'Subcategory Trash',
                'route' => 'subcategories.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 4,
                'title' => 'View Posts',
                'route' => 'posts.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 4,
                'title' => 'Create Post',
                'route' => 'posts.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 4,
                'title' => 'Post Trash',
                'route' => 'posts.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 5,
                'title' => 'View Roles',
                'route' => 'role.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 5,
                'title' => 'Create Role',
                'route' => 'role.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 5,
                'title' => 'Role Trash',
                'route' => 'role.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 6,
                'title' => 'View User',
                'route' => 'users.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 6,
                'title' => 'Add User',
                'route' => 'users.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 6,
                'title' => 'User Trash',
                'route' => 'users.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 8,
                'title' => 'View Menu',
                'route' => 'menu.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 8,
                'title' => 'Create Menu',
                'route' => 'menu.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 8,
                'title' => 'Menu Trash',
                'route' => 'menu.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 9,
                'title' => 'View Submenu',
                'route' => 'submenu.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 9,
                'title' => 'Create Submenu',
                'route' => 'submenu.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 9,
                'title' => 'Submenu Trash',
                'route' => 'submenu.trash',
                'icon' => 'fas fa-trash',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 10,
                'title' => 'View Permission',
                'route' => 'permission.index',
                'icon' => 'far fa-eye',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ], [
                'menu_id' => 10,
                'title' => 'Create Permission',
                'route' => 'permission.create',
                'icon' => 'fas fa-plus-square',
                'active' => 'active',
                'deleted_at' => null,
                'created_at' => $defaultTimestamp,
                'updated_at' => $defaultTimestamp,
            ],
        ];

        foreach ($submenus as $submenu) {
            // $data['menu_id'] = $submenu['menu_id'];
            // $data['title'] = $submenu['title'];
            // $data['route'] = $submenu['route'];
            // $data['icon'] = $submenu['icon'];
            // $data['active'] = $submenu['active'];
            // $data['deleted_at'] = $submenu['deleted_at'];
            // $data['created_at'] = $submenu['created_at'];
            // $data['updated_at'] = $submenu['updated_at'];
            // Submenus::create($data);
            DB::table('submenuses')->insert(
                [
                    'menu_id' => $submenu['menu_id'],
                    'title' => $submenu['title'],
                    'route' => $submenu['route'],
                    'icon' => $submenu['icon'],
                    'active' => $submenu['active'],
                ]
            );
        }

        /**
         * Category
         * `categories` (`id`, `name`, `slug`, `description`, `image`, `deleted_at`, `created_at`, `updated_at`)
         */
        $categories = [
            [
                'name' => 'Computer',
                'slug' => 'computer',
                'description' => 'all about computer',
                'image' => 'computer.png',
            ], [
                'name' => 'Gadget and Tablet',
                'slug' => 'gadget-and-tablet',
                'description' => 'all about gadget and tablet',
                'image' => 'mobile.png',
            ], [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'all about design',
                'image' => 'design.png',
            ], [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'all about technology',
                'image' => 'techno.png',
            ], [
                'name' => 'Programming',
                'slug' => 'programming',
                'description' => 'all about programing',
                'image' => 'programming.png',
            ], [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'description' => 'All about laptop',
                'image' => 'laptop.png',
            ],
        ];

        foreach ($categories as $category) {
            // $data['name'] = $category['name'];
            // $data['slug'] = $category['slug'];
            // $data['description'] = $category['description'];
            // $data['image'] = $category['image'];
            // Category::create($data);

            DB::table('categories')->insert(
                [
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                ]
            );
        }

        /**
         * Subcategory
         * cat_id = {
         *  [1, Computer], 
         *  [2, Gadget and Tablet], 
         *  [3, Design], [4, Technology], 
         *  [5, Programming], 
         *  [6, Laptop]
         * }
         * `sub_categories` (`id`, `category_id`, `subname`, `slug`, `deleted_at`, `created_at`, `updated_at`)
         */

        $subcategories = [
            [
                'category_id' => 1,
                'subname' => 'Processor',
                'slug' => 'processor',
            ], [
                'category_id' => 1,
                'subname' => 'GPU',
                'slug' => 'gpu',
            ], [
                'category_id' => 1,
                'subname' => 'Motherboard',
                'slug' => 'motherboard',
            ], [
                'category_id' => 1,
                'subname' => 'HW new',
                'slug' => 'hw-news',
            ], [
                'category_id' => 2,
                'subname' => 'Gadget and tablet news',
                'slug' => 'gadget-and-tablet-news',
            ], [
                'category_id' => 2,
                'subname' => 'Iphone',
                'slug' => 'iphone',
            ], [
                'category_id' => 2,
                'subname' => 'Xiaomi',
                'slug' => 'xiaomi',
            ], [
                'category_id' => 2,
                'subname' => 'Asus',
                'slug' => 'asus',
            ], [
                'category_id' => 3,
                'subname' => '3Ds Max tutorials',
                'slug' => '3ds-max-tutorials',
            ], [
                'category_id' => 3,
                'subname' => 'Maya tutorials',
                'slug' => 'maya-tutorials',
            ], [
                'category_id' => 3,
                'subname' => 'Design news',
                'slug' => 'design-news',
            ], [
                'category_id' => 4,
                'subname' => 'Artificial intelligence',
                'slug' => 'artificial-intelligence',
            ], [
                'category_id' => 4,
                'subname' => 'Internet of things',
                'slug' => 'internet-of-things',
            ], [
                'category_id' => 4,
                'subname' => 'Machine learning',
                'slug' => 'machine-learning',
            ], [
                'category_id' => 5,
                'subname' => 'What new in programming',
                'slug' => 'what-new-in-programming',
            ], [
                'category_id' => 5,
                'subname' => 'HTML tutorials',
                'slug' => 'html-tutorials',
            ], [
                'category_id' => 5,
                'subname' => 'CSS Tutorials',
                'slug' => 'css-tutorials',
            ], [
                'category_id' => 5,
                'subname' => 'Javascript Tutorials',
                'slug' => 'javascript-tutorials',
            ], [
                'category_id' => 5,
                'subname' => 'PHP Tutorials',
                'slug' => 'php-tutorials',
            ], [
                'category_id' => 6,
                'subname' => 'Asus laptop',
                'slug' => 'asus-laptop',
            ], [
                'category_id' => 6,
                'subname' => 'Acer laptop',
                'slug' => 'acer-laptop',
            ], [
                'category_id' => 6,
                'subname' => 'Lenovo laptop',
                'slug' => 'lenovo-laptop',
            ],
        ];

        foreach ($subcategories as $subcategory) {
            // $data['category_id'] = $subcategory['category_id'];
            // $data['subname'] = $subcategory['subname'];
            // $data['slug'] = $subcategory['slug'];
            // SubCategory::create($data);

            DB::table('sub_categories')->insert(
                [
                    'category_id' => $subcategory['category_id'],
                    'subname' => $subcategory['subname'],
                    'slug' => $subcategory['slug'],
                ]
            );
        }

        /**
         * Roles
         * `roles` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`)
         */
        $roles = [
            [
                'name' => 'Developer',
                'description' => 'This role is given to develop and maintain web app',
            ], [
                'name' => 'Admin',
                'description' => 'This role is given to access all menus and settings',
            ], [
                'name' => 'Moderator',
                'description' => 'This role is given to access restrict category such create category, subcategory, add post, etc',
            ], [
                'name' => 'Staff',
                'description' => 'This role is given to access post settings and mailing only',
            ],
        ];

        foreach ($roles as $role) {
            // $data['name'] = $role['name'];
            // $data['description'] = $role['description'];
            // Role::create($data);

            DB::table('roles')->insert(
                [
                    'name' => $role['name'],
                    'description' => $role['description'],
                ]
            );
        }

        /**
         * Dummy Users
         * `users` (`id`, `name`, `username`, `email`, `address`, `phone`, `image`, `role_id`, `is_active`, `email_verified_at`, `password`, `deleted_at`, `remember_token`, `created_at`, `updated_at`)
         */
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'jul_rajab@yahoo.co.id',
                'address' => 'test',
                'phone' => '1234555',
                'image' => 'users.png',
                'role_id' => 1,
                'is_active' => 1,
                'password' => '$2y$10$7SGeczFIRnV/r3.5hzKMv.K84on2mE6EB/.YHYVO2xl5HYIzjdQde',
            ], [
                'name' => 'john doe',
                'username' => 'john-doe',
                'email' => 'johndoe@yahoo.com',
                'address' => 'first road',
                'phone' => '123123',
                'image' => 'users.png',
                'role_id' => 2,
                'is_active' => 2,
                'password' => '$2y$10$RNNtisVqXtD3.1tYFFBWieBMUoULnkTWsNOWAtbqMLj294J4QYivq',
            ],
        ];

        foreach ($users as $user) {
            // $data['name'] = $user['name'];
            // $data['username'] = $user['username'];
            // $data['email'] = $user['email'];
            // $data['address'] = $user['address'];
            // $data['phone'] = $user['phone'];
            // $data['image'] = $user['image'];
            // $data['role_id'] = $user['role_id'];
            // $data['is_active'] = $user['is_active'];
            // $data['password'] = $user['password'];
            // User::create($data);

            DB::table('users')->insert([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'address' => $user['address'],
                'phone' => $user['phone'],
                'image' => $user['image'],
                'role_id' => $user['role_id'],
                'is_active' => $user['is_active'],
                'password' => $user['password'],
            ]);
        }
    }
}
