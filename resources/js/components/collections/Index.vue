<template>
    <div>
        <!-- --- -->
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="px-4 sm:px-6 lg:px-8 pb-10">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">
                        Collections
                    </h1>
                    <!-- <p class="mt-2 text-sm text-gray-700">
                        A table of placeholder stock market data that does not
                        make any sense.
                    </p> -->
                </div>
                <!-- <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                    >
                        Export
                    </button>
                </div> -->
            </div>
            <div class="">
                <span class="text-xs"> Showing {{ get_official_receipts.meta.from }} to {{ get_official_receipts.meta.to }} out of {{ get_official_receipts.meta.total }} </span>
            </div>
            <div class="mt-2 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                    >
                        <div
                            class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Date
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Official Receipt
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Customer
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Amount
                                        </th>
                                        <th
                                            scope="col"
                                            class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-6"
                                        >
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    v-if="get_official_receipts"
                                    class="divide-y divide-gray-200 bg-white"
                                >
                                    <tr
                                        v-for="(
                                            item, itemIndex
                                        ) in get_official_receipts.data"
                                        :key="itemIndex"
                                    >
                                        <td
                                            class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6"
                                        >
                                            {{ item.formatted_date }}
                                        </td>

                                        <td
                                            class="whitespace-nowrap px-2 py-2 text-sm text-gray-500"
                                        >
                                            {{ item.formatted_id }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-2 py-2 text-sm text-gray-500"
                                        >
                                            <div v-if="item.account">
                                                {{ item.account.code }} |
                                                {{ item.account.name }}
                                            </div>
                                            <div v-else>NO RECORD</div>
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-2 py-2 text-sm text-gray-500"
                                        >
                                            {{ item.formatted_amount }}
                                        </td>
                                        <td
                                            class="space-x-1 relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                        >
                                            <a
                                                @click="edit(item)"
                                                href="#"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                Edit
                                            </a>
                                            <a
                                                @click="view(item)"
                                                href="#"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                View
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- More transactions... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    <button
                        :class="{
                            'opacity-50':
                                get_official_receipts.links.prev == null,
                        }"
                        :disabled="get_official_receipts.links.prev == null"
                        @click="prev()"
                        type="button"
                        class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    >
                        <span class="sr-only">Previous</span>
                        <!-- Heroicon name: mini/chevron-left -->
                        <svg
                            class="h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <button
                        :class="{
                            'opacity-50':
                                get_official_receipts.links.next == null,
                        }"
                        :disabled="get_official_receipts.links.next == null"
                        @click="next()"
                        type="button"
                        class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    >
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: mini/chevron-right -->
                        <svg
                            class="h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </div>
        </div>

        <!-- --- -->
        <collections.modal
            v-if="collection_modal.show"
            @close="
                collection_modal.show = false;
                selected_official_receipt = null;
            "
            :read_only="collection_modal.read_only"
            :official_receipt_id="selected_official_receipt.id"
        ></collections.modal>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            official_receipts: null,
            collection_modal: {
                show: false,
                read_only: false,
            },
            selected_official_receipt: null,
        };
    },
    methods: {
        next() {
            this.$store.dispatch("fetchOfficialReceipts", {
                page : this.get_official_receipts.meta.current_page + 1
            });
        },
        prev() {
            this.$store.dispatch("fetchOfficialReceipts", {
                page : this.get_official_receipts.meta.current_page - 1
            });
        },
        edit(item) {
            this.selected_official_receipt = JSON.parse(JSON.stringify(item));
            this.collection_modal.show = true;
            this.collection_modal.read_only = false;
        },
        view(item) {
            this.selected_official_receipt = JSON.parse(JSON.stringify(item));
            this.collection_modal.show = true;
            this.collection_modal.read_only = true;
        },
    },
    computed: {
        ...mapGetters(["get_official_receipts"]),
    },
    created() {
        document.title = "Collections";
    },
    mounted() {
        this.$store.dispatch("fetchOfficialReceipts");
    },
};
</script>

<style></style>
