<div>
    <script>
        window.addEventListener('refresh-page', event => {
            window.location.reload(true);
        })
    </script>
    <div class="card">
        <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap mt-3">

                <table class="table table-bordered table-hover table-sm text-start mt-2" style="font-size: 13px">
                    <thead>
                        <tr>
                            <th>User Request</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userRequestList as $userRequest)
                            <tr>
                                <td>{{ $userRequest->name }}</td>
                                <td>{{ $userRequest->email }}</td>
                                <td>
                                    <button class="btn btn-primary"
                                        wire:click="requestAccepted({{ $userRequest->id }}, '{{ $userRequest->email }}')">
                                        <span wire:loading wire:target="requestAccepted"
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span wire:loading.remove wire:target="requestAccepted">Accept</span></button>

                                    <button class="btn btn-outline-primary"
                                        wire:click="requestDenied({{ $userRequest->id }}, '{{ $userRequest->email }}')">
                                        <span wire:loading wire:target="requestDenied"
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span wire:loading.remove wire:target="requestDenied">Decline</span></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
