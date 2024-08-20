<template>
    <div class="">

        <!-- SEARCH -->
        <div class="grid grid-cols-12 gap-5">

            <div class="col-span-6" v-click-outside="hideCategory" >
                 <label id="listbox-label" class="block text-sm font-medium text-gray-700">Choose Category</label>
                <Multiselect
                    class="block mt-2"
                    placeholder="All"
                    :searchable="true"
                    v-model="selected_category"
                    :options="category_options"
                    @select="fetchProducts(1)"
                    @deselect="fetchProducts(1)"
                    @clear="onClearCategory()"

                />
            </div>

            <div class="col-span-6 rounded-md shadow-sm flex items-end">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <input
                        v-model="search"
                        @keyup="fetchProducts()"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300"
                        placeholder="Search here...">
                </div>
            </div>

        </div>


        <!-- PRODUCTS -->
        <div v-if="products != null" class="mt-3 pb-10">

            <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                <li  v-for="(item, index) in products.data"
                    :key="index"
                    @click="goToProduct(item)"
                    class="relative" >

                    <div class="shadow-sm group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                        <img
                            :src="item.img_path"
                            class="h-44 w-full object-cover pointer-events-none group-hover:opacity-75"
                            alt="">
                        <button type="button" class="absolute inset-0 focus:outline-none">
                            <!-- <span class="sr-only">View details for IMG_4985.HEIC</span> -->
                        </button>
                    </div>
                    <p class="mt-2 text-sm font-medium text-gray-900 pointer-events-none flex">

                        <span class="bg-gray-600 text-white px-1 rounded">
                            {{ item.retail }}
                        </span>

                        <span
                        class="ml-1 text-sm font-medium text-gray-500 truncate pointer-events-none">
                            {{ item.product_description }}
                        </span>
                    </p>
                </li>

                <!-- More files... -->
            </ul>

        </div >

        <div v-if="products != null && products.data.length == 0" class="mt-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <!-- <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3> -->
            <p class="mt-1 text-sm text-gray-500">Nothing to display.</p>
        </div>

        <!-- PAGINATION -->
        <!-- <div>
        </div> -->

        <store-product
            v-if="get_product_overview_status"
        ></store-product>

    </div>
</template>

<script>
import { mapGetters } from "vuex";
import StoreProduct from './StoreProduct.vue';
import Multiselect from '@vueform/multiselect/dist/multiselect.vue2.js'

export default {
  components: { StoreProduct, Multiselect },
    data(){
        return {
            is_category_selection_visible: false,
            search: '',
            products : null,
            selected : null,
            toggle: false,
            // categories:['All'],
            outlet_categories: [],
            selected_category: null,
            search_category: 'All',
            category_options: [],
        }
    },
    computed: {
        ...mapGetters([
            'get_auth',
            'get_selected_store',
            'get_product_overview_status'
        ])
    },
    methods: {
        fetchProducts(page = null){
            axios.get(`/outlet-products`, {
                params: {
                    exclude_zero_price: true,
                    branch_id: this.get_auth.branch.id,
                    outlet_id: this.get_auth.outlet.id,
                    search: this.search,
                    group: this.selected_category,
                    page: page ?? 1,
                    limit: 500
                }
            }).then( res=> {
                this.products = JSON.parse( JSON.stringify(res.data) );
            }).catch( err => {
                this.products = null;
            })
        },

        goToProduct(product){
            this.$store.dispatch('changeSelectedStoreProduct', JSON.parse(JSON.stringify(product)))
            this.$store.dispatch('openProductOverview')
        },

        getSelectedCategory(index){
            this.selected = index.description;
            this.toggle = false;
            this.selected_category = index.group_code;
            this.search_category = index.description;
            this.fetchProducts(1);
        },
        fetchGroups(){
            // if(this.search_category == ''){
            //     this.search_category = 'All';

            // }
            axios.get(`/outlet-groups`, {
                params: {
                    branch_id: this.get_auth.branch.id,
                    outlet_id: this.get_auth.outlet.id,
                    search: this.search_category
                }
            }).then(res=>{
                this.outlet_categories = res.data.data;
                // this.outlet_categories.forEach(el=>{
                //     this.categories.push(el.description);
                // })

                this.outlet_categories.forEach(el => {

                    if (el.description.trim() != '') {
                        this.category_options.push({
                            value: el.group_code,
                            label: el.description
                        });
                    }
                });
            })
        },
        hideCategory(){
            this.toggle = false;
            this.selected = 'All';
        },
        setToAll() {
            console.log('i am fired');
            if(this.search_category == ''){
                this.search_category = 'All';
                this.selected_category = null;
                // this.fetchProducts(1);
            }
        },

        searchCategory(){
            this.toggle =true;
            this.fetchGroups(1);
        },
        toggleCategories(){
            this.search_category = '';
            this.toggle = !this.toggle;
        },

        onClearCategory() {
            this.selected_category = null;
            this.fetchProducts(1);
        }

    },
    mounted(){
        this.fetchProducts();
        this.fetchGroups();
    }
}
</script>

<!-- <style>
    @import '@vueform/multiselect/themes/tailwind.css';
</style> -->
<style src="@vueform/multiselect/themes/default.css"></style>
