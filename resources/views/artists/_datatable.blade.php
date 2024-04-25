<table id="artists" class="table table-sm w-100">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('headers.name') }}</th>
        <th>{{ __('headers.albums') }}</th>
        <th></th>
    </tr>
</thead>
<tbody></tbody>
</table>

@push('js')
<script type="text/javascript">
$(document).ready(function () {

    var dt = $('#artists').DataTable({
        language: {
            url: "{{ __('datatable.i18n') }}"
        },
        stateSave: true,
        processing: true,
        serverSide: true,
        ajax: '{{ route('artists.index') }}',
        search: {
            return: true,
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'albums_count', name: 'albums_count', searchable: false },
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        return `
                        <div class="d-flex">
                        </div>`
                        ;
                    }
                }
            },
        ]
    });
});
</script>
@endpush
