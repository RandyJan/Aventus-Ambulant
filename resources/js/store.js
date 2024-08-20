import axios from "axios";
import createPersistedState from "vuex-persistedstate";

export default {
    state: {
        device: null,
        authenticated_user: null,
        current_transaction: null, // 'OSNUMBER or null'
        selected_store: null, // used in store products page to filter the display
        selected_store_product: null, // used in store product page to show production information
        is_cart_open: false,
        is_product_overview_open: false,
        is_print_preview_open: false,
        is_os_overview_open: null, // value will be orderslip code
        selected_product_to_edit: null, // this is the product added in the cart available for edit.

        // SYSTEM SETTINGS
        settings: {
            app_name: null,
            app_type: null,
            device: null,
            cart_layout: {
                group_by_store: false,
                plate_number_entry: false,
                table_number_entry: false,
                headcount_entry: false,
            },
            work_shifting: false,
            customer_display: false,
            plate_number_entry: false,
            show_header_logo_in_print_preview: false,
            show_qr_code_in_print_preview: false,
            table_assignment:null,
        },

        // OFFICIAL RECEIPTS
        official_receipt: null,
        official_receipts: null,
    },

    mutations: {
        open_the_cart(state) {
            state.is_cart_open = true;
        },
        close_the_cart(state) {
            state.is_cart_open = false;
        },
        update_user_auth(state, payload) {
            state.authenticated_user = payload;
        },
        update_device(state, payload) {
            state.device = payload;
        },
        update_authenticated_user_shift(state, payload) {
            state.authenticated_user.shift.current = payload;
        },
        FETCH_CURRENT_TRANSACTION(state, payload) {
            state.current_transaction = payload;
        },
        CHANGE_SELECTED_STORE(state, payload) {
            state.selected_store = payload;
        },
        CHANGE_SELECTED_PRODUCT(state, payload) {
            state.selected_store_product = payload;
        },
        CLOSE_PRODUCT_OVERVIEW(state) {
            state.is_product_overview_open = false;
        },
        OPEN_PRODUCT_OVERVIEW(state) {
            state.is_product_overview_open = true;
        },
        UPDATE_CURRENT_TRANSACTION_PLATE_NUMBER(state, payload) {
            state.current_transaction.plate_number = payload;
        },
        OPEN_PRINT_PREVIEW(state) {
            state.is_print_preview_open = true;
        },
        CLOSE_PRINT_PREVIEW(state) {
            state.is_print_preview_open = false;
        },
        OPEN_OS_PREVIEW(state, payload) {
            state.is_os_overview_open = payload;
        },
        CLOSE_OS_PREVIEW(state) {
            state.is_os_overview_open = null;
        },
        OPEN_SELECTED_PRODUCT_TO_EDIT(state, payload) {
            state.selected_product_to_edit = payload;
        },
        CLOSE_SELECTED_PRODUCT_TO_EDIT(state) {
            state.selected_product_to_edit = null;
        },
        UPDATE_SETTINGS(state, payload) {
            state.settings = payload;
        },
        FETCH_OFFICIAL_RECEIPTS(state, payload) {
            state.official_receipts = payload;
        },
    },

    actions: {
        fetchOfficialReceipts({ commit }, payload) {
            axios
                .get("/official-receipts", {
                    params: {
                        limit: payload ? (payload.limit ? payload.limit : 10) : 10,
                        page: payload ? payload.page : 1,
                        filter_by_today: true,
                    },
                })
                .then((res) => {
                    commit("FETCH_OFFICIAL_RECEIPTS", JSON.parse(
                        JSON.stringify(res.data)
                    ));
                })
                .catch((error) => {
                    commit("FETCH_OFFICIAL_RECEIPTS", null);
                });
        },
        updateSettings({ commit }, payload) {
            commit("UPDATE_SETTINGS", payload);
        },
        openSelectedProductToEdit({ commit }, payload) {
            commit("OPEN_SELECTED_PRODUCT_TO_EDIT", payload);
        },
        closeSelectedProductToEdit({ commit }, payload) {
            commit("CLOSE_SELECTED_PRODUCT_TO_EDIT");
        },
        fetchCurrentTransaction({ commit, getters }) {
            axios
                .post("/current-transaction", {
                    branch_id: getters.get_auth.branch.id,
                    user_id: getters.get_auth.user.username,
                })
                .then((res) => {
                    commit("FETCH_CURRENT_TRANSACTION", res.data.data);
                })
                .catch((error) => {
                    commit("FETCH_CURRENT_TRANSACTION", null);
                });
        },
        changeSelectedStore({ commit }, payload) {
            commit("CHANGE_SELECTED_STORE", payload);
        },
        closeProductOverview({ commit }) {
            commit("CLOSE_PRODUCT_OVERVIEW", false);
        },
        openProductOverview({ commit }) {
            commit("OPEN_PRODUCT_OVERVIEW", true);
        },
        changeSelectedStoreProduct({ commit }, payload) {
            commit("CHANGE_SELECTED_PRODUCT", payload);
        },
        updateCurrentTransactionPlateNumber({ commit }, payload) {
            commit("UPDATE_CURRENT_TRANSACTION_PLATE_NUMBER", payload);
        },
        openPrintView({ commit }) {
            commit("OPEN_PRINT_PREVIEW");
        },
        closePrintView({ commit }) {
            commit("CLOSE_PRINT_PREVIEW");
        },
        openOSOverview({ commit }, payload) {
            commit("OPEN_OS_PREVIEW", payload);
        },
        closeOSOverview({ commit }) {
            commit("CLOSE_OS_PREVIEW");
        },
        fetchAppSetting({ commit, getters }) {
            axios
                .get("/app-setting", {
                    params: {
                        device_id: getters.get_settings.device
                            ? getters.get_settings.device.terminal.id
                            : null,
                    },
                })
                .then((res) => {
                    var setting = JSON.parse(
                        JSON.stringify(getters.get_settings)
                    );
                    setting.app_name = res.data.data.app_name;
                    setting.app_type = res.data.data.app_type;
                    setting.work_shifting = res.data.data.work_shifting;
                    setting.show_header_logo_in_print_preview =
                        res.data.data.show_header_logo_in_print_preview;
                    setting.show_qr_code_in_print_preview =
                        res.data.data.show_header_logo_in_print_preview;
                    setting.plate_number_entry = res.data.data.plate_number_entry;
                    setting.customer_display = res.data.data.customer_display;
                    setting.table_assignment = res.data.data.table_assignment;
                    setting.service_charge = res.data.data.service_charge;
                    setting.service_charge_percentage = res.data.data.service_charge_percentage;

                    commit("UPDATE_SETTINGS", setting);
                });
        },
    },

    getters: {
        get_official_receipts(state) {
            return state.official_receipts;
        },
        get_selected_product_to_edit(state) {
            return state.selected_product_to_edit;
        },
        get_selected_product_to_edit_status(state) {
            if (state.selected_product_to_edit == null) {
                return false;
            }

            return state.selected_product_to_edit;
        },
        get_device(state) {
            return state.device;
        },
        get_auth(state) {
            return state.authenticated_user;
        },
        get_current_transaction(state) {
            return state.current_transaction;
        },
        get_selected_store(state) {
            return state.selected_store;
        },
        get_selected_store_product(state) {
            return state.selected_store_product;
        },
        get_product_overview_status(state) {
            return state.is_product_overview_open;
        },
        get_print_preview_status(state) {
            return state.is_print_preview_open;
        },
        get_os_overview_status(state) {
            if (state.is_os_overview_open == null) {
                return false;
            }

            return true;
        },
        get_os_overview_value(state) {
            return state.is_os_overview_open;
        },
        if_can_process_order(state) {
            if(state.authenticated_user.shift == null){
                return false;
            }

            if (state.authenticated_user.shift.current == null) {
                return false;
            }

            if (state.authenticated_user.shift.current.shift_posted === "1") {
                return false;
            }

            if (state.authenticated_user.shift.current.day_posted === "1") {
                return false;
            }

            return true;
        },
        get_settings(state) {
            return state.settings;
        },
    },

    plugins: [createPersistedState()],
};
