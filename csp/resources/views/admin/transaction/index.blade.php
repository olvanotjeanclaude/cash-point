@extends('layouts.app')

@section('title')
    Liste des transactions
@endsection

@section('css')
    <x-datatable-css-link />
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Transactions',
        'pageDescription' => 'Les transactions enregistrés dans le système sont répertoriés ici',
        'action' => 'Nouveu',
        'icon' => 'fas fa-plus',
        'link' => '#',
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center loading-table">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-hover table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Opérateur</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr class="">
                                        <td class="align-middle">{{ format_date($transaction->added_at) }}</td>
                                        <td class="align-middle">{{ $transaction->time }}</td>
                                        <td class="align-middle text-uppercase">{{ $transaction->type }}</td>
                                        <td class="align-middle">{{ $transaction->recipient_number }}</td>
                                        <td class="align-middle">{{ $transaction->amount }} Ar</td>
                                        <td class="align-middle">{{ $transaction->operator }}</td>
                                        <td class="align-middle">{!! getBadgeStatus('Transaction', $transaction->status) !!}</td>
                                        <td class="align-middle">
                                            <a href="#" class="btn btn-sm btn-warning">
                                                <i class="fas fa-show"></i>
                                                Voir
                                            </a>
                                            <a href="#" class="btn btn-sm btn-success">
                                                <i class="fas fa-edit mr-2"></i>
                                                Editer
                                            </a>
                                            <button data-id="#" data-url="#"
                                                class="btn btn-sm btn-danger remove-btn">
                                                <i class="fas fa-minus mr-2"></i>
                                                Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('script')
    <x-datatable-js-link />
@endsection
