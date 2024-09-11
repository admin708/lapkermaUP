@php
    $totalIntS2= 0;
    $totalLokS2 = 0;
    $totalProdiIntS2 = 0;
    $totalProdiLokS2 = 0;
    $totalProdiKerjasamaS2 = 0;
@endphp
<div id="top-categories" class="top-cat-area" style="padding-bottom: 70px">
    <div class="container">
        <h3>JENJANG MAGISTER & DOKTOR (S2 & S3)</h3>
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
                         
                          @foreach ($getProdi->whereIn('jenjang',['magister','doktor'])->sortByDesc('jenjang') as $item)
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
                                {{$item->jenjang == 'magister' ? 'S2':'S3'}}
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 2) as $moaInt)
                                  @if ($year)
                                      @if (substr($moaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count++;
                                              $totalIntS2++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count++;
                                        $totalIntS2++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 2) as $iaInt)
                                  @if ($year)
                                      @if (substr($iaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count2++;
                                              $totalIntS2++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count2++;
                                        $totalIntS2++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{-- {{$count}}-{{$count2}} --}}

                                {{$count+$count2}}
                                @php
                                    if ($count+$count2 != 0) {
                                      $totalProdiIntS2++;
                                    }
                                @endphp
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 1) as $moa)
                                  @if ($year)
                                      @if (substr($moa->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count3++;
                                              $totalLokS2++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count3++;
                                        $totalLokS2++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 1) as $ia)
                                  @if ($year)
                                      @if (substr($ia->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $count4++;
                                              $totalLokS2++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $count4++;
                                        $totalLokS2++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{-- {{$count3}}-{{$count4}} --}}

                                {{$count3+$count4}}
                                @php
                                    if ($count3+$count4 != 0) {
                                      $totalProdiLokS2++;
                                    }
                                @endphp
                              </td>
                              @if ($count+$count2+$count3+$count4 != 0)
                                  @php
                                      $totalProdiKerjasamaS2++;
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
                                <td width="13%">{{$totalIntS2}}</td>
                                <td width="13%">{{$totalLokS2}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">
                                    Total Prodi yang memiliki Kerjasama
                                </td>
                                <td width="13%">{{$totalProdiIntS2}}</td>
                                <td width="13%">{{$totalProdiLokS2}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi S2</td>
                                <td colspan="2"> {{$totalProdiS2}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi S2 yang Memiliki Kerjasama</td>
                                <td colspan="2">{{$totalProdiKerjasamaS2}} / {{$totalProdiS2}} = {{round($totalProdiKerjasamaS2/$totalProdiS2*100)}}%</td>
                              </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">1. Luar Negeri</td>
                                <td colspan="2">{{$totalProdiIntS2}} / {{$totalProdiS2}} = {{round($totalProdiIntS2/$totalProdiS2*100)}}%</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">2. Dalam Negeri</td>
                                <td colspan="2">{{$totalProdiLokS2}} / {{$totalProdiS2}} = {{round($totalProdiLokS2/$totalProdiS2*100)}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>