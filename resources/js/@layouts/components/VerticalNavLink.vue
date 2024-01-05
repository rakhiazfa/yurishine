<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    item: {
        type: null,
        required: true,
    },
});
</script>

<template>
    <li class="nav-link" :class="{ disabled: item.disable }">
        <Link :href="item.to">
            <VIcon :icon="item.icon" class="nav-item-icon" />
            <span class="nav-item-title">
                {{ item.title }}
            </span>
        </Link>
    </li>
</template>

<style lang="scss">
.layout-vertical-nav {
    .nav-link a {
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
}
</style>
