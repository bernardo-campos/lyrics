<table id="artists" class="table table-sm w-100">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('headers.name') }}</th>
        <th>{{ __('headers.albums') }}</th>
        <th>{{ __('headers.songs') }}</th>
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
        ajax: {
            url: '{{ route('artists.index') }}',
            error: function (xhr, error, thrown) {
                var errorMessage = "{{ __('datatable.error') }}";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#artists_processing').hide();
                alert(errorMessage);
            }
        },
        search: {
            return: true,
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'albums_count', name: 'albums_count', searchable: false },
            { data: 'songs_count', name: 'songs_count', searchable: false },
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        return `
                        <div class="d-flex">
                        <a title="{{ __('Albums') }}" href="${row.urls.albums}" class="btn btn-sm btn-primary py-0 px-1"><i class="fas fa-compact-disc"></i></a>
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
