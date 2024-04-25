<table id="albums" class="table table-sm w-100">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('headers.year') }}</th>
        <th>{{ __('headers.artist') }}</th>
        <th>{{ __('headers.name') }}</th>
        <th>{{ __('headers.image') }}</th>
        <th>{{ __('headers.songs') }}</th>
        <th></th>
    </tr>
</thead>
<tbody></tbody>
</table>

<x-adminlte-modal id="modalImg" title="" class="text-center" size="lg">
    <div class="row">
        <div class="col-12">
            <h2><span id="albumname"></span> (<span id="albumyear"></span>)</h2>
            <figure>
                <image id="img" class="img-fluid" src=""></image>
            </figure>
        </div>
    </div>
</x-adminlte-modal>

@push('js')
<script type="text/javascript">
$('#modalImg').on('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = $(event.relatedTarget)

    // Extract info from data-* attributes
    var imageurl = button.data('imageurl');
    var albumname = button.data('albumname');
    var albumyear = button.data('albumyear');

    var modal = $(this)
    modal.find('#img').attr('src', imageurl)
    modal.find('#albumname').text(albumname)
    modal.find('#albumyear').text(albumyear )
})
</script>
@endpush

@push('js')
<script type="text/javascript">
$(document).ready(function () {

    var dt = $('#albums').DataTable({
        language: {
            url: "{{ __('datatable.i18n') }}"
        },
        stateSave: true,
        processing: true,
        serverSide: true,
        ajax: '{{ route('albums.index') }}',
        search: {
            return: true,
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'year', name: 'year' },
            { data: 'artist.name', name: 'artist.name' },
            { data: 'name', name: 'name' },
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    if (type === 'display' && row?.image?.url) {
                        return `
                        <button
                            class="btn btn-xs btn-primary"
                            data-toggle="modal"
                            data-target="#modalImg"
                            data-imageurl="${row.image.url}"
                            data-albumname="${row.name}"
                            data-albumyear="${row.year}"
                        >
                        {{ __('Show') }}
                        </button>`
                        ;
                    }
                }
            },
            { data: 'songs_count', name: 'songs_count', searchable: false },
            {
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    console.log({type, row})
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
