<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Room編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
                    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

                    <form method="POST" action="{{ route('rooms.update', $room) }}" id="roomForm">
                        @csrf
                        @method('PUT')
                        <label>ルーム名</label>
                        <input name="title" required type="text" class="mx-2 my-4"
                            value="{{ $room->title }}"></input>
                        <label>人数</label>
                        <input name="size" required type="number" class="mx-2 my-4" value="{{ $room->size }}"><br>
                        <div x-data="{ open: false }">
                            <input @click="open = !open" type="checkbox" class="my-4"></input>
                            <label>位置情報を更新</label><br>
                            <span x-show="open">
                                <input type="checkbox" class="my-1" id="position"></input>
                                <label>自分の位置をセットする</label><br>
                                <input type="text" id="address" value="場所" class="my-2"></input>
                                <button id="getPosition"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">検索</button>
                                <p id="map"></p>
                            </span>

                        </div><br>
                        <label class="my-4">本文</label>

                        <!-- Quill editor container -->
                        <div id="toolbar-container">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>
                        <div id="editor"></div>
                        <input type="hidden" name="data_json" id="data_json" value="">
                        <input type="hidden" name="latitude" id="latitude" value="">
                        <input type="hidden" name="longitude" id="longitude" value="">
                        <div class="flex justify-end mt-4">
                            <button type="submit" id="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                更新
                            </button>
                        </div>
                    </form>

                    <script>
                        const quill = new Quill('#editor', {
                            modules: {
                                syntax: true,
                                toolbar: '#toolbar-container',
                            },
                            theme: 'snow',
                        });

                        var content_text = '{!! $room->data_json !!}';
                        var json = content_text.replace(/\n/g, '\\n');
                        json = JSON.parse(json);
                        quill.setContents(json);

                        document.getElementById('roomForm').addEventListener('submit', function(e) {
                            const delta = quill.getContents();
                            const jsoncontent = JSON.stringify(delta);
                            document.getElementById('data_json').value = jsoncontent;
                        });


                        document.getElementById('getPosition').addEventListener('click', function(e) {
                            e.preventDefault();
                            var address = document.getElementById('address').value;
                            const url = `https://www.google.com/maps?output=embed&q=${address}`
                            document.getElementById('map').innerHTML =
                                `<iframe src="${url}&t=m&hl=ja&z=18" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
                            document.getElementById('latitude').value = 33.59253;
                            document.getElementById('longitude').value = 130.39928;
                        });

                        document.getElementById('position').addEventListener('change', function(e) {
                            const options = {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0,
                            };

                            function success(pos) {
                                const crd = pos.coords;
                                console.log(crd.latitude);
                                console.log(crd.longitude);
                                document.getElementById('map').innerHTML =
                                    `<iframe src="https://maps.google.com/maps?output=embed&q=${crd.latitude},${crd.longitude}&ll=${crd.latitude},${crd.longitude}&t=m&hl=ja&z=18" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
                                document.getElementById('latitude').value = crd.latitude;
                                document.getElementById('longitude').value = crd.longitude;
                            }

                            function error(err) {
                                console.warn(`ERROR(${err.code}): ${err.message}`);
                            }

                            navigator.geolocation.getCurrentPosition(success, error, options);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
