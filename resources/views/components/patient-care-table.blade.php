@props(['label', 'datas' => null])
<div class="container mt-2 table-container ml-sm-2">   
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-secondary">{{ $label }}</h5>
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <table id="reports-table" class="table table-hover table-striped table-borderless">
        <thead class="rounded-top">
            <tr>
                <th scope="col" class="p-3 rounded-start bg-primary text-white">Patient</th>
                <th scope="col" class="p-3 bg-primary text-white">Case</th>
                <th scope="col" class="p-3 bg-primary text-white">Responder</th>
                <th scope="col" class="p-3 rounded-end bg-primary text-white">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($datas as $data)
                <tr>
                    <td class="p-3 rounded-start">{{ $data->patientName }}</td>
                    <td class="p-3">{{ $data->patientCareCase->description }}</td>
                    <td class="p-3">{{ $data->recordedBy }}</td>
                    <td class="p-3 rounded-end">
                        <a class="btn btn-sm btn-success text-white" href="{{ route('patient_care.show', ['id' => $data->patientCareID]) }}">
                            <i class="bi bi-eye-fill"></i>
                            <span class="d-none d-sm-inline">View</span>
                        </a>
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
        paginateTable('reports-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "reports-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "reports-table");
    });
</script>

