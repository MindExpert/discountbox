<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\UserStoreRequest;
use App\Http\Requests\Management\UserUpdateRequest;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', User::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = User::query()->select(['users.*']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (User $user) {
                        $view   = user()->can('view', $user);
                        $update = user()->can('update', $user);
                        $delete = user()->can('delete', $user);

                        return [
                            'view'   => $view,
                            'update' => $update,
                            'delete' => $delete,
                        ];
                    })
                    ->editColumn('full_name', function (User $user) {
                        return view('management.users.datatable.full_name', compact('user'));
                    })
                    ->addColumn('role', function (User $user) {
                        return view('management.users.datatable.role', compact('user'));
                    })
                    ->addColumn('actions', 'management.users.datatable.actions')
                    ->rawColumns(['full_name', 'role', 'actions'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.users.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', User::class);

        return response()->json(
            User::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label'])
        );
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('management.users.create');
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        try {
            /** @var User $user */
            $user = User::query()->create([
                'role'            => $request->input('role'),
                'first_name'      => $request->input('first_name'),
                'last_name'       => $request->input('last_name'),
                'nickname'        => $request->input('nickname'),
                'email'           => $request->input('email'),
                'password'        => Hash::make($request->input('password')),
                'mobile'          => $request->input('mobile'),
                //'locale'          => $request->input('locale'),
                'birth_date'      => $request->input('birth_date'),
            ]);


            $user->touch();

            FlashNotification::success(__('general.success'), __('user.responses.created'));
            return ActionJsonResponse::make(true, route('management.users.show', ['user' => $user->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('user.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.users.index'))->response();
        }
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('management.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('management.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        try {
            $user->update([
                'role'            => $request->input('role'),
                'first_name'      => $request->input('first_name'),
                'last_name'       => $request->input('last_name'),
                'nickname'        => $request->input('nickname'),
                'email'           => $request->input('email'),
                'mobile'          => $request->input('mobile'),
                //'locale'          => $request->input('locale'),
                'birth_date'      => $request->input('birth_date'),
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }

            $user->touch();

            FlashNotification::success(__('general.success'), __('user.responses.updated'));
            return ActionJsonResponse::make(true, route('management.users.show', ['user' => $user->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('user.responses.not_updated'));
            return ActionJsonResponse::make(false, route('management.users.index'))->response();
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $user->delete();

            FlashNotification::success(__('general.success'), __('user.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('user.responses.not_deleted'));
        }

        return redirect()->route('management.users.index');
    }
}
