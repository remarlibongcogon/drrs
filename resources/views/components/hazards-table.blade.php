@props(['label', 'datas' => null])
<div class="container mt-2 table-container">   
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-primary">{{ $label }}</h5>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <table id="hazards-table" class="table table-hover table-striped table-borderless">
        <thead class="rounded-top">
            <tr>
                <th scope="col" class="p-3 rounded-start bg-primary text-white">Name</th>
                <th scope="col" class="p-3 bg-primary text-white">Status</th>
                <th scope="col" class="p-3 rounded-end bg-primary text-white">Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($datas as $data)
                <tr>
                    <td class="p-3 rounded-start">{{ $data->hazardName }}</td>
                    <td class="p-3">
                        <small class="badge rounded-pill {{ $data->hazardStatus == 1 ? 'bg-success' : 'bg-danger'}}">
                            {{ $data->hazard_status->description }}
                        </small> 
                    </td>
                    <td class="p-3 rounded-end">
                        <a class="btn btn-sm btn-secondary text-white" href="{{ route('hazard_map.edit', ['id' => $data->hazardID]) }}">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('hazard_map.disable', ['id' => $data->hazardID]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-exclamation-circle"></i>
                                <span class="d-none d-sm-inline">Disable</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
        paginateTable('hazards-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "hazards-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "hazards-table");
    });
</script>