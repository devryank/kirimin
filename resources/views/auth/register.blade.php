<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="Nama Lengkap" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="E-mail" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-jet-label for="roles" value="Peran" />
                <select name="roles" id="roles"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
                    <option value="seller">Penjual</option>
                    <option value="user">Pembeli</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="province" value="Provinsi" />
                <select name="province" id="province"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
                    @foreach ($provinces->provinsi as $province)
                    <option value="{{ $province->id }}">{{ $province->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="city" value="Kota" />
                <select name="city" id="city"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="kecamatan" value="Kecamatan" />
                <select name="kecamatan" id="kecamatan"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                    required>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="Password" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="Ketik Ulang Password" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                                class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of
                                Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                                class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy
                                Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Sudah punya akun?
                </a>

                <x-jet-button class="ml-4">
                    Daftar
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

<script>
    var province = document.getElementById('province');
    province.onchange = (event) => {
    $('#city').empty();
    $('#kecamatan').empty();
    var province_id = event.target.value;
    searchCity(province_id)
 }
    function searchCity(province_id) {
        jQuery.ajax({
            url: '/city/'+province_id,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#city').empty();
                    $('#city').append('<option>-- Pilih Kota --</option>');
                for (let index = 0; index < response.kota_kabupaten.length; index++) {
                    $('#city').append('<option value=' + response.kota_kabupaten[index].id + '>' + response.kota_kabupaten[index].nama + '</option>');
                }
            }
        });
    }

    var city = document.getElementById('city');
    city.onchange = (event) => {
    var city_id = event.target.value;
    searchKecamatan(city_id)
 }
    function searchKecamatan(city_id) {
        jQuery.ajax({
            url: '/kecamatan/'+city_id,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#kecamatan').empty();
                    $('#kecamatan').append('<option>-- Pilih Kecamatan --</option>');
                for (let index = 0; index < response.kecamatan.length; index++) {
                    $('#kecamatan').append('<option value=' + response.kecamatan[index].id_kota + '>' + response.kecamatan[index].nama + '</option>');
                }
            }
        });
    }


</script>