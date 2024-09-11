@php
    $totalIntSpesialis= 0;
    $totalLokSpesialis = 0;
    $totalProdiIntSpesialis = 0;
    $totalProdiLokSpesialis = 0;
    $totalProdiKerjasamaSpesialis = 0;
@endphp
<div id="top-categories" class="top-cat-area" style="padding-bottom: 70px">
    <div class="container">
        <h3>JENJANG SPESIALIS</h3>
        <div class="row">
            <div class="top-cat-items">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PROGRAM STUDI</th>
                                <th>FAKULTAS</th>
                                <th>JENJANG</th>
                                <th>LUAR NEGERI (1)</th>
                                <th>DALAM NEGERI (0,5)</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($getProdi->whereIn('jenjang',['spesialis 1','spesialis 2'])) --}}
                          @foreach ($getProdi->whereIn('jenjang',['spesialis 1','spesialis 2']) as $item)
                            @php

                            // dd($getProdi->whereIn('jenjang','LIKE', ['spesialis 1','spesialis 2']));
                                $count = 0;
                                $count2 = 0;
                                $count3 = 0;
                                $count4 = 0;
                            @endphp
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$item->nama_resmi}}</td>
                              <td>{{$item->fakultas->nama_fakultas}}</td>
                              <td class="text-uppercase" width="13%">
                                SPESIALIS
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 2) as $moaInt)
                                  @if ($year)
                                      @if (substr($moaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count++;
                                              $totalIntSpesialis++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count++;
                                        $totalIntSpesialis++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 2) as $iaInt)
                                  @if ($year)
                                      @if (substr($iaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count2++;
                                              $totalIntSpesialis++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count2++;
                                        $totalIntSpesialis++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{$count+$count2}}
                                @php
                                    if ($count+$count2 != 0) {
                                      $totalProdiIntSpesialis++;
                                    }
                                @endphp
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 1) as $moa)
                                  @if ($year)
                                      @if (substr($moa->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count3++;
                                              $totalLokSpesialis++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count3++;
                                        $totalLokSpesialis++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 1) as $ia)
                                  @if ($year)
                                      @if (substr($ia->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count4++;
                                              $totalLokSpesialis++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count4++;
                                        $totalLokSpesialis++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{-- {{$count3}}-{{$count4}} --}}

                                {{$count3+$count4}}
                                @php
                                    if ($count3+$count4 != 0) {
                                      $totalProdiLokSpesialis++;
                                    }
                                @endphp
                              </td>
                              @if ($count+$count2+$count3+$count4 != 0)
                                  @php
                                      $totalProdiKerjasamaSpesialis++;
                                  @endphp
                              @endif
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tbody>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">
                                    Total Dokumen Kerjasama
                                </td>
                                <td width="13%">{{$totalIntSpesialis}}</td>
                                <td width="13%">{{$totalLokSpesialis}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">
                                    Total Prodi yang memiliki Kerjasama
                                </td>
                                <td width="13%">{{$totalProdiIntSpesialis}}</td>
                                <td width="13%">{{$totalProdiLokSpesialis}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi Spesialis</td>
                                <td colspan="2"> {{$totalProdiSpesialis}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi Spesialis yang Memiliki Kerjasama</td>
                                <td colspan="2">{{$totalProdiKerjasamaSpesialis}} / {{$totalProdiSpesialis}} = {{round($totalProdiKerjasamaSpesialis/$totalProdiSpesialis*100)}}%</td>
                              </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">1. Luar Negeri</td>
                                <td colspan="2">{{$totalProdiIntSpesialis}} / {{$totalProdiSpesialis}} = {{round($totalProdiIntSpesialis/$totalProdiSpesialis*100)}}%</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">2. Dalam Negeri</td>
                                <td colspan="2">{{$totalProdiLokSpesialis}} / {{$totalProdiSpesialis}} = {{round($totalProdiLokSpesialis/$totalProdiSpesialis*100)}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>