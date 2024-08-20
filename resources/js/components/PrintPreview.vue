<template>
    <transition name="container">
        <div
            class="fixed inset-x-0 inset-y-0 bg-gray-700 z-50 overflow-auto text-gray-700"
        >
            <button
                @click="close()"
                class="absolute top-2 right-2 text-gray-50"
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

            <div class="flex space-x-10 justify-center">
                <div class="os-container pb-5 hidden">
                    <div class="py-2 flex justify-center">
                        <button
                            class="border-white border-2 text-white rounded px-3 py-1 tracking-widest hover:bg-gray-600"
                            @click="print()"
                        >
                            Print
                        </button>
                    </div>

                    <!-- CONTENT -->
                    <div class="bg-white px-2" id="print">
                        <!-- LOGO -->
                        <div class="py-2">
                            <img
                                v-if="
                                    get_settings.show_header_logo_in_print_preview
                                "
                                src="/assets/logo-sm.png"
                                alt=""
                                srcset=""
                            />
                            <div
                                class="text-sky-600 leading-4 font-semibold text-center"
                            >
                                {{ get_settings.app_name }}
                                <div class="text-xs font-normal">
                                    Application
                                </div>
                            </div>
                        </div>

                        <div class="text-[10px] mt-2">
                            <!--
                            <div class="flex justify-between items-center">
                                <div>Orderslip No.</div>
                                <div>{{ order_summary.orderslip_number }}</div>
                            </div>
                            -->
                            <div
                                v-if="get_settings.app_type == 'shell_ambulant'"
                                class="flex justify-between items-center"
                            >
                                <div>Nick Name</div>
                                <div>
                                    {{
                                        order_summary.plate_number
                                            ? order_summary.plate_number
                                            : "-"
                                    }}
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Server</div>
                                <div>{{ order_summary.prepared_by }}</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Date</div>
                                <div>{{ order_summary.date }}</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Time</div>
                                <div>{{ order_summary.time }}</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Status</div>
                                <div>{{ order_summary.status }}</div>
                            </div>
                            <div
                                v-if="
                                    get_settings.app_type != 'invoicer_ambulant'
                                "
                                class="flex justify-between items-center"
                            >
                                <div>Total Headcount</div>
                                <div>{{ order_summary.total_headcount }}</div>
                            </div>
                            <div
                                v-if="
                                    get_settings.app_type ==
                                    'restaurant_ambulant'
                                "
                                class="flex justify-between items-center"
                            >
                                <div>Table No.</div>
                                <div>{{ order_summary.table_number }}</div>
                            </div>
                        </div>

                        <div class="mt-2 py-2 border-gray-200 border-t">
                            <!-- STORE -->
                            <div
                                v-for="(store, index) in order_summary.stores"
                                :key="index"
                                class="text-[10px] text-gray-700"
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
                                    class="border-b pl-2"
                                >
                                    <div class="grid grid-cols-12 items-start">
                                        <!-- <div class="col-span-2 text-center">
                                            <div class="inline-block text-[8px]">
                                                {{ item.quantity }}x
                                            </div>
                                        </div> -->
                                        <div class="col-span-12 mt-1">
                                            <div class="text-[9px] font-medium">
                                                {{ item.parent.description }}
                                            </div>
                                            <div
                                                class="col-span-12 flex justify-between"
                                            >
                                                <div
                                                    class="inline-block text-[8px]"
                                                >
                                                    {{ item.parent.quantity }} x
                                                    P{{
                                                        item.parent.price.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    class="text-[8px] font-semibold text-right"
                                                >
                                                    {{
                                                        item.parent.net_amount.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                            <div class="pl-2">
                                                <div
                                                    v-for="(
                                                        component,
                                                        componentIndex
                                                    ) in item.items"
                                                    :key="componentIndex"
                                                    class="text-[9px] flex justify-between"
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
                                                    class="text-[8px]"
                                                >
                                                    *{{ item.parent.remarks }}*
                                                </div>
                                                <div
                                                    v-if="item.parent.os_sc"
                                                    class="text-[8px]"
                                                >
                                                    #{{
                                                        item.parent.os_sc
                                                            .SC_NAME
                                                    }}#
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-span-2">
                                            <div class="text-[8px] font-semibold text-right">{{ item.amount }}</div>
                                        </div> -->
                                        <!-- <div class="col-span-12 flex justify-between">
                                            <div class="inline-block text-[8px]">
                                                {{ item.parent.quantity }} x P{{item.parent.price.toFixed(2)}}
                                            </div>
                                            <div class="text-[8px] font-semibold text-right">{{ item.parent.amount }}</div>
                                        </div> -->
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        get_settings.app_type ==
                                        'shell_ambulant'
                                    "
                                    class="flex justify-end mb-2"
                                >
                                    Sub Total:
                                    <span class="ml-2 font-semibold">{{
                                        store.sub_total
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div
                                class="flex justify-between items-center text-[10px] font-semibold"
                            >
                                TOTAL
                                <div>{{ order_summary.total_amount }}</div>
                            </div>
                            <!-- SERVICE CHARGE -->
                            <div
                                v-if="get_settings.service_charge"
                                class="pl-4 flex justify-between items-center text-[8px] font-semibold"
                            >
                                Service Charge ({{
                                    order_summary.service_charge_percentage
                                }}%)
                                <div>
                                    {{ order_summary.service_charge_amount }}
                                </div>
                            </div>
                            <div
                                class="pl-4 flex justify-between items-center text-[8px] font-semibold"
                            >
                                <!-- DISCOUNTABLE -->
                                VATable Sales
                                <div>{{ order_summary.vatable_sales }}</div>
                            </div>
                            <div
                                class="pl-4 flex justify-between items-center text-[8px] font-semibold"
                            >
                                Less VAT
                                <div>{{ order_summary.vat_amount }}</div>
                            </div>
                            <div
                                class="pl-4 flex justify-between items-center text-[8px] font-semibold"
                            >
                                VAT Ex.
                                <div>{{ order_summary.vat_ex }}</div>
                            </div>
                            <div
                                class="pl-4 flex justify-between items-center text-[8px] font-semibold"
                            >
                                20.00% SC Disc.
                                <div>
                                    {{ order_summary.sc_discount_amount }}
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center text-xs font-semibold"
                            >
                                GRAND TOTAL
                                <div>{{ order_summary.net_amount }}</div>
                            </div>
                        </div>

                        <div
                            v-if="order_summary.sc_records.length > 0"
                            class="border-2 border-dashed p-2 mt-4 text-[9px]"
                        >
                            <div class="text-center">Senior(s) Detail</div>
                            <ul role="list" class="divide-y divide-gray-200">
                                <li
                                    v-for="(
                                        item, scIndex
                                    ) in order_summary.sc_records"
                                    :key="scIndex"
                                    class="py-1"
                                >
                                    <div>ID: {{ item.SC_ID }}</div>
                                    <div>NAME: {{ item.SC_NAME }}</div>
                                    <div>ADDRESS: {{ item.SC_ADDRESS }}</div>
                                </li>
                            </ul>
                        </div>

                        <!-- HAS CUSTOMER -->
                        <div
                            v-if="order_summary.customer"
                            class="border-2 border-dashed p-2 mt-4 text-[9px]"
                        >
                            <div class="text-center text-[10px]">
                                CUSTOMER INFORMATION
                            </div>
                            <div class="flex justify-between space-x-2 mt-1">
                                <div>Name</div>
                                <div class="font-semibold text-right">
                                    {{
                                        order_summary.formatted_customer
                                            .customer_name
                                    }}
                                </div>
                            </div>
                            <div
                                v-if="
                                    order_summary.formatted_customer
                                        .email_address != ''
                                "
                                class="flex justify-between space-x-2"
                            >
                                <div>Email</div>
                                <div class="font-semibold text-right">
                                    {{
                                        order_summary.formatted_customer
                                            .email_address
                                    }}
                                </div>
                            </div>
                        </div>

                        <div
                            class="text-center mt-1 py-2 border-dashed border-2"
                        >
                            <div class="leading-5 font-semibold">
                                <!-- <div class="text-xs">ORDER SLIP</div> -->
                                <div class="text-xs uppercase">
                                    {{
                                        get_settings.app_type ==
                                        "invoicer_ambulant"
                                            ? "Pullout Slip"
                                            : ""
                                    }}
                                    {{
                                        get_settings.app_type ==
                                        "restaurant_ambulant"
                                            ? "Order Slip"
                                            : ""
                                    }}
                                    {{
                                        get_settings.app_type ==
                                        "shell_ambulant"
                                            ? "Order Slip"
                                            : ""
                                    }}
                                </div>
                                <div class="">
                                    {{ order_summary.orderslip_number }}
                                </div>
                            </div>
                            <div
                                v-if="
                                    get_settings.show_qr_code_in_print_preview
                                "
                                class="flex justify-center pr-8 pl-8 pt-2"
                            >
                                <qr-code
                                    :text="order_summary.orderslip_number"
                                    :size="80"
                                ></qr-code>
                            </div>
                        </div>
                        <div class="text-white">
                            <div>.</div>
                            <div>.</div>
                        </div>
                    </div>
                </div>

                <div class="os-container2">
                    <div class="py-2 flex justify-center">
                        <button
                            class="border-white border-2 text-white rounded px-3 py-1 tracking-widest hover:bg-gray-600"
                            @click="posPrint()"
                        >
                            Print
                        </button>
                    </div>
                    <div v-if="print_data" class="w-full bg-gray-100">
                        <!-- <pre v-for="(item, i) in print_data" :key="i">
                            {{ item }}
                        </pre> -->
                        <pre>
                            <p v-for="(item, index) in print_data" :key="index">{{ item }}</p>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: {
        order_summary: {
            required: true,
            default: null,
        },
    },
    data() {
        return {
            print_data: null,
        };
    },
    methods: {
        close() {
            this.$store.dispatch("closePrintView");
        },
        print() {
            window.print();
        },
        posPrint(preview = null) {
            console.log(this.order_summary);
            axios
                .get(`/pos-print`, {
                    params: {
                        orderslip_number: this.order_summary.orderslip_number,
                        preview: preview,
                    },
                })
                .then((response) => {
                    this.print_data = response.data.data.print_data;
                })
                .catch((error) => {});
        },
    },
    computed: {
        ...mapGetters(["get_settings"]),
    },
    created() {
        this.posPrint(true);
    },
};
</script>

<style>
@media print {
    * {
        visibility: hidden;
        overflow: hidden;
    }

    @page {
        width: 58mm;
        margin: 0;
        padding: 0;

        /* margin-left: 5px !important; */
        /* width: 58mm;
            margin: 2;
            padding: 0; */
    }
    #print * {
        width: auto;
        visibility: visible;
        border: none;
    }
}
.os-container2 {
    /* width: 58mm; */
    width: 400px;
    font-size: 4mm;
    font-family: monospace;
}
.os-container {
    width: 58mm;
    font-family: monospace;
}
.container-enter-active,
.container-leave-active {
    transition: opacity 0.5s;
}
.container-enter, .container-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
