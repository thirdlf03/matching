<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Room作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('rooms.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">部屋一覧に戻る</a>
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
                    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

                    <form method="POST" action="{{ route('rooms.store') }}" id="roomForm">
                        @csrf
                        <label>ルーム名</label>
                        <input name="title" required type="text" class="mx-2 my-4"></input>
                        <br class="block sm:hidden">
                        <label>人数</label>
                        <input name="size" required type="number" class="mx-2 my-4"><br>
                        <!-- カレンダーを追加-->
                         
                        <div x-data="{
                            datePickerOpen: false,
                            datePickerValue: '',
                            datePickerFormat: 'YYYY-MM-DD',
                            datePickerMonth: '',
                            datePickerYear: '',
                            datePickerDay: '',
                            datePickerDaysInMonth: [],
                            datePickerBlankDaysInMonth: [],
                            datePickerMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            datePickerDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            datePickerDayClicked(day) {
                                let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
                                this.datePickerDay = day;
                                this.datePickerValue = this.datePickerFormatDate(selectedDate);
                                this.datePickerIsSelectedDate(day);
                                this.datePickerOpen = false;
                            },
                            datePickerPreviousMonth() {
                                if (this.datePickerMonth == 0) {
                                    this.datePickerYear--;
                                    this.datePickerMonth = 12;
                                }
                                this.datePickerMonth--;
                                this.datePickerCalculateDays();
                            },
                            datePickerNextMonth() {
                                if (this.datePickerMonth == 11) {
                                    this.datePickerMonth = 0;
                                    this.datePickerYear++;
                                } else {
                                    this.datePickerMonth++;
                                }
                                this.datePickerCalculateDays();
                            },
                            datePickerIsSelectedDate(day) {
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
                            },
                            datePickerIsToday(day) {
                                const today = new Date();
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return today.toDateString() === d.toDateString() ? true : false;
                            },
                            datePickerCalculateDays() {
                                let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
                                // find where to start calendar day of week
                                let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
                                let blankdaysArray = [];
                                for (var i = 1; i <= dayOfWeek; i++) {
                                    blankdaysArray.push(i);
                                }
                                let daysArray = [];
                                for (var i = 1; i <= daysInMonth; i++) {
                                    daysArray.push(i);
                                }
                                this.datePickerBlankDaysInMonth = blankdaysArray;
                                this.datePickerDaysInMonth = daysArray;
                            },
                            datePickerFormatDate(date) {
            let formattedDate = ('0' + date.getDate()).slice(-2);
            let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
            let formattedYear = date.getFullYear();
            return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
        },
                        }" x-init="currentDate = new Date();
                        if (datePickerValue) {
                            currentDate = new Date(Date.parse(datePickerValue));
                        }
                        datePickerMonth = currentDate.getMonth();
                        datePickerYear = currentDate.getFullYear();
                        datePickerDay = currentDate.getDay();
                        datePickerValue = datePickerFormatDate(currentDate);
                        datePickerCalculateDays();" x-cloak>
                            <div class="container px-4 py-2 mx-auto md:py-10">
                                <div class="w-full mb-5">
                                    <label for="datepicker"
                                        class="block mb-1 text-sm font-medium text-neutral-500">Select Date</label>
                                    <div class="relative w-[17rem]">
                                        <input x-ref="datePickerInput" type="text"
                                            @click="datePickerOpen=!datePickerOpen" x-model="datePickerValue"
                                            x-on:keydown.escape="datePickerOpen=false"
                                            class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md text-neutral-600 border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                                            placeholder="Select date" readonly />
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div x-show="datePickerOpen" x-transition @click.away="datePickerOpen = false"
                                            class="absolute top-0 left-0 max-w-lg p-4 mt-12 antialiased bg-white border rounded-lg shadow w-[17rem] border-neutral-200/70">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <span x-text="datePickerMonthNames[datePickerMonth]"
                                                        class="text-lg font-bold text-gray-800"></span>
                                                    <span x-text="datePickerYear"
                                                        class="ml-1 text-lg font-normal text-gray-600"></span>
                                                </div>
                                                <div>
                                                    <button @click="datePickerPreviousMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 19l-7-7 7-7" />
                                                        </svg>
                                                    </button>
                                                    <button @click="datePickerNextMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-7 mb-3">
                                                <template x-for="(day, index) in datePickerDays" :key="index">
                                                    <div class="px-0.5">
                                                        <div x-text="day"
                                                            class="text-xs font-medium text-center text-gray-800"></div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="grid grid-cols-7">
                                                <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                    <div class="p-1 text-sm text-center border border-transparent">
                                                    </div>
                                                </template>
                                                <template x-for="(day, dayIndex) in datePickerDaysInMonth"
                                                    :key="dayIndex">
                                                    <div class="px-0.5 mb-1 aspect-square">
                                                        <div x-text="day" @click="datePickerDayClicked(day)"
                                                            :class="{
                                                                'bg-neutral-200': datePickerIsToday(day) == true,
                                                                'text-gray-600 hover:bg-neutral-200': datePickerIsToday(
                                                                        day) == false && datePickerIsSelectedDate(
                                                                    day) == false,
                                                                'bg-neutral-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(
                                                                    day) == true
                                                            }"
                                                            class="flex items-center justify-center text-sm leading-none text-center rounded-full cursor-pointer h-7 w-7">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ここまでカレンダーを追加 -->
                        <div class="flex items-center">
                            <select name="category_id" id="categorySelect"
                                class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">すべてのカテゴリー</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="category_id" id="selected_category_id"
                            value="{{ request('category_id') }}">
                        <br>
                        <div x-data="{ open: false }">
                            <input @click="open = !open" type="checkbox" class="my-4"></input>
                            <label>位置情報をセット</label><br>
                            <span x-show="open">
                                <input type="checkbox" class="my-1" id="check"></input>
                                <label>詳細画面に位置情報を載せる</label><br>
                                <br>
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
                        <div id="editor" required></div>
                        <input type="hidden" name="data_json" id="data_json" value="">
                        <input type="hidden" name="is_show" id="show" value="0">
                        <input type="hidden" name="latitude" id="latitude" value="">
                        <input type="hidden" name="longitude" id="longitude" value="">
                        <div class="flex justify-end mt-4">
                            <button type="submit" id="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                送信
                            </button>
                        </div>
                    </form>
                    <style>
                        .selected {
                            background-color: #0000FF;
                            /* Blue color */
                            color: #fff;
                            /* Change text color if needed */
                        }
                    </style>
                    <script>
                        const quill = new Quill('#editor', {
                            modules: {
                                syntax: true,
                                toolbar: '#toolbar-container',
                            },
                            placeholder: '内容を入力',
                            theme: 'snow',
                        });

                        document.getElementById('categorySelect').addEventListener('change', function() {
                            document.getElementById('selected_category_id').value = this.value;
                        });

                        document.getElementById('roomForm').addEventListener('submit', function(e) {
                            const delta = quill.getContents();
                            const jsoncontent = JSON.stringify(delta);
                            document.getElementById('data_json').value = jsoncontent;
                        });

                        document.querySelectorAll('.category-icon').forEach(icon => {
                            icon.addEventListener('click', function() {
                                document.querySelectorAll('.category-icon').forEach(i => i.classList.remove('selected'));
                                this.classList.add('selected');
                                document.getElementById('selected_category_id').value = this.getAttribute(
                                    'data-category-id');
                            });
                        });

                        document.getElementById('getPosition').addEventListener('click', function(e) {
                            e.preventDefault();
                            var address = document.getElementById('address').value;
                            const url = `https://www.google.com/maps?output=embed&q=${address}`
                            document.getElementById('map').innerHTML =
                                `<iframe src="${url}&t=m&hl=ja&z=18" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
                            document.getElementById('latitude').value = 33.59253;
                            document.getElementById('longitude').value = 130.39928;
                        });

                        document.getElementById('check').addEventListener('change', function(e) {
                            if (document.getElementById('show').value == '1') {
                                document.getElementById('show').value = '0';
                                console.log(document.getElementById('show').value);
                            } else {
                                document.getElementById('show').value = '1';
                                console.log(document.getElementById('show').value);
                            }
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
                                    `<iframe src="https://maps.google.com/maps?output=embed&q=${crd.latitude},${crd.longitude}&ll=${crd.latitude},${crd.longitude}&t=m&hl=ja&z=18" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
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
