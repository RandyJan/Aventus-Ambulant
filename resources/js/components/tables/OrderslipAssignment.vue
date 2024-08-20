<template>
    <transition name="container">
      <div class="fixed inset-x-0 inset-y-0 bg-gray-100 z-50 overflow-auto">
            <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <div class="m-auto container p-5">
                <h1 class="font-extrabold text-2xl text-gray-800">Table Selection</h1>

                <div class="mt-5">
                    <div class="flex space-x-2 relative w-full border-2 border-gray-300 border-dashed rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span
                        v-for="(item, itemIndex) in get_current_transaction.tables"
                        :key="itemIndex"
                        class="inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-indigo-100 text-indigo-700">
                            {{ item.table.description }}
                            <button @click="removeTableInOrderslip(item)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                <span class="sr-only">Remove large option</span>
                                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                </svg>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="grid grid-cols-12 gap-4">

                        <div @click="selectTable(table)" v-for="(table, tableIndex) in tables" :key="tableIndex" class="col-span-6 md:col-span-4 lg:col-span-3 relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <div class="flex-1 min-w-0">
                                <a href="#" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ table.description }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        Code: {{ table.table_code }}
                                    </p>
                                </a>
                            </div>
                        </div>

                        <!-- More people... -->
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    data(){
        return {
            tables: [],
        }
    },
    methods: {
      fetchTables(){
          axios.get('/tables', {
              params: {
                  limit: 100,
                  available_only: true,
                  branch_id: this.get_auth.branch.id
                //   except_os: [ { os:this.get_current_transaction.orderslip_number }]
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
      selectTable(table){
          axios.post(`/orderslip-tables`, {
              branch_id: this.get_auth.branch.id,
              outlet_id: this.get_auth.outlet.id,
              device_id: this.get_auth.terminal.id,
              orderslip_id: this.get_current_transaction.orderslip_id,
              osnumber: this.get_current_transaction.orderslip_number,
              table_id: table.table_id,
              table_code: table.table_code
          }).then(res=>{

              toast.fire({title: res.data.message});

              this.fetchTables();
              this.$store.dispatch('fetchCurrentTransaction');
              this.$store.dispatch('setTable') ;

          })
      },
      removeTableInOrderslip(data){
          debug(data)
          axios.delete(`/orderslip-tables`, {
                data:{
                    branch_id: this.get_auth.branch.id,
                    outlet_id: this.get_auth.outlet.id,
                    device_id: this.get_auth.terminal.id,
                    orderslip_id: this.get_current_transaction.orderslip_id,
                    osnumber: this.get_current_transaction.orderslip_number,
                    table_id: data.table_id
                }
          }).then(res=>{

              toast.fire({title: res.data.message});

              this.fetchTables();
              this.$store.dispatch('fetchCurrentTransaction');

          })
      }
    },
    computed: {
        ...mapGetters([
            'get_current_transaction',
            'get_auth',
        ])
    },
    created(){
        this.fetchTables();
    }
}
</script>

<style>

</style>
