<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="province">İl</label>
            <select name="province" id="province" class="form-control" >
                <option value="" selected disabled>İl seçiniz</option>
                @foreach ($provinces as $key => $value)
                    <option value="{{ $value->province_key }}">
                        {{ $value->province_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="district">İlçe</label>
            <select name="district" class="form-control" id="district" >
                <option value="">Seç</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="neighborhood">Mahalle</label>
            <select name="neighborhood" class="form-control" id="neighborhood" >
                <option value="">Seç</option>
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label class="mb-2" for="address">Adres</label>
            <textarea class="form-control" name="address" id="" rows="5">{{ old('address') }}</textarea>
        </div>
    </div>
</div>
