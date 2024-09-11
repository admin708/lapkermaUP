@php
    $totalIntS3= 0;
    $totalLokS3 = 0;
    $totalProdiIntS3 = 0;
    $totalProdiLokS3 = 0;
    $totalProdiKerjasamaS2 = 0;
@endphp
<div id="top-categories" class="top-cat-area" style="padding-bottom: 70px">
    <div class="container">
        <h3>JENJANG DOKTOR (S3)</h3>
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
                         
                          @foreach ($getProdi->where('jenjang','doktor') as $item)
                            @php
                                $s3count = 0;
                                $s3count2 = 0;
                                $s3count3 = 0;
                                $s3count4 = 0;
                            @endphp
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$item->nama_resmi}}</td>
                              <td>{{$item->fakultas->nama_fakultas}}</td>
                              <td class="text-uppercase" width="13%">
                                S3
                              </td>
                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 2) as $moaInt)
                                  @if ($year)
                                      @if (substr($moaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $s3count++;
                                              $totalIntS3++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $s3count++;
                                        $totalIntS3++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 2) as $iaInt)
                                  @if ($year)
                                      @if (substr($iaInt->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $s3count2++;
                                              $totalIntS3++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $s3count2++;
                                        $totalIntS3++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{$s3count+$s3count2}}
                                @php
                                    if ($s3count+$s3count2 != 0) {
                                      $totalProdiIntS3++;
                                    }
                                @endphp
                              </td>

                              <td width="13%">
                                @foreach ($item->getMoa->where('jenis_kerjasama', 1) as $moas3)
                                  @if ($year)
                                      @if (substr($moas3->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $s3count3++;
                                              $totalLokS3++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $s3count3++;
                                        $totalLokS3++;
                                      @endphp
                                  @endif
                                @endforeach
                                @foreach ($item->getIa->where('jenis_kerjasama', 1) as $ia)
                                  @if ($year)
                                      @if (substr($ia->tanggal_ttd, 0, 4) == $year)
                                          @php
                                              $s3count4++;
                                              $totalLokS3++;
                                          @endphp
                                      @endif
                                  @else
                                      @php
                                        $s3count4++;
                                        $totalLokS3++;
                                      @endphp
                                  @endif
                                @endforeach
                                {{$s3count3+$s3count4}}
                                @php
                                    if ($s3count3+$s3count4 != 0) {
                                      $totalProdiLokS3++;
                                    }
                                @endphp
                              </td>
                              @if ($s3count+$s3count2+$s3count3+$s3count4 != 0)
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
                                <td width="13%">{{$totalIntS3}}</td>
                                <td width="13%">{{$totalLokS3}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">
                                    Total Prodi yang memiliki Kerjasama
                                </td>
                                <td width="13%">{{$totalProdiIntS3}}</td>
                                <td width="13%">{{$totalProdiLokS3}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi S3</td>
                                <td colspan="2"> {{$totalProdiS3}}</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">Total Jumlah Prodi S3 yang Memiliki Kerjasama</td>
                                <td colspan="2">{{$totalProdiKerjasamaS2}} / {{$totalProdiS3}} = {{round($totalProdiKerjasamaS2/$totalProdiS3*100)}}%</td>
                              </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">1. Luar Negeri</td>
                                <td colspan="2">{{$totalProdiIntS3}} / {{$totalProdiS3}} = {{round($totalProdiIntS3/$totalProdiS3*100)}}%</td>
                            </tr>
                            <tr style="font-weight:700">
                                <td class="text-uppercase">2. Dalam Negeri</td>
                                <td colspan="2">{{$totalProdiLokS3}} / {{$totalProdiS3}} = {{round($totalProdiLokS3/$totalProdiS3*100)}}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>