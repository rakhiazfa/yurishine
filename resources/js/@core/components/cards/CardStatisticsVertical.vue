<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    image: {
        type: String,
        required: true,
    },
    stats: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <VCard>
        <VCardText class="d-flex align-center">
            <img width="42" :src="props.image" alt="image" />

            <VSpacer />
        </VCardText>

        <VCardText>
            <p class="text-xs mb-1">
                {{ props.title }}
            </p>
            <h5 class="text-h5 text-no-wrap mb-3">
                {{ props.stats }}
            </h5>
        </VCardText>
    </VCard>
</template>
