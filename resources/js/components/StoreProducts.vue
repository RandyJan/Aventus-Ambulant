<template>
    <div class="">
        <!-- SEARCH -->
        <div>
            <!-- <label for="email" class="block text-sm font-medium text-gray-700">Search products</label> -->
            <div class="mt-1 flex rounded-md shadow-sm">
                <div
                    class="relative flex items-stretch flex-grow focus-within:z-10"
                >
                    <input
                        v-model="search"
                        @keyup="fetchProducts()"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300"
                        placeholder="Search here..."
                    />
                </div>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div v-if="products != null" class="py-3">
            <ul
                role="list"
                class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
            >
                <li
                    v-for="(item, index) in products.data"
                    :key="index"
                    @click="goToProduct(item)"
                    class="relative"
                >
                    <div
                        class="shadow-sm group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden"
                    >
                        <img
                            :src="item.img_path"
                            onerror="this.onerror=null;this.src='/assets/default-product.png';"
                            class="h-44 w-full object-cover pointer-events-none group-hover:opacity-75"
                            alt=""
                        />
                        <button
                            type="button"
                            class="absolute inset-0 focus:outline-none"
                        >
                            <!-- <span class="sr-only">View details for IMG_4985.HEIC</span> -->
                        </button>
                    </div>
                    <p
                        class="mt-2 text-sm font-medium text-gray-900 pointer-events-none flex items-start"
                    >
                        <span
                            class="flex-shrink-0 bg-gray-600 text-white px-1 rounded"
                        >
                            {{ item.retail }}
                        </span>

                        <span
                            class="ml-1 text-sm font-medium text-gray-500 pointer-events-none"
                        >
                            {{ item.short_description }}
                        </span>
                    </p>
                </li>

                <!-- More files... -->
            </ul>
        </div>

        <div
            v-if="products != null && products.data.length == 0"
            class="mt-10 text-center"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mx-auto h-12 w-12 text-gray-400"
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
            <p class="mt-1 text-sm text-gray-500">Nothing to display.</p>
        </div>

        <!-- PAGINATION -->
        <div></div>

        <store-product v-if="get_product_overview_status"></store-product>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import StoreProduct from "./StoreProduct.vue";
export default {
    components: { StoreProduct },
    data() {
        return {
            search: "",
            products: null,
            selected: null,
        };
    },
    computed: {
        ...mapGetters([
            "get_auth",
            "get_selected_store",
            "get_product_overview_status",
        ]),
    },
    methods: {
        fetchProducts(page = null) {
            axios
                .get(`/stores/${this.get_selected_store.group_code}/products`, {
                    params: {
                        branch_id: this.get_auth.branch.id,
                        outlet_id: this.get_auth.outlet.id,
                        search: this.search,
                        page: page ?? 1,
                        limit: 50,
                    },
                })
                .then((res) => {
                    this.products = JSON.parse(JSON.stringify(res.data));
                })
                .catch((err) => {
                    this.products = null;
                });
        },

        goToProduct(product) {
            this.$store.dispatch(
                "changeSelectedStoreProduct",
                JSON.parse(JSON.stringify(product))
            );
            this.$store.dispatch("openProductOverview");
        },
    },
    mounted() {
        this.fetchProducts();
        // console.log("from vue...");
    },
};
</script>

<style></style>
