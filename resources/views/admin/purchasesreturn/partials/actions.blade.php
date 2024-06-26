<div class="btn-group dropleft">
    <button type="button" class="btn btn-ghost-primary dropdown rounded" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-three-dots-vertical"></i>
    </button>
    <div class="dropdown-menu">
        @can('access_purchase_return_payments')
            <a href="{{ route('purchase-return-payments.index', $data->id) }}" class="dropdown-item">
                <i class="fa fa-cash-coin mr-2 text-warning" style="line-height: 1;"></i> Show Payments
            </a>
        @endcan
        @can('access_purchase_return_payments')
            @if($data->due_amount > 0)
                <a href="{{ route('purchase-return-payments.create', $data->id) }}" class="dropdown-item">
                    <i class="fa fa-plus-circle-dotted mr-2 text-success" style="line-height: 1;"></i> Add Payment
                </a>
            @endif
        @endcan
        @can('edit_purchase_returns')
            <a href="{{ route('purchase-returns.edit', $data->id) }}" class="dropdown-item">
                <i class="fa fa-pencil mr-2 text-primary" style="line-height: 1;"></i> Edit
            </a>
        @endcan
        @can('show_purchase_returns')
            <a href="{{ route('purchase-returns.show', $data->id) }}" class="dropdown-item">
                <i class="fa fa-eye mr-2 text-info" style="line-height: 1;"></i> Details
            </a>
        @endcan
        @can('delete_purchase_return')
            <button id="delete" class="dropdown-item" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }">
                <i class="fa fa-trash mr-2 text-danger" style="line-height: 1;"></i> Delete
                <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('purchase-returns.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </button>
        @endcan
    </div>
</div>
