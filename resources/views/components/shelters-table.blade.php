@props(['label', 'datas' => null])
<div class="container mt-2 table-container">   
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-primary">{{ $label }}</h5>
            <input type="text" id="searchInput-shelter" class="form-control w-25" placeholder="Search...">  
    </div>
    <table id="shelters-table" class="table table-striped table-hover table-borderless">
        <thead class="rounded-top">
            <tr>
                <th scope="col" class="p-3 rounded-start bg-primary text-white">Name</th>
                <th scope="col" class="p-3 bg-primary text-white">Created At</th>
                <th scope="col" class="p-3 rounded-end bg-primary text-white">Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($datas as $data)
                <tr>
                    <td class="p-3 rounded-start">{{ $data->shelterName }}</td>
                    <td class="p-3">{{ $data->created_at->diffForHumans() }}</td>
                    <td class="p-3 rounded-end">
                        <a class="btn btn-sm btn-secondary text-white" href="{{ route('shelter.edit', ['id' => $data->shelterID]) }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('shelter.delete', ['id' => $data->shelterID]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-exclamation-circle"></i>
                                <span class="d-none d-sm-inline">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <nav class="pagination-container">
        <ul class="pagination justify-content-end" id="pagination-shelter"></ul>
    </nav>
</div>

@section('js')
<script src="{{ asset('js/searchbox-table.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
 {{-- for pagination --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('shelters-table', data, 5, 'pagination-shelter');
        document.getElementById("searchInput-shelter").addEventListener("input", function() {
            searchTable("searchInput-shelter", "shelters-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput-shelter").addEventListener("input", function() {
        searchTable("searchInput-shelter", "shelters-table");
    });
</script>
@endsection
