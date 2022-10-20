<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Routing\Route;

trait ThePermissionTrait
{
    /**
     * Permission Trait
     * @param Request $request
     * @return $this|false|string
     */

    public function hasPermission()
    {
        $menu_ids = explode(',', auth()->user()->getRole->permission['menu_id']);

        for ($i = 0; $i < sizeof($menu_ids); $i++) {
            $menuName = Menu::where('id', $menu_ids[$i])->first();
            $getMenuName = strtolower($menuName->menu);
            $baseRoute = '';

            switch ($getMenuName) {
                case "category":
                    $baseRoute = "categories";
                    break;
                case "subcategory":
                    $baseRoute = 'subcategories';
                    break;
                case "post":
                    $baseRoute = 'posts';
                    break;
                case "role":
                    $baseRoute = 'role';
                    break;
                case "user":
                    $baseRoute = 'users';
                    break;
                case "menu":
                    $baseRoute = 'menu';
                    break;
                case "submenu":
                    $baseRoute = 'submenu';
                    break;
                case "permission":
                    $baseRoute = 'permission';
                    break;
                default:
                    $baseRoute = 'dashboard';
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['view']) && Route::is("$baseRoute.index")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['create']) && Route::is("$baseRoute.create")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['edit']) && Route::is("$baseRoute.edit")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['delete']) && Route::is("$baseRoute.destory")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['trash']) && Route::is("$baseRoute.trash")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['restore']) && Route::is("$baseRoute.restore")) {
                return abort(401);
            }

            if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['remove']) && Route::is("$baseRoute.delete")) {
                return abort(401);
            }

            // if (!isset(auth()->user()->getRole->permission['name']["$menuName->id"]['other']) && Route::is("$baseRoute.trash")) {
            //   return abort(401);
            // }
        }

        if (!isset(auth()->user()->getRole->permission['name']["7"]['other']) && Route::is("message.index")) {
            return abort(401);
        }

        if (!isset(auth()->user()->getRole->permission['name']["13"]['other']) && Route::is("comment.index")) {
            return abort(401);
        }
    }
}
