require("./bootstrap");
import Vue from "vue";
import Vuex from "vuex";
import swal from "sweetalert2";
import store from "./store";
import VueQRCodeComponent from "vue-qrcode-component";
import VueCompositionAPI from "@vue/composition-api";
import Toggle from "@vueform/toggle/dist/toggle.vue2.js";
import moment from "moment";

Vue.use(Vuex);
Vue.use(VueCompositionAPI);

window.moment = moment;

// const momentParser = function (datetime, output_format) {
//     if (datetime) {
//         if (output_format) {
//             return moment(datetime).utcOffset("+08:00").format(output_format);
//         }
//         return moment(datetime).utcOffset("+08:00").format("MMMM DD, YYYY");
//     }
//     return "-";
// };

Vue.prototype.$momentParser = function (datetime, output_format) {
    if (datetime) {
        if (output_format) {
            return moment(datetime).utcOffset("+08:00").format(output_format);
        }
        return moment(datetime).utcOffset("+08:00").format("MMMM DD, YYYY");
    }
    return "-";
};

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    icon: "success",
    position: "top",
    showConfirmButton: false,
    timer: 3000,
});
window.toast = toast;

const confirm = swal.mixin({
    icon: "warning",
    title: "Are you sure?",
    showCancelButton: true,
    confirmButtonText: "Yes",
    customClass: {
        confirmButton:
            "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
        cancelButton:
            "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
    },
    buttonsStyling: false,
});
window.confirm = confirm;

window.debug = function (value) {
    console.log(value);
};

Vue.component("Toggle", Toggle);
Vue.component("login", require("./components/Login.vue").default);
Vue.component("settings", require("./components/Settings.vue").default);
Vue.component(
    "search-vendors",
    require("./components/SearchVendors.vue").default
);
Vue.component("addnewjo", require("./components/AddNewJO.vue").default);
Vue.component("navigation", require("./components/layouts/Nav.vue").default);
Vue.component("cart", require("./components/Cart.vue").default);
Vue.component(
    "pending-orderslip",
    require("./components/PendingOrderslip.vue").default
);
Vue.component(
    "completed-orderslip",
    require("./components/CompletedOrderslip.vue").default
);
Vue.component(
    "user-information",
    require("./components/UserInformation.vue").default
);
Vue.component("stores", require("./components/Stores.vue").default);
Vue.component(
    "store-products",
    require("./components/StoreProducts.vue").default
);
Vue.component(
    "store-product",
    require("./components/StoreProduct.vue").default
);
Vue.component(
    "print-preview",
    require("./components/PrintPreview.vue").default
);
Vue.component("qr-code", VueQRCodeComponent);
Vue.component(
    "orderslip-overview",
    require("./components/OrderslipOverview.vue").default
);
Vue.component("servery", require("./components/Servery.vue").default);
Vue.component(
    "edit-product-on-cart",
    require("./components/EditProductOnCart.vue").default
);
Vue.component("product-list", require("./components/ProductList.vue").default);

Vue.component(
    "carts-customer",
    require("./components/carts/Customer.vue").default
);
Vue.component(
    "carts-customer-browser",
    require("./components/carts/CustomerBrowser.vue").default
);
Vue.component(
    "collections.index",
    require("./components/collections/Index.vue").default
);
Vue.component(
    "collections.modal",
    require("./components/collections/Modal.vue").default
);
Vue.component(
    "accounts.browser",
    require("./components/accounts/Browser.vue").default
);
Vue.component(
    "accounts.add_mode_of_payment",
    require("./components/collections/AddModeOfPayment.vue").default
);
Vue.component(
    "accounts.add_invoice",
    require("./components/collections/AddInvoice.vue").default
);

Vue.directive("click-outside", {
    bind: function (el, binding, vnode) {
        el.eventSetDrag = function () {
            el.setAttribute("data-dragging", "yes");
        };
        el.eventClearDrag = function () {
            el.removeAttribute("data-dragging");
        };
        el.eventOnClick = function (event) {
            var dragging = el.getAttribute("data-dragging");
            // Check that the click was outside the el and its children, and wasn't a drag
            if (
                !(el == event.target || el.contains(event.target)) &&
                !dragging
            ) {
                // call method provided in attribute value
                vnode.context[binding.expression](event);
            }
        };
        document.addEventListener("touchstart", el.eventClearDrag);
        document.addEventListener("touchmove", el.eventSetDrag);
        document.addEventListener("click", el.eventOnClick);
        document.addEventListener("touchend", el.eventOnClick);
    },
    unbind: function (el) {
        document.removeEventListener("touchstart", el.eventClearDrag);
        document.removeEventListener("touchmove", el.eventSetDrag);
        document.removeEventListener("click", el.eventOnClick);
        document.removeEventListener("touchend", el.eventOnClick);
        el.removeAttribute("data-dragging");
    },
});

import { mapGetters } from "vuex";
const app = new Vue({
    el: "#app",
    store: new Vuex.Store(store),
    methods: {
        tableCleaner() {
            axios.patch(`/table-cleaner`).then((res) => {
                // debug('cleaning the table...')
            });
        },
    },
    computed: {
        ...mapGetters(["get_auth", "get_settings"]),
    },
    created() {
        if (!this.get_auth) {
            if (
                ["/login", "/settings"].indexOf(window.location.pathname) > -1
            ) {
                return;
            }
            // force logout if the location storage vuex has been removed.
            window.location = "/logout";
        }

        if (
            this.get_auth != null &&
            ["shell_ambulant", "restaurant_ambulant"].includes(
                this.get_settings.app_type
            )
        ) {
            this.$store.dispatch("fetchCurrentTransaction");
        }

        if (this.get_settings.app_type == "restaurant_ambulant") {
            this.tableCleaner();
            setInterval(() => {
                this.tableCleaner();
            }, 10000);
        }
    },
});
