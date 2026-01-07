@extends('admin.master.master')
@section('title', 'Order Details')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .main-content { font-size: 0.9rem; }
        .main-content h2 { font-size: 1.6rem; }
        .main-content h4 { font-size: 1.15rem; }
        .card { border: none; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
        .card-header { background-color: #fff; border-bottom: 1px solid #e9ecef; padding: 1rem 1.5rem; font-weight: 600; }
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; }
        .invoice-header .logo { max-height: 50px; }
        .invoice-header .invoice-info { text-align: right; }
        .summary-card .list-group-item { display: flex; justify-content: space-between; border: none; padding: 0.75rem 0; }
        .summary-card .grand-total { font-size: 1.2rem; font-weight: bold; color: #0d6efd; border-top: 1px solid #e9ecef; margin-top: 0.5rem; padding-top: 0.75rem; }
        
        /* Modal Input Styles */
        .price-input { text-align: right; font-weight: bold; }
        .qty-badge { background: #f8f9fa; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px; }
    </style>
@endsection

@section('body')
<main class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-header">
                            <div>
                                @if($companyInfo && $companyInfo->logo)
                                    <img src="{{ asset('/') }}{{$front_logo_name}}" alt="Company Logo" class="logo">
                                @else
                                    <h4 class="mb-0">{{ $companyInfo->ins_name ?? 'Company Name' }}</h4>
                                @endif
                                <address class="mt-2 mb-0 text-muted address-block">
                                    {{ $companyInfo->address ?? 'Company Address' }}<br>
                                    Phone: {{ $companyInfo->phone ?? 'N/A' }}
                                </address>
                            </div>
                            <div class="invoice-info">
                                <h4 class="text-primary">INVOICE</h4>
                                <p>#{{ $order->invoice_no }}</p>
                                <p>Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d F, Y') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="section-title">Billed To</h6>
                                <address class="address-block">
                                    @if($order->customer)
                                        <strong>{{ $order->customer->name }}</strong><br>
                                        {{ $order->customer->address ?? 'N/A' }}<br>
                                        <i class="fa fa-phone me-1"></i> {{ $order->customer->phone }}<br>
                                        <i class="fa fa-envelope me-1"></i> {{ $order->customer->email ?? 'N/A' }}
                                    @else
                                        <strong class="text-danger">Customer Deleted</strong>
                                    @endif
                                </address>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="section-title">Shipped To</h6>
                                <address class="address-block">
                                    @if($order->customer)
                                        <strong>{{ $order->customer->name }}</strong><br>
                                        {{ $order->shipping_address }}
                                    @else
                                        <strong class="text-danger">Customer Deleted</strong>
                                    @endif
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Order Items</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $detail)
                                    <tr>
                                        <td class="ps-4">{{ $detail->product->name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">
                                            {{ number_format($detail->unit_price, 2) }}
                                        </td>
                                        <td class="text-end pe-4">
                                            {{ number_format($detail->subtotal, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col-lg-4">
                <div class="card summary-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Order Summary
                        <span class="badge bg-{{ 
                            $order->status == 'accepted' ? 'success' : 
                            ($order->status == 'cancelled' ? 'danger' : 'warning') 
                        }} text-uppercase">{{ $order->status }}</span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Subtotal <span>{{ number_format($order->subtotal, 2) }}</span></li>
                            
                            @if($order->discount > 0)
                                <li class="list-group-item">Discount <span>- {{ number_format($order->discount, 2) }}</span></li>
                            @endif
                            
                            <li class="list-group-item grand-total">Total <span>{{ number_format($order->total_amount, 2) }}</span></li>
                        </ul>
                    </div>
                    
                    <div class="card-footer bg-white p-3">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                <i class="fa fa-refresh me-1"></i> Update Status & Price
                            </button>

                            <div class="btn-group">
                                <a href="{{ route('order.print.a4', $order->id) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-print me-1"></i> A4</a>
                                <a href="{{ route('order.print.a5', $order->id) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-print me-1"></i> A5</a>
                                <a href="{{ route('order.print.pos', $order->id) }}" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-receipt me-1"></i> POS</a>
                            </div>

                            <form id="delete-form" action="{{ route('order.destroy', $order->id) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash me-1"></i> Delete Invoice</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="updateStatusModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Update Order Status & Prices</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('order.update.status.prices', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3">
                            <label class="form-label fw-bold mb-0">Order Status:</label>
                        </div>
                        <div class="col-md-9">
                            <select name="status" id="modalStatusSelect" class="form-select form-select-lg">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="waiting" {{ $order->status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                <option value="accepted" {{ $order->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive border rounded">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product Info</th>
                                    <th width="100" class="text-center">Qty</th>
                                    <th width="180">Unit Price</th>
                                    <th width="150" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $detail->product->name ?? 'Unknown' }}</div>
                                        <div class="text-muted small">{{ $detail->product->product_code ?? '' }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="qty-badge">{{ $detail->quantity }}</span>
                                        <input type="hidden" class="qty-hidden" value="{{ $detail->quantity }}">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            {{-- লজিক: যদি আগে থেকে প্রাইস থাকে সেটা দেখাবে, না থাকলে প্রোডাক্টের বেস প্রাইস দেখাবে --}}
                                            <input type="number" step="0.01" 
                                               name="prices[{{ $detail->id }}]" 
                                               class="form-control price-input" 
                                               value="{{ $detail->unit_price > 0 ? $detail->unit_price : ($detail->product->base_price ?? 0) }}" 
                                               min="0">
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold row-total">
                                        {{ number_format(($detail->unit_price > 0 ? $detail->unit_price : ($detail->product->base_price ?? 0)) * $detail->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                    <td class="text-end fw-bold text-primary" id="modalGrandTotal">0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save me-1"></i> Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    
    // 1. Calculate Totals on Page Load & Input Change
    function calculateTotals() {
        let grandTotal = 0;
        
        $('.price-input').each(function() {
            let price = parseFloat($(this).val()) || 0;
            let qty = parseFloat($(this).closest('tr').find('.qty-hidden').val()) || 0;
            let rowTotal = price * qty;
            
            $(this).closest('tr').find('.row-total').text(rowTotal.toFixed(2));
            grandTotal += rowTotal;
        });

        $('#modalGrandTotal').text(grandTotal.toFixed(2));
    }

    // Run on load to show initial totals
    calculateTotals();

    // Run on input change
    $('.price-input').on('input', function() {
        calculateTotals();
    });

    // 2. Delete Confirmation
    $('#delete-form').on('submit', function(e){
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    });
});
</script>
@endsection