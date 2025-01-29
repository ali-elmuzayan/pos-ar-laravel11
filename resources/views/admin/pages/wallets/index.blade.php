@extends('layouts.admin')

@section('title', 'المحافظ والمعاملات')
@section('main-color', 'info')
@section('prev-link', route('dashboard'))
@section('prev-link-title', 'الصفحة الرئيسية')
@section('content-title', 'المحافظ والمعاملات')
@section('content-page-name', 'المحافظ والمعاملات')

@section('content')



    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title">المحافظ والمعاملات </h5>

                </div>
                <div class="card-body">

                    @if(!empty($wallets))
                        <div class="row">
                            <div class="col-md-6">

                                <ul class="list-group">

                                    <center><p class="list-group-item list-group-item-new_info"><b>المحافظ</b></p></center>
                                    @foreach($wallets as $wallet)
                                        <div class="wallet-card">
                                            <div class="balance" data-wallet-id="{{ $wallet->id }}">E£ {{$wallet->balance}}</div> <!-- Display the balance here -->
                                            <div class="name"><h3>{{$wallet->name}}</h3></div>
                                            <div class="buttons">

                                                @if($wallet->id === 1)

                                                    <form action="{{route('wallets.withdraw-to-main', $wallet->id)}}" method="post" >
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="withdraw btn btn-dark button" >تفريغ الخزنة</button>
                                                    </form>
                                                   @else
                                                <a  data-id="{{$wallet->id}}" class="withdraw btn btn-dark withdrawBtn button"  role="button" >سحب</a>

                                                    @endif
                                                <a  data-id="{{$wallet->id}}" class="deposit btn btn-light text-dark button"  role="button" >ايداع</a>
{{--                                                <button class="create-expense btn btn-dark">انشئ نفقة@if($wallet->id == 1) (@e</button>--}}
                                            </div>
                                        </div>
                                    @endforeach


                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group">
                                    <center><p class="list-group-item list-group-item-secondary"><b>المعاملات الاخيرة</b></p></center>

                                        <table class="table text-center table-bordered table-hover w-100 ">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>المبلغ</th>
                                                <th>المحفظة</th>
                                                <th>العملية</th>
                                                <th>الوصف</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $counter = 1; @endphp
                                            @foreach($walletTransactions as $transaction)
                                                <tr>
                                                    <td>{{$counter++}}</td>
                                                    <td>{{$transaction->amount}}</td>
                                                    <td>{{$transaction->wallet->name}}</td>
{{--                                                    <td class="@if($transaction->type === 'deposit') text-success @else text-danger @endif ">{{$transaction->type}}</td>--}}
                                                    <td><span class="badge @if($transaction->type === 'deposit')badge-success @else badge-danger @endif">{{$transaction->type}}</span></td>
                                                    <td>{{$transaction->description ?? 'بدون وصف'}}</td>
                                                    <

                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>


                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" style="opacity:75%;">
                            عفوا لا يوجد بيانات لعرضها
                        </div>
                    @endif




                </div>


            </div>
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('css/mycustomstyle.css')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("plugins/sweetalert2/sweetalert2.min.css")}}">

@endpush
@push('js')


    {{--    add quantity to the product --}}
    <script>
        $(document).ready(function () {
            $('.withdrawBtn').click(function () {
                var tdh = $(this);
                var id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'سحب قيمة مالية',
                    html:
                        '<input type="number" min="1" style="width:80%;" id="swal-input1" class="swal2-input" placeholder="المبلغ">' +
                        '<textarea id="swal-input2" class="swal2-input" placeholder="الوصف"></textarea>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'سحب',
                    cancelButtonText: 'إلغاء',
                    preConfirm: () => {
                        const amount = Number(document.getElementById('swal-input1').value);
                        const description = document.getElementById('swal-input2').value;

                        // Perform validation
                        if (!amount || amount <= 0) {
                            Swal.showValidationMessage('يجب أن تكون القيمة أكبر من الصفر!');
                            return false; // Prevent dialog from closing
                        }
                        if (!description.trim()) {
                            Swal.showValidationMessage('يجب إدخال وصف!');
                            return false; // Prevent dialog from closing
                        }

                        // If validation passes, return values
                        return [amount, description];
                    }
                }).then((result) => {
                    if (result.value) {
                        const amount = result.value[0];
                        const description = result.value[1];
                        const url = "{{ route('wallets.withdraw', ':id') }}".replace(':id', id);
                        var walletId = this.getAttribute('data-id'); // Get the wallet ID from the clicked button

                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: 'PUT',
                                amount: amount, // Send the quantity to the server
                                description: description // Send the description to the server
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire('تم السحب!', response.message, 'success');
                                    $(`.balance[data-wallet-id="${walletId}"]`).text('E£ ' + response.new_balance);

                                    // Add the new transaction to the table
                                    const newTransaction = `
            <tr>
                <td>${response.transaction.id}</td>
                <td>${response.transaction.amount}</td>
                <td>${response.transaction.wallet_name}</td>
                <td>
                    <span class="badge ${response.transaction.type === 'deposit' ? 'badge-success' : 'badge-danger'}">
                        ${response.transaction.type === 'deposit' ? 'إيداع' : 'سحب'}
                    </span>
                </td>
                <td>${response.transaction.description || 'بدون وصف'}</td>
            </tr>
        `;
                                    // Prepend the new transaction to the table
                                    $('table tbody').prepend(newTransaction);
                                } else {
                                    Swal.fire('خطأ!', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('خطأ!', 'حدث خطأ أثناء الإضافة.', 'error');
                            }
                        });
                    }
                });
            });
        });
        $(document).ready(function () {
            $('.deposit').click(function () {
                var tdh = $(this);
                var id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'إيداع قيمة مالية',
                    html:
                        '<input type="number" min="1" style="width:80%;" id="swal-input1" class="swal2-input" placeholder="المبلغ">' +
                        '<textarea id="swal-input2" class="swal2-input" placeholder="الوصف"></textarea>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'إيداع',
                    cancelButtonText: 'إلغاء',
                    preConfirm: () => {
                        const amount = Number(document.getElementById('swal-input1').value);
                        const description = document.getElementById('swal-input2').value;

                        // Perform validation
                        if (!amount || amount <= 0) {
                            Swal.showValidationMessage('يجب أن تكون القيمة أكبر من الصفر!');
                            return false; // Prevent dialog from closing
                        }
                        if (!description.trim()) {
                            Swal.showValidationMessage('يجب إدخال وصف!');
                            return false; // Prevent dialog from closing
                        }

                        // Return values if validation passes
                        return [amount, description];
                    }
                }).then((result) => {
                    if (result.value) {
                        const amount = result.value[0];
                        const description = result.value[1];
                        const url = "{{ route('wallets.deposit', ':id') }}".replace(':id', id);
                        var walletId = this.getAttribute('data-id'); // Get the wallet ID from the clicked button

console.log(walletId)
                        // AJAX request
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: 'PUT',
                                amount: amount,
                                description: description
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('تم الايداع!', response.message, 'success');
                                    $(`.balance[data-wallet-id="${walletId}"]`).text('E£ ' + response.new_balance);
                                    // Add the new transaction to the table
                                    const newTransaction = `
            <tr>
                <td>${response.transaction.id}</td>
                <td>${response.transaction.amount}</td>
                <td>${response.transaction.wallet_name}</td>
                <td>
                    <span class="badge ${response.transaction.type === 'deposit' ? 'badge-success' : 'badge-danger'}">
                        ${response.transaction.type === 'deposit' ? 'إيداع' : 'سحب'}
                    </span>
                </td>
                <td>${response.transaction.description || 'بدون وصف'}</td>
            </tr>
        `;
                                    // Prepend the new transaction to the table
                                    $('table tbody').prepend(newTransaction);
                                } else {
                                    Swal.fire('خطأ!', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('خطأ!', 'حدث خطأ أثناء الإضافة.', 'error');
                            }
                        });
                    }
                });
            });
        });

    </script>
    <script>
        const walletUrl = "{{ route('wallets.transactions', ':id') }}";
    </script>


    <script src="{{asset('js/ajax/wallets.js')}}"></script>
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    @endpush
