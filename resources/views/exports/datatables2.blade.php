<div>
    <table>
        <tr>
            <td>Jenis Kerjasama</td>
            <td>Tempat Pelaksanaan</td>
            <td>Dasar Dokumen Kerjasama</td>
            <td>Nomor Dokumen Unhas</td>
            <td>Judul Kerjasama</td>
            <td>Tanggal TTD</td>
            <td>Tanggal Awal</td>
            <td>Tanggal Akhir</td>
            <td>Status</td>
            <td>Jangka Waktu</td>
            <td>Penggiat Kerjasama</td>
            <td>Fakultas</td>
            <td>Prodi</td>
            <td>Bentuk Kegiatan</td>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->jenis_kerjasama == 1 ? 'DN':'LN' }} - {{ $item->negara }}</td>
            <td>{{ $item->tempat_pelaksanaan }}</td>
            <td>{{ $item->dasar_dokumen }}</td>
            <td>{{ $item->nomor_dok_unhas }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->tanggal_ttd }}</td>
            <td>{{ $item->tanggal_awal }}</td>
            <td>{{ $item->tanggal_berakhir }}</td>
            <td>{{ $item->status == 1 ? 'Aktif':($item->status == 2 ? 'Dalam Perpanjangan':($item->status == 3 ? 'Kadaluarsa':($item->status == 4 ? 'Tidak Aktif':''))) }}</td>
            <td>{{ $item->jangka_waktu }}</td>
            <td>
                @php
                    $penggiat = strtoupper(str_replace(str_split('[]"'), '', $item->penggiat));
                    $penggiat= strtoupper(str_replace(',', ' / ', $penggiat))
                @endphp
                {{ $penggiat }}
            </td>
            <td>
                @foreach ($fakultas as $item_fakultas)
                    @if ($item_fakultas->id == $item->fakultas_pihak)
                        {{ $item_fakultas->nama_fakultas }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach ($prodi as $item_prodi)
                    @if ($item_prodi->id == $item->prodi_id)
                        {{ $item_prodi->nama_resmi }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach ($bentuk->where('id_ia',$item->id) as $item_kegiatan)
                    {{ $loop->iteration.'.'.$item_kegiatan->kegiatan->nama }} &ensp;
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
</div>
