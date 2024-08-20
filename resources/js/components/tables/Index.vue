<template>
    <transition name="container">
        <div class="fixed inset-x-0 inset-y-0 bg-gray-100 z-50 overflow-auto">
            <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <div class="m-auto container p-5">
                <h1 class="font-extrabold text-2xl text-gray-800">Tables</h1>


                <!-- table -->
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="mt-8 flex flex-col">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                    <!-- <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">OS No.</th> -->
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>

                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="(table, tableIndex) in tables" :key="tableIndex">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div class="text-gray-900">{{ table.description }}</div>
                                            <div class="text-gray-500"> <small>{{ table.table_code }}</small> </div>
                                        </td>
                                        <!-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div class="text-gray-900">{{ table.os_number }}</div>
                                        </td> -->
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span v-if="table.os_number == null" class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Available</span>
                                            <span v-if="table.os_number != null" class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Used</span>

                                            <div v-if="table.os_number != null" class="text-gray-500 px-2"> <small>{{ table.os_number }}</small> </div>
                                        </td>
                                    </tr>

                                    <!-- More people... -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- end of table -->

            </div>

        </div>
    </transition>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
    data(){
        return {
            tables: [],
        }
    },
    methods:{
        fetchTables(){
            axios.get('/tables', {
                params: {
                    limit: 100,
                    // available_only: true,
                    branch_id: this.get_auth.branch.id
                }
            }).then(res=>{
            //   this.tables = res.data.data;
            this.tables = [];
            res.data.data.forEach(el=>{
                this.tables.push({
                    ...el
                });
            })
        })
      },
    },
    computed:{
        ...mapGetters([
            'get_auth'
        ]),
    },
    created(){
        this.fetchTables();
    }

}
</script>

<style>

</style>
