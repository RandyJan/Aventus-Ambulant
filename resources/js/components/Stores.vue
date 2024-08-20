<template>
  <div>
    <!-- IF HAS RECORDS -->
    <div v-if="stores != null && stores.data.length > 0" class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div @click="goToStoreProducts(store)" v-for="(store, index) in stores.data" :key="index" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <div class="flex-shrink-0">
                <!-- <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> -->
            </div>
            <div class="flex-1 min-w-0">
                <a href="#" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">{{ store.description }}</p>
                    <!-- <p class="text-sm text-gray-500 truncate">23 Items</p> -->
                </a>
            </div>
        </div>
        <!-- More people... -->
    </div>

      <!-- IF NO RECORDS -->
        <div v-if="stores != null && stores.data.length == 0" class="mt-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <!-- <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3> -->
            <p class="mt-1 text-sm text-gray-500 font-medium">Nothing to display.</p>
        </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            search: '',
            stores : null,
        }
    },
    methods: {
        fetchStores(page = null){
            axios.get(`/stores`, {
                params: {
                    search : this.search,
                    page : page ?? 1,
                    limit: 50
                }
            }).then( res => {
                this.stores = JSON.parse( JSON.stringify(res.data));
            }).catch( error => {
                this.stores = null;
            })
        },
        goToStoreProducts(store){
            this.$store.dispatch('changeSelectedStore', JSON.parse(JSON.stringify(store)));
            window.location = `/stores/${store.slug}`;
        }
    },
    mounted(){
        this.fetchStores();
    }
}
</script>

<style>

</style>
