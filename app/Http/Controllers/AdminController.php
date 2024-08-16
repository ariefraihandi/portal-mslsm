<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\MenuSubChild;
use App\Models\AccessMenu;
use App\Models\Instansi;
use App\Models\AccessSub;
use App\Models\AccessSubChild;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DataTables;

class AdminController extends Controller
{

    public function showMenu(Request $request)
    {
        $accessMenus            = $request->get('accessMenus');
        $id                     = $request->session()->get('user_id');
        $user                   = User::with('detail')->find($id); 
        $menus                  = Menu::all();
        $menuSubs               = MenuSub::all();
        $menuSubChildren        = MenuSubChild::all();
        $roleList               = Role::all();

        $data = [
            'title'             => 'Menu List',
            'subtitle'          => 'Portal MS Lhokseumawe',
            'users'             => $user,
            'sidebar'           => $accessMenus,
            'menus'             => $menus,
            'menuSubs'          => $menuSubs,
            'menuSubChildren'   => $menuSubChildren,
            'roleList'          => $roleList,
        ];

        return view('Admin.menuList', $data);
    }

    public function showsubMenu(Request $request)
    {
        $accessMenus            = $request->get('accessMenus');
        $id                     = $request->session()->get('user_id');
        $user                   = User::with('detail')->find($id); 
        $menus                  = Menu::all();
        $menuSubs               = MenuSub::all();
        $menuSubChildren        = MenuSubChild::all();
        $roleList               = Role::all();

        $data = [
            'title'             => 'Submenu List',
            'subtitle'          => 'Bilik Hukum',
            'users'             => $user,
            'sidebar'           => $accessMenus,
            'menus'             => $menus,
            'menuSubs'          => $menuSubs,
            'menuSubChildren'   => $menuSubChildren,
            'roleList'          => $roleList,
        ];
        
        return view('Admin.submenuList', $data);
    }
    
    public function showchildMenu(Request $request)
    {
        $accessMenus            = $request->get('accessMenus');
        $id                     = $request->session()->get('user_id');
        $user                   = User::with('detail')->find($id); 
        $menus                  = Menu::all();
        $menuSubs               = MenuSub::all();
        $menuSubChildren        = MenuSubChild::all();
        $roleList               = Role::all();

        $data = [
            'title'             => 'Child Menu List',
            'subtitle'          => 'Portal MS Lhokseumawe',
            'users'             => $user,
            'sidebar'           => $accessMenus,
            'menus'             => $menus,
            'menuSubs'          => $menuSubs,
            'menuSubChildren'   => $menuSubChildren,
            'roleList'          => $roleList,
        ];

        return view('Admin.childmenuList', $data);
    }
    
    public function showRoleList(Request $request)
    {
        $accessMenus            = $request->get('accessMenus');
        $id                     = $request->session()->get('user_id');
        $user                   = User::with('detail')->find($id); 
        $menus                  = Menu::all();
        $menuSubs               = MenuSub::all();
        $menuSubChildren        = MenuSubChild::all();
        $roleList               = Role::all();

        $data = [
            'title'             => 'Role List',
            'subtitle'          => 'Portal MS Lhokseumawe',
            'users'             => $user,
            'sidebar'           => $accessMenus,
            'menus'             => $menus,
            'menuSubs'          => $menuSubs,
            'menuSubChildren'   => $menuSubChildren,
            'roleList'          => $roleList,
        ];

        return view('Admin.roleList', $data);
    }

    public function showInstasi(Request $request)
    {
        // Fetch the data with ID 1
        $instansi = Instansi::find(1);
        $id                     = $request->session()->get('user_id');
        $user                   = User::with('detail')->find($id); 
    
        // If the data is not found, you might want to handle this case
        if (!$instansi) {
            abort(404, 'Instansi not found');
        }
    
        $accessMenus = $request->get('accessMenus');
    
        $data = [
            'title'             => 'Instansi',
            'subtitle'          => 'Portal MS Lhokseumawe',
            'users'             => $user,
            'sidebar'           => $accessMenus,
            'instansi'          => $instansi, // Add the fetched data here
        ];
    
        return view('Admin.instansi', $data);
    }
    

    public function showRole(Request $request)
    {
        $accessMenus = $request->get('accessMenus');          
        $id                     = $request->session()->get('user_id');
        $roles = Role::where('id', '!=', 1)->with('users')->get();
        $menus = Menu::all();
        $user                   = User::with('detail')->find($id); 
        $subMenus = MenuSub::all();
        $childMenus = MenuSubChild::all();
    
        $data = [
            'title' => 'Accesses',
            'subtitle' => 'Bilik Hukum',
            'roles' => $roles,
            'users'             => $user,
            'sidebar' => $accessMenus,
            'menus' => $menus,
            'subMenus' => $subMenus,
            'childMenus' => $childMenus,
        ];
        
        return view('Admin.roleAccess', $data);
    }
    

    //addItem
        public function addMenu(Request $request)
        {
            try {
                // Validate the request data
                $request->validate([
                    'menu_name' => 'required|string|max:255',
                    // Add any other validation rules you may need
                ]);
        
                // Start a database transaction
                \DB::beginTransaction();
        
                // Fetch the count of menus in the database and use it as the order value
                $order = Menu::count() + 1;
        
                // Create a new menu
                $menu = new Menu([
                    'menu_name' => $request->input('menu_name'),
                    'order' => $order,
                    'status' => $request->has('status') ? 1 : 0,
                ]);
        
                // Save the menu
                $menu->save();
            
                // Create a new access menu record
                $accessMenu = new AccessMenu([
                    'role_id' => 1, // Assuming role_id 1 is for the admin role
                    'menu_id' => $menu->id,
                ]);
        
                // Save the access menu record
                $accessMenu->save();
        
                // Commit the transaction
                \DB::commit();
        
                // Flash success response to the session
                return redirect()->route('admin.menu.menulist')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Menu added successfully',
                    ],
                ]);
            } catch (\Exception $e) {
                // Rollback the transaction
                \DB::rollBack();
        
                // Flash error response to the session
                return redirect()->route('admin.menu.menulist')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Failed to add menu. ' . $e->getMessage(),
                    ],
                ]);
            }
        }
        
        public function addSubmenu(Request $request)
        {
            try {
                // Validate the request data for submenu
                $request->validate([
                    'submenu_name' => 'required|string|max:255',
                    'menu_id' => 'required|exists:menus,id', // Validate if the selected menu exists
                    'url' => 'required|string',
                    'icon' => 'required|string',
                ]);

                // Fetch the menu_id from the request
                $menuId = $request->input('menu_id');

                // Count the number of existing submenus for the specified menu_id
                $order = MenuSub::where('menu_id', $menuId)->count() + 1;

                // Create a new submenu
                $submenu = new MenuSub([
                    'menu_id' => $menuId,
                    'title' => $request->input('submenu_name'),
                    'order' => $order,
                    'url' => $request->input('url'),
                    'icon' => $request->input('icon'),
                    'itemsub' => $request->has('itemsub') ? 1 : 0,
                    'is_active' => $request->has('status') ? 1 : 0, // Ensure you are using the correct column name
                ]);

                // Save the submenu
                $submenu->save();

                // Create a new access submenu record
                $accessSub = new AccessSub([
                    'role_id' => 1, // Assuming role_id 1 is for the admin role
                    'submenu_id' => $submenu->id,
                ]);

                // Save the access submenu record
                $accessSub->save();

                // Flash success response to the session
                return redirect()->route('admin.menu.submenulist')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Submenu added successfully',
                    ],
                ]);
            } catch (\Exception $e) {
                // Flash error response to the session
                return redirect()->route('admin.menu.submenulist')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Failed to add submenu. ' . $e->getMessage(),
                    ],
                ]);
            }
        }

        public function addChildSubmenu(Request $request)
        {
            \DB::beginTransaction(); // Start the database transaction
        
            try {
                // Validate the request data for child submenu
                $request->validate([
                    'childsubmenu_name' => 'required|string|max:255',
                    'submenu_id' => 'required|exists:menu_subs,id', // Validate if the selected submenu exists
                    'url' => 'required|string',
                ]);
        
                // Fetch the submenu_id from the request
                $submenuId = $request->input('submenu_id');
        
                // Count the number of existing child submenus for the specified submenu_id
                $order = MenuSubChild::where('id_submenu', $submenuId)->count() + 1;
        
                // Create a new child submenu
                $childsubmenu = new MenuSubChild([
                    'id_submenu' => $submenuId,
                    'title' => $request->input('childsubmenu_name'),
                    'order' => $order,
                    'url' => $request->input('url'),
                    'is_active' => $request->has('childSubmenuStatus') ? 1 : 0,
                ]);
        
                // Save the child submenu
                $childsubmenu->save();
        
                // Create a new access submenu child record
                $accessSubChild = new AccessSubChild([
                    'role_id' => 1, // Assuming role_id 1 is for the admin role
                    'childsubmenu_id' => $childsubmenu->id,
                ]);
        
                // Save the access submenu child record
                $accessSubChild->save();
        
                \DB::commit(); // Commit the transaction if all operations are successful
        
                // Flash success response to the session
                return redirect()->route('admin.menu.childmenulist')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Child Submenu added successfully',
                    ],
                ]);
            } catch (\Exception $e) {
                \DB::rollBack(); // Rollback the transaction if any error occurs
        
                // Flash error response to the session
                return redirect()->route('admin.menu.childmenulist')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Failed to add Child Submenu. ' . $e->getMessage(),
                    ],
                ]);
            }
        }  

        public function addRole(Request $request)
        {
            $request->validate([
                'role_name' => 'required|string|max:255',
            ]);

            Role::create([
                'name' => $request->role_name,
            ]);

            return redirect()->route('admin.menu.role')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Role added successfully',
                ],
            ]);
        }

    //!addItem

    //editItem
        public function editRole(Request $request)
        {
            // Validasi input
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'role_name' => 'required|string|max:255',
            ]);

            // Temukan role berdasarkan ID
            $role = Role::find($request->role_id);

            // Update nama role
            $role->name = $request->role_name;
            $role->save();

            // Redirect kembali dengan response
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Role updated successfully',
                ],
            ]);
        }
    //!editItem


    //Delete
        public function deleteMenu(Request $request)
        {
            \DB::beginTransaction();
        
            try {
                // Retrieve the ID from the query parameters
                $id = $request->input('id');
                \Log::info('Attempting to delete menu with ID: ' . $id);
        
                // Check if the menu exists
                $menu = Menu::find($id);
                if (!$menu) {
                    throw new \Exception('Menu not found.');
                }
        
                // Delete the associated access menu records
                AccessMenu::where('menu_id', $id)->delete();
                \Log::info('Deleted access menu records for menu ID: ' . $id);
        
                // Get all submenus related to the menu
                $subMenus = MenuSub::where('menu_id', $id)->get();
        
                foreach ($subMenus as $subMenu) {
                    $subMenuId = $subMenu->id;
        
                    // Delete all access submenu records related to the submenu
                    AccessSub::where('submenu_id', $subMenuId)->delete();
                    \Log::info('Deleted access sub menu records for submenu ID: ' . $subMenuId);
        
                    // Get all submenus children related to the submenu
                    $subMenuChildren = MenuSubChild::where('id_submenu', $subMenuId)->get();
        
                    foreach ($subMenuChildren as $subMenuChild) {
                        $subMenuChildId = $subMenuChild->id;
        
                        // Delete all access sub children records related to the sub menu child
                        AccessSubChild::where('childsubmenu_id', $subMenuChildId)->delete();
                        \Log::info('Deleted access sub child records for sub menu child ID: ' . $subMenuChildId);
        
                        // Delete the sub menu child
                        $subMenuChild->delete();
                        \Log::info('Deleted sub menu child with ID: ' . $subMenuChildId);
                    }
        
                    // Delete the submenu
                    $subMenu->delete();
                    \Log::info('Deleted submenu with ID: ' . $subMenuId);
                }
        
                // Delete the menu with the specified ID
                $menu->delete();
                \Log::info('Deleted menu with ID: ' . $id);
        
                // Commit the transaction
                \DB::commit();
        
                $successMessage = 'Menu and associated submenus and access records deleted successfully';
        
                return redirect()->route('admin.menu.menulist')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => $successMessage,
                    ],
                ]);
            } catch (\Exception $e) {
                // Rollback the transaction
                \DB::rollBack();
        
                $errorMessage = 'Failed to delete menu and associated records. ' . $e->getMessage();
                \Log::error($errorMessage);
        
                return redirect()->route('admin.menu.menulist')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => $errorMessage,
                    ],
                ]);
            }
        }

        public function deleteChildSubMenu(Request $request)
        {
            $subMenuChildId = $request->input('id');
            
            try {
                // Hapus AccessSubChild yang terkait dengan childsubmenu_id
                AccessSubChild::where('childsubmenu_id', $subMenuChildId)->delete();
                Log::info('Deleted access sub child records for sub menu child ID: ' . $subMenuChildId);

                // Hapus MenuSubChild dengan ID yang diberikan
                MenuSubChild::where('id', $subMenuChildId)->delete();

                // Jika berhasil, kembalikan response sukses
                return redirect()->route('admin.menu.childmenulist')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Sub menu child successfully deleted!',
                    ],
                ]);
            } catch (\Exception $e) {
                // Log error jika terjadi kesalahan
                Log::error('Error deleting sub menu child: ' . $e->getMessage());

                // Kembalikan response error jika terjadi kegagalan
                return redirect()->route('admin.menu.childmenulist')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => $errorMessage,
                    ],
                ]);
            }
        }

        public function deleteRole(Request $request)
        {
            // Validasi input
            $request->validate([
                'id' => 'required|exists:roles,id',
            ]);
    
            // Temukan role berdasarkan ID dan hapus
            $role = Role::find($request->id);
            $role->delete();
    
            // Redirect kembali dengan response
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Role deleted successfully',
                ],
            ]);
        }
    //!Delete

    //Move
        public function moveMenu(Request $request)
        {
            // Mendapatkan data menu berdasarkan ID yang dikirimkan
            $menu = Menu::findOrFail($request->menu_id);

            // Mendapatkan menu yang akan ditukar urutannya
            if ($request->direction === 'up') {
                $menuToSwapWith = Menu::where('order', '<', $menu->order)
                                    ->orderBy('order', 'desc')
                                    ->first();
            } elseif ($request->direction === 'down') {
                $menuToSwapWith = Menu::where('order', '>', $menu->order)
                                    ->orderBy('order', 'asc')
                                    ->first();
            }

            // Jika ada menu untuk ditukar urutannya
            if ($menuToSwapWith) {
                // Tukar urutan menu
                $tempOrder = $menu->order;
                $menu->order = $menuToSwapWith->order;
                $menuToSwapWith->order = $tempOrder;

                // Simpan perubahan urutan kedua menu
                $menu->save();
                $menuToSwapWith->save();

                return response()->json(['success' => true]);
            }

            // Jika tidak ada menu untuk ditukar urutannya
            return response()->json(['success' => false, 'message' => 'No menu to swap with.']);
        }

        public function moveSubmenu(Request $request)
        {
            $id = $request->input('id');
            $direction = $request->input('direction');

            // Find the submenu by ID
            $submenu = MenuSub::find($id);

            if (!$submenu) {
                return response()->json(['success' => false, 'message' => 'Submenu not found.'], 404);
            }

            $menuId = $submenu->menu_id;
            $currentOrder = $submenu->order;

            if ($direction == 'up') {
                // Find the submenu with the order just above the current submenu
                $previousSubmenu = MenuSub::where('menu_id', $menuId)
                    ->where('order', '<', $currentOrder)
                    ->orderBy('order', 'desc')
                    ->first();

                if ($previousSubmenu) {
                    // Swap the orders
                    $submenu->order = $previousSubmenu->order;
                    $previousSubmenu->order = $currentOrder;

                    $submenu->save();
                    $previousSubmenu->save();
                }
            } elseif ($direction == 'down') {
                // Find the submenu with the order just below the current submenu
                $nextSubmenu = MenuSub::where('menu_id', $menuId)
                    ->where('order', '>', $currentOrder)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextSubmenu) {
                    // Swap the orders
                    $submenu->order = $nextSubmenu->order;
                    $nextSubmenu->order = $currentOrder;

                    $submenu->save();
                    $nextSubmenu->save();
                }
            }

            // Return a success response
            return response()->json(['success' => true]);
        }

        public function moveChildSubmenu(Request $request)
        {
            $id = $request->input('id');
            $direction = $request->input('direction');

            $childSubmenu = MenuSubChild::find($id);
            if (!$childSubmenu) {
                return response()->json(['success' => false, 'message' => 'Child submenu not found']);
            }

            $currentOrder = $childSubmenu->order;

            if ($direction == 'up') {
                $previousChildSubmenu = MenuSubChild::where('id_submenu', $childSubmenu->id_submenu)
                    ->where('order', '<', $currentOrder)
                    ->orderBy('order', 'desc')
                    ->first();

                if ($previousChildSubmenu) {
                    $childSubmenu->order = $previousChildSubmenu->order;
                    $previousChildSubmenu->order = $currentOrder;

                    $childSubmenu->save();
                    $previousChildSubmenu->save();
                }
            } elseif ($direction == 'down') {
                $nextChildSubmenu = MenuSubChild::where('id_submenu', $childSubmenu->id_submenu)
                    ->where('order', '>', $currentOrder)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextChildSubmenu) {
                    $childSubmenu->order = $nextChildSubmenu->order;
                    $nextChildSubmenu->order = $currentOrder;

                    $childSubmenu->save();
                    $nextChildSubmenu->save();
                }
            }

            return response()->json(['success' => true]);
        }
    //!Move

    public function changeAccess(Request $request)
    {
        // Ambil data dari permintaan
        $roleId = $request->input('roleId');
        $menuId = $request->input('menuId');        
        $type   = $request->input('type');     
        // Cari nama peran berdasarkan ID
        $roleName = Role::find($roleId)->name;
        
        if ($type == 'menu') { 
            $menuName           = Menu::find($menuId)->menu_name;
            $existingAccess     = AccessMenu::where('role_id', $roleId)->where('menu_id', $menuId)->first();           

            $response = '';

            if ($existingAccess) {             
                $existingAccess->delete();
                $response = 'delete';
            } else {
                // Jika akses menu belum ada, tambahkan
                $newAccess = new AccessMenu();
                $newAccess->role_id = $roleId;
                $newAccess->menu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $menuName
            ]);
        } elseif ($type === 'submenu') {
            $submenuName = MenuSub::find($menuId)->title;

            // Cek apakah akses menu sudah ada dalam database
            $existingAccess = AccessSub::where('role_id', $roleId)->where('submenu_id', $menuId)->first();

            $response = '';

            if ($existingAccess) {
                // Jika akses menu sudah ada, hapus
                $existingAccess->delete();
                $response = 'delete';
            } else {
                // Jika akses menu belum ada, tambahkan
                $newAccess = new AccessSub();
                $newAccess->role_id = $roleId;
                $newAccess->submenu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            // Beri respons dalam bentuk JSON dengan respons dan informasi nama peran dan nama menu
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $submenuName
            ]);

        } elseif ($type === 'childsubmenu') {
            $childSubName = MenuSubChild::find($menuId)->title;
         
            $existingAccess = AccessSubChild::where('role_id', $roleId)->where('childsubmenu_id', $menuId)->first();

            $response = '';

            if ($existingAccess) {             
                $existingAccess->delete();
                $response = 'delete';
            } else {    
                $newAccess = new AccessSubChild();
                $newAccess->role_id = $roleId;
                $newAccess->childsubmenu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            // Beri respons dalam bentuk JSON dengan respons dan informasi nama peran dan nama menu
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $childSubName
            ]);
        }
    }

//Get Data
    public function getDataMenu()
    {
        $menus = Menu::all();
        
        return DataTables::of($menus)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('title', function ($menu) {
                return $menu->menu_name;
            })
            ->addColumn('submenu', function ($menu) {
                // Mengambil jumlah submenu terkait dengan menu ini
                $submenuCount = MenuSub::where('menu_id', $menu->id)->count();
                return '#' . $submenuCount;
            })
            ->addColumn('order', function ($menu) use ($menus) {
                // Menghitung ulang nomor urut berdasarkan urutan yang sesuai dalam kolom 'order'
                $index = $menu->order;
                
                // Mengembalikan nomor urut yang dihitung ulang beserta icon panah
                $arrowUp = '<a href="#" onclick="moveItem(\'' . $menu->id . '\', \'up\', event)" class="text-body"><i class="fas fa-arrow-up"></i></a>';
                $arrowDown = '<a href="#" onclick="moveItem(\'' . $menu->id . '\', \'down\', event)" class="text-body"><i class="fas fa-arrow-down"></i></a>';
                
                return '#' . ($index) . '  | ' . $arrowUp . ' ' . $arrowDown;
            })              
            ->addColumn('is_active', function ($menu) {
                // Menyesuaikan badge is_active berdasarkan status menu
                if ($menu->status == 1) {
                    return '<div class="text-center"><span class="badge bg-label-primary">Active</span></div>';
                } else {
                    return '<div class="text-center"><span class="badge bg-label-danger">Inactive</span></div>';
                }
            })
            ->addColumn('action', function ($menu) {
                $id = $menu->id;
                $menu_name = $menu->menu_name;
                $editModalTrigger = '<a href="#" class="text-body edit-menu-btn" data-toggle="modal" data-target="#editPerkara_' . $id . '">' .
                                    '<i class="bx bxs-message-square-edit mx-1"></i>' .
                                    '</a>';
                $deleteConfirmation = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'' . '/delete/menu?id=' . $id . '\', \'' . 'Hapus Menu: ' . $menu_name . ' ?\')">' .
                                    '<i class="bx bx-trash"></i>' .
                                    '</a>';
            
                return '<div class="d-flex align-items-center">' .
                        $editModalTrigger .
                        $deleteConfirmation .
                        '</div>';
            })
            ->rawColumns(['is_active', 'order', 'action'])
            ->make(true);
    }
    
    public function getDatasubMenu()
    {
        $menuSubs = MenuSub::with('menu')->orderBy('menu_id')->orderBy('order')->get();
    
        $usedColors = [];
        $uniqueMenuIds = $menuSubs->pluck('menu_id')->unique();
        foreach ($uniqueMenuIds as $menuId) {
            $usedColors[$menuId] = $this->generateSimilarColor($usedColors);
        }
    
        return DataTables::of($menuSubs)
            ->addColumn('no', function ($menuSub) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('Submenu', function ($menuSub) {
                return '<i class="' . $menuSub->icon . '"></i> ' . $menuSub->title;
            })                
            ->addColumn('Menu', function ($menuSub) {
                return $menuSub->menu ? $menuSub->menu->menu_name : 'No Menu';
            })
            ->addColumn('order', function ($menuSub) use ($menuSubs) {
                static $orderCounters = [];
                $menuId = $menuSub->menu_id;
            
                if (!isset($orderCounters[$menuId])) {
                    $orderCounters[$menuId] = 0;
                }
            
                $orderCounters[$menuId]++;
                $order = '#' . $orderCounters[$menuId];
            
                $arrowUp = '<a href="#" onclick="moveItem(\'' . $menuSub->id . '\', \'up\', event)" class="text-body"><i class="fas fa-arrow-up"></i></a>';
                $arrowDown = '<a href="#" onclick="moveItem(\'' . $menuSub->id . '\', \'down\', event)" class="text-body"><i class="fas fa-arrow-down"></i></a>';
            
                return $order . ' |  ' . $arrowUp . ' ' . $arrowDown;
            })
            ->addColumn('url', function ($menuSub) {
                return $menuSub->url;
            })
            ->addColumn('dropdown', function ($menuSub) {
                if ($menuSub->itemsub == 1) {
                    return '<div class="text-center"><span class="badge bg-label-primary">True</span></div>';
                } else {
                    return '<div class="text-center"><span class="badge bg-label-warning">False</span></div>';
                }
            })                
            ->addColumn('status', function ($menuSub) {
                if ($menuSub->is_active == 1) {
                    return '<div class="text-center"><span class="badge bg-label-success">Active</span></div>';
                } else {
                    return '<div class="text-center"><span class="badge bg-label-danger">Inactive</span></div>';
                }
            })                           
            ->addColumn('action', function ($menuSub) {
                $id = $menuSub->id;
                $menuSubName = $menuSub->title; // Assuming 'title' is the name column for the submenu
                $editModalTrigger = '<a href="#" class="text-body edit-menu-btn" data-toggle="modal" data-target="#editMenuModal_' . $id . '">' .
                                    '<i class="bx bxs-message-square-edit mx-1"></i>' .
                                    '</a>';
                $deleteConfirmation = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'' . '/delete/submenu?id=' . $id . '\', \'' . 'Hapus Submenu: ' . $menuSubName . ' ?\')">' .
                                    '<i class="bx bx-trash"></i>' .
                                    '</a>';

                return '<div class="d-flex align-items-center">' .
                        $editModalTrigger .
                        $deleteConfirmation .
                        '</div>';
            })
            ->setRowAttr([
                'style' => function($menuSub) use ($usedColors) {
                    return 'background-color: ' . $usedColors[$menuSub->menu_id] . ';';
                }
            ])
            ->rawColumns(['no', 'Submenu', 'Menu', 'dropdown', 'status','order', 'action'])
            ->make(true);
    }
    
    public function getDataChildMenu()
    {            
        $childmenuSubs = MenuSubChild::with('menuSub')->orderBy('id_submenu')->orderBy('order')->get();
        // dd($childmenuSubs);
        // Generate colors similar to #e8c9ed for each menu_id
        $usedColors = [];
        $uniqueMenuIds = $childmenuSubs->pluck('id_submenu')->unique();
        foreach ($uniqueMenuIds as $menuId) {
            $usedColors[$menuId] = $this->generateSimilarColor($usedColors);
        }
    
        return DataTables::of($childmenuSubs)
            ->addColumn('no', function ($childmenuSub) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('title', function ($childmenuSub) {
                return $childmenuSub->title;
            })                
            ->addColumn('submenu', function ($childmenuSub) {
                return $childmenuSub->menuSub ? $childmenuSub->menuSub->title : 'No SubMenu';
            })
                            
            ->addColumn('order', function ($childmenuSub) use ($childmenuSubs) {
                static $orderCounters = [];
                $submenuId = $childmenuSub->id_submenu;
            
                if (!isset($orderCounters[$submenuId])) {
                    $orderCounters[$submenuId] = 0;
                }
            
                $orderCounters[$submenuId]++;
                $order = '#' . $orderCounters[$submenuId];
            
                $arrowUp = '<a href="#" onclick="moveItem(\'' . $childmenuSub->id . '\', \'up\', event)" class="text-body"><i class="fas fa-arrow-up"></i></a>';
                $arrowDown = '<a href="#" onclick="moveItem(\'' . $childmenuSub->id . '\', \'down\', event)" class="text-body"><i class="fas fa-arrow-down"></i></a>';
            
                return $order . ' | ' . $arrowUp . ' ' . $arrowDown;
            })                
            ->addColumn('url', function ($childmenuSub) {
                return '/'.$childmenuSub->url;
            })                          
            ->addColumn('status', function ($childmenuSub) {
                if ($childmenuSub->is_active == 1) {
                    return '<div class="text-center"><span class="badge bg-label-success">Active</span></div>';
                } else {
                    return '<div class="text-center"><span class="badge bg-label-danger">Inactive</span></div>';
                }
            })                           
            ->addColumn('action', function ($childmenuSub) {
                $id = $childmenuSub->id;
                $childmenuSubName = $childmenuSub->title; // Assuming 'title' is the name column for the child submenu
                $editModalTrigger = '<a href="#" class="text-body edit-childmenu-btn" data-toggle="modal" data-target="#editChildMenuModal_' . $id . '">' .
                                    '<i class="bx bxs-message-square-edit mx-1"></i>' .
                                    '</a>';
                $deleteConfirmation = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'' . '/delete/childsubmenu?id=' . $id . '\', \'' . 'Hapus Child Submenu: ' . $childmenuSubName . ' ?\')">' .
                                    '<i class="bx bx-trash"></i>' .
                                    '</a>';
            
                return '<div class="d-flex align-items-center">' .
                        $editModalTrigger .
                        $deleteConfirmation .
                        '</div>';
            })                
            ->setRowAttr([
                'style' => function($childmenuSub) use ($usedColors) {
                    return 'background-color: ' . $usedColors[$childmenuSub->id_submenu] . ';';
                }
            ])
            ->rawColumns(['no', 'status','order', 'action'])
            ->make(true);
    }
      
    private function generateSimilarColor($usedColors)
    {
        // Daftar warna serupa
        $similarColors = [
            '#b2b4ff69',
            '#9395d669',
            '#d4d69369',
            '#d6a69369',
            '#93d6a469'
        ];
    
        // Filter warna yang belum digunakan
        $availableColors = array_diff($similarColors, $usedColors);
    
        // Jika semua warna sudah digunakan, kembalikan warna acak
        if (empty($availableColors)) {
            return $similarColors[array_rand($similarColors)];
        }
    
        // Pilih warna dari warna yang tersedia
        return $availableColors[array_rand($availableColors)];
    }

    public function getDataRoleList(Request $request)
{
    if ($request->ajax()) {
        $data = Role::all();
        return Datatables::of($data)
            
            ->addColumn('no', function ($data) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function($row){
                $id = $row->id;
                $roleName = $row->name;

                $editIcon = '<a href="#" class="text-body edit-role-btn" data-toggle="modal" data-target="#editRole_' . $id . '">' .
                            '<i class="bx bxs-message-square-edit mx-1"></i>' .
                            '</a>';
                $deleteIcon = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'/delete/role?id=' . $id . '\', \'Hapus Role: ' . $roleName . ' ?\')">' .
                              '<i class="bx bx-trash"></i>' .
                              '</a>';

                return $editIcon . $deleteIcon;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

    
      
//! Get Data
}
