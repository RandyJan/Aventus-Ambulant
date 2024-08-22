<template>
    <div class="pb-4">
        <div class="flex justify-center">
            <div class="flex items-center text-xs font-semibold">
                <div class="w-4 h-4 bg-green-500"></div>
                <span class="ml-1"> Paid </span>
            </div>
            <div class="ml-3 flex items-center text-xs font-semibold">
                <div class="w-4 h-4 bg-yellow-500"></div>
                <span class="ml-1"> Unpaid </span>
            </div>
            <!-- <div class="ml-3 flex items-center text-xs font-semibold">
                <div class="w-4 h-4 bg-sky-500" ></div>
                <span class="ml-1">
                    Current Transaction
                </span>
            </div> -->
        </div>

        <div class="mt-2 flex justify-between items-center">
            <div>
                <!-- @click="createNewOrderslip()" -->

                <!-- <button
                    @click="createNewOrderslip()"
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-sky-700 bg-sky-100 hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                >
                    New Transaction
                </button> -->
                <a
                href="/AddNewJO"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-sky-700 bg-sky-100 hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                >
                    New Transaction
            </a>
            </div>
            <div
                v-if="orderslips != null && orderslips.data.length > 0"
                class="flex items-center"
            >
                <span class="mr-2 text-sm text-gray-700">
                    <!-- Showing 1 to 10 of 20 results -->
                    Showing {{ orderslips.meta.from }} to
                    {{ orderslips.meta.to }} of
                    {{ orderslips.meta.total }} results
                </span>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <button
                        @click="btnPrevious()"
                        :class="{
                            'opacity-50 cursor-not-allowed':
                                orderslips.links.prev == null,
                        }"
                        :disabled="orderslips.links.prev == null"
                        type="button"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                    >
                        <span class="sr-only">Previous</span>
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>

                    <button
                        @click="btnNext()"
                        type="button"
                        :class="{
                            'opacity-50 cursor-not-allowed':
                                orderslips.links.next == null,
                        }"
                        :disabled="orderslips.links.next == null"
                        class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                    >
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </div>
        </div>

        <!-- IF HAS RECORDS -->
        <div
            v-if="orderslips != null && orderslips.data.length > 0"
            class="mt-4"
        >
            <ul
                role="list"
                class="grid grid-cols-2 gap-2 sm:gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
            >
                <li
                    v-for="(item, index) in orderslips.data"
                    :key="index"
                    class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200 relative overflow-hidden"
                >
                    <div class="w-full p-4 sm:px-8 md:px-6 text-gray-600">
                        <!-- :class="{
                            'bg-green-500': item.is_paid,
                            'bg-yellow-500': !item.is_paid,
                            'bg-sky-400':
                                get_auth.user.username ==
                                item.user_current_transaction,
                        }" -->
                        <div
                            :class="{
                                'bg-green-500': item.is_paid,
                                'bg-yellow-500': !item.is_paid,
                                'bg-sky-400':
                                    get_auth.user.username ==
                                    item.user_current_transaction,
                            }"
                            class="h-7 absolute top-0 inset-x-0 flex items-center justify-center"
                        >
                            <span class="text-white font-bold">
                                {{ item.orderslip_code  }}
                            </span>
                        </div>

                        <div class="mt-6">
                            <!-- Current Transaction Button -->
                            <button
                                v-if="
                                    get_auth.user.username ==
                                    item.user_current_transaction
                                "
                                @click="detachCurrentTransaction(item)"
                                type="button"
                                class="absolute top-1 right-1 bg-sky-100 flex-shrink-0 ml-0.5 h-5 w-5 rounded-full inline-flex items-center justify-center text-sky-400 hover:bg-sky-200 hover:text-sky-500 focus:outline-none focus:bg-sky-500 focus:text-white"
                            >
                                <!-- <span class="sr-only">Remove large option</span> -->
                                <svg
                                    class="h-3 w-3"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 8 8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.5"
                                        d="M1 1l6 6m0-6L1 7"
                                    />
                                </svg>
                            </button>
                            <!-- <div
                                v-if="
                                    get_auth.user.username ==
                                    item.user_current_transaction
                                "
                                class="absolute top-1.5 right-1.5 rounded-full items-center text-xs font-medium bg-sky-100 text-sky-700"
                            >
                                <button
                                    @click="detachCurrentTransaction(item)"
                                    type="button"
                                    class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-sky-400 hover:bg-sky-200 hover:text-sky-500 focus:outline-none focus:bg-sky-500 focus:text-white"
                                >
                                    <span class="sr-only"
                                        >Remove large option</span
                                    >
                                    <svg
                                        class="h-2 w-2"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 8 8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.5"
                                            d="M1 1l6 6m0-6L1 7"
                                        />
                                    </svg>
                                </button>
                            </div> -->

                            <!-- DATE & TIME -->
                            <div class="flex items-start mt-2">
                                <svg
    xmlns="http://www.w3.org/2000/svg"
    class="h-5 w-5"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
>
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M12 14c-3.313 0-6-2.686-6-6s2.687-6 6-6 6 2.686 6 6-2.687 6-6 6zm0 2c3.313 0 6 1.686 6 5v1H6v-1c0-3.314 2.687-5 6-5z"
    />
</svg>
                                <div class="text-sm truncate ml-2">
                                    <!-- {{ item.created_date }} <br /> -->
                                    <!-- {{ item.created_time }} -->
                                      
                                    {{ item.customer_name }}
                                    
                                </div>
                            </div>

                            <!-- DEVICE ID -->
                            <div
                                v-if="
                                    get_settings.app_type ==
                                    'restaurant_ambulant'
                                "
                                class="flex items-center mt-1"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                    />
                                </svg>
                                <div class="text-sm truncate ml-2">
                                    {{
                                        item.terminal != null
                                            ? item.terminal.description
                                            : ""
                                    }}
                                </div>
                            </div>
                                <!-- DATE -->
                                <div
                                v-if="
                                    get_settings.app_type ==
                                    'restaurant_ambulant'
                                "
                                class="flex items-center mt-1"
                            >
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg> 
                                <div class="text-sm truncate ml-2">
                                   {{ item.created_date }} <br />
                                    {{ item.created_time }}
                                </div>
                            </div>

                            <!-- NICK NAME -->
                            <div
                                v-if="get_settings.app_type == 'shell_ambulant'"
                                class="flex items-center mt-1"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                    />
                                </svg>

                                <div class="text-sm truncate ml-2">
                                    <!-- {{
                                        item.plate_number
                                            ? item.plate_number
                                            : "-"
                                    }} -->

                                </div>
                            </div>

                            <!-- TABLE NO. -->
                            <div
                                v-if="
                                    get_settings.app_type ==
                                    'restaurant_ambulant'
                                "
                                class="flex items-center mt-1"
                            >
                                <!-- <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                                    />
                                </svg> -->
                        <!-- Procedure/s: {{item}} -->
                                <div class="text-sm truncate ml-2">
                                    <!-- {{ item.length}} -->
                                      
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200">
                            <div
                                v-if="
                                    get_auth.user.username !=
                                    item.user_current_transaction
                                "
                                @click="attachCurrentTransaction(item)"
                                class="w-0 flex-1 flex"
                            >
                                <a
                                    href="javascript:;"
                                    class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="text-gray-400 h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
                                        />
                                    </svg>
                                </a>
                            </div>
                            <div
                                v-if="
                                    get_auth.user.username ==
                                        item.user_current_transaction &&
                                    item.is_paid == true
                                "
                                @click="markAsCompleteTheOrderslip(item)"
                                class="w-0 flex-1 flex"
                            >
                                <a
                                    href="javascript:;"
                                    class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="text-gray-400 h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </a>
                            </div>
                            <div
                                @click="
                                    openModalForOSOverview(item.orderslip_code)
                                "
                                class="-ml-px w-0 flex-1 flex"
                            >
                                <a
                                    href="javascript:;"
                                    class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500"
                                >
                                    <!-- Heroicon name: solid/phone -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                        />
                                    </svg>
                                    <!-- <span class="ml-3">View Detail</span> -->
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- More orderslip... -->
            </ul>
        </div>

        <!-- IF HAS RECORDS - PAGINATION -->
        <div
            v-if="orderslips != null && orderslips.data.length > 0"
            class="flex justify-between items-center mt-4"
        >
            <div>
                <!-- <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-sky-700 bg-sky-100 hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">Create new Orderslip</button> -->
            </div>
            <div class="flex items-center">
                <span class="mr-2 text-sm text-gray-700">
                    <!-- Showing 1 to 10 of 20 results -->
                    Showing {{ orderslips.meta.from }} to
                    {{ orderslips.meta.to }} of
                    {{ orderslips.meta.total }} results
                </span>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <button
                        @click="btnPrevious()"
                        type="button"
                        :class="{
                            'opacity-50 cursor-not-allowed':
                                orderslips.links.prev == null,
                        }"
                        :disabled="orderslips.links.prev == null"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                    >
                        <span class="sr-only">Previous</span>
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>

                    <button
                        @click="btnNext()"
                        type="button"
                        :class="{
                            'opacity-50 cursor-not-allowed':
                                orderslips.links.next == null,
                        }"
                        :disabled="orderslips.links.next == null"
                        class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                    >
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </div>
        </div>

        <!-- IF NO RECORDS -->
        <div
            v-if="orderslips != null && orderslips.data.length == 0"
            class="mt-10 text-center"
        >
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
            <p class="mt-1 text-sm text-gray-500 font-medium">
                Nothing to display.
            </p>
        </div>

        <orderslip-overview v-if="get_os_overview_status"></orderslip-overview>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
    data() {
        return {
            search: "",
            orderslips: null,
        };
    },
    methods: {
        ...mapMutations(["open_the_cart"]),
        btnPrevious() {
            if (this.orderslips.links.prev == null) {
                // toast.fire({title: 'This is the first page.', icon: 'warning'})
                toast.fire({ title: "Noting to display!", icon: "warning" });
                return;
            }
            this.fetchOrderslip(this.orderslips.meta.current_page - 1);
        },
        btnNext() {
            if (this.orderslips.links.next == null) {
                // toast.fire({title: 'This is the last page.', icon: 'warning'})
                toast.fire({ title: "Noting to display!", icon: "warning" });
                return;
            }
            this.fetchOrderslip(this.orderslips.meta.current_page + 1);
        },
        fetchOrderslip(page = null) {
            axios
                .get(`/orderslips`, {
                    params: {
                        branch_id: this.get_auth
                            ? this.get_auth.branch.id
                            : null,
                        outlet_id: this.get_auth
                            ? this.get_auth.outlet.id
                            : null,
                        search: this.search,
                        page: page ?? 1,
                        limit: 25,
                        hide_completed: true,
                    },
                })
                .then((res) => {
                    this.orderslips = JSON.parse(JSON.stringify(res.data));
                })
                .catch((error) => {
                    this.orderslips = null;
                });
        },
        createNewOrderslip() {
        //     swal.fire({
        //         title: "Are you sure?",
        //         text: "This action will create a new Transaction!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "Yes",
        //         customClass: {
        //             confirmButton:
        //                 "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
        //             cancelButton:
        //                 "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
        //         },
        //         buttonsStyling: false,
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // axios.get("/AddNewJO", {
        //             //         branch_id: this.get_auth.branch.id,
        //             //         outlet_id: this.get_auth.outlet.id,
        //             //         device_id: this.get_auth.terminal.id,
        //             //         // business_date: this.get_auth.shift.current.business_date,
        //             //         user_name: this.get_auth.user.name,
        //             //         user_id: this.get_auth.user.username,
        //             //         service_charge_percentage:
        //             //             this.get_settings.service_charge_percentage,
        //             //     })
        //                axios.post("/orderslips", {
        //                     branch_id: this.get_auth.branch.id,
        //                     outlet_id: this.get_auth.outlet.id,
        //                     device_id: this.get_auth.terminal.id,
        //                     // business_date: this.get_auth.shift.current.business_date,
        //                     user_name: this.get_auth.user.name,
        //                     user_id: this.get_auth.user.username,
        //                     service_charge_percentage:
        //                         this.get_settings.service_charge_percentage,
        //                 })
        //                 .then((res) => {
        //                     debug(res.data);
        //                     toast.fire({
        //                         title: "Successfully created.",
        //                     });
        //                     this.fetchOrderslip(
        //                         this.orderslips.meta.current_page
        //                     );
        //                     this.$store.dispatch("fetchCurrentTransaction");

        //                     this.open_the_cart();
        //                 })
        //                 .catch((error) => {
        //                     debug(error.response.data);
        //                 });
        //         }
        //     });
         },
        detachCurrentTransaction(transaction) {
            swal.fire({
                title: "Are you sure?",
                text: "This action will detach your current transaction!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton:
                        "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
                    cancelButton:
                        "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/detach-current-transaction", {
                            branch_id: this.get_auth.branch.id,
                            user_id: this.get_auth.user.username,
                        })
                        .then((res) => {
                            debug(res.data);
                            toast.fire({ title: "Detached Successfully!" });
                            transaction.user_current_transaction = null;
                            this.$store.dispatch("fetchCurrentTransaction");
                        })
                        .catch((error) => {
                            debug(error.response.data);
                        });
                }
            });
        },
        attachCurrentTransaction(transaction) {
            swal.fire({
                title: "Are you sure?",
                html: `This action will swap transaction <span class="font-semibold">#${transaction.orderslip_code}</span> as your current transaction!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton:
                        "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
                    cancelButton:
                        "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/attach-current-transaction", {
                            orderslip_number: transaction.orderslip_code,
                            branch_id: this.get_auth.branch.id,
                            user_id: this.get_auth.user.username,
                        })
                        .then((res) => {
                            debug(res.data);
                            toast.fire({ title: "Successfully Swapped!" });
                            transaction.user_current_transaction =
                                this.get_auth.user.username;
                            this.fetchOrderslip(
                                this.orderslips.meta.current_page
                            );

                            this.$store.dispatch("fetchCurrentTransaction");
                        })
                        .catch((error) => {
                            debug(error.response.data);
                        });
                }
            });
        },
        markAsCompleteTheOrderslip(transaction) {
            swal.fire({
                title: "Are you sure?",
                html: `This action will mark as complete the orderslip <span class="font-semibold">${transaction.orderslip_code}</span>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton:
                        "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
                    cancelButton:
                        "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/mark-as-complete", {
                            orderslip_number: transaction.orderslip_code,
                            branch_id: this.get_auth.branch.id,
                            user_id: this.get_auth.user.username,
                        })
                        .then((res) => {
                            debug(res.data);
                            toast.fire({
                                title: "Successfully Marked as Complete!",
                            });
                            this.fetchOrderslip(
                                this.orderslips.meta.current_page
                            );
                            this.$store.dispatch("fetchCurrentTransaction");
                        })
                        .catch((error) => {
                            debug(error.response.data);
                        });
                }
            });
        },
        openModalForOSOverview(orderslip_code) {
            console.log(this.get_current_transaction);
            this.$store.dispatch("openOSOverview", orderslip_code);
        },
    },
    computed: {
        ...mapGetters([
            "get_auth",
            "get_device",
            "if_can_process_order",
            "get_os_overview_status",
            "get_settings",
            "get_current_transaction"
        ]),
    },
    created() {
        // if(this.if_can_process_order == false){
        //     window.location = '/user-info'
        // }

        this.fetchOrderslip();
    },
};
</script>

<style></style>
