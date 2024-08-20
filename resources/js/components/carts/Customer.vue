<template>
    <div class="py-2">
        <div class="flex justify-between">
            <div class="uppercase">Customer</div>
            <div>
                <button
                    v-if="get_current_transaction.customer"
                    @click="remove()"
                    type="button"
                    class="ml-1 inline-flex items-center px-1 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring focus:ring-sky-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-4 h-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                        />
                    </svg>
                </button>
                <button
                    @click="is_browser_open = true"
                    type="button"
                    class="ml-1 inline-flex items-center px-1 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-sky-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring focus:ring-sky-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                    </svg>
                    <span class="ml-1"> Browse </span>
                </button>
            </div>
        </div>

        <!-- NO CUSTOMER -->
        <div
            v-if="!get_current_transaction.customer"
            class="text-center text-gray-500 font-semibold"
        >
            REQUIRED
        </div>

        <!-- HAS CUSTOMER -->
        <div v-if="get_current_transaction.customer" class="text-sm">
            <div class="flex justify-between space-x-2">
                <div>Name</div>
                <div class="font-semibold text-right">
                    {{
                        get_current_transaction.formatted_customer.customer_name
                    }}
                </div>
            </div>
            <div
                v-if="
                    get_current_transaction.formatted_customer.email_address !=
                    ''
                "
                class="flex justify-between space-x-2"
            >
                <div>Email</div>
                <div class="font-semibold text-right">
                    {{
                        get_current_transaction.formatted_customer.email_address
                    }}
                    <div>
                        <button
                            @click="sendToEmail()"
                            type="button"
                            class="ml-1 inline-flex items-center px-1 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-sky-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring focus:ring-sky-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                                />
                            </svg>

                            <span class="ml-1"> Send to Email </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <carts-customer-browser
            v-if="is_browser_open"
            @close="is_browser_open = false"
        ></carts-customer-browser>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            is_browser_open: false,
        };
    },
    methods: {
        sendToEmail() {
            confirm.fire({text: 'This will send a pullout slip email to the customer.'}).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(
                            `/orderslips/${this.get_current_transaction.orderslip_number}/send-to-email`
                        )
                        .then((res) => {
                            toast.fire({ title: res.data.message });
                            this.$store.dispatch("fetchCurrentTransaction");
                        });
                }
            });
        },
        remove() {
            confirm.fire().then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(
                            `/orderslips/${this.get_current_transaction.orderslip_number}/customer`
                        )
                        .then((res) => {
                            toast.fire({ title: res.data.message });
                            this.$store.dispatch("fetchCurrentTransaction");
                        });
                }
            });
        },
    },
    computed: {
        ...mapGetters(["get_current_transaction"]),
    },
    mounted() {},
};
</script>

<style></style>
