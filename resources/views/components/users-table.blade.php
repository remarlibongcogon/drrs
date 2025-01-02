@props(['label', 'datas' => null])
<div class="container mt-2 table-container p-2">   
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-secondary">{{ $label }}</h5>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <div class="table-responsive">
        <table id="users-table" class="display table table-hover table-striped table-borderless data-table">
            <thead class="rounded-top">
                <tr>
                    <th scope="col" class="p-3 rounded-start bg-primary text-white">ID</th>
                    <th scope="col" class="p-3 bg-primary text-white">Name</th>
                    <th scope="col" class="p-3 bg-primary text-white d-none d-sm-table-cell">Role</th>
                    <th scope="col" class="p-3 bg-primary text-white">Status</th>
                    <th scope="col" class="p-3 rounded-end bg-primary text-white">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($datas as $data)
                    <tr>
                        <td class="p-3 rounded-start">{{ $data->id }}</td>
                        <td class="p-3">{{ $data->firstname }} {{ $data->lastname }}</td>
                        <td class="p-3 d-none d-sm-table-cell">{{ $data->role_relation->description }}</td>
                        <td class="p-3"><small class="badge rounded-pill text-bg-success">{{ $data->status ? 'Active' : '' }}</small></td>
                        <td class="p-3 rounded-end">
                            <a class="btn btn-sm btn-secondary text-white" href="{{ route('users.details', ['id' => $data->id]) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('users.disable', ['id' => $data->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger my-2">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span class="d-none d-sm-inline">Disable</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="pagination-container">
        <ul class="pagination justify-content-end" id="pagination"></ul>
    </nav>
</div>

<script src="{{ asset('js/searchbox-table.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
 {{-- for pagination --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('users-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "users-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "users-table");
    });
</script>
