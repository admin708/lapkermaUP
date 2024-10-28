<form action="{{ route('register') }}" method="POST" id="regis-form" class="mfp-hide white-popup-block">
    <div class="login-social">
        <h4>Register User</h4>
        @csrf
        <div>
            <input type="text" name="name" class="form-control" placeholder="NAME">
        </div>
        <br>
        <div>
            <input type="text" name="email" class="form-control" placeholder="EMAIL" required>
        </div>
        <br>
        <div>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="PASSWORD (8 Characters minimum)" required>
        </div>
        <br>
        <div>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                placeholder="PHONE NUMBER" required>
        </div>
        <br>
        <div>
            <select name="fakultas" wire:model="fakultas" class="form-control" required
                onchange="event.stopPropagation();>
                <option value="null">FACULTY/FAKULTAS (Don't change
                if you don't have one)</option>
                @foreach ($fakultasList as $faculty)
                    <option value="{{ $faculty->id }}" {{ old('fakultas') == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->nama_fakultas }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <select name="prodi" wire:model="prodi" class="form-control" required
                onchange="event.stopPropagation();>
                <option value="null">MAJOR/PROGRAM STUDI (Don't
                change if you don't have one)</option>
                @foreach ($prodiList as $prodiData)
                    <option value="{{ $prodiData->id }}" {{ old('prodi') == $prodiData->id ? 'selected' : '' }}>
                        {{ $prodiData->nama_resmi }}
                    </option>
                @endforeach
            </select>
        </div>

        @if (session('errors'))
            <div class="mt-1 alert bg-rgba-danger mb-1" style="margin-bottom: 0px">
                <i class="bx bx-info-circle align-middle"></i>
                <span class="align-middle">
                    @foreach ($errors->register->all() as $error)
                        {{ $error }}
                    @endforeach
                </span>
            </div>
        @endif
        <hr>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </div>
</form>
