<template>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">User Information</h3>
                    <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p> -->
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div v-if="get_auth.user" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.user.name }}
                            </dd>
                        </div>
                        <div v-if="get_auth.branch" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Branch</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.branch.branch_name }}
                            </dd>
                        </div>
                        <div v-if="get_auth.outlet" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Outlet</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.outlet.description }}
                            </dd>
                        </div>
                        <div v-if="get_auth.terminal" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Terminal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.terminal.description }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div v-if="get_settings.work_shifting" class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Shift Information</h3>
                    <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p> -->
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Today's Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.shift.todays_date }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Business Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.shift.current != null ? get_auth.shift.current.business_date : '-' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Shift #</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.shift.current != null ? get_auth.shift.current.shift_count : '-' }}
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Shift Posted At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.shift.current ? (get_auth.shift.current.shift_posted_at ?  get_auth.shift.current.shift_posted_at:'n/a') : '-'}}
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Day Posted At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ get_auth.shift.current ? (get_auth.shift.current.day_posted_at ?  get_auth.shift.current.day_posted_at:'n/a') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="  flex justify-center space-x-5 px-4 py-5 ">
                    <button
                        v-if="get_auth.shift.current == null || get_auth.shift.current.business_date != get_auth.shift.todays_date"
                        @click="openShift()"
                        class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                            Open Shift
                    </button>
                    <button
                        v-if="get_auth.shift.current != null ? (get_auth.shift.current.shift_posted === '0' ? true:false) : null"
                        @click="closeShift()"
                        class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                            Close Shift
                    </button>
                    <button
                        v-if="get_auth.shift.current != null ? (get_auth.shift.current.day_posted === '0' ? true:false) : null"
                        @click="closeDay()"
                        class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Close Day
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex"
export default {
    methods: {
        ...mapMutations([
            'update_authenticated_user_shift'
        ]),
        openShift(){
            confirm.fire({
                text: 'Your shift will be open if you continue!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/open-shift', {
                        branch_id: this.get_auth.branch.id,
                        outlet_id: this.get_auth.outlet.id,
                        terminal_id: this.get_auth.terminal.id,
                    }).then( res => {
                        this.update_authenticated_user_shift( res.data.data );
                        toast.fire({
                            title: res.data.message
                        })
                    }).catch( error => {

                    });
                }
            })
        },
        closeShift(){
            confirm.fire({
                text: 'Your shift will be close if you continue!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/close-shift', {
                        shift_id: this.get_auth.shift.current.id
                    }).then( res => {
                        this.update_authenticated_user_shift( res.data.data );
                        toast.fire({
                            title: res.data.message
                        })
                    }).catch( error => {

                    });
                }
            })
        },
        closeDay(){
            confirm.fire({
                text: 'Are you sure you want to Close Day?'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/close-day', {
                        shift_id: this.get_auth.shift.current.id
                    }).then( res => {
                        this.update_authenticated_user_shift( res.data.data );
                        toast.fire({
                            title: res.data.message
                        })
                    }).catch( error => {

                    });
                }
            })
        },
    },
    computed: {
        ...mapGetters([
            'get_auth',
            'get_settings',
        ])
    }
}
</script>

<style>

</style>
