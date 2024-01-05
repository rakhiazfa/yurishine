<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
});
</script>
<template>
    <div v-if="links.length > 3">
        <div class="flex items-center gap-3">
            <div v-for="(link, key) in links" :key="key">
                <Link
                    v-if="link.url === null"
                    :href="link.url"
                    class="px-3 py-2 text-xs leading-4 text-gray-500 border rounded pointer-events-none"
                    preserve-scroll
                >
                    <span v-html="link.label"></span>
                </Link>
                <Link
                    v-else
                    :href="link.url"
                    :class="`px-3 py-2 text-xs leading-4 text-gray-600 border rounded hover:bg-gray-50 ${
                        link.active ? 'bg-blue-500 text-white' : ''
                    }`"
                    preserve-scroll
                >
                    <span v-html="link.label"></span>
                </Link>
            </div>
        </div>
    </div>
</template>
