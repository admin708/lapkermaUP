<div class="container-xxl flex-grow-1 container-p-y">
    <style>
        .position-relative {
            position: relative !important;
        }
    
        .translate-middle-y {
            transform: translateY(-50%) !important;
        }

        .translate-middle {
            transform: translate(-50%,-50%)!important;
        }

        .start-50 {
            left: 50%!important;
        }

        .start-0 {
            left: 0 !important;
        }
    
        .top-50 {
            top: 50% !important;
        }
    
        .position-absolute {
            position: absolute !important;
        }
    
        .rowss {
            --bs-gutter-x: 1.625rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-0.5 * var(--bs-gutter-x));
            margin-left: calc(-0.5 * var(--bs-gutter-x));
        }
    
        .col-8 {
            flex: 0 0 auto;
            width: 66.66666667%;
        }
    
        .col-3 {
            flex: 0 0 auto;
            width: 25%;
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%;
        }
    
        .wkwkwk {
            width: 60%;
            -webkit-transition: width 0.4s ease-in-out;
            transition: width 0.4s ease-in-out;
        }
    
        /* When the input field gets focus, change its width to 100% */
        .wkwkwk:focus {
            width: 100%;
        }

        .errorAlert {
            background-color: rgba(248, 37, 37, 0.13)
        }
    </style>
    <div class="container card" style="margin-top: 55px">
      <div class="rowss">
        <div class="col-12 position-relative">
            <input wire:keydown.enter="cariKerjasama" type="text" class="
            @error('search')
            errorAlert
            @enderror
            form-control form-control-lg position-absolute top-50 start-50 translate-middle wkwkwk" wire:model="search" placeholder="Cari Berdasarkan Nama Mitra, Negara Mitra, atau No.Dokumen Kerjasama">
        </div>
      </div>
      <div  style="margin-top: 55px">
        @if ($alert)
            <center style="color: red">{{$alert}}</center>
        @endif
        <hr>
      </div>
    </div>
</div>