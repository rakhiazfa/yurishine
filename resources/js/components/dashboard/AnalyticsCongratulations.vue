<script setup></script>
<template>
    <VCard class="text-center text-sm-start">
        <VRow no-gutters>
            <VCol cols="12" sm="8" order="2" order-sm="1">
                <VCardItem>
                    <VCardTitle class="text-md-h5 text-primary">
                        Congratulations John! 🎉
                    </VCardTitle>
                </VCardItem>

                <VCardText>
                    <span>
                        You have done 72% 🤩 more sales today.
                        <br />
                        Check your new raising badge in your profile.
                    </span>
                    <br />
                    <VBtn variant="tonal" class="mt-4" size="small">
                        View Badges
                    </VBtn>
                </VCardText>
            </VCol>

            <VCol cols="12" sm="4" order="1" order-sm="2" class="text-center">
            </VCol>
        </VRow>
    </VCard>
</template>

<style lang="scss" scoped>
.john-illustration {
    inset-block-end: -0.0625rem;
    inset-inline-end: 3rem;
}
</style>
