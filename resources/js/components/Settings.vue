<template>
    <main class="relative -mt-32">
        <div class="max-w-screen-xl mx-auto pb-6 px-4 sm:px-6 lg:pb-16 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">

                    <div class="divide-y divide-gray-200 lg:col-span-12">
                        <!-- Profile section -->
                        <div class="py-6 px-4 sm:p-6 lg:pb-8">
                            <div class="mt-6 grid grid-cols-12 gap-6">
                                <!-- <div class="col-span-12">
                                    <label for="url" class="block text-sm font-medium text-gray-700">API URL</label>
                                    <input type="text" name="url" id="url"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                    <p class="mt-2 text-sm text-gray-500">
                                        ex. http://example.com
                                    </p>
                                </div> -->

                                <!-- <div class="col-span-12 sm:col-span-6">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">Device
                                        Name</label>
                                    <input type="text" v-model="device_name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                </div> -->
                                <div class="col-span-12">
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">Device
                                        Serial</label>
                                    <input type="text" v-model="device_serial"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Privacy section -->
                        <div class=" divide-y divide-gray-200">
                            <div class=" py-4 px-4 flex justify-end sm:px-6">
                                <button @click="btnClose" type="submit"
                                    class="ml-5 bg-gray-700 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Close
                                </button>
                                <button @click="btnSave" type="submit"
                                    class="ml-5 bg-sky-700 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {mapMutations, mapGetters} from 'vuex'

export default {
    props:{
        login_url: {
            type: String,
            required: true
        },

    },
    data(){
        return {
            device_name: '',
            device_serial: '',
            settings: null,
        }
    },
    methods: {
        ...mapMutations([
            'update_device',
        ]),
        btnSave(){

            axios.post(`/settings`, {
                device_serial: this.device_serial
            }).then(res => {
                this.settings.device = res.data.data;
                this.$store.dispatch('updateSettings', this.settings);

                this.update_device(res.data.data);

                toast.fire({
                    title: res.data.message,
                    didClose: () => {
                        // window.location = this.login_url;
                    }
                })

            }).catch(error => {
                toast.fire({
                    icon: 'error',
                    title: error.response.data.message
                });
            })

        },
        btnClose(){
            window.location = '/login';
        }
    },
    computed:{
        ...mapGetters([
            'get_device',
            'get_settings',
        ]),
    },
    created(){
        this.settings = this.get_settings;
        this.device_serial = this.get_device ? this.get_device.terminal.serial_number : null;

    }
}
</script>

<style>

</style>
