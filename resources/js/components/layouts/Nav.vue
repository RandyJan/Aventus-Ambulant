<template>
    <div>
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <transition name="left_side_nav">
            <div
                v-if="is_show_menu"
                class="fixed inset-0 flex z-40"
                role="dialog"
                aria-modal="true"
            >
                <!--
                Off-canvas menu overlay, show/hide based on off-canvas menu state.

                Entering: "transition-opacity ease-linear duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "transition-opacity ease-linear duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div
                    @click="is_show_menu = !is_show_menu"
                    class="fixed inset-0 bg-gray-600 bg-opacity-75"
                    aria-hidden="true"
                ></div>

                <!--
                Off-canvas menu, show/hide based on off-canvas menu state.

                Entering: "transition ease-in-out duration-300 transform"
                    From: "-translate-x-full"
                    To: "translate-x-0"
                Leaving: "transition ease-in-out duration-300 transform"
                    From: "translate-x-0"
                    To: "-translate-x-full"
                -->
                <div
                    class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800"
                >
                    <!--
                        Close button, show/hide based on off-canvas menu state.

                        Entering: "ease-in-out duration-300"
                        From: "opacity-0"
                        To: "opacity-100"
                        Leaving: "ease-in-out duration-300"
                        From: "opacity-100"
                        To: "opacity-0"
                    -->
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button
                            @click="is_show_menu = !is_show_menu"
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <!-- Heroicon name: outline/x -->
                            <svg
                                class="h-6 w-6 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-shrink-0 flex items-center px-4">
                        <img
                            class="h-14 w-auto"
                            src="/assets/logo-sm.png"
                            alt="Workflow"
                        />
                        <div
                            class="text-white leading-tight font-semibold text-lg"
                        >
                            <!-- <div class=""> -->
                            {{ get_settings.app_name }}
                            <!-- </div> -->
                            <div class="font-normal">Application</div>
                        </div>
                        <!-- <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow"> -->
                    </div>
                    <div class="mt-5 flex-1 h-0 overflow-y-auto">
                        <nav class="px-4 space-y-4">
                            <a
                                v-if="
                                    [
                                        'shell_ambulant',
                                        'restaurant_ambulant',
                                    ].includes(get_settings.app_type)
                                "
                                href="/"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <!-- Heroicon name: outline/users -->
                                <svg
                                    class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                                    />
                                </svg>
                                Pending Orders
                            </a>

                            <a
                                v-if="
                                    [
                                        'shell_ambulant',
                                        'restaurant_ambulant',
                                    ].includes(get_settings.app_type)
                                "
                                href="/completed-orders"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <!-- Heroicon name: outline/users -->
                                <svg
                                    class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                                    />
                                </svg>
                                Completed Orders
                            </a>

                            <a
                                v-if="
                                    ['invoicer_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                                href="/"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <!-- Heroicon name: outline/users -->
                                <svg
                                    class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                                    />
                                </svg>
                                Collections
                            </a>

                            <!-- <a href="/servery" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">

                                <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0  h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                                </svg>
                                Servery
                            </a> -->

                            <a
                                v-if="
                                    ['restaurant_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                                @click="show_table_list_modal = true"
                                href="javascript:void(0);"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                                    />
                                </svg>
                                Tables
                            </a>

                            <a
                                href="/user-info"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <!-- Heroicon name: outline/users -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                User Information
                            </a>

                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <!-- <a href="/" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-base font-medium rounded-md">

                                <svg class="text-gray-300 mr-4 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Home
                            </a> -->

                            <a
                                @click="btnSignOut"
                                href="javascript:;"
                                class="border-t-2 border-gray-300 text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
                            >
                                <!-- Heroicon name: outline/users -->
                                <svg
                                    class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <!-- <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /> -->
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                                Logout
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </transition>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <nav class="bg-gray-800">
            <div class="mx-auto px-2 sm:px-6 lg:px-8">
                <div
                    class="relative flex items-center justify-between h-16 space-x-2"
                >
                    <div
                        class="border-white flex-1 flex items-stretch justify-start"
                    >
                        <!-- BURGER MENU -->
                        <button
                            @click="is_show_menu = !is_show_menu"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            type="button"
                        >
                            <svg
                                class="block h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>
                        <div
                            class="ml-4 flex items-center text-white text-base font-medium space-x-2"
                        >
                            <!-- <span>
                                {{ page_title }}
                            </span> -->
                            <button
                                v-if="
                                    ['invoicer_ambulant'].includes(
                                        get_settings.app_type
                                    )
                                "
                                @click="newOR()"
                                type="button"
                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                New Collection
                            </button>
                            <button
                                v-if="
                                    get_current_transaction &&
                                    [
                                        'shell_ambulant',
                                        'restaurant_ambulant',
                                    ].includes(get_settings.app_type)
                                "
                                @click="goToStores()"
                                type="button"
                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Menu
                            </button>
                        </div>
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                    >
                        <!-- <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button> -->
                        <!-- <button
                            v-if="get_current_transaction"
                            @click="goToStores()"
                            type="button"
                            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Select Stores
                        </button> -->

                        <!-- Customer Display Toggle -->
                        <div
                            v-if="
                                get_settings.customer_display && get_current_transaction &&
                                [
                                    'shell_ambulant',
                                    'restaurant_ambulant',
                                ].includes(get_settings.app_type)
                            "
                            class="flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"
                                />
                            </svg>
                            <Toggle
                                class="ml-1"
                                @change="onCustomerDisplay()"
                                v-model="
                                    get_current_transaction.customer_display
                                "
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
                                    handleOffDisabled: 'bg-gray-100 left-0',
                                    label: 'text-center w-8 border-box whitespace-nowrap select-none',
                                }"
                            />
                        </div>

                        <!-- cart -->
                        <div class="ml-3 relative flex">
                            <button
                                v-if="
                                    get_current_transaction &&
                                    [
                                        'shell_ambulant',
                                        'restaurant_ambulant',
                                    ].includes(get_settings.app_type)
                                "
                                @click="open_the_cart"
                                class="text-white"
                                type="button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <span
                                    class="absolute -top-2 -right-2 h-5 w-5 rounded-full ring-2 ring-white bg-green-800 p-0 text-xs flex items-center justify-center"
                                >
                                    {{ get_current_transaction.items_count }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <cart v-if="is_cart_open"></cart>

        <TableIndex
            v-if="show_table_list_modal"
            @close="show_table_list_modal = false"
        ></TableIndex>

        <collections.modal
            v-if="show_collection_modal"
            @close="show_collection_modal = false; official_receipt = null"
            :official_receipt_id="official_receipt.id"
        ></collections.modal>

    </div>
</template>

<script>
import { mapMutations, mapState, mapGetters } from "vuex";
import TableIndex from "../tables/Index.vue";

export default {
    components: {
        TableIndex,
    },
    props: {
        page_title: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            is_profile_show: false,
            is_show_menu: false,
            show_table_list_modal: false,
            show_collection_modal: false,

            official_receipt: null,
        };
    },
    methods: {
        ...mapMutations([
            "open_the_cart",
            "update_user_auth",
            "update_authenticated_user_shift",
        ]),
        btnSignOut() {
            axios
                .get("/logout")
                .then((res) => {
                    toast.fire({
                        title: res.data.message,
                        didClose: () => {
                            this.update_user_auth(null);
                            window.location = "/";
                        },
                    });
                })
                .catch((err) => {
                    window.location = "/";
                });
        },
        goToStores() {
            if (this.get_settings.app_type == "restaurant_ambulant") {
                window.location = "/menu";
                return;
            }

            window.location = "/stores";
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
        newOR() {
            confirm.fire({text: 'A new Official Receipt will be created.'}).then((result) => {
                if (result.isConfirmed) {
                    console.log("new OR...");

                    axios.post('/official-receipts', {
                        device_id: this.get_auth.terminal.id
                    }).then(res => {
                        console.log(res.data);
                        this.$store.dispatch('fetchOfficialReceipts');
                        this.official_receipt = res.data.data;
                        this.show_collection_modal = true;
                    });

                }
            });
        },
    },
    computed: {
        ...mapState(["is_cart_open"]),
        ...mapGetters([
            "get_settings",
            "get_auth",
            "get_current_transaction",
            "if_can_process_order",
        ]),
    },
};
</script>

<style>
.user-enter-active,
.user-leave-active {
    transition: opacity 0.5s;
}
.user-enter, .user-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}

.left_side_nav-enter-active,
.left_side_nav-leave-active {
    /* transition: opacity .5s; */
    transition: transform 0.2s ease;
}
.left_side_nav-enter, .user-leave-to /* .fade-leave-active below version 2.1.8 */ {
    /* opacity: 0; */
    transform: translateX(-100%);
    transition: all 100ms ease-in 0s;
}
</style>
