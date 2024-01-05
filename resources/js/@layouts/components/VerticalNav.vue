<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import { useDisplay } from "vuetify";
import logo from "@images/logo.png";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    tag: {
        type: [String, null],
        required: false,
        default: "aside",
    },
    isOverlayNavActive: {
        type: Boolean,
        required: true,
    },
    toggleIsOverlayNavActive: {
        type: Function,
        required: true,
    },
});

const { mdAndDown } = useDisplay();
const refNav = ref();

const isVerticalNavScrolled = ref(false);
const updateIsVerticalNavScrolled = (val) =>
    (isVerticalNavScrolled.value = val);

const handleNavScroll = (evt) => {
    isVerticalNavScrolled.value = evt.target.scrollTop > 0;
};
</script>

<template>
    <Component
        :is="props.tag"
        ref="refNav"
        class="layout-vertical-nav"
        :class="[
            {
                visible: isOverlayNavActive,
                scrolled: isVerticalNavScrolled,
                'overlay-nav': mdAndDown,
            },
        ]"
    >
        <!-- 👉 Header -->
        <div class="nav-header mb-5">
            <slot name="nav-header">
                <Link href="/dashboard" class="flex justify-center">
                    <img :src="logo" alt="Yurishine" class="logo" />
                </Link>
            </slot>
        </div>
        <slot name="before-nav-items">
            <div class="vertical-nav-items-shadow" />
        </slot>
        <slot
            name="nav-items"
            :update-is-vertical-nav-scrolled="updateIsVerticalNavScrolled"
        >
            <PerfectScrollbar
                tag="ul"
                class="nav-items"
                :options="{ wheelPropagation: false }"
                @ps-scroll-y="handleNavScroll"
            >
                <slot />
            </PerfectScrollbar>
        </slot>

        <slot name="after-nav-items" />
    </Component>
</template>

<style lang="scss">
@use "@configured-variables" as variables;
@use "@layouts/styles/mixins";

// 👉 Vertical Nav
.layout-vertical-nav {
    position: fixed;
    z-index: variables.$layout-vertical-nav-z-index;
    display: flex;
    flex-direction: column;
    block-size: 100%;
    inline-size: variables.$layout-vertical-nav-width;
    inset-block-start: 0;
    inset-inline-start: 0;
    transition: transform 0.25s ease-in-out, inline-size 0.25s ease-in-out,
        box-shadow 0.25s ease-in-out;
    will-change: transform, inline-size;

    .logo {
        display: block;
        width: 125px;
        height: auto;
    }

    .nav-header {
        display: flex;
        align-items: center;
        justify-content: center;

        .header-action {
            cursor: pointer;
        }
    }

    .nav-items {
        block-size: 100%;
    }

    .nav-item-title {
        overflow: hidden;
        margin-inline-end: auto;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    // 👉 Collapsed
    .layout-vertical-nav-collapsed & {
        &:not(.hovered) {
            inline-size: variables.$layout-vertical-nav-collapsed-width;
        }
    }

    // 👉 Overlay nav
    &.overlay-nav {
        &:not(.visible) {
            transform: translateX(-#{variables.$layout-vertical-nav-width});

            @include mixins.rtl {
                transform: translateX(variables.$layout-vertical-nav-width);
            }
        }
    }
}
</style>
