<template>
    <transition name="container">
        <div
            class="fixed inset-x-0 inset-y-0 bg-gray-100 z-50 overflow-auto text-gray-700"
        >
            <button
                @click="close()"
                class="absolute top-2 right-2 text-gray-500"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-10 w-10"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </button>

            <div class="m-auto container p-5 pb-10">
                <h1 class="font-extrabold text-2xl text-gray-800">
                    Browse Customer
                </h1>
                <div>
                    <!-- SEARCH -->
                    <div>
                        <!-- <label
                            for="search"
                            class="block text-sm font-medium text-gray-700"
                            >search</label
                        > -->
                        <div class="mt-1">
                            <input
                                v-model="search"
                                @keyup="searchKeyUp()"
                                type="text"
                                name="search"
                                id="search"
                                class="shadow-sm focus:ring-gray-500 focus:border-gray-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Search here..."
                            />
                        </div>
                    </div>

                    <!-- LIST -->
                    <div
                        v-if="customers && customers.data.length > 0"
                        class="mt-2"
                    >
                        <label for=""
                            >Result : {{ customers.meta.from }} to
                            {{ customers.meta.to }} out of
                            {{ customers.meta.total }}</label
                        >
                        <!-- -- -->
                        <div
                            class="bg-white shadow overflow-hidden sm:rounded-md"
                        >
                            <ul role="list" class="divide-y divide-gray-200">
                                <li
                                    v-for="(
                                        customer, customerKey
                                    ) in customers.data"
                                    :key="customerKey"
                                >
                                    <a
                                        @click="selectCustomer(customer)"
                                        href="#"
                                        class="block hover:bg-gray-50"
                                        :class="{
                                            'border-4 border-gray-400':
                                                customer.is_selected,
                                        }"
                                    >
                                        <div class="px-4 py-4 sm:px-6">
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <p
                                                    class="text-sm font-medium text-indigo-600 truncate"
                                                >
                                                    {{ customer.name }}
                                                </p>
                                                <div
                                                    class="ml-2 flex-shrink-0 flex"
                                                >
                                                    <p
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                                    >
                                                        {{ customer.code }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-2 sm:flex sm:justify-between"
                                            >
                                                <div class="sm:flex space-x-2">
                                                    <p
                                                        class="flex items-center text-sm text-gray-500"
                                                    >
                                                        <!-- <UsersIcon
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                            aria-hidden="true"
                                                        /> -->

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25"
                                                            />
                                                        </svg>

                                                        {{
                                                            customer.email
                                                                ? customer.email
                                                                : "No email"
                                                        }}
                                                    </p>
                                                    <p
                                                        class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0"
                                                    >
                                                        <!-- <LocationMarkerIcon
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                            aria-hidden="true"
                                                        /> -->

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
                                                            />
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
                                                            />
                                                        </svg>

                                                        {{
                                                            customer.address
                                                                ? customer.address
                                                                : "No Address"
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex justify-between space-x-4 mt-4">
                            <button
                                @click="submit"
                                type="submit"
                                class="w-full tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                            >
                                Select
                            </button>
                            <button
                                @click="close()"
                                type="submit"
                                class="w-full tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                    <div
                        v-else
                        class="text-center py-4 font-semibold uppercase"
                    >
                        NO RECORD
                    </div>
                    <!-- LIST -->
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            search: "",
            customers: null,
            selected_customer: null,
            timer: null,
        };
    },
    methods: {
        close() {
            console.log("closing..");
            this.$emit("close");
        },
        fetchCustomers(page = 1) {
            axios
                .get("/customer-accounts", {
                    params: {
                        page: page,
                        limit: 10,
                        ...this.payload,
                    },
                })
                .then((res) => {
                    console.log(res);
                    this.customers = {
                        meta: res.data.meta,
                        links: res.data.links,
                        data: [],
                    };

                    res.data.data.forEach((e, k) => {
                        var data = {
                            ...e,
                            is_selected: false,
                        };

                        this.customers.data.push(data);
                    });
                });
        },
        selectCustomer(item) {
            this.selected_customer = null;
            this.customers.data.forEach((e) => {
                e.is_selected = false;
            });

            item.is_selected = true;
            setTimeout(() => {
                this.selected_customer = JSON.parse(JSON.stringify(item));
            }, 50);
        },
        submit() {
            this.$emit("close", {
                account: JSON.parse(
                    JSON.stringify(this.selected_customer)
                ),
            });
        },
        searchKeyUp() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                this.fetchCustomers();
            }, 500);
        },
    },
    mounted() {
        this.fetchCustomers(1);
    },
    computed: {
        payload() {
            return {
                filter_search: this.search,
            };
        },
    },
};
</script>

<style>
.container-enter-active,
.container-leave-active {
    transition: opacity 0.5s;
}
.container-enter, .container-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
