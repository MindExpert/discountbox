<?php

namespace App\Http\Controllers\Management;

use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', Transaction::class);

        if ($request->ajax() || $request->wantsJson()) {
            try {

                $datatableQuery = Transaction::query()
                    ->select(['transactions.*'])
                    ->with(['user', 'transactional']);

                return DataTables::eloquent($datatableQuery)
                    ->addColumn('permissions', function (Transaction $transaction) {
                        $view   = user()->can('view', $transaction);
                        $update = user()->can('update', $transaction);
                        $delete = user()->can('delete', $transaction);

                        return [
                            'view'   => $view,
                            'update' => $update,
                            'delete' => $delete,
                        ];
                    })
                    ->editColumn('name', function (Transaction $transaction) {
                        return view('management.transactions.datatable.name', compact('transaction'));
                    })
                    ->addColumn('type', function (Transaction $transaction) {
                        return view('management.transactions.datatable.type', compact('transaction'));
                    })
                    ->addColumn('actions', 'management.transactions.datatable.actions')
                    ->rawColumns(['actions', 'name', 'type'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return EmptyDatatable::toJson();
            }
        }

        return view('management.transactions.index');
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize('search', Transaction::class);

        return response()->json(
            Transaction::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()->append(['label'])
        );
    }

    public function create(): View
    {
        $this->authorize('create', Transaction::class);

        return view('management.users.create');
    }

    public function store(TransactionStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Transaction::class);
        #TODO: Add validation for user_id and amount
        $type = $request->input('type');

        try {
            /** @var Transaction $Transaction */
            $transaction = Transaction::query()->create([
                'user_id' => $request->input('user_id'),
                'credit'  => $type === 'credit' ? $request->input('amount') : 0,
                'debit'   => $type === 'debit' ? $request->input('amount') : 0,
                'type'    => TransactionTypeEnum::PROFILE_COMPLETE,
                'name'    => json_encode([
                    'lang'   => 'transaction.names.manual_bonus',
                    'params' => ['actionable' => __('transaction.event.profile')]
                ]),
                'notes'  => json_encode([
                    'lang'   => 'transaction.names.profile_bonus',
                    'params' => []
                ]),
            ]);

            FlashNotification::success(__('general.success'), __('transaction.responses.created'));
            return ActionJsonResponse::make(true, route('management.transactions.show', ['transaction' => $transaction->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('transaction.responses.not_created'));
            return ActionJsonResponse::make(false, route('management.transactions.index'))->response();
        }
    }

    public function show(Transaction $transaction): View
    {
        $this->authorize('view', $transaction);

        return view('management.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction): View
    {
        $this->authorize('update', $transaction);

        return view('management.transactions.edit', compact('transaction'));
    }

    public function update(UserUpdateRequest $request, Transaction $transaction): JsonResponse
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

            FlashNotification::success(__('general.success'), __('user.responses.updated'));
            return ActionJsonResponse::make(true, route('management.users.show', ['user' => $user->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('user.responses.not_updated'));
            return ActionJsonResponse::make(false, route('management.users.index'))->response();
        }
    }

    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->authorize('delete', $transaction);

        try {
            $transaction->delete();

            FlashNotification::success(__('general.success'), __('transaction.responses.deleted'));
        } catch (Exception $exception) {
            report($exception);
            FlashNotification::error(__('general.error'), __('transaction.responses.not_deleted'));
        }

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        } else {
            return redirect()->route('management.transactions.index');
        }

    }
}
