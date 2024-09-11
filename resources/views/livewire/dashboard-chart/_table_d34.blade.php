@php
    $totalIntD34= 0;
    $totalLokD34 = 0;
    $totalProdiIntD34 = 0;
    $totalProdiLokD34 = 0;
    $totalProdiKerjasamaD34 = 0;
@endphp
<div id="top-categories" class="top-cat-area" style="padding-bottom: 70px">
    <div class="container">
        <h3>JENJANG D3 & D4</h3>
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
                         
                          @foreach ($getProdi->whereIn('jenjang',['diploma 3','diploma 4']) as $item)
                            @php
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
                                @if ($item->jenjang == 'diploma 3')
                                    D3
                                @elseif ($item->jenjang == 'diploma 4')
                                    D4
                                @endif
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 2) as $moaInt)
                                  @if ($year)
                                      @if (substr($moaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count++;
                                              $totalIntD34++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count++;
                                        $totalIntD34++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 2) as $iaInt)
                                  @if ($year)
                                      @if (substr($iaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count2++;
                                              $totalIntD34++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count2++;
                                        $totalIntD34++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{$count+$count2}}
                                @php
                                    if ($count+$count2 != 0) {
                                      $totalProdiIntD34++;
                                    }
                                @endphp
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 1) as $moa)
                                  @if ($year)
                                      @if (substr($moa->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count3++;
                                              $totalLokD34++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count3++;
                                        $totalLokD34++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 1) as $ia)
                                  @if ($year)
                                      @if (substr($ia->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count4++;
                                              $totalLokD34++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count4++;
                                        $totalLokD34++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{$count3+$count4}}
                                @php
                                    if ($count3+$count4 != 0) {
                                      $totalProdiLokD34++;
                                    }
                                @endphp
                              </td>
                              @if ($count+$count2+$count3+$count4 != 0)
                                  @php
                                      $totalProdiKerjasamaD34++;
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
                                <td width="13%">{{$totalIntD34}}</td>
                                <td width="13%">{{$totalLokD34}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">
                                    Total Prodi yang memiliki Kerjasama
                                </td>
                                <td width="13%">{{$totalProdiIntD34}}</td>
                                <td width="13%">{{$totalProdiLokD34}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi D3/D4</td>
                                <td colspan="2"> {{$totalProdiD34}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi D3/D4 yang Memiliki Kerjasama</td>
                                <td colspan="2">{{$totalProdiKerjasamaD34}} / {{$totalProdiD34}} = {{round($totalProdiKerjasamaD34/$totalProdiD34*100)}}%</td>
                              </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">1. Luar Negeri</td>
                                <td colspan="2">{{$totalProdiIntD34}} / {{$totalProdiD34}} = {{round($totalProdiIntD34/$totalProdiD34*100)}}%</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">2. Dalam Negeri</td>
                                <td colspan="2">{{$totalProdiLokD34}} / {{$totalProdiD34}} = {{round($totalProdiLokD34/$totalProdiD34*100)}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>