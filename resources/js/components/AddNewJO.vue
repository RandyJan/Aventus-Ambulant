<template>
    <div class="orderslip-form">
      <h2>New Order slip</h2>
      <div>
        <label for="orderslipNo">Orderslip Number:</label>
        <input type="text" id="orderslipNo" v-model="orderslipNo" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300"/>
      </div>
      <div>
        <label for="customerName">Patient Name:</label>
        <input type="text" id="customerName" v-model="customerName" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300"/>
      </div>
      <div>
        <button @click="createNewOrderslip" class="ml-5 bg-gray-700 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
          Submit</button>
        <button @click="cancel" class="ml-5 bg-sky-700 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">Cancel</button>
      </div>
    </div>
    </template>
    
    <script>
import { mapGetters, mapMutations } from "vuex";

    export default {
    data() {
      return {
        orderslipNo: '',
        customerName: ''
      };
    },
    methods: {
      ...mapMutations(["open_the_cart"]),
      submit() {
        // Handle form submission logic here
        console.log('Submitted:', this.orderslipNo, this.customerName);
      },
      fetchOrderslip(page = null) {
            axios
                .get(`/orderslips`, {
                    params: {
                        branch_id: this.get_auth
                            ? this.get_auth.branch.id
                            : null,
                        outlet_id: this.get_auth
                            ? this.get_auth.outlet.id
                            : null,
                        search: this.search,
                        page: page ?? 1,
                        limit: 25,
                        hide_completed: true,
                    },
                })
                .then((res) => {
                    this.orderslips = JSON.parse(JSON.stringify(res.data));
                })
                .catch((error) => {
                    this.orderslips = null;
                });
        },
      createNewOrderslip() {
            swal.fire({
                title: "Are you sure?",
                text: "This action will create a new Transaction!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton:
                        "inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500",
                    cancelButton:
                        "ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // axios.get("/AddNewJO", {
                    //         branch_id: this.get_auth.branch.id,
                    //         outlet_id: this.get_auth.outlet.id,
                    //         device_id: this.get_auth.terminal.id,
                    //         // business_date: this.get_auth.shift.current.business_date,
                    //         user_name: this.get_auth.user.name,
                    //         user_id: this.get_auth.user.username,
                    //         service_charge_percentage:
                    //             this.get_settings.service_charge_percentage,
                    //     })
                    console.log("test");
                    console.log(this.get_auth.branch.id);
                       axios.post("/orderslips", {
                            branch_id: this.get_auth.branch.id,
                            outlet_id: this.get_auth.outlet.id,
                            device_id: this.get_auth.terminal.id,
                            orderslip_no:this.orderslipNo,
                            customer_name:this.customerName,  
                            // business_date: this.get_auth.shift.current.business_date,
                            user_name: this.get_auth.user.name,
                            user_id: this.get_auth.user.username,
                            service_charge_percentage:
                                this.get_settings.service_charge_percentage,
                        })
                        .then((res) => {
                            debug(res.data);
                            toast.fire({
                                title: "Successfully created.",
                            });
                            // this.fetchOrderslip(
                            //     this.orderslips.meta.current_page
                            // );
                            this.$store.dispatch("fetchCurrentTransaction");
                           window.location = "/";

                            // this.open_the_cart();
                        })
                        .catch((error) => {
                          toast.fire({
                                title: "Error creating file.",
                            });
                            console.log(error);
                            debug(error.response.data);
                        });
                }
            });
         },
      cancel() {
        // Handle cancel logic here
        this.orderslipNo = '';
        this.customerName = '';
        window.location = "/";

      }
    },
    computed: {
        ...mapGetters([
            "get_auth",
            "get_device",
            "if_can_process_order",
            "get_os_overview_status",
            "get_settings",
        ]),
    },
    };
    </script>
    
    <style scoped>
    .orderslip-form {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    }
    .orderslip-form div {
    margin-bottom: 15px;
    }
    </style>