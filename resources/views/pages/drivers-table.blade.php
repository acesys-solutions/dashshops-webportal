<div class="table-responsive">
    <table class="table table-flush" id="drivers-list">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>email</th>
                <th>Phone Number</th>
                <th>Acceptance Rating</th>
                <th>Current Location</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers ?? [] as $p)
            <div id="driver_profile_{{$p->id}}" style="display:none">{{json_encode($p)}}</div>
            <tr>
                <td class=" text-sm" style="word-wrap: break-word;">
                    <div class="d-flex">

                        <img class="w-10 ms-3" style="max-width:40px; height: 40px; object-fit: cover;" src="{{\App::make('url')->to('images/'.$p->user->photo)}}" alt="">
                        <h6 class="ms-3 my-auto" style="font-size: 10pt;">{{$p->user->firstname}} {{$p->user->lastname}}</h6>
                    </div>
                </td>
                <td class="text-sm">
                    {{$p->user->email}}

                </td>
                <td class="text-sm">
                    {{$p->user->phone_number}}

                </td>
                <?php
                if ($p->acceptance_rating['count'] == 0) {
                    $rating = "0%";
                } else {
                    $rating = round(($p->acceptance_rating['total'] / $p->acceptance_rating['count']) * 100, 1) . "%";
                }
                ?>
                <td class="text-sm">{{$rating}}</td>
                <td class="text-sm">
                    @if($p->current_location)
                    <i class="fa-solid fa-location-dot"></i> {{$p->current_location['city']}}, {{$p->current_location['state']}}
                    @endif
                </td>
                <td>
                    @if($p->approval_status == "Approved")
                    <span class="badge badge-success badge-sm m-1">Approved</span>
                    @elseif($p->approval_status == "Denied")
                    <span class="badge badge-danger badge-sm m-1">Denied</span>
                    @else
                    <span class="badge badge-warning badge-sm m-1">Pending</span>
                    @endif
                </td>
                <td class="text-sm">

                    <a href="javascript:;" onclick="showModal('{{$p->id}}')" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="View Driver">
                        <i class="fas fa-eye text-secondary"></i>
                    </a>
                    <a href="javascript:;" onclick="approveDriver('{{$p->id}}','')" data-bs-toggle="tooltip" data-bs-original-title="Approve product">
                        <i class="fas fa-thumbs-up text-success"></i>
                    </a>
                    <a href="javascript:;" onclick="denyDriver('{{$p->id}}','')" data-bs-toggle="tooltip" data-bs-original-title="Deny product">
                        <i class="fas fa-thumbs-down text-danger"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>