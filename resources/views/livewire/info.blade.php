<ul wire:poll.33s class="pagination justify-content-center">
    <li class="page-item">
        <a class="page-link1" href="{{ route('menu','ManagemenUser') }}">
            <i class="fas fa-fw fa-user"></i>
            @if (auth()->user()->role_id == 1)
            <span class="badge badge-danger badge-counter"
                style="padding: .15em .15em; margin: -7px; font-size: .6em;">{{$infouser}}</span>
            @endif
        </a>
    </li>
    <li class="page-item">
        <a href="#" class="page-link1" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-power-off"></i>
        </a>
    </li>
</ul>