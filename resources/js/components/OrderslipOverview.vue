<template>
    <transition name="cart">
        <div class="fixed inset-x-0 inset-y-0 bg-gray-100 z-50 overflow-auto">
            <button
                @click="$store.dispatch('closeOSOverview')"
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

            <div v-if="order_summary != null" class="m-auto container p-5">
                <h1 class="font-extrabold text-2xl text-gray-800">
                    Transaction Summary
                </h1>

                <div
                    class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5 text-gray-600"
                >
                    <div>
                        <!-- IF HAS RECORDS -->
                        <div v-if="order_summary.stores.length > 0" class="">
                            <!-- STORE -->
                            <div
                                v-for="(store, index) in order_summary.stores"
                                :key="index"
                            >
                                <h1
                                    v-if="
                                        [
                                            'shell_ambulant',
                                            'invoicer_ambulant',
                                        ].includes(get_settings.app_type)
                                    "
                                    class="font-semibold"
                                >
                                    {{ store.store.description }}
                                </h1>

                                <!-- ITEMS -->
                                <div
                                    v-for="(item, index2) in store.store_orders"
                                    :key="index2"
                                    class="mt-2 pb-2 border-b"
                                >
                                    <div>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 font-"
                                        >
                                            ₱{{ item.parent.price }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"
                                        >
                                            x{{ item.parent.quantity }}
                                        </span>
                                        <span
                                            v-if="item.parent.sc_headcount > 0"
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800"
                                        >
                                            {{ item.parent.sc_headcount }}
                                            Senior
                                        </span>
                                        <span
                                            v-if="
                                                item.parent.is_group_meal == 1
                                            "
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800"
                                        >
                                            gm:{{
                                                item.parent.group_serving
                                            }}pax
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-12">
                                        <div class="col-span-10">
                                            <div class="font-medium">
                                                {{ item.parent.description }}
                                            </div>
                                            <div>
                                                <div
                                                    v-for="(
                                                        component,
                                                        componentIndex
                                                    ) in item.items"
                                                    :key="componentIndex"
                                                    class="text-xs flex justify-between"
                                                >
                                                    <div class="truncate">
                                                        -
                                                        {{
                                                            component.quantity
                                                        }}x
                                                        {{
                                                            component.description
                                                        }}
                                                    </div>
                                                    <div class="text-right">
                                                        {{
                                                            component.net_amount >
                                                            0
                                                                ? component.net_amount.toFixed(
                                                                      2
                                                                  )
                                                                : ""
                                                        }}
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="item.parent.remarks"
                                                    class="text-xs"
                                                >
                                                    *{{ item.parent.remarks }}*
                                                </div>
                                                <div
                                                    v-if="item.parent.os_sc"
                                                    class="text-xs"
                                                >
                                                    #{{
                                                        item.parent.os_sc
                                                            .SC_NAME
                                                    }}#
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <div
                                                class="text-sm font-semibold text-right"
                                            >
                                                {{ item.parent.net_amount }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end mb-2 mt-1">
                                    Sub Total :
                                    <span class="ml-2 font-semibold">{{
                                        store.sub_total
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- IF NO RECORDS -->
                        <div
                            v-if="order_summary.stores.length == 0"
                            class="flex items-center justify-center"
                        >
                            <div class="text-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="mx-auto h-16 w-16 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <!-- <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3> -->
                                <p
                                    class="mt-1 text-sm text-gray-500 font-medium"
                                >
                                    Nothing to display.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div
                            v-if="order_summary.sc_records.length > 0"
                            class="border-2 border-gray-300 border-dashed p-2"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    Senior(s) Detail
                                </div>
                            </div>
                            <div
                                v-if="order_summary.is_sc"
                                class="flow-root mt-2"
                            >
                                <ul
                                    role="list"
                                    class="divide-y divide-gray-200"
                                >
                                    <li
                                        v-for="(
                                            item, scIndex
                                        ) in order_summary.sc_records"
                                        :key="scIndex"
                                        class=""
                                    >
                                        <div
                                            class="flex items-center space-x-4"
                                        >
                                            <!-- <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                            </div> -->
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-medium text-gray-900 truncate"
                                                >
                                                    {{ item.SC_NAME }}
                                                </p>
                                                <p
                                                    class="text-xs text-gray-500 truncate"
                                                >
                                                    {{ item.SC_ADDRESS }}
                                                </p>
                                            </div>
                                            <div class="">
                                                <div class="text-right">
                                                    <strong class="text-xs">
                                                        {{ item.SC_ID }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-gray-200 rounded-md px-4 pb-4">
                            <div
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2 mt-2"
                            >
                                Job Order No.
                                <span class="font-extrabold text-lg">{{
                                    order_summary.orderslip_number
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2 mt-2"
                            >
                                Patient Name
                                <span class="font-extrabold text-lg">{{
                                    order_summary.customer_name
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Server
                                <span class="font-semibold">{{
                                    order_summary.prepared_by
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Date
                                <span class="font-semibold">{{
                                    order_summary.date
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Time
                                <span class="font-semibold">{{
                                    order_summary.time
                                }}</span>
                            </div>

                            <!-- NICK NAME -->
                            <div
                                v-if="get_settings.plate_number_entry"
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Nick Name</div>
                                <span class="font-semibold">
                                    {{
                                        order_summary.plate_number
                                            ? order_summary.plate_number
                                            : "-"
                                    }}
                                </span>
                            </div>

                            <!-- TABLE NO. -->
                            <div
                                v-if="
                                    get_settings.app_type ==
                                    'restaurant_ambulant'
                                "
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Table No.</div>
                                <span class="font-semibold">
                                    {{
                                        order_summary.table_number
                                            ? order_summary.table_number
                                            : "-"
                                    }}
                                </span>
                            </div>

                            <!-- HEAD COUNT -->
                            <div
                                v-if="order_summary.total_headcount > 0"
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Head Count</div>
                                <span class="font-semibold">
                                    {{ order_summary.total_headcount }}
                                </span>
                            </div>

                            <!-- DURATION -->
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                                v-if="
                                    ['shell_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                            >
                                Duration
                                <span class="font-semibold">{{
                                    order_summary.duration
                                }}</span>
                            </div>

                            <!-- STATUS -->
                            <div
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Status</div>
                                <span class="font-semibold">
                                    {{ order_summary.status }}
                                </span>
                            </div>

                            <!-- TOTALS -->
                            <!-- VATable Sales -->
                            <div
                                class="text-sm flex justify-end items-center mt-2"
                            >
                                <div class="flex items-center mr-4">
                                    VATable Sales
                                </div>
                                <span class="font-semibold">
                                    {{ order_summary.vatable_sales }}
                                </span>
                            </div>
                            <!-- VAT Amount -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    VAT Amount
                                </div>
                                <span class="font-semibold">
                                    {{ order_summary.vat_amount }}
                                </span>
                            </div>
                            <!-- VAT Ex -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    VAT Ex.
                                </div>
                                <span class="font-semibold">
                                    {{ order_summary.vat_ex }}
                                </span>
                            </div>

                            <!-- SC Discount -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    SC Discount
                                </div>
                                <span class="font-semibold">
                                    {{ order_summary.sc_discount_amount }}
                                </span>
                            </div>
                            <!-- Service Charge -->
                            <div
                                v-if="get_settings.service_charge"
                                class="text-sm flex justify-end items-center"
                            >
                                <div class="flex items-center mr-4 italic">
                                    (Service Charge
                                    {{
                                        order_summary.service_charge_percentage
                                    }}%)
                                </div>
                                <span class="font-semibold">
                                    {{ order_summary.service_charge_amount }}
                                </span>
                            </div>
                            <!-- GRAND TOTAL -->
                            <div class="text-base flex justify-between py-3">
                                <span class="font-bold"> Net Amount </span>
                                <span class="font-bold">{{
                                    order_summary.net_amount
                                }}</span>
                            </div>
                            <!-- TOTALS -->

                            <!-- GRAND TOTAL -->
                            <!-- <div class="text-base flex justify-between py-3">
                                <span class="font-bold"> Grand Total </span>
                                <span class="font-bold">{{
                                    order_summary.total_amount
                                }}</span>
                            </div> -->

                            <!-- PRINT PREVIEW -->
                            <div>
                                <button
                                    @click="printPreview()"
                                    type="submit"
                                    class="tracking-wider w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                >
                                    Print Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <print-preview
                v-if="get_print_preview_status"
                :order_summary="order_summary"
            ></print-preview>
        </div>
    </transition>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";
import PrintPreview from "./PrintPreview.vue";
export default {
    components: { PrintPreview },
    data() {
        return {
            order_summary: null,
        };
    },
    methods: {
        ...mapMutations([]),
        updatePlateNumber() {
            swal.fire({
                title: "Enter Plate #",
                input: "text",
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,

                preConfirm: (input) => {
                    return input;
                },
                allowedOutsideClick: () => !swal.isLoading(),
            }).then((result) => {
                if (result.value) {
                    // debug(result.value);
                    axios
                        .patch(`/plate-number`, {
                            plate_number: result.value.trim(),
                            orderslip_number:
                                this.order_summary.orderslip_number,
                        })
                        .then((res) => {
                            debug(res);
                            this.$store.dispatch(
                                "updateCurrentTransactionPlateNumber",
                                result.value.trim()
                            );
                            toast.fire({
                                text: "Plate Number updated successfully!",
                            });
                        })
                        .catch((err) => {
                            debug(err.response);
                        });
                }
            });
        },
        printPreview() {
            this.$store.dispatch("openPrintView");
        },
        fetchOrderslipData() {
            axios
                .get(`/orderslips/${this.get_os_overview_value}`)
                .then((res) => {
                    this.order_summary = res.data.data;
                })
                .catch((err) => {
                    debug(err);
                    toast.fire({
                        icon: "error",
                        text: err.response.data.message,
                    });
                });
        },
    },
    computed: {
        ...mapGetters([
            "get_print_preview_status",
            "get_os_overview_value",
            "get_settings",
        ]),
    },
    created() {
        this.fetchOrderslipData();
    },
};
</script>

<style>
.cart-enter-active,
.cart-leave-active {
    transition: opacity 0.5s;
}
.cart-enter, .cart-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
