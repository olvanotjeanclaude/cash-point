<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="province">İl</label>
            <select name="province" id="province" class="form-control" required>
                <option value="" selected disabled>İl seçiniz</option>
                @foreach ($provinces as $key => $value)
                    <option @if ($value->province_key == $address->province) selected @endif value="{{ $value->province_key }}">
                        {{ $value->province_name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Lütfen il seçiniz.
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="district">İlçe</label>
            <select name="district" class="form-control" id="district" required>
                <option value="" @if (!$address->district) selected @endif disabled>Seç</option>
                @if ($address->district)
                    <option value="{{ $address->district }}" selected>
                        {{ $address->get_district->district_name }}</option>
                @endif
            </select>
            <div class="invalid-feedback">
                Lütfen İlçe seçiniz.
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="mb-2" for="neighborhood">Mahalle</label>
            <select name="neighborhood" class="form-control" id="neighborhood" required>
                <option value="" @if (!$address->neighborhood) selected @endif disabled>Seç</option>
                @if ($address->neighborhood)
                    <option value="{{ $address->neighborhood }}" selected>
                        {{ $address->get_neighborhood->neighborhood_name }}</option>
                @endif
            </select>
            <div class="invalid-feedback">
                Lütfen Mahalle seçiniz.
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label class="mb-2" for="address">Adres</label>
            <textarea class="form-control" name="address" id=""
                rows="5">{{ $address->address }}</textarea>
        </div>
    </div>
</div>