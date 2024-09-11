@if ($PIN == 'index')
    @include('Pages.IndexAdmin')
@elseif ($PIN == 'dashboard')
    @include('Pages.DashboardAdmin')
@elseif ($PIN == 'InputDataTables')
    @include('Pages.InputDataTables')
@elseif ($PIN == 'editData')
    @include('Pages.EditDataTables')
@endif
