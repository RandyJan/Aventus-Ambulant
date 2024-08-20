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
                    Unpaid Invoice
                </h1>
                <div>
                    <!-- CONTENT -->
                    <div class="mt-2">
                        <div class="grid grid-cols-12">
                            <div class="col-span-12">
                                <div class="mt-2 flex flex-col">
                                    <div
                                        class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8"
                                    >
                                        <div
                                            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                                        >
                                            <div
                                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                                            >
                                                <table
                                                    class="min-w-full divide-y divide-gray-300"
                                                >
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th
                                                                scope="col"
                                                                class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                            >
                                                                Reference
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                            >
                                                                Date
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                            >
                                                                Invoice No.
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                            >
                                                                Balance
                                                            </th>
                                                            <th
                                                                scope="col"
                                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                            >
                                                                Tax Type
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        v-if="invoices"
                                                        class="divide-y divide-gray-200 bg-white text-gray-500"
                                                    >
                                                        <tr
                                                            v-for="(
                                                                item, itemIndex
                                                            ) in invoices.data"
                                                            :key="itemIndex"
                                                            @click="
                                                                selectItem(item)
                                                            "
                                                            :class="{
                                                                'bg-gray-500 !text-white':
                                                                    item.is_selected,
                                                            }"
                                                        >
                                                            <td
                                                                class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-6"
                                                            >
                                                                {{ item.formatted_transaction_number }}
                                                            </td>

                                                            <td
                                                                class="whitespace-nowrap px-2 py-2 text-sm"
                                                            >
                                                                {{
                                                                    item.reference_date
                                                                }}
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-2 py-2 text-sm"
                                                            >
                                                                <div>
                                                                    {{
                                                                        item.invoice_number
                                                                    }}
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap px-2 py-2 text-sm 0"
                                                            >
                                                                {{
                                                                    item.balance
                                                                }}
                                                            </td>
                                                            <td
                                                                class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                            >
                                                                {{ item.tx_type }}
                                                            </td>
                                                        </tr>

                                                        <!-- More transactions... -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div
                                    v-if="selected_invoice"
                                    class="border-dashed border-2 border-gray-300 p-2 mt-4 space-y-2"
                                >
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Reference</label
                                        >
                                        <div class="mt-1">
                                            <input
                                            v-model="selected_invoice.formatted_transaction_number"
                                                disabled
                                                type="text"
                                                class="bg-gray-300 text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Invoice No</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                disabled
                                                v-model="
                                                    selected_invoice.invoice_number
                                                "
                                                type="text"
                                                class="bg-gray-300 text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Invoice Date</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                disabled
                                                v-model="
                                                    selected_invoice.reference_date
                                                "
                                                type="text"
                                                class="bg-gray-300 text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Amount</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                v-model="
                                                    selected_invoice.amount
                                                "
                                                type="number"
                                                class="text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Paid Amount</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                v-model="
                                                    selected_invoice.paid_amount
                                                "
                                                type="number"
                                                class="text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Balance</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                v-model="
                                                    selected_invoice.new_balance
                                                "
                                                type="number"
                                                class="text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                            >Tax Due</label
                                        >
                                        <div class="mt-1">
                                            <input
                                                v-model="
                                                    selected_invoice.tax_due
                                                "
                                                type="number"
                                                class="text-right block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex justify-between space-x-4 mt-4">
                            <button
                                :class="{
                                    'opacity-50 cursor-not-allowed' : !selected_invoice
                                }"
                                :disabled="!selected_invoice"
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
    props: {
        account_code: {
            required: true,
        },
        receipt_id: {
            required: true,
        }
    },
    data() {
        return {
            invoices: null,
            selected_invoice: null,
            search: "",
            timer: null,
        };
    },
    methods: {
        close() {
            console.log("closing..");
            this.$emit("close");
        },
        fetchInvoices(page = 1) {
            axios
                .get(
                    `/customer-accounts/${this.account_code}/unpaid-invoices`,
                    {
                        params: {
                            page: page,
                            limit: 100,
                        },
                    }
                )
                .then((res) => {
                    console.log(res);
                    this.invoices = {
                        meta: res.data.meta,
                        links: res.data.links,
                        data: [],
                    };

                    res.data.data.forEach((e, k) => {
                        var data = {
                            ...e,
                            is_selected: false,
                            amount: e.balance,
                            paid_amount: e.balance,
                            new_balance: 0,
                            tax_due: 0,
                        };

                        this.invoices.data.push(data);
                    });
                });
        },
        selectItem(item) {
            if (item.is_selected == true) {
                item.is_selected = false;
                this.selected_invoice = null;
                return;
            }

            this.selected_invoice = null;
            this.invoices.data.forEach((e) => {
                e.is_selected = false;
            });

            item.is_selected = true;
            setTimeout(() => {
                this.selected_invoice = JSON.parse(JSON.stringify(item));
            }, 50);
        },
        submit() {
            confirm.fire().then((result) => {
                if (result.isConfirmed) {
                    console.log("submitted...");

                    console.log(this.selected_invoice);
                    axios.post(`/official-receipts/${this.receipt_id}/invoice`, {
                        ...this.selected_invoice
                    }).then(res => {
                        console.log(res);
                    });
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
    },
    mounted() {
        this.fetchInvoices();
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
