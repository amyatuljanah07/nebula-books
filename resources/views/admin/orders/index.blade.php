@extends('layouts.admin')

@section('content')
<div class="content-card">
    <div class="card-header d-flex align-items-center" style="background: transparent; border-bottom: none;">
        <h2 class="mb-0"><i class="fas fa-shopping-cart"></i> Daftar Order</h2>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Order Number</th>
                        <th width="20%">Customer</th>
                        <th width="12%">Total</th>
                        <th width="10%">Status</th>
                        <th width="10%">Payment</th>
                        <th width="13%">Tanggal</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $index => $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong style="color: #6366f1;">{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div><strong>{{ $order->user->name }}</strong></div>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td><strong>{{ $order->formatted_total }}</strong></td>
                        <td>
                            @if($order->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->status === 'processing')
                                <span class="badge bg-info">Processing</span>
                            @elseif($order->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($order->payment_status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($order->payment_status === 'refunded')
                                <span class="badge bg-secondary">Refunded</span>
                            @else
                                <span class="badge bg-warning text-dark">Unpaid</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($order->canBeCancelled())
                                <form action="{{ route('admin.orders.destroy', $order) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus order ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">Belum ada order</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection