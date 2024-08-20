<template>
    <div>
        <transition name="container">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div
                class="relative z-10 content"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
            >
                <!--
                    Background backdrop, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                    Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                ></div>

                <div class="fixed z-10 inset-0 overflow-y-auto">
                    <div
                        class="flex items-center sm:items-center justify-center min-h-full p-4 text-center"
                    >
                        <!--
                            Modal panel, show/hide based on modal state.

                            Entering: "ease-out duration-300"
                            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            To: "opacity-100 translate-y-0 sm:scale-100"
                            Leaving: "ease-in duration-200"
                            From: "opacity-100 translate-y-0 sm:scale-100"
                            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        -->
                        <!-- CONTAINER -->
                        <div
                            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-3xl w-full sm:p-6"
                        >
                            <!-- CLOSE BUTTON -->
                            <button
                                @click="close()"
                                class="absolute top-0 right-0 btn btn-danger rounded-full inline-flex items-center p-1 mt-2 mr-2"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>

                            <!-- BODY -->
                            <div>
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                >
                                    Collection
                                </h3>

                                <!-- CONTENT -->
                                <div
                                    v-if="official_receipt"
                                    class="py-4 grid grid-cols-12 gap-2"
                                >
                                    <div class="col-span-6">
                                        <label
                                            for="or"
                                            class="block text-xs font-medium text-gray-500"
                                        >
                                            Official Receipt No.
                                        </label>
                                        <div class="mt-0">
                                            <h1
                                                class="text-lg font-bold text-gray-500"
                                            >
                                                {{
                                                    official_receipt.header
                                                        .formatted_id
                                                }}
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <label
                                            for="or"
                                            class="block text-xs font-medium text-gray-500"
                                        >
                                            Date
                                        </label>
                                        <div class="mt-0">
                                            <h1
                                                class="text-lg font-bold text-gray-500"
                                            >
                                                {{
                                                    official_receipt.header
                                                        .formatted_date
                                                }}
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div
                                            class="border-dashed border-2 border-gray-300 p-2"
                                        >
                                            <div class="">
                                                <div
                                                    class="flex justify-between"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-500"
                                                    >
                                                        Customer Information
                                                    </label>
                                                    <div
                                                        v-if="
                                                            read_only == false
                                                        "
                                                        class="flex items-center space-x-1"
                                                    >
                                                        <button
                                                            v-if="
                                                                official_receipt
                                                                    .header
                                                                    .account
                                                            "
                                                            @click="
                                                                removeCustomer()
                                                            "
                                                            class="btn btn-xs btn-danger px-1"
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
                                                            @click="
                                                                show_customer_browser = true
                                                            "
                                                            class="btn btn-xs btn-info"
                                                        >
                                                            Browse
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                v-if="
                                                    official_receipt.header
                                                        .account
                                                "
                                                class="mt-2"
                                            >
                                                <div
                                                    class="flex justify-between"
                                                >
                                                    <span
                                                        class="badge bg-blue-100 text-blue-800 uppercase font-semibold"
                                                    >
                                                        {{
                                                            official_receipt
                                                                .header.account
                                                                .code
                                                        }}
                                                    </span>
                                                    <span
                                                        class="badge bg-blue-100 text-blue-800"
                                                    >
                                                        {{
                                                            official_receipt
                                                                .header.account
                                                                .email
                                                                ? official_receipt
                                                                      .header
                                                                      .account
                                                                      .email
                                                                : "No email"
                                                        }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h1
                                                        class="text-lg font-bold text-gray-500"
                                                    >
                                                        {{
                                                            official_receipt
                                                                .header.account
                                                                .name
                                                        }}
                                                    </h1>
                                                </div>
                                            </div>
                                            <div
                                                v-else
                                                class="mt-2 p-2 text-center"
                                            >
                                                NO RECORD
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div
                                            class="border-dashed border-2 border-gray-300 p-2"
                                        >
                                            <div class="">
                                                <div
                                                    class="flex justify-between"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-500"
                                                    >
                                                        Invoice(s)
                                                    </label>
                                                    <div
                                                        class="flex items-center space-x-1"
                                                    >
                                                        <button
                                                            @click="
                                                                show_insert_invoice_modal = true
                                                            "
                                                            :class="{
                                                                'opacity-50 cursor-not-allowed': !show_insert_invoice_button
                                                            }"
                                                            :disabled="!show_insert_invoice_button"
                                                            class="btn btn-xs btn-info"
                                                        >
                                                            Insert
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div
                                            class="border-dashed border-2 border-gray-300 p-2"
                                        >
                                            <div class="">
                                                <div
                                                    class="flex justify-between"
                                                >
                                                    <label
                                                        class="block text-sm font-medium text-gray-500"
                                                    >
                                                        Payment(s)
                                                    </label>
                                                    <div
                                                        v-if="
                                                            read_only == false
                                                        "
                                                        class="flex items-center space-x-1"
                                                    >
                                                        <button
                                                            @click="
                                                                show_add_mode_of_payment = true
                                                            "
                                                            class="btn btn-xs btn-info"
                                                        >
                                                            Insert
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <!-- items -->

                                                <!-- This example requires Tailwind CSS v2.0+ -->
                                                <ul
                                                    role="list"
                                                    class="divide-y divide-gray-200"
                                                >
                                                    <li class="py-2">
                                                        <!-- Your content -->
                                                        <div
                                                            class="flex items-start justify-between"
                                                        >
                                                            <div>
                                                                <span
                                                                    class="badge bg-blue-100 text-blue-800 uppercase font-semibold"
                                                                >
                                                                    CASH
                                                                </span>
                                                                <h1
                                                                    class="text-lg font-bold text-gray-500"
                                                                >
                                                                    666.66
                                                                </h1>
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    read_only ==
                                                                    false
                                                                "
                                                            >
                                                                <button
                                                                    class="btn btn-xs btn-info"
                                                                >
                                                                    Edit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="py-2">
                                                        <!-- Your content -->
                                                        <div
                                                            class="flex items-start justify-between"
                                                        >
                                                            <div>
                                                                <span
                                                                    class="badge bg-blue-100 text-blue-800 uppercase font-semibold"
                                                                >
                                                                    BANK
                                                                    TRANSFER
                                                                </span>
                                                                <h1
                                                                    class="text-lg font-bold text-gray-500"
                                                                >
                                                                    222.22
                                                                </h1>
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    read_only ==
                                                                    false
                                                                "
                                                            >
                                                                <button
                                                                    class="btn btn-xs btn-info"
                                                                >
                                                                    Edit
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- other detail -->
                                                        <div class="mt-1">
                                                            <div
                                                                class="flex justify-between"
                                                            >
                                                                <div class="">
                                                                    <label
                                                                        for="or"
                                                                        class="block text-xs font-medium text-gray-500"
                                                                    >
                                                                        Ref No.
                                                                    </label>
                                                                    <div
                                                                        class="mt-0"
                                                                    >
                                                                        <h1
                                                                            class="text-lg font-bold text-gray-500"
                                                                        >
                                                                            0011232
                                                                        </h1>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="text-right"
                                                                >
                                                                    <label
                                                                        for="or"
                                                                        class="block text-xs font-medium text-gray-500"
                                                                    >
                                                                        Bank
                                                                    </label>
                                                                    <div
                                                                        class="mt-0"
                                                                    >
                                                                        <h1
                                                                            class="text-base font-bold text-gray-500"
                                                                        >
                                                                            Metrobank
                                                                        </h1>
                                                                        <div
                                                                            class="text-xs"
                                                                        >
                                                                            08.29.2022
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end other detail -->
                                                    </li>

                                                    <!-- More items... -->
                                                </ul>

                                                <!-- END items -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 p-2">
                                        <div class="flex justify-between">
                                            <div>Total Amount</div>
                                            <div>{{ official_receipt.header.formatted_amount }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Less SC/PWD Discount</div>
                                            <div>{{ official_receipt.header.formatted_sc_pwd_discount }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Total Due</div>
                                            <div>{{ official_receipt.header.formatted_net_due }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Less Withholding Tax</div>
                                            <div>0.00</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Total Paid</div>
                                            <div>{{ official_receipt.header.formatted_net_amount }}</div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 p-2">
                                        <div class="flex justify-between">
                                            <div>Vatabale Sales</div>
                                            <div>{{ official_receipt.header.formatted_vatable_sales }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Vat Amount</div>
                                            <div>{{ official_receipt.header.formatted_vat_amount }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Vat Exempt Sales</div>
                                            <div>{{ official_receipt.header.formatted_vat_exempt }}</div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>Zero Rated Sales</div>
                                            <div>{{ official_receipt.header.formatted_zero_rated }}</div>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div class="grid grid-cols-1 gap-4">
                                            <button
                                                @click="sendToEmail()"
                                                v-if="
                                                    official_receipt.header
                                                        .account
                                                "
                                                :class="{
                                                    'opacity-50 cursor-not-allowed':
                                                        official_receipt.header
                                                            .account.email ==
                                                        null,
                                                }"
                                                :disabled="
                                                    official_receipt.header
                                                        .account.email == null
                                                "
                                                class="btn btn-info btn-md"
                                            >
                                                Send to Email
                                            </button>
                                            <!-- <button class="btn btn-info btn-md">
                                                Print Receipt
                                            </button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <accounts.browser
            v-if="show_customer_browser"
            @close="customerBrowserOnClose"
        ></accounts.browser>
        <accounts.add_mode_of_payment
            v-if="show_add_mode_of_payment"
            @close="show_add_mode_of_payment = false"
        ></accounts.add_mode_of_payment>
        <accounts.add_invoice
            :account_code="official_receipt.header.account.code"
            :receipt_id="official_receipt.header.id"
            v-if="show_insert_invoice_modal"
            @close="show_insert_invoice_modal = false"
        ></accounts.add_invoice>
    </div>
</template>

<script>
export default {
    props: {
        z_index: {
            default: "z-10",
        },
        read_only: {
            type: Boolean,
            default: false,
        },
        official_receipt_id: {
            default: null,
        },
    },
    data() {
        return {
            official_receipt: null,
            show_customer_browser: false,
            show_add_mode_of_payment: false,
            show_insert_invoice_modal: false,
        };
    },
    methods: {
        close() {
            this.$store.dispatch("fetchOfficialReceipts");
            this.$emit("close");
        },
        customerBrowserOnClose(payload) {
            console.log(payload);
            this.show_customer_browser = false;
            if (payload) {
                // update customer code in or
                axios
                    .post(
                        `/official-receipts/${this.official_receipt.header.id}/customer`,
                        {
                            account_code: payload.account.code,
                            account_name: payload.account.name,
                        }
                    )
                    .then((res) => {
                        this.fetch();
                    });
            }
        },
        fetch() {
            if (this.official_receipt_id == null) {
                return;
            }

            axios
                .get(`/official-receipts/${this.official_receipt_id}`)
                .then((res) => {
                    this.official_receipt = res.data.data;
                });
        },
        removeCustomer() {
            confirm
                .fire({
                    text: "This will remove customer record in Official Receipt!",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete(
                                `/official-receipts/${this.official_receipt.header.id}/customer`
                            )
                            .then((res) => {
                                this.fetch();
                            });
                    }
                });
        },
        sendToEmail() {
            console.log("sending email...");

            confirm
                .fire({
                    text: "It will send an Official Receipt to the customer.",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(
                                `/official-receipts/${this.official_receipt.header.id}/email-sender`,
                                {
                                    email: this.official_receipt.header.account
                                        .email,
                                }
                            )
                            .then((res) => {
                                // console.log(res);
                                toast.fire({ title: res.data.message });
                            });
                    }
                });
        },
    },
    computed: {
        show_insert_invoice_button(){
            if (this.read_only == true) {
                return false;
            }

            if (this.official_receipt.header.account == null) {
                return false;
            }

            return true;
        }
    },
    mounted() {
        this.fetch();
    },
};
</script>

<style scoped>
.content {
    @apply text-gray-500;
}
.container-enter-active,
.container-leave-active {
    transition: opacity 0.5s;
}
.container-enter, .container-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
