<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div
        class="relative z-10"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <!--
            Background backdrop, show/hide based on modal state.

            Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
            Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        ></div>

        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div
                class="flex items-center sm:items-center justify-center min-h-full p-4 text-center"
            >
                <!--
                    Modal panel, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                    Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <!-- CONTAINER -->
                <div
                    class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-3xl w-full sm:p-6"
                >
                    <!-- CLOSE BUTTON -->
                    <button
                        @click="close()"
                        class="absolute top-0 right-0 btn btn-danger rounded-full inline-flex items-center p-1 mt-2 mr-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    <!-- BODY -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Title of Modal
                        </h3>

                        <!-- CONTENT -->
                        <div class="py-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        close() {
            this.$emit("close");
        },
    },
};
</script>

<style></style>
