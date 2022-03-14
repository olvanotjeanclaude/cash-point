<div class="card">
    <div class="card-body">
        <div class="text-center loading-table">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="table-responsive">
            <table id="datatable-buttons" class="list-container table-sm table table-striped table-bordered"
                style="">
                <thead>
                    <tr>
                        @foreach ($head as $item)
                            <th scope="col">{{ $item }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
