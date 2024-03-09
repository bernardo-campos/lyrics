<table id="songs" class="table table-sm dt-responsive">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('Artist') }}</th>
        <th>{{ __('Album') }}</th>
        <th>{{ __('Ttitle') }}</th>
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
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        ajax: '{{ route('songs.index') }}',
        processing: true,
        search: {
            return: true,
        },
        serverSide: true,
        stateSave: true,
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'album.artist.name', name: 'album.artist.name', searchable: false},
            { data: 'album.name', name: 'album.name', searchable: false},
            { data: 'name', name: 'name', searchable: false},
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

@push('css')
<style type="text/css">
    #songs {
        width: 100%!important;
    }
    mark,.mark {
        padding: 0;
        background-color: #b4ff00;
    }
    div#songs_processing:before {
        content: '';
        display: block;
        cursor: progress;
        background-color: #ffffff85;
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
</style>
@endpush