<table id="artists" class="table table-sm">
<thead>
    <tr>
        <th style="width: 10px">Id</th>
        <th>{{ __('Name') }}</th>
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
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
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

@push('css')
<style type="text/css">
    #artists {
        width: 100%!important;
    }
    div#albums_processing:before {
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