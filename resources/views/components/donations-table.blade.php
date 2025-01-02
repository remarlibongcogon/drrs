@props(['label', 'datas' => null, 'type'])
<div class="container mt-2 table-container"> 
    <div class="mb-1 d-flex justify-content-between">
        <h5 class="p-1 text-secondary">{{ $label }}</h5>
        <!-- <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">   -->
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <thead class="rounded-top">
                <tr>
                    <th scope="col" class="p-3 rounded-start bg-primary text-white">Date</th>
                    <th scope="col" class="p-3 bg-primary text-white">Name</th>
                    <th scope="col" class="p-3 bg-primary text-white">ContactNo</th>
                    @if($type == 1 || $type == 3)
                        <th scope="col" class="p-3 bg-primary text-white">Amount</th>
                    @endif
                    @if($type == 2)
                        <th scope="col" class="p-3 bg-primary text-white">Definition</th>
                    @endif
                    @if($type == 3 || $type == 2)
                        <th scope="col" class="p-3 bg-primary text-white">Proof of Donation</th>
                    @endif
                    <th scope="col" class="p-3 bg-primary text-white">Mode</th>
                    <th scope="col" class="p-3 bg-primary text-white">Status</th>
                    <th scope="col" class="p-3 rounded-end bg-primary text-white">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                {{-- @foreach($datas as $data) --}}
                @foreach($datas as $index => $data)
                    <tr>
                        <td class="p-3 rounded-start">
                            {{ \Carbon\Carbon::parse($data['created_at'])->format('M d, Y') }}
                        </td>
                        <td class="p-3">{{ $data['fullname'] }}</td>
                        <td class="p-3">{{ $data['contactno'] }}</td>
                        @if($type == 1 || $type == 3)
                            <td class="p-3">{{ $data['amount'] }}</td>
                        @endif
                        @if($type == 2)
                            <td class="p-3">{{ $data['definition'] }}</td>
                        @endif
                        
                        @if($type == 3 || $type == 2)
                            <td class="p-3">
                                {{$data['proof_of_donation']}}
                                &nbsp;
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewImageModal{{ $index }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>

                            <!-- Image Modal -->
                            <div class="modal fade" id="viewImageModal{{ $index }}" tabindex="-1" aria-labelledby="viewImageModalLabel{{ $index }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewImageModalLabel{{ $index }}">Proof of Donation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $data['proof_of_donation']) }}" class="img-fluid" alt="Proof of Donation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <td class="p-3">{{ $data['donationModeDesc'] }}</td>
                        <td class="p-3">{{ $data['isPickUp'] == 0 ? 'Pending' : 'Received' }}</td>
                        <td class="p-3 rounded-end">
                            <a class="btn btn-sm btn-success text-white @if($data['isPickUp'] == 1 && Auth::user()->role == 3) disabled @endif" 
                                href="#" 
                                onclick="submitPickupForm({{ $data['donationID'] }}, {{ $type }});">
                                <i class="bi bi-check-circle"></i>
                             </a>
                    
                            <a class="btn btn-sm btn-warning text-white" 
                                href="{{ route('print.donation', ['type' => $type, 'id' => $data['donationID']]) }}">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{-- <nav class="pagination-container">
        <ul class="pagination justify-content-end" id="pagination"></ul>
    </nav> --}}
</div>

