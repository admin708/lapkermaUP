<div class="">

  @if ($year && $fakultas)
  @php
    
     $totalProdiSpesialis = $this->getProdi->whereIn('jenjang',['spesialis 1','spesialis 2'])->count();
  @endphp
 
  @if ($totalProdiSpesialis)
      @include('livewire.dashboard-chart._table_spesialis')
  @endif
  @endif
  
</div>
