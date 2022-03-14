@if (count($meetings) > 0)
    <table class="list-container table table-striped table-sm table-bordered">
        <thead>
            <tr>
                @userPermission("2")
                <th>Kim Eklemiş</th>
                @enduserPermission
                <th>Tarihi</th>
                <th>Saat</th>
                <th>Not</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($meetings as $meeting)
                <tr id="row_{{ $meeting->id }}">
                    @userPermission("2")
                    <td>{{ Auth::user()->id == $meeting->user->id ? '(Benim)' : $meeting->user->full_name }}
                    </td>
                    @enduserPermission
                    <td>
                        {{ format_date($meeting->date) }}
                    </td>
                    <td>{{ $meeting->time }}</td>
                    <td style="max-width:400px;">
                        {{ $meeting->description }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@else
    <h6 class="text-danger">Herhangi bir görüşme yok.</h6>
@endif
