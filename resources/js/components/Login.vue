<template>
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="flex justify-between sm:mx-auto sm:w-full sm:max-w-md ">
            <div class="flex items-center justify-center">
                    <img src="/assets/logo-sm.png" alt="" srcset="">
                    <div class="text-sky-600 leading-4 font-semibold">
                        {{ get_settings.app_name }}
                        <div class="font-normal italic">Application</div>
                    </div>
                </div>
            <h1 class="mt-4 text-center text-3xl font-extrabold text-gray-700">
                Login
            </h1>
        </div>

        <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-6"  >
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">
                            Username
                        </label>
                        <div class="mt-1">
                            <input v-model="username" @keyup.enter="btnSignin()" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1">
                            <input v-model="password" @keyup.enter="btnSignin()" type="password"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                            <button @click="btnSignin()" type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                Sign in
                            </button>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Device Information
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between text-gray-700">
                        <span class="text-sm">Branch</span>
                        <strong>{{ get_device ? get_device.branch.branch_name : '' }}</strong>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span class="text-sm">Name</span>
                        <strong>{{ get_device ? get_device.terminal.description : '' }}</strong>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span class="text-sm">Serial No.</span>
                        <strong>{{ get_device ? get_device.terminal.serial_number : '' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <button @click="goToSettings" class="absolute bottom-4 right-4 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>

    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";

export default {
    data(){
        return {
            username: '',
            password: '',
        }
    },
    methods: {
        ...mapMutations([
            'update_user_auth'
        ]),
        btnSignin(){
            axios.post('/login', {
                username: this.username,
                password: this.password,
                device_serial: this.get_device ? this.get_device.terminal.serial_number : null
            }).then(res=>{

                this.update_user_auth(res.data.data);

                if( this.get_settings.work_shifting == true ){
                    if(res.data.data.shift.current == null){
                        window.location = '/';
                        return;
                    }

                    swal.fire({
                        title: '<strong>Shift Information</strong>',
                        html:`

                            <div class="text-left">

                                <div class="flex justify-between">Employee Name <span class="font-semibold">${this.get_auth.user.name}</span> </div>
                                <div class="flex justify-between">Business Date <span class="font-semibold">${this.get_auth.shift.current.business_date}</span> </div>
                                <div class="flex justify-between">Shift # <span class="font-semibold">${this.get_auth.shift.current.shift_count}</span> </div>
                                <div class="flex justify-between">Todays Date <span class="font-semibold">${this.get_auth.shift.todays_date}</span> </div>


                                <div class="mt-5">
                                    ${ this.get_auth.shift.todays_date != this.get_auth.shift.current.business_date ? `
                                    <hr>
                                    <h1 class="font-semibold">Warnings:</h1>
                                        <div class="ml-2">- Your shift date is behind!</div>
                                    `:'' }
                                </div>

                            </div>


                        `,
                        confirmButtonText:'Continue',
                        didClose: () => {
                            window.location = '/';
                        }
                    });
                }

                window.location = '/';


            }).catch(err=>{
                debug(err.response);
                toast.fire({
                    icon: 'error',
                    title: err.response.data.message
                })
            })

        },
        goToSettings(){
            window.location = '/settings';
        },
    },
    computed: {
        ...mapGetters([
            'get_device',
            'get_auth',
            'get_settings',
        ]),
    },
    created() {
        this.$store.dispatch('fetchAppSetting');
    }
}
</script>

<style>

</style>
