<div class="card">
    <div class="card-body">
        <div class="text-center loading-table">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <h4 class="card-title mb-4">Les 10 derniers retrait</h4>
        <div class="table-responsive">
            <table class="table table-hover table-centered table-sm table-nowrap mb-0">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Heure</th>
                        <th scope="col">Client</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Status</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withDraws as $transaction)
                        <tr class="">
                            <td class="align-middle">{{ format_date($transaction->added_at) }}</td>
                            <td class="align-middle">{{ $transaction->time }}</td>
                            <td class="align-middle">{{ $transaction->recipient_number }}</td>
                            <td class="align-middle">{{ $transaction->amount }} Ar</td>
                            <td class="align-middle">{!! getBadgeStatus('Transaction', $transaction->status) !!}</td>
                            <td class="align-middle">
                                <a href="#" class="btn btn-sm btn-warning">
                                    <i class="fas fa-show"></i>
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
