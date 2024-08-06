@extends('adminlte::page')
@section('plugins.Vue3', true)

@section('title', config('app.name'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">Advanced search</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<div id="app">
    <div v-if="loadingVue">{{ __('Rendering webpage...') }}</div>

    <div>
        <div class="form-group">
            <label for="query">Find</label>
            <input
                v-model="query"
                class="form-control"
                placeholder="Enter search term"
                type="text">
        </div>

        <div class="form-group">
            <label for="artists">Artists</label>
            <select class="form-control" id="artists" v-model="artists" multiple>
                <option value="">Select artist</option>
                <option value="1">Artist 1</option>
                <option value="2">Artist 2</option>
                <option value="3">Artist 3</option>
            </select>
        </div>

        <div class="form-group">
            <label for="albums">Albums</label>
            <select class="form-control" id="albums" v-model="albums" multiple>
                <option value="">Select album</option>
                <option value="1">Album 1</option>
                <option value="2">Album 2</option>
                <option value="3">Album 3</option>
            </select>
        </div>

        <div class="icheck-primary ml-2">
            <input class="form-check-input" type="checkbox" id="exactSearch" v-model="exactSearch">
            <label class="form-check-label" for="exactSearch">Exact search</label>
        </div>

        <button class="btn btn-primary" @click="fetchData">Search</button>
    </div>

    <table>
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Lyric</th>
        </thead>
        <tbody>
            <tr v-for="row in results">
                <td v-text="row.id"></td>
                <td v-text="row.name"></td>
                <td v-text="row.lyric"></td>
            </tr>
        </tbody>
    </table>


</div>
@stop

@push('js')
<script>
const { createApp } = Vue

const app = createApp({
    data() {
        return {
            loadingVue: true,
            loading: false,
            results: [],
            query: '',
            artists: [],
            albums: [],
            exactSearch: false,
            params: {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            }
        }
    },
    computed: {
        url() {
            const url = "{{ route('search.index') }}";

            const query = encodeURIComponent(this.query);
            const artists = this.artists.join(',');
            const albums = this.albums.join(',');

            const params = new URLSearchParams();
            params.append('query', query);
            params.append('artists', artists);
            params.append('albums', albums);

            return `${url}?${params.toString()}`;
        }
    },
    methods: {
        async fetchData() {
            console.log(this.albums)
            console.log(this.artists)
            console.log(this.url)
            this.loading = true;
            try {
                const response = await fetch(this.url, this.params);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.results = data; // Assign the results to the variable
                console.log(this.results)
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.loadingVue = false;
    }
});

app.mount("#app");

</script>
@endpush

@push('css')
<style>
[v-cloak] {
  display: none;
}
</style>
@endpush