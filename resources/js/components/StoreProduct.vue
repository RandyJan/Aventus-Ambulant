<template>
    <transition name="cart">
        <div class="fixed inset-0 bg-gray-100 z-50">
            <button @click="close()" class="absolute top-2 right-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <div class="h-full overflow-y-auto">
                <div class="mx-auto mb-14 mt-14 p-5 max-w-lg">
                    <div
                        class="shadow-sm group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                        <img :src="get_selected_store_product
                            ? get_selected_store_product.img_path
                            : null
                            " onerror="this.onerror=null;this.src='/assets/default-product.png';"
                            class="h-56 w-full object-cover pointer-events-none group-hover:opacity-75" alt="" />
                    </div>

                    <div class="flex justify-between mt-2 items-start">
                        <div class="ml-1 text-base font-medium text-gray-500 pointer-events-none">
                            {{
                                get_selected_store_product
                                    ? get_selected_store_product.product_description
                                    : null
                            }}
                            <span class="text-red-500">{{
                                main.is_group_meal == 1
                                    ? `(${main.group_serving}pax)`
                                    : ""
                            }}</span>
                        </div>
                        <span
                            class="flex-shrink-0 flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-600 text-gray-50">
                            {{
                                get_selected_store_product
                                    ? get_selected_store_product.retail
                                    : null
                            }}
                        </span>
                    </div>

                    <div class="">
                        <div class="flex space-x-5 justify-center items-center mt-5">
                            <button @click="minusQty()" type="button"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4" />
                                </svg>
                            </button>
                            <div class="text-4xl font-medium">
                                {{ main.modified_quantity }}
                            </div>
                            <button @click="plusQty()" type="button"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div class="text-center text-gray-500">Quantity</div>
                    </div>

                    <!-- headcounts configuration -->
                    <div v-if="get_current_transaction.is_sc" class="mt-5">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-gray-100 text-sm text-gray-500 tracking-wide">
                                    Headcount Configuration
                                </span>
                            </div>
                        </div>
                        <div class="">
                            <div>
                                <div class="flex space-x-5 justify-center items-center mt-5">
                                    <button @click="minusQtySCPWD()" type="button"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <div class="text-4xl font-medium">
                                        {{ sc_count }}
                                    </div>
                                    <button @click="plusQtySCPWD()" type="button"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-center text-xs mt-1">
                                    <span class="italic">
                                        Senior Headcount ({{ sc_records.length
                                        }}<small>max</small>)
                                    </span>
                                </div>
                            </div>
                            <!-- <div>
                                <div class="flex space-x-5 justify-center items-center mt-5">

                                    <div class="text-4xl font-medium">
                                        {{ regular_headcount }}
                                    </div>
                                </div>
                                <div class="text-center text-xs mt-1">
                                    <span class="italic">
                                        Regular Headcount
                                    </span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- end of headcounts configuration -->

                    <!-- non modifiable components -->
                    <div v-if="non_modifiable.length > 0" class="mt-5">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-gray-100 text-sm text-gray-500 tracking-wide">
                                    Non Modifiable Components
                                </span>
                            </div>
                        </div>

                        <!-- component -->
                        <!-- :class="{ 'hidden':!item.is_visible }"  -->
                        <div class="p-2 text-gray-500">
                            <label v-for="(item, index) in non_modifiable" :key="index"
                                :class="{ hidden: !item.is_visible }" class="text-sm font-medium flex items-center">
                                {{ item.child_description }}
                                <small class="ml-2 font-normal">quantity
                                    {{ item.modified_quantity }}</small>
                            </label>
                        </div>
                    </div>
                    <!-- end of non modifiable components -->

                    <!-- modifiable components -->
                    <div v-if="modifiable.length > 0" class="mt-5">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-gray-100 text-sm text-gray-500 tracking-wide">
                                    Modifiable Components
                                </span>
                            </div>
                        </div>

                        <!-- component -->
                        <div v-for="(item, index) in modifiable" :key="index" class="p-2 rounded text-gray-500">
                            <label class="text-sm font-medium flex items-center">
                                {{ item.child_description }}
                                <small class="ml-2 font-normal">quantity
                                    {{ item.modified_quantity }}</small>
                            </label>

                            <!-- sub component available for swap -->
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="(
                                        sub_item, sub_item_index
                                    ) in item.group_products" :key="sub_item_index" class="py-2">
                                    <!-- Your content -->
                                    <div class="grid grid-cols-12">
                                        <div class="col-span-3 flex justify-center items-center space-x-2">
                                            <button @click="
                                                minusSubComponentQty(
                                                    item,
                                                    sub_item
                                                )
                                                " type="button"
                                                class="inline-flex items-center p-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>

                                            <div class="text-lg font-medium">
                                                {{ sub_item.modified_quantity }}
                                            </div>

                                            <button @click="
                                                plusSubComponentQty(
                                                    item,
                                                    sub_item
                                                )
                                                " type="button"
                                                class="inline-flex items-center p-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="col-span-7 text-xs items-center">
                                            <div>
                                                {{
                                                    sub_item.product_description
                                                }}
                                            </div>
                                            <div class="text-[10px] font-semibold">
                                                {{
                                                    sub_item.retail_price.toFixed(
                                                        2
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="col-span-2 text-xs font-semibold flex justify-end items-center">
                                            {{
                                                (
                                                    sub_item.retail_price *
                                                    sub_item.modified_quantity
                                                ).toFixed(2)
                                            }}
                                        </div>
                                    </div>
                                </li>
                                <!-- More items... -->
                            </ul>
                        </div>
                    </div>
                    <!-- end of modifiable components -->

                    <div class="mt-5">
                        <label for="comment" class="block text-xs text-gray-500">
                            {{
                                get_settings.app_type == "invoicer_ambulant"
                                    ? "IMEI"
                                    : ""
                            }}
                            {{
                                get_settings.app_type == "restaurant_ambulant"
                                    ? "Add notes"
                                    : ""
                            }}
                            {{
                                get_settings.app_type == "shell_ambulant"
                                    ? "Add notes"
                                    : ""
                            }}
                        </label>
                        <div class="mt-1">
                            <textarea v-model="main.notes" rows="2" name="comment" id="comment"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 border-t">
                        <div class="">
                            <!-- <div v-if="vatable_sales > 0" class="relative"> -->
                            <div  class="relative">

                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex items-center justify-between">
                                    <span class="pr-3 bg-gray-100 text-sm font-medium text-gray-700">
                                        VATable Sales
                                    </span>
                                    <span class="pr-3 pl-2 bg-gray-100 text-sm font-medium text-gray-700">
                                        {{ vatable_sales.toFixed(2) }}
                                    </span>
                                </div>
                            </div>
                            <!-- <div v-if="vat_amount > 0" class="relative"> -->
                            <div class="relative">

                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex items-center justify-between">
                                    <span class="pr-3 bg-gray-100 text-sm font-medium text-gray-700">
                                        VAT Amount
                                    </span>
                                    <span class="pr-3 pl-2 bg-gray-100 text-sm font-medium text-gray-700">
                                        {{ vat_amount.toFixed(2) }}
                                    </span>
                                </div>
                            </div>
                            <!-- <div v-if="vat_ex > 0" class="relative"> -->
                            <div  class="relative">

                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex items-center justify-between">
                                    <span class="pr-3 bg-gray-100 text-sm font-medium text-gray-700">
                                        VAT Ex.
                                    </span>
                                    <span class="pr-3 pl-2 bg-gray-100 text-sm font-medium text-gray-700">
                                        {{ vat_ex.toFixed(2) }}
                                    </span>
                                </div>
                            </div>
                            <div  class="relative">

<div class="absolute inset-0 flex items-center" aria-hidden="true">
    <div class="w-full border-t border-gray-300"></div>
</div>
<div class="relative flex items-center justify-between">
    <span class="pr-3 bg-gray-100 text-sm font-medium text-gray-700">
        Discount
    </span>
    <span class="pr-3 pl-2 bg-gray-100 text-sm font-medium text-gray-700">
        {{ sc_discount_amount.toFixed(2) }}
    </span>
</div>
</div>

                            <!-- <div v-if="sc_discount_amount > 0" class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex items-center justify-between">
                                    <span class="pr-3 bg-gray-100 text-sm font-medium text-gray-700">
                                        SC/PWD Discount
                                        {{ sc_discount_percentage }}%
                                    </span>
                                    <span class="pr-3 pl-2 bg-gray-100 text-sm font-medium text-gray-700">
                                        {{ sc_discount_amount.toFixed(2) }}
                                    </span>
                                </div>
                            </div> -->
                        </div>

                        <button @click="submit()" type="button" :class="{
                            'bg-green-600 hover:bg-green-700 focus:ring-green-500':
                                main.modified_quantity > 0,
                            'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500':
                                main.modified_quantity <= 0,
                        }"
                            class="mt-4 w-full justify-center inline-flex items-center px-4 py-3 border border-transparent text-sm leading-4 font-semibold rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 tracking-wide">
                            Add to Cart - {{ net_amount.toFixed(2) }}
                        </button>
                        <button @click=" discountBtn()" type="button" :class="{
                            'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500':
                                main.modified_quantity > 0,
                            'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500':
                                main.modified_quantity <= 0,
                        }" class="mt-2 w-full justify-center inline-flex items-center px-4 py-3 border 
                        border-transparent text-sm leading-4 font-semibold rounded-md shadow-sm text-white
                         focus:outline-none focus:ring-2 focus:ring-offset-2 tracking-wide" data-bs-toggle="modal">
                            Apply Discount
                        </button>
                        <!-- modal -->
                        <div v-if="isApplyDisc" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
                            aria-modal="true">

                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                            </div>

                            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                <div
                                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                                    <div
                                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl 
                                        transition-all sm:my-8  w-2/3 ">
                                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 w-full">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                    <h3 class="py-4 px-6 text-left text-gray-600 font-bold uppercase"
                                                        id="modal-title">Item Discount</h3>


                                                    <div class=" rounded-lg overflow-hidden mx-4 md:mx-0 mytbl-cont">
                                                        <table class="w-full table-fixed ">
                                                            <thead>
                                                                <tr class="bg-gray-100">
                                                                    <th
                                                                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                                        Discount</th>
                                                                    <th
                                                                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                                        Value</th>
                                                                    <th
                                                                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                                                                        isPercent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white">
                                                                <tr v-for=" (item,index) in discounts"
                                                                 :key=index
                                                                 class="hover:bg-gray-200 hover:cursor-pointer"
                                                                 @click="computeDiscount(item.VALUE,item.ISPERCENT,item.ID)"

                                                                 >
                                                                    <td class="py-4 px-6 border-b border-gray-200">{{item.SHORTDESCRIPTION}}

                                                                    </td>
                                                                    <td
                                                                        class="py-4 px-6 border-b border-gray-200 truncate">
                                                                        {{ item.VALUE }}</td>
                                                                    <td class="py-4 px-6 border-b border-gray-200">
                                                                        {{ item.ISPERCENT == 1? "YES":"NO" }}</td>

                                                                </tr>
                                                                
                                                                <!-- Add more rows here -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                            <button @click = "closeDisc()" type="button"
                                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                                >Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end -->
                    </div>


                </div>
            </div>
        </div>





    </transition>

</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: "StoreProduct",

    data() {
        return {
            isApplyDisc: false,
            main: null,
            non_modifiable: [],
            modifiable: [],
            sc_records: [],
            discounts:null,
            discountedAmount:0,
            sc_count: 0,
            tax_and_discount_template: {
                service_charge: false,
                service_charge_percentage: 0,
                service_charge_amount: 0,

                tax_percentage: 12,
                vatable_sales: 0,
                vat_amount: 0,
                vat_ex: 0,
                sc_discount_amount: 0,
            },
        };
    },
    methods: {
        close() {
            this.$store.dispatch("closeProductOverview");
        },
        computeDiscount(value,isPercent,disc_id){
            var items = this.main;
            if(items.net_amount < value){
                toast.fire({
                    icon:"error",
                    title: "Discount Value should not be greater than price"
                });
                return;
            }
            if(items.isDiscounted == 1){
                toast.fire({
                    icon:"error",
                    title: "Item already discounted"
                });
                return;
            }
            console.log("dis one");
            console.log(items);
            var basePrice =items.net_amount;
            var vatAmt = items.vat_amount;
            var lessVatPrice = basePrice-vatAmt;
            var discValue = isPercent == 1? value/100:value;

            var discAmt = isPercent == 1 ? lessVatPrice * discValue:discValue;
            var discountedPrice = lessVatPrice - discAmt;
            this.discountedAmount = discountedPrice;
            items.sc_discount_amount = discAmt;
            items.sc_discount_percentage =value;
            items.discId = disc_id;
     if(value == 20)
            {      items.vat_ex = lessVatPrice;
                items.vat_amount = 0;
                items.vatable_sales = 0;}
            items.net_amount = discountedPrice;
            items.isDiscounted = 1;
            console.log(discountedPrice);
            console.log(isPercent);
            toast.fire({
                    icon:"success",
                    title: "Item discount success"
                });
            this.closeDisc();
        },
        closeDisc(){
            this.isApplyDisc = !this.isApplyDisc;
            
        },
        discountBtn() {
            this.isApplyDisc = !this.isApplyDisc;
            axios
                        .get(`/getDiscounts`)
                        .then((res) => {
                            this.discounts = JSON.parse(JSON.stringify(res.data));
                            // toast.fire({
                            //     title: "Request successful",
                            // });
                            console.log(this.discounts);
                        })
                        .catch((error) => {
                            toast.fire({
                                icon: "warning",
                                title: error.response.data.message,
                            });
                            // console.log( error.response.data.message);
                        });
        },
        minusQtySCPWD() {
            if (this.sc_count == 0) {
                return;
            }

            this.sc_count--;
            this.taxAndDiscountUpdater();
        },
        plusQtySCPWD() {
            if (this.sc_records.length == this.sc_count) {
                toast.fire({
                    title: `Max Senior Count is ${this.sc_records.length}`,
                    icon: "info",
                });
                return;
            }

            // if(this.main.modified_quantity == this.sc_count){
            //     toast.fire({title: `Cant be higher than the order quantity`, icon: 'warning'})
            //     return ;
            // }

            this.sc_count++;

            this.taxAndDiscountUpdater();
        },
        minusQty() {
            if (this.main.modified_quantity == 0) {
                return;
            }

            if (this.sc_count == this.main.modified_quantity) {
                this.sc_count -= 1;
            }

            this.main.modified_quantity--;
            this.updateComponents("minus");

            this.taxAndDiscountUpdater();
        },
        plusQty() {
            this.main.modified_quantity++;
            this.updateComponents("plus");

            this.taxAndDiscountUpdater();
        },
        submit() {
            if (this.main.modified_quantity == 0) {
                return;
            }

            confirm.fire({}).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(`/add-to-cart`, {
                            orderslip_number:
                                this.get_current_transaction.orderslip_number,
                            product: this.main,
                            notes: this.main.notes,
                            non_modifiable: this.non_modifiable,
                            modifiable: this.modifiable,
                            senior_headcount: this.sc_count,
                            // regular_headcount: this.regular_headcount,
                        })
                        .then((res) => {
                            toast.fire({
                                title: "Successfully added",
                            });
                            this.$store.dispatch("fetchCurrentTransaction");
                            console.log('this is it');
                            console.log(  this.get_current_transaction);
                            this.close();
                        })
                        .catch((error) => {
                            toast.fire({
                                icon: "warning",
                                title: error.response.data.message,
                            });
                        });
                }
            });
        },
        fetchComponents() {
            axios
                .get(`/postmixes`, {
                    params: {
                        display_only: true,
                        product_id: this.get_selected_store_product.product_id,
                        limit: 100,
                    },
                })
                .then((res) => {
                    res.data.data.forEach((el) => {
                        if (!el.is_modifiable) {
                            this.non_modifiable.push({
                                ...el,
                            });
                        }
                        if (el.is_modifiable) {
                            this.modifiable.push({
                                ...el,
                                group_products: [],
                            });
                        }
                    });

                    this.fetchProductsWithSameCategoryOfModifiableComponent();
                })
                .catch((error) => { });
        },
        fetchProductsWithSameCategoryOfModifiableComponent() {
            this.modifiable.forEach((el) => {
                axios
                    .get("/outlet-products", {
                        params: {
                            include_zero_price: true,
                            branch_id:
                                this.get_selected_store_product.branch_id,
                            outlet_id:
                                this.get_selected_store_product.outlet_id,
                            // group: el.group_code,
                            category: el.category_code,
                            limit: 100,
                        },
                    })
                    .then((res) => {
                        var main_el = res.data.data.filter((e) => {
                            return e.product_id == el.child_product_id;
                        });
                        main_el = main_el[0];

                        res.data.data.forEach((e) => {
                            if (el.child_product_id != e.product_id) {
                                el.group_products.push({
                                    ...e,
                                    ...JSON.parse(
                                        JSON.stringify(
                                            this.tax_and_discount_template
                                        )
                                    ),
                                    amount: 0,
                                    net_amount: 0,
                                    retail_price:
                                        e.retail > main_el.retail
                                            ? e.retail - main_el.retail
                                            : 0,
                                    modified_quantity: 0,
                                });
                            }
                        });
                    });
            });
        },
        updateComponents(action) {
            this.non_modifiable.forEach((el) => {
                el.modified_quantity = el.child_quantity * this.qty;
            });

            this.modifiable.forEach((el) => {
                if (action == "plus") {
                    el.modified_quantity += el.child_quantity;
                }

                if (action == "minus") {
                    if (el.modified_quantity > 0) {
                        el.modified_quantity -= el.child_quantity;
                        return;
                    }

                    var qty_to_deduct = el.child_quantity;
                    el.group_products.forEach((e) => {
                        if (e.modified_quantity > 0 && qty_to_deduct > 0) {
                            if (e.modified_quantity >= qty_to_deduct) {
                                e.modified_quantity -= qty_to_deduct;
                                qty_to_deduct = 0;
                            } else {
                                qty_to_deduct -= e.modified_quantity;
                                e.modified_quantity = 0;
                            }
                        }
                    });
                }
            });
        },
        minusSubComponentQty(parent, child) {
            if (child.modified_quantity == 0) {
                return;
            }

            child.modified_quantity -= 1;
            parent.modified_quantity += 1;
        },
        plusSubComponentQty(parent, child) {
            if (parent.modified_quantity == 0) {
                return;
            }

            parent.modified_quantity -= 1;
            child.modified_quantity += 1;
        },
        taxAndDiscountUpdater() {
            this.compute_tax_and_discount(this.main);
            this.modifiable.forEach((el) => {
                el.group_products.forEach((e) => {
                    this.compute_tax_and_discount(e);
                });
            });
        },
        // compute_tax_and_discount(item) {
        //     console.log("---------------");
        //     console.log("item.product_id", item.product_id);
        //     console.log("item.retail_price", item.retail_price);
        //     console.log("item.modified_quantity", item.modified_quantity);
        //     console.log("item.sc_count", this.sc_count);
        //     console.log("item.is_group_meal", item.is_group_meal);
        //     console.log("item.is_vatable", item.is_vatable);
        //     console.log("item.tax_percentage", item.tax_percentage);
        //     console.log(
        //         "item.is_less_vat_for_scpwd",
        //         item.is_less_vat_for_scpwd
        //     );
        //     console.log(
        //         "item.sc_discount_percentage",
        //         item.sc_discount_percentage
        //     );

        //     item.amount = item.retail_price * item.modified_quantity;

        //     if (item.modified_quantity == 0) {
        //         item.vatable_sales = 0;
        //         item.vat_amount = 0;
        //         item.vat_ex = 0;
        //         item.sc_discount_amount = 0;
        //         item.net_amount = 0;

        //         item.service_charge_amount = 0;
        //         return;
        //     }

        //     // get vatable sales
        //     if (item.is_vatable == 1 || item.is_vatable == true) {
        //         var nprice = item.retail_price;
        //         var nqty = item.modified_quantity;

        //         if (item.is_group_meal == 1) {
        //             nprice = nprice / item.group_serving;
        //             nqty = nqty * item.group_serving;
        //         }

        //         item.vatable_sales =
        //             (nprice * (nqty - this.sc_count)) /
        //             (item.tax_percentage / 100 + 1);
        //     }
        //     // end

        //     // get vat amount
        //     if (item.is_vatable == 1 || item.is_vatable == true) {
        //         item.vat_amount =
        //             item.vatable_sales * (item.tax_percentage / 100);
        //     }
        //     // end

        //     // get VAT Ex
        //     item.vat_ex = 0;
        //     if (item.is_vatable == 1 || item.is_vatable == true) {
        //         var amount = 0;
        //         var nprice = item.retail_price;
        //         var nqty = item.modified_quantity;

        //         if (item.is_group_meal == 1) {
        //             nprice = nprice / item.group_serving;
        //             nqty = nqty * item.group_serving;
        //         }

        //         if (this.sc_count > 0 && item.is_less_vat_for_scpwd == 1) {
        //             amount = nprice * this.sc_count;
        //         }

        //         item.vat_ex = amount / (item.tax_percentage / 100 + 1);
        //     }

        //     // get sc discount
        //     item.sc_discount_amount = 0;
        //     if (this.sc_count > 0 && item.is_less_vat_for_scpwd == 1) {
        //         item.sc_discount_amount =
        //             item.vat_ex * (item.sc_discount_percentage / 100);
        //     }
        //     // end

        //     // get net amount
        //     // item.net_amount = item.amount;
        //     // if( (item.is_vatable == 1 || item.is_vatable == true) && this.sc_count > 0 && item.is_less_vat_for_scpwd == 1 ){
        //     //     item.net_amount = item.vatable_sales;
        //     // }
        //     item.net_amount =
        //         item.vatable_sales +
        //         item.vat_amount +
        //         item.vat_ex -
        //         item.sc_discount_amount;
        //     // end
        // },

        // TAX COMPUTATIONS
        compute_tax_and_discount(item) {
            console.log("---------------");
            console.log("item.product_id", item.product_id);
            console.log("item.retail_price", item.retail_price);
            console.log("item.modified_quantity", item.modified_quantity);
            console.log("item.sc_count", this.sc_count);
            console.log("item.is_group_meal", item.is_group_meal);
            console.log("item.is_vatable", item.is_vatable);
            console.log("item.tax_percentage", item.tax_percentage);
            console.log(
                "item.is_less_vat_for_scpwd",
                item.is_less_vat_for_scpwd
            );
            console.log(
                "item.sc_discount_percentage",
                item.sc_discount_percentage
            );

            item.amount = item.retail_price * item.modified_quantity;

            if (item.modified_quantity == 0) {
                this.reset_computation(item);
                return;
            }

            if (item.is_vatable == 0) {
                this.formula_for_non_vatable(item);
            }

            if (item.is_vatable == 1) {
                this.formula_for_vatable(item);
            }

            return;
        },
        formula_for_non_vatable(item) {
            console.info("formula_for_non_vatable...");
            this.reset_computation(item);

            var _price = item.retail_price;
            var _qty = item.modified_quantity;

            if (item.is_group_meal == 1) {
                _price = _price / item.group_serving;
                _qty = _qty * item.group_serving;
            }

            if (this.sc_count > 0) {
                item.sc_discount_amount =
                    _price *
                    this.sc_count *
                    (item.sc_discount_percentage / 100);
            }

            item.net_amount = _price * _qty - item.sc_discount_amount;

            this.print_computed_value(item);
        },
        formula_for_vatable(item) {
            this.reset_computation(item);
            console.info("formula_for_vatable...");
            if (this.sc_count == 0) {
                this.formula_for_vatable_non_discount(item);
            }

            if (this.sc_count > 0 && item.is_less_vat_for_scpwd == 0) {
                this.formula_for_scpwd_non_less_vat(item);
            }

            if (this.sc_count > 0 && item.is_less_vat_for_scpwd == 1) {
                this.formula_for_scpwd_less_vat(item);
            }

            this.print_computed_value(item);
        },
        formula_for_vatable_non_discount(item) {
            console.info("formula_for_vatable_non_discount...");
            var _price = item.retail_price;
            var _qty = item.modified_quantity;

            item.vatable_sales =
                (_price * _qty) / (item.tax_percentage / 100 + 1);

            item.vat_amount = item.vatable_sales * (item.tax_percentage / 100);

            item.net_amount = item.vatable_sales + item.vat_amount;
        },
        formula_for_scpwd_non_less_vat(item) {
            console.info("formula_for_scpwd_non_less_vat...");
            var _price = item.retail_price;
            var _qty = item.modified_quantity;
            var _tax_percentage_over = item.tax_percentage / 100 + 1;
            var _tax_percentage = item.tax_percentage / 100;

            if (item.is_group_meal == 1) {
                _price = _price / item.group_serving;
                _qty = _qty * item.group_serving;
            }

            var _qty_without_sc = _qty - this.sc_count;
            var _gross_price = _price * _qty_without_sc;
            item.vatable_sales = _gross_price / _tax_percentage_over;
            item.vat_amount = item.vatable_sales * _tax_percentage;

            var _sc_gross_price = _price * this.sc_count;
            var _sc_vat_amount =
                (_sc_gross_price / _tax_percentage_over) * _tax_percentage;
            var _sc_vat_ex = _sc_gross_price - _sc_vat_amount;
            item.sc_discount_amount =
                _sc_vat_ex * (item.sc_discount_percentage / 100);
            var _sc_net_price_vat_ex = _sc_vat_ex - item.sc_discount_amount;
            var _sc_net_price_plus_vat = _sc_net_price_vat_ex * _tax_percentage;
            var _sc_net_price = _sc_net_price_vat_ex + _sc_net_price_plus_vat;

            // calculate total
            item.vatable_sales += _sc_net_price_vat_ex;
            item.vat_amount += _sc_net_price_plus_vat;
            item.net_amount = item.vatable_sales + item.vat_amount;
        },
        formula_for_scpwd_less_vat(item) {
            console.info("formula_for_scpwd_less_vat...");
            var _price = item.retail_price;
            var _qty = item.modified_quantity;

            if (item.is_group_meal == 1) {
                _price = _price / item.group_serving;
                _qty = _qty * item.group_serving;
            }

            var _qty_without_sc = _qty - this.sc_count;
            item.vatable_sales =
                (_price * _qty_without_sc) / (item.tax_percentage / 100 + 1);
            item.vat_amount = item.vatable_sales * (item.tax_percentage / 100);

            var _gross_amount = _price * this.sc_count;
            var _less_vat =
                (_gross_amount / (item.tax_percentage / 100 + 1)) *
                (item.tax_percentage / 100);

            item.vat_ex = _gross_amount - _less_vat;
            item.sc_discount_amount =
                item.vat_ex * (item.sc_discount_percentage / 100);

            if (item.sc_discount_amount > 0) {
                item.vat_ex -= item.sc_discount_amount;
            }

            item.net_amount =
                item.vatable_sales + item.vat_amount + item.vat_ex;
        },
        reset_computation(item) {
            item.vatable_sales = 0;
            item.vat_amount = 0;
            item.vat_ex = 0;
            item.sc_discount_amount = 0;
            item.service_charge_amount = 0;
            item.net_amount = 0;
        },
        print_computed_value(item) {
            console.info("print_computed_value...");
            console.info(`vatable_sales: ${item.vatable_sales}`);
            console.info(`vat_amount: ${item.vat_amount}`);
            console.info(`vat_ex: ${item.vat_ex}`);
            console.info(`sc_discount_amount: ${item.sc_discount_amount}`);
            console.info(
                `service_charge_amount: ${item.service_charge_amount}`
            );
            console.info(`net_amount: ${item.net_amount}`);
        },
        // END OF TAX COMPUTATIONS
    },
    computed: {
        ...mapGetters([
            "get_product_overview_status",
            "get_selected_store_product",
            "get_current_transaction",
            "get_settings",
        ]),
        vatable_sales() {
            var x = 0;
            x += this.main.vatable_sales;
            return x;
        },
        vat_amount() {
            var x = 0;
            x += this.main.vat_amount;
            return x;
        },
        vat_ex() {
            var x = 0;
            x += this.main.vat_ex;
            return x;
        },
        sc_discount_percentage() {
            var x = 0;
            x += this.main.sc_discount_percentage;
            return x;
        },
        sc_discount_amount() {
            var x = 0;
            x += this.main.sc_discount_amount;
            return x;
        },
        net_amount() {
            var x = 0;
            x += this.main.net_amount;
            return x;
        },
        regular_headcount() {
            return (
                this.get_current_transaction.total_headcount -
                this.sc_records.length
            );
        },
    },

    created() {
        if (this.get_settings.service_charge == true) {
            console.log("service charge is enable...");
            this.tax_and_discount_template.service_charge =
                this.get_settings.service_charge;
            this.tax_and_discount_template.service_charge_percentage =
                this.get_settings.service_charge_percentage;
        }

        this.fetchComponents();

        this.main = {
            ...JSON.parse(JSON.stringify(this.get_selected_store_product)),
            ...JSON.parse(JSON.stringify(this.tax_and_discount_template)),
            amount: 0,
            net_amount: 0,
            modified_quantity: 1,
            notes: "",
            retail_price: this.get_selected_store_product.retail,
            isDiscounted:0,
            discId: 0,
        };
        this.compute_tax_and_discount(this.main);

        this.get_current_transaction.sc_records.forEach((el) => {
            this.sc_records.push({
                ...JSON.parse(JSON.stringify(el)),
            });
        });
    },

};
</script>

<style>
.mytbl-cont{
    max-height: 30vh;
    overflow-y:auto ;
    border: 1px solid #ccc;

}
table{
    width: 100%;
    border-collapse: collapse;

}
thead th{
    position: sticky;
    top: 0;
    background-color: #f9f9f9;
    z-index: 10;
    padding: 8px;
    text-align: center;
    border: solid 1px #ddd;
}
th,td{
    padding: 8px;
    border: 1px solid #ddd;
}
.container-enter-active,
.container-leave-active {
    transition: opacity 0.5s;
}

.container-enter,
.container-leave-to

/* .fade-leave-active below version 2.1.8 */
    {
    opacity: 0;
}
</style>
