<template>
    <div>
        <iframe
            class="w-full h-screen"
            :src="link"
            frameborder="0">

        </iframe>
    </div>
</template>

<script>
export default {
    props : {
        link: {
            required: true,
            type: String,
        }
    }
}
</script>

<style>

</style>
