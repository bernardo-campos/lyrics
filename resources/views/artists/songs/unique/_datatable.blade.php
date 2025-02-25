<table id="songs" class="table table-sm dt-responsive table-hover w-100">
<thead>
    <tr>
        <th>{{ __('headers.title') }}</th>
        <th>{{ __('headers.count') }}</th>
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
            url: '{{ route('artists.songs.unique.index', $artist) }}',
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
            { data: 'name', name: 'name', searchable: true},
            { data: 'count', name: 'count', searchable: false},
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    if (type === 'display') {

                        let btnShow = row.urls?.show
                            ? `<a title="{{ __('Show') }}" href="${row.urls.show}" class="btn btn-sm btn-warning py-0 px-1"><i class="fa fa-eye"></i></a>`
                            : '';

                        return `<div class="d-flex">${btnShow}</div>`;
                    }
                }
            },
        ]
    });
});
</script>
@endpush
