<?php

namespace App\Http\Controllers\Management;

use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\TransactionStoreRequest;
use App\Models\Transaction;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    ->with(['user']);

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
                    ->editColumn('user_id', function (Transaction $transaction) {
                        return view('management.transactions.datatable.user', compact('transaction'));
                    })
                    ->editColumn('name', function (Transaction $transaction) {
                        if (! empty($transaction->notes)) {
                            $html = nl2br($transaction->notes);
                        } else {
                            $html = __('general.no_data');
                        }

                        return view('management.transactions.datatable.name', compact('transaction', 'html'));
                    })
                    ->addColumn('type', function (Transaction $transaction) {
                        return view('management.transactions.datatable.type', compact('transaction'));
                    })
                    ->addColumn('actions', 'management.transactions.datatable.actions')
                    ->filterColumn('user_id', function (Builder $query, $keyword) {
                        if ($keyword) {
                            if (is_numeric($keyword)) {
                                return $query->where('transactions.user_id', $keyword);
                            } else {
                                return $query->whereIn('transactions.user_id', function ($subQuery) use ($keyword) {
                                    return $subQuery->select('id')
                                        ->from('users')
                                        ->whereRaw("CONVERT(users.first_name using 'utf8mb4') like ?", ["%$keyword%"])
                                        ->orWhereRaw("CONVERT(users.last_name using 'utf8mb4') like ?", ["%$keyword%"]);
                                });
                            }
                        }
                        return $query;
                    })
                    ->withQuery('model_aggregates', function ($filteredQuery) {
                        $filteredQuery->getQuery()->orders = null;
                        $filteredQuery->getQuery()->limit = null;
                        $filteredQuery->getQuery()->offset = null;

                        return $filteredQuery
                            ->select(DB::raw("
                                SUM(transactions.credit) AS total_credit,
                                SUM(transactions.debit) AS total_debit,
                                (SUM(transactions.credit) - SUM(transactions.debit))  AS available_credit,
                                transactions.type AS group_type
                            "))
                            ->groupBy('transactions.type')
                            ->orderBy('transactions.type')
                            ->get()
                            ->map(function ($item) {
                                return [
                                    'available_credit' => number_format_short($item->available_credit, 2),
                                    'total_credit'     => number_format_short($item->total_credit, 2),
                                    'total_debit'      => number_format_short($item->total_debit, 2),
                                    'type_label'       => TransactionTypeEnum::tryFrom($item->group_type)->label(),
                                    'type_color'       => TransactionTypeEnum::tryFrom($item->group_type)->color(),
                                ];
                            });
                    })
                    ->rawColumns(['actions', 'user_id', 'name', 'type'])
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

        if ($type === 'credit') {
            $credit = $request->input('amount');
            $debit  = 0;
            $name   = json_encode([
                'lang'   => 'transaction.names.credit',
                'params' => ['actionable' => __('transaction.event.manual')]
            ]);
            $notes = json_encode([
                'lang'   => 'transaction.names.manual_bonus',
                'params' => []
            ]);

        } else {
            $credit = 0;
            $debit  = $request->input('amount');
            $name   = json_encode([
                'lang'   => 'transaction.names.debit',
                'params' => ['actionable' => __('transaction.event.manual')]
            ]);
            $notes = json_encode([
                'lang'   => 'transaction.names.manual_debit',
                'params' => []
            ]);
        }

        try {
            /** @var Transaction $Transaction */
            $transaction = Transaction::query()->create([
                'user_id' => $request->input('user_id'),
                'credit'  => $credit,
                'debit'   => $debit,
                'type'    => $type === 'credit' ? TransactionTypeEnum::MANUAL_CREDIT : TransactionTypeEnum::MANUAL_DEBIT,
                'name'    => $name,
                'notes'   => $notes,
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
