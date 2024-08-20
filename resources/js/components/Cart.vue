<template>
    <transition name="cart">
        <div class="fixed inset-x-0 inset-y-0 bg-gray-100 z-50 overflow-auto">
            <button
                @click="close_the_cart()"
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
                    Transaction Summary
                </h1>

                <div
                    class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-5 text-gray-600"
                >
                    <div class="">
                        <!-- IF HAS RECORDS -->
                        <div
                            v-if="get_current_transaction.stores.length > 0"
                            class=""
                        >
                            <!-- STORE -->
                            <div
                                v-for="(
                                    store, index
                                ) in get_current_transaction.stores"
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
                                    :class="{
                                        'pl-4':
                                            get_settings.app_type ==
                                            'shell_ambulant',
                                    }"
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
                                        <span
                                            v-if="
                                                item.parent.available ==
                                                item.parent.quantity
                                            "
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-sky-100 text-sky-800 font-semibold"
                                        >
                                            Confirmed
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

                                                <div
                                                    v-if="
                                                        is_allowed_to_perform_action
                                                    "
                                                    class="flex items-center space-x-2"
                                                >
                                                    <a
                                                        @click="
                                                            editItem(
                                                                item.parent,
                                                                item.items
                                                            )
                                                        "
                                                        class="font-medium text-xs text-sky-600"
                                                        href="javascript:;"
                                                    >
                                                        Edit
                                                    </a>
                                                    <a
                                                        v-if="
                                                            is_allow_to_remove_item(
                                                                item.parent
                                                            )
                                                        "
                                                        @click="
                                                            removeItem(
                                                                item.parent
                                                            )
                                                        "
                                                        class="font-medium text-xs text-sky-600"
                                                        href="javascript:;"
                                                    >
                                                        Remove
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <div
                                                class="text-sm font-semibold text-right"
                                            >
                                                {{
                                                    item.parent.net_amount.toFixed(
                                                        2
                                                    )
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        get_settings.app_type ==
                                        'shell_ambulant'
                                    "
                                    class="flex justify-end mb-2 mt-1 text-sm"
                                >
                                    Sub Total :
                                    <span class="ml-2 font-semibold">{{
                                        store.sub_total
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- IF NO RECORDS -->
                        <div
                            v-if="get_current_transaction.stores.length == 0"
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
                            v-if="get_settings.app_type != 'invoicer_ambulant'"
                            class="border-2 border-gray-300 border-dashed p-2"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    Is Senior ?
                                    <Toggle
                                        class="ml-2"
                                        @change="changeSCStatus()"
                                        v-model="get_current_transaction.is_sc"
                                        on-label="On"
                                        off-label="Off"
                                        :classes="{
                                            container:
                                                'inline-block rounded-full outline-none focus:ring focus:ring-sky-500 focus:ring-opacity-30',
                                            toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                            toggleOn:
                                                'bg-sky-500 border-sky-500 justify-start text-white',
                                            toggleOff:
                                                'bg-gray-600 border-gray-600 justify-end text-white',
                                            toggleOnDisabled:
                                                'bg-gray-300 border-gray-300 justify-start text-gray-400 cursor-not-allowed',
                                            toggleOffDisabled:
                                                'bg-gray-200 border-gray-200 justify-end text-gray-400 cursor-not-allowed',
                                            handle: 'inline-block bg-white w-5 h-5 top-0 rounded-full absolute transition-all',
                                            handleOn:
                                                'left-full transform -translate-x-full',
                                            handleOff: 'left-0',
                                            handleOnDisabled:
                                                'bg-gray-100 left-full transform -translate-x-full',
                                            handleOffDisabled:
                                                'bg-gray-100 left-0',
                                            label: 'text-center w-8 border-box whitespace-nowrap select-none',
                                        }"
                                    />
                                </div>
                                <div>
                                    <button
                                        v-if="get_current_transaction.is_sc"
                                        @click="openCreateSeniorModal()"
                                        type="button"
                                        class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                    >
                                        <!-- Heroicon name: solid/plus-sm -->
                                        <svg
                                            class="h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div
                                v-if="get_current_transaction.is_sc"
                                class="flow-root mt-2"
                            >
                                <ul
                                    role="list"
                                    class="divide-y divide-gray-200"
                                >
                                    <li
                                        v-for="(
                                            item, scIndex
                                        ) in get_current_transaction.sc_records"
                                        :key="scIndex"
                                        class=""
                                    >
                                        <div
                                            class="flex items-center space-x-4 pb-2"
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
                                                        ID: {{ item.SC_ID }}
                                                    </strong>
                                                </div>
                                                <div class="flex justify-end">
                                                    <button
                                                        @click="
                                                            openEditSeniorModal(
                                                                item
                                                            )
                                                        "
                                                        class="inline-flex items-center shadow-sm px-1 rounded-md py-0.5 border border-gray-300 text-sm leading-5 font-medium text-gray-700 bg-white hover:bg-gray-50"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                            />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        v-if="
                                                            get_current_transaction
                                                                .stores
                                                                .length == 0
                                                        "
                                                        @click="
                                                            removeSenior(item)
                                                        "
                                                        class="ml-1 inline-flex items-center shadow-sm px-1 rounded-md py-0.5 border border-gray-300 text-sm leading-5 font-medium text-gray-700 bg-white hover:bg-gray-50"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            />
                                                        </svg>
                                                    </button>
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
                                Transaction No.
                                <span class="font-extrabold text-lg">{{
                                    get_current_transaction.orderslip_number
                                }}</span>
                            </div> 
                            <div
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2 mt-2"
                            >
                                Patient Name:
                                <span class="font-extrabold text-lg">{{
                                    get_current_transaction.customer_name
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Server
                                <span class="font-semibold">{{
                                    get_current_transaction.prepared_by
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Date
                                <span class="font-semibold">{{
                                    get_current_transaction.date
                                }}</span>
                            </div>
                            <div
                                class="text-sm flex justify-between border-b border-gray-300 py-2"
                            >
                                Time
                                <span class="font-semibold">{{
                                    get_current_transaction.time
                                }}</span>
                            </div>
                            <div
                                v-if="
                                    ['restaurant_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">
                                    Table No.
                                    <button
                                        @click="
                                            show_table_orderslip_assignment_modal = true
                                        "
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
                                    </button>
                                </div>
                                <span class="font-semibold">
                                    {{
                                        get_current_transaction.table_number
                                            ? get_current_transaction.table_number
                                            : "-"
                                    }}
                                </span>
                            </div>
                            <div
                                v-if="get_settings.plate_number_entry"
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">
                                    Nick Name:
                                    <button
                                        @click="updatePlateNumber()"
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
                                    </button>
                                </div>
                                <span class="font-semibold">
                                    {{
                                        get_current_transaction.plate_number
                                            ? get_current_transaction.plate_number
                                            : "-"
                                    }}
                                </span>
                            </div>
                            <div
                                v-if="
                                    [
                                        'shell_ambulant',
                                        'restaurant_ambulant',
                                    ].includes(get_settings.app_type)
                                "
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">
                                    Total Head Count
                                    <button
                                        @click="updateTotalHeadcount()"
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
                                    </button>
                                </div>
                                <span class="font-semibold">
                                    {{
                                        get_current_transaction.total_headcount
                                            ? get_current_transaction.total_headcount
                                            : "-"
                                    }}
                                </span>
                            </div>
                            <div
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Status</div>
                                <span class="font-semibold">
                                    {{ get_current_transaction.status }}
                                </span>
                            </div>

                            <!-- ORDER TYPE -->
                            <div
                                v-if="get_settings.service_charge"
                                class="text-sm flex justify-between items-center border-b border-gray-300 py-2"
                            >
                                <div class="flex items-center">Order Type</div>
                                <div>
                                    <select
                                        @change="orderTypeOnChange"
                                        v-model="
                                            get_current_transaction.order_type
                                        "
                                        id="location"
                                        name="location"
                                        class="block w-full rounded-md border-gray-300 py-1 pl-2 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">None</option>
                                        <option value="1">DINE IN</option>
                                        <option value="2">TAKE OUT</option>
                                    </select>
                                </div>
                            </div>

                            <!-- VATable Sales -->
                            <div
                                class="text-sm flex justify-end items-center mt-2"
                            >
                                <div class="flex items-center mr-4">
                                    VATable Sales
                                </div>
                                <span class="font-semibold">
                                    {{ get_current_transaction.vatable_sales }}
                                </span>
                            </div>
                            <!-- VAT Amount -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    VAT Amount
                                </div>
                                <span class="font-semibold">
                                    {{ get_current_transaction.vat_amount }}
                                </span>
                            </div>
                            <!-- VAT Ex -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    VAT Ex.
                                </div>
                                <span class="font-semibold">
                                    {{ get_current_transaction.vat_ex }}
                                </span>
                            </div>

                            <!-- SC Discount -->
                            <div class="text-sm flex justify-end items-center">
                                <div class="flex items-center mr-4">
                                    SC Discount
                                </div>
                                <span class="font-semibold">
                                    {{
                                        get_current_transaction.sc_discount_amount
                                    }}
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
                                        get_current_transaction.service_charge_percentage
                                    }}%)
                                </div>
                                <span class="font-semibold">
                                    {{
                                        get_current_transaction.service_charge_amount
                                    }}
                                </span>
                            </div>
                            <!-- GRAND TOTAL -->
                            <div class="text-base flex justify-between py-3">
                                <span class="font-bold"> Net Amount </span>
                                <span class="font-bold">{{
                                    get_current_transaction.net_amount
                                }}</span>
                            </div>

                            <!-- CUSTOMER -->
                            <div
                                v-if="
                                    ['invoicer_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                                class="border-t border-gray-300 pt-2"
                            >
                                <carts-customer></carts-customer>
                            </div>

                            <!-- BUTTONS -->
                            <div
                                class="grid grid-flow-col auto-cols-auto gap-3 border-t border-gray-300 pt-2"
                            >
                                <button
                                    @click="printPreview()"
                                    :disabled="enable_confirm_button"
                                    :class="{
                                        'opacity-50': enable_confirm_button,
                                    }"
                                    type="submit"
                                    class="tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                >
                                    Print Preview
                                </button>
                                <button
                                    v-if="
                                        get_settings.app_type ==
                                            'shell_ambulant' &&
                                        this.get_current_transaction.stores
                                            .length > 0
                                    "
                                    @click="shellConfirmOrder()"
                                    type="submit"
                                    class="tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                >
                                    Confirm Order 
                                </button>
                                <button
                                    v-if="
                                        get_settings.app_type ==
                                        'restaurant_ambulant'
                                    "
                                    @click="confirmOrder()"
                                    type="submit"
                                    :disabled="!enable_confirm_button"
                                    :class="{
                                        'opacity-50': !enable_confirm_button,
                                    }"
                                    class="tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                >
                                    Confirm Order 
                                </button>
                                <button
                                    v-if="
                                        get_settings.app_type ==
                                        'restaurant_ambulant'
                                    "
                                    @click="rePrintConfirmOrder()"
                                    type="submit"
                                    :disabled="enable_confirm_button"
                                    :class="{
                                        'opacity-50': enable_confirm_button,
                                    }"
                                    class="tracking-wider flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                >
                                    Re-Print Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <print-preview
                v-if="get_print_preview_status"
                :order_summary="get_current_transaction"
            ></print-preview>

            <edit-product-on-cart
                v-if="item_selected_for_edit"
                :payload="item_selected_for_edit"
                @close="closeEditItemModal"
            ></edit-product-on-cart>

            <CreateSenior
                v-if="create_sc_modal"
                :payload="create_sc_modal"
                @close="closeCreateSeniorModal()"
            ></CreateSenior>

            <EditSenior
                v-if="edit_sc_modal"
                :payload="edit_sc_modal"
                @close="closeEditSeniorModal()"
            ></EditSenior>

            <TableOrderslipAssignment
                v-if="show_table_orderslip_assignment_modal"
                @close="show_table_orderslip_assignment_modal = false"
            ></TableOrderslipAssignment>
        </div>
    </transition>
</template>

<script>
import { mapMutations, mapGetters, mapActions } from "vuex";
import PrintPreview from "./PrintPreview.vue";
import CreateSenior from "./Seniors/Create.vue";
import EditSenior from "./Seniors/Edit.vue";
import TableOrderslipAssignment from "./tables/OrderslipAssignment.vue";

export default {
    data() {
        return {
            create_sc_modal: null,
            edit_sc_modal: null,
            item_selected_for_edit: null,
            show_table_orderslip_assignment_modal: false,
        };
    },
    components: {
        PrintPreview,
        CreateSenior,
        EditSenior,
        TableOrderslipAssignment,
    },
    methods: {
        ...mapMutations(["close_the_cart"]),
        ...mapActions(["fetchCurrentTransaction"]),
        orderTypeOnChange() {
            console.log(this.get_current_transaction.order_type);
            console.log("orderTypeOnChange");
            axios
                .post(`/change-order-type`, {
                    orderslip_number:
                        this.get_current_transaction.orderslip_number,
                    order_type: this.get_current_transaction.order_type,
                })
                .then((res) => {
                    this.fetchCurrentTransaction();
                });
        },
        is_allow_to_remove_item(item) {
            if (this.get_settings.app_type == "restaurant_ambulant") {
                if (item.confirmed_at != null) {
                    return false;
                }
            }

            return true;
        },
        rePrintConfirmOrder() {
            confirm
                .fire({
                    text: "This action will print all the list of items to the designated location",
                    // confirmButtonText: 'Proceed to update Table number.',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(`/reprint-order-in-kitchen`, {
                                orderslip_number:
                                    this.get_current_transaction
                                        .orderslip_number,
                            })
                            .then((res) => {
                                debug(res);
                                this.$store.dispatch("fetchCurrentTransaction");
                                toast.fire({
                                    title: "RePrinted Successfully.",
                                });
                            })
                            .catch((err) => {
                                debug(err.response);
                            });
                    }
                });
        },
        confirmOrder() {
            if (!this.enable_confirm_button) {
                return;
            }

            confirm
                .fire({
                    text: "This action will print a list of unconfirmed items to the designated location",
                    // confirmButtonText: 'Proceed to update Table number.',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .patch(`/confirm-order`, {
                                orderslip_number:
                                    this.get_current_transaction
                                        .orderslip_number,
                            })
                            .then((res) => {
                                debug(res);
                                this.$store.dispatch("fetchCurrentTransaction");
                                toast.fire({
                                    title: "Successfully confirmed.",
                                });
                            })
                            .catch((err) => {
                                debug(err.response);
                            });
                    }
                });
        },
        updateTotalHeadcount() {
            swal.fire({
                title: "Enter Total Head Count #",
                input: "number",
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: (input) => {
                    return input;
                },
                allowedOutsideClick: () => !swal.isLoading(),
            }).then((result) => {
                if (result.value) {
                    if (
                        this.get_current_transaction.sc_records.length > 0 &&
                        result.value <
                            this.get_current_transaction.sc_records.length
                    ) {
                        toast.fire({
                            title: "Must not be less than the total Senior Record.",
                            icon: "warning",
                        });
                        return;
                    }

                    axios
                        .patch(`/total-head-count`, {
                            value: result.value.trim(),
                            orderslip_number:
                                this.get_current_transaction.orderslip_number,
                        })
                        .then((res) => {
                            debug(res);
                            this.$store.dispatch("fetchCurrentTransaction");
                            toast.fire({
                                title: "Total Head Count updated Successfully!",
                            });
                        })
                        .catch((err) => {
                            debug(err.response);
                        });
                }
            });
        },
        updatePlateNumber() {
            swal.fire({
                title: "Enter Nick Name",
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
                                this.get_current_transaction.orderslip_number,
                        })
                        .then((res) => {
                            debug(res);
                            this.$store.dispatch(
                                "updateCurrentTransactionPlateNumber",
                                result.value.trim()
                            );
                            toast.fire({
                                title: "Nick Name updated Successfully!",
                            });
                        })
                        .catch((err) => {
                            debug(err.response);
                        });
                }
            });
        },
        printPreview() {
            if (this.get_settings.app_type == "invoicer_ambulant") {
                if (this.get_current_transaction.customer == null) {
                    toast.fire({
                        title: "Please select a Customer to continue.",
                        icon: "warning",
                    });
                    return;
                }
            }

            // if (
            //     this.get_settings.app_type == "shell_ambulant" &&
            //     this.get_current_transaction.plate_number == ""
            // ) {
            //     confirm
            //         .fire({
            //             title: "",
            //             text: "Plate number is required. Please update and Print again.",
            //             confirmButtonText: "Proceed to update plate number.",
            //         })
            //         .then((result) => {
            //             if (result.isConfirmed) {
            //                 this.updatePlateNumber();
            //             }
            //         });
            //     return;
            // }

            if (this.enable_confirm_button) {
                toast.fire({
                    icon: "warning",
                    title: "There is unconfirmed item",
                });
                return;
            }

            this.$store.dispatch("openPrintView");
        },
        editItem(parent, items) {
            parent = JSON.parse(JSON.stringify(parent));
            items = JSON.parse(JSON.stringify(items));
            this.item_selected_for_edit = {
                parent: parent,
                items: items,
            };
        },
        closeEditItemModal() {
            this.item_selected_for_edit = null;
        },
        changeSCStatus() {
            // if(!this.get_current_transaction.is_sc){
            axios
                .patch(`/orderslip-senior-status`, {
                    branch_id: this.get_auth.branch.id,
                    os_number: this.get_current_transaction.orderslip_number,
                    sc_status:
                        !this.get_current_transaction.is_sc == true ? 0 : 1,
                })
                .then((res) => {
                    this.$store.dispatch("fetchCurrentTransaction");
                });
            return;
        },
        openCreateSeniorModal() {
            if (
                this.get_current_transaction.total_headcount ==
                this.get_current_transaction.sc_records.length
            ) {
                toast.fire({
                    title: "# of Senior entry cannot be greater than the assigned total head count!",
                    icon: "warning",
                });
                return;
            }

            this.create_sc_modal = {
                os_number: this.get_current_transaction.orderslip_number,
                branch_id: this.get_auth.branch.id,
            };
        },
        closeCreateSeniorModal() {
            this.create_sc_modal = null;
        },
        openEditSeniorModal(item) {
            this.edit_sc_modal = {
                ...JSON.parse(JSON.stringify(item)),
                // os_number : this.get_current_transaction.orderslip_number,
                // branch_id : this.get_auth.branch.id,
                // senior_id : item.ID
            };
        },
        closeEditSeniorModal() {
            this.edit_sc_modal = null;
        },
        removeSenior(item) {
            confirm
                .fire({
                    text: "This action will remove selected senior data.",
                    // confirmButtonText: 'Proceed to update Table number.',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete(`/orderslip-seniors/${item.ID}`)
                            .then((res) => {
                                this.$store.dispatch("fetchCurrentTransaction");
                            });
                    }
                });
        },
        removeItem(item) {
            if (this.get_settings.app_type == "restaurant_ambulant") {
                swal.fire({
                    title: "Supervisor",
                    html: `
                        <div class="text-left p-2">

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">
                                    Username
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="username" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password
                                </label>
                                <div class="mt-1">
                                    <input type="password" name="password" id="password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="">
                                </div>
                            </div>

                        </div>
                    `,
                    confirmButtonText: "Continue",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton:
                            "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
                        cancelButton:
                            "ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
                    },
                    showCancelButton: true,
                    buttonsStyling: false,
                    focusConfirm: false,
                    preConfirm: () => {
                        var username =
                            document.getElementById("username").value;
                        var password =
                            document.getElementById("password").value;

                        item = JSON.parse(JSON.stringify(item));
                        axios
                            .delete(`/cart-item`, {
                                data: {
                                    os_number: item.os_number,
                                    product_id: item.product_id,
                                    sequence: item.sequence,
                                    supervisor: {
                                        username: username,
                                        password: password,
                                    },
                                },
                            })
                            .then((res) => {
                                this.$store.dispatch("fetchCurrentTransaction");
                                this.close();
                            })
                            .catch((error) => {
                                toast.fire({
                                    icon: "warning",
                                    title: error.response.data.message,
                                });
                            });
                    },
                });

                return;
            }

            confirm
                .fire({
                    text: "This action will completely remove the selected item.",
                    // confirmButtonText: 'Proceed to update Table number.',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        item = JSON.parse(JSON.stringify(item));
                        axios
                            .delete(`/cart-item`, {
                                data: {
                                    os_number: item.os_number,
                                    product_id: item.product_id,
                                    sequence: item.sequence,
                                },
                            })
                            .then((res) => {
                                toast.fire({ title: res.data.message });
                                this.$store.dispatch("fetchCurrentTransaction");
                            });
                    }
                });
        },
        onCustomerDisplay() {
            axios
                .patch(`/customer-display`, {
                    device_id: this.get_auth.terminal.id,
                    branch_id: this.get_auth.branch.id,
                    os_number: this.get_current_transaction.orderslip_number,
                    customer_display:
                        !this.get_current_transaction.customer_display == true
                            ? 0
                            : 1,
                })
                .then((res) => {
                    this.$store.dispatch("fetchCurrentTransaction");
                });
            return;
        },
        shellConfirmOrder() {
            // debug("shell confirm order...");
            confirm
                .fire({
                    text: "Are you sure?",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // debug(
                        //     "OS No. " +
                        //         this.get_current_transaction.orderslip_number
                        // );
                        axios
                            .patch(
                                `/shell-confirm-order/${this.get_current_transaction.orderslip_number}`
                            )
                            .then((res) => {
                                toast.fire({
                                    title: res.data.message,
                                });
                                this.$store.dispatch("fetchCurrentTransaction");
                            })
                            .catch((error) => {
                                debug(error.response.data);
                                toast.fire({
                                    icon: "error",
                                    title: error.response.data.message,
                                });
                            });
                    }
                });
        },
    },
    computed: {
        ...mapGetters([
            "get_current_transaction",
            "get_print_preview_status",
            "get_selected_product_to_edit_status",
            "get_auth",
            "get_settings",
        ]),
        is_allowed_to_perform_action() {
            if (this.get_current_transaction.status == "Paid") {
                return false;
            }

            return true;
        },
        enable_confirm_button() {
            if (this.get_current_transaction.stores.length == 0) {
                return false;
            }
            if (this.get_current_transaction.total_headcount == null) {
                return false;
            }
            if (this.get_current_transaction.table_number == "") {
                return false;
            }

            if (this.get_current_transaction.unconfirmed_items <= 0) {
                return false;
            }
            console.log(this.get_settings.table_assignment);
            return true;
        },
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
