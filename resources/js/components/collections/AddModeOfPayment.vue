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

            <div class="m-auto container p-5">
                <h1 class="font-extrabold text-2xl text-gray-800">
                    Mode of Payment - Add
                </h1>
                <div>
                    <!-- CONTENT -->
                    <div class="mt-2">
                        <div>
                            <!--
                                This example requires Tailwind CSS v2.0+

                                This example requires some changes to your config:

                                ```
                                // tailwind.config.js
                                module.exports = {
                                    // ...
                                    plugins: [
                                    // ...
                                    require('@tailwindcss/forms'),
                                    ],
                                }
                                ```
                            -->
                            <div>
                                <label
                                    for="location"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Mode of Payment
                                </label>
                                <select
                                    id="location"
                                    name="location"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option
                                        v-for="(
                                            item, itemIndex
                                        ) in mode_of_payments"
                                        :key="itemIndex"
                                        :value="item.description"
                                    >
                                        {{ item.description }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex justify-between space-x-4 mt-4">
                            <button
                                @click="submit"
                                class="w-full tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                            >
                                Submit
                            </button>
                            <button
                                @click="close()"
                                class="w-full tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                    <!-- CONTENT -->
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
            timer: null,
            mode_of_payments: [],
        };
    },
    methods: {
        close() {
            console.log("closing..");
            this.$emit("close");
        },
        submit() {
            confirm.fire().then((result) => {
                if (result.isConfirmed) {
                    console.log("submitted...");
                }
            });
        },
        searchKeyUp() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }

            this.timer = setTimeout(() => {
                console.log("searching...");
            }, 500);
        },
        fetchModeOfPayments(page = 1) {
            axios
                .get(`/mode-of-payments`, {
                    params: {
                        page: page,
                        limit: 1,
                    },
                })
                .then((res) => {
                    res.data.data.forEach((obj) => {
                        this.mode_of_payments.push(obj);
                    });

                    if (res.data.links.next != null) {
                        this.fetchModeOfPayments(
                            res.data.meta.current_page + 1
                        );
                    }
                });
        },
    },
    mounted() {
        this.fetchModeOfPayments(1);
    },
    computed: {},
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
