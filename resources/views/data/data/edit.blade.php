<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Methode TOPSIS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                    id="tabs-home01" role="tabpanel" aria-labelledby="tabs-home-tab01" data-te-tab-active>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
                        <p class="font-semibold text-black text-center pb-3">Masukkan Data Alternatif dan Kriteria</p>
                        {{-- <form method="POST" action="{{ route('data.update', ['id' => $data->id]) }}"> --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3" role="alert" id="danger-alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <script>
                                    setTimeout(function() {
                                        var successAlert = document.getElementById('danger-alert');
                                        successAlert.style.display = 'none';
                                    }, 5000);
                                </script>
                            @endif
                            @method('PUT')
                            @csrf
                            <div class="mb-6">
                                <label for="alternatif_id"
                                    class="block mb-2 text-sm font-medium text-gray-900">Alternatif</label>
                                <select id="alternatif_id" name="alternatif_id"
                                    class="w-full px-4 py-2.5 border rounded-lg" required>
                                    <option value="">Pilih Alternatif</option>
                                    @foreach ($alternatif as $alternatif)
                                        <option value="{{ $alternatif->id }}"
                                            {{ 'alternatif_id' == $alternatif->id ? 'selected' : '' }}>
                                            {{ $alternatif->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="kriteria_id"
                                    class="block mb-2 text-sm font-medium text-gray-900">Kriteria</label>
                                <select id="kriteria_id" name="kriteria_id" class="w-full px-4 py-2.5 border rounded-lg"
                                    required>
                                    <option value="">Pilih Kriteria</option>
                                    @foreach ($kriteria as $kriteria)
                                        <option value="{{ $kriteria->id }}"
                                            {{ 'kriteria_id' == $kriteria->id ? 'selected' : '' }}>
                                            {{ $kriteria->kriteria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="value" class="block mb-2 text-sm font-medium text-gray-900">Value</label>
                                <input type="value" id="value" name="value"
                                    class="w-full px-4 py-2.5 border rounded-lg" required>
                            </div>
                            <div class="flex flex-row justify-between">
                                <button type="button" id="backButton"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium rounded-lg p-2.5 text-center">Back</button>
                                <button type="submit"
                                    class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg p-2.5 text-center">Submit</button>
                            </div>

                            <script>
                                // Get a reference to the "Back" button
                                const backButton = document.getElementById('backButton');

                                // Add a click event listener to the "Back" button
                                backButton.addEventListener('click', function() {
                                    // Use window.history.back() to go back to the previous page
                                    window.history.back();
                                });
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-profile01" role="tabpanel" aria-labelledby="tabs-profile-tab01">
            Tab 2 content
        </div>
        <div class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-messages01" role="tabpanel" aria-labelledby="tabs-profile-tab01">
            Tab 3 content
        </div>
    </div>
    <script>
        import {
            Tab,
            initTE,
        } from "tw-elements";

        initTE({
            Tab
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    </div>
    </div>
</x-app-layout>
