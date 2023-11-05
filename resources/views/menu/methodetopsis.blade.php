<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Methode TOPSIS') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="mb-7">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Matrix Ternormalisasi</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        @foreach ($kriteria as $k)
                                            <th scope="col" class="px-6 py-3">
                                                {{ $k->kriteria }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                        <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                {{ $a->nama }}
                                            </td>
                                            @foreach ($kriteria as $k)
                                                <td class="px-6 py-4">
                                                    {{ number_format($originalResults[$a->id][$k->id], 2) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-10">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Matrix Ternormalisasi
                            Terbobot</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        @foreach ($kriteria as $k)
                                            <th scope="col" class="px-6 py-3">
                                                {{ $k->kriteria }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                        <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                {{ $a->nama }}
                                            </td>
                                            @foreach ($kriteria as $k)
                                                <td class="px-6 py-4">
                                                    {{ number_format($weightedResults[$a->id][$k->id], 2) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-10">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Solusi Ideal Positif dan
                            Negatif</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        @foreach ($kriteria as $k)
                                            <th scope="col" class="px-6 py-3">
                                                {{ $k->kriteria }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            {{ 'A+' }}
                                        </td>
                                        @foreach ($Amax as $a)
                                            <td class="px-6 py-4">
                                                {{ number_format($a, 4) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            {{ 'A-' }}
                                        </td>
                                        @foreach ($Amin as $a)
                                            <td class="px-6 py-4">
                                                {{ number_format($a, 4) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-10">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Solusi Ideal Positif D+</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        @foreach ($kriteria as $k)
                                            <th scope="col" class="px-6 py-3">
                                                {{ $k->kriteria }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                        <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                {{ $a->nama }}
                                            </td>
                                            @foreach ($kriteria as $k)
                                                <td class="px-6 py-4">
                                                    {{ number_format($resultSquaredPositif[$a->id][$k->id], 4) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-10">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Solusi Ideal Negatif D-</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3"></th>
                                        @foreach ($kriteria as $k)
                                            <th scope="col" class="px-6 py-3">
                                                {{ $k->kriteria }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                        <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                {{ $a->nama }}
                                            </td>
                                            @foreach ($kriteria as $k)
                                                <td class="px-6 py-4">
                                                    {{ number_format($resultSquaredNegatif[$a->id][$k->id], 4) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 mt-10">
                        <p class="bg-gray-800 rounded-md text-white p-3 text-center">Berikut Nilai D+ dan D-</p>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-center">Alternatif</th>
                                            <th scope="col" class="px-6 py-3 text-center">{{ 'D+' }}</th>
                                            <th scope="col" class="px-6 py-3 text-center">{{ 'D-' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alternatif as $a)
                                            <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                                                <td class="px-6 py-4 text-center">
                                                    {{ $a->nama }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    @if (is_array($sqrtByAlternatifPositif[$a->id]))
                                                        @foreach ($sqrtByAlternatifPositif[$a->id] as $value)
                                                            {{ number_format($value, 4) }}
                                                        @endforeach
                                                    @else
                                                        {{ number_format($sqrtByAlternatifPositif[$a->id], 4) }}
                                                    @endif
                                                </td>                                                
                                                <td class="px-6 py-4 text-center">
                                                    @if (is_array($sqrtByAlternatifNegatif[$a->id]))
                                                        @foreach ($sqrtByAlternatifNegatif[$a->id] as $value)
                                                            {{ number_format($value, 4) }}
                                                        @endforeach
                                                    @else
                                                        {{ number_format($sqrtByAlternatifNegatif[$a->id], 4) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
