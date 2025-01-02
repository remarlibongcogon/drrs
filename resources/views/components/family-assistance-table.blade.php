@props(['label', 'datas' => null])
<div class="container mt-2 table-container">   
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-secondary">{{ $label }}</h5>
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">  
    </div>
    <div class="table-responsive">
        <table id="assistance-table" class="table table-hover table-borderless">
            <thead class="rounded-top">
                <tr>
                    <th scope="col" class="p-3 rounded-start bg-primary text-white">Date</th>
                    <th scope="col" class="p-3 bg-primary text-white">Name</th>
                    <th scope="col" class="p-3 bg-primary text-white">Contact No.</th>
                    <th scope="col" class="p-3 bg-primary text-white d-none d-sm-table-cell" style="display:none">Municipality</th>
                    <th scope="col" class="p-3 rounded-end bg-primary text-white">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($datas as $data)
                    <tr>
                        <td class="p-3 rounded-start">
                            <!-- Carbon is used since date's data type is not 'timestamp' -->
                            {{ \Carbon\Carbon::parse($data['created_at'])->format('M d, Y') }}
                        </td>
                        <td class="p-3">{{ $data['last_name'] . ', ' . $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['suffix'] }}</td>
                        <td class="p-3">{{ $data['primary_contact_no'] }}</td>
                        <td class="p-3 d-none d-sm-table-cell">{{ $data['city_municipality'] }}</td>
                        <td class="p-3 rounded-end">
                            <a class="btn btn-sm btn-warning text-white" href="{{ route('family.assistance.record', ['id' => $data['id']]) }}">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a class="btn btn-sm btn-success text-white" href="{{ route('family.assistance.view.update', ['id' => $data['id']]) }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
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

@section('js')
<script src="{{ asset('js/searchbox-table.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>
 {{-- for pagination --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($datas); 
        paginateTable('assistance-table', data, 5);
        document.getElementById("searchInput").addEventListener("input", function() {
            searchTable("searchInput", "assistance-table");
        });
    });
</script>
 {{-- for searchbox --}}
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchTable("searchInput", "assistance-table");
    });
</script>
@endsection
