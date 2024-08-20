<template>
    <div class="max-w-md mx-auto sm:max-w-3xl">
        <div>
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 48 48" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h2 class="mt-2 text-lg font-medium text-gray-900">Vendors</h2>
                <p class="mt-1 text-sm text-gray-500">
                    A place where you can search vendor before proceeding to payment.
                </p>
            </div>
            <div class="mt-6 sm:flex sm:items-center">
                <!-- <label for="emails" class="sr-only">Email addresses</label> -->
                <div class="relative rounded-md shadow-sm sm:min-w-0 sm:flex-1">
                    <input type="text" v-on:keyup="searchTimeOut" v-model="search"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-32 sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search here...">

                </div>
                <button type="button"
                    class="mt-3 sm:mt-0 sm:ml-4 sm:flex-shrink-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </button>

            </div>
        </div>

        <transition name="empty_list">
            <div v-if="vendors.length == 0" class="mt-10">
                <div class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="mt-2 block text-sm font-medium text-gray-600">
                        Nothing to display...
                    </span>
                </div>
            </div>
        </transition>

        <transition name="list">
            <div v-if="vendors.length > 0" class="my-10 pb-10">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Recommended vendors
                </h3>
                <ul role="list" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <li v-for="vendor in vendors" :key="vendor.id">
                        <a :href="'/vendors/'+vendor.id"
                            class="group p-2 w-full flex items-center justify-between rounded-full border border-gray-300 shadow-sm space-x-3 text-left hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="min-w-0 flex-1 flex items-center space-x-3">
                                <span class="block flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                </span>
                                <span class="block min-w-0 flex-1">
                                    <span class="block text-sm font-medium text-gray-900 truncate">{{ vendor.vendor }}</span>
                                    <span class="block text-sm font-medium text-gray-500 truncate">{{ vendor.stall }}, {{ vendor.location }}</span>
                                </span>
                            </span>
                            <span class="flex-shrink-0 h-10 w-10 inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data(){
        return {
            search: '',
            vendors: [],
            selected_vendor: null,

            timer: null,
        }
    },
    methods: {
        searchTimeOut() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                // your code
                this.searchOnChange();
            }, 800);
        },
        searchOnChange(){
            debug(`search: ${this.search}`)

            if(this.search == ''){
                this.vendors = [];
                return;
            }

            axios.get('/vendors', {
                params: {
                    search: this.search
                }
            }).then(res=>{
                debug(res.data);
                this.vendors = [];
                res.data.data.forEach(element => {

                    setTimeout(() => {
                        this.vendors.push(element);
                    }, 100);
                });
                // this.vendors = res.data.data;
            });
        }
    }
}
</script>

<style>
    .list-enter-active {
        transition: opacity .5s;
    }
    .list-enter{
        opacity: 0;
    }

    .empty_list-enter-active {
        transition: opacity .5s;
    }
    .empty_list-enter{
        opacity: 0;
    }
</style>
