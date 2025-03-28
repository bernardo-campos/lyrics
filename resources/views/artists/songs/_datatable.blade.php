<table id="songs" class="table table-sm table-hover dt-responsive w-100">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('headers.album') }}</th>
        <th>{{ __('headers.title') }}</th>
        <th></th>
    </tr>
</thead>
<tbody></tbody>
</table>

@push('js')
<script type="text/javascript">
$(document).ready(function () {

    var dt = $('#songs').DataTable({
        language: {
            url: "{{ __('datatable.i18n') }}"
        },
        ajax: {
            url: '{{ route('artists.songs.index', $artist) }}',
            error: function (xhr, error, thrown) {
                var errorMessage = "{{ __('datatable.error') }}";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#songs_processing').hide();
                alert(errorMessage);
            }
        },
        processing: true,
        search: {
            return: true,
        },
        serverSide: true,
        stateSave: true,
        columns: [
            { data: 'id', name: 'id', searchable: true},
            { data: 'album.name', name: 'album.name', searchable: true},
            { data: 'name', name: 'name', searchable: true},
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        return `
                        <div class="d-flex">
                            <a title="{{ __('Show') }}" href="${row.urls.show}" class="btn btn-sm btn-warning py-0 px-1"><i class="fa fa-eye"></i></a>
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
