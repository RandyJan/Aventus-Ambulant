<template>
    <div>
        <transition name="container">
            <div class="fixed inset-0 bg-gray-100 z-50 " >
                <button @click="close()" class="absolute top-2 right-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>


                <div
                    v-if="payload != null"
                    class="h-full overflow-y-auto">

                    <div class="mx-auto mb-14 mt-5 p-5 pt-0 max-w-lg">

                        <!-- MODAL TITLE -->
                        <h1 class="font-extrabold text-2xl text-gray-600 ">
                            Adding Senior Record
                        </h1>

                        <!-- CONTENT -->
                        <div class="mt-5">

                            <div class="">
                                <label for="street-address" class="block text-sm font-medium text-gray-700"> ID No. </label>
                                <div class="mt-1">
                                    <input v-model="id" type="text" name="street-address" id="street-address" autocomplete="street-address" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="street-address" class="block text-sm font-medium text-gray-700"> Full name </label>
                                <div class="mt-1">
                                    <input v-model="name" type="text" name="street-address" id="street-address" autocomplete="street-address" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="about" class="block text-sm font-medium text-gray-700"> Address </label>
                                <div class="mt-1">
                                    <textarea v-model="address" id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                </div>
                                <!-- <p class="mt-2 text-sm text-gray-500">Write a few sentences about yourself.</p> -->
                            </div>

                            <button
                                @click="submit()"
                                type="submit"
                                class="mt-4 tracking-wider w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                Submit
                            </button>

                        </div>

                    </div>

                </div>
            </div>
        </transition>
    </div>
</template>

<script>

export default {
    props:{
        payload: {
            type: Object,
            default: null,
        }
    },
    data(){
        return {
            id : '',
            name : '',
            address : '',
        }
    },
    methods: {
        close(){
            this.$emit('close');
        },
        submit(){

            if(this.id == ''){
                toast.fire({title: 'ID No. is required.', icon: 'warning'})
                return;
            }

            if(this.name == ''){
                toast.fire({title: 'Name is required.', icon: 'warning'})
                return;
            }

            if(this.address == ''){
                toast.fire({title: 'Address is required.', icon: 'warning'})
                return;
            }

            confirm.fire({
                text: 'This action will create a new senior data.',
                // confirmButtonText: 'Proceed to update Table number.',
            }).then( (result) => {
                if(result.isConfirmed){
                    axios.post(`/orderslip-seniors`, {
                        sc_id: this.id,
                        sc_name: this.name,
                        sc_address: this.address,
                        ...this.payload
                    }).then(res=>{
                        this.close();
                        this.$store.dispatch('fetchCurrentTransaction');
                    });
                }
            })

        },
    },
}
</script>

<style>

</style>
