<script setup>
import { useTheme } from "vuetify";
import VerticalNavSectionTitle from "@/@layouts/components/VerticalNavSectionTitle.vue";
import VerticalNavLayout from "@layouts/components/VerticalNavLayout.vue";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";

import Footer from "@/layouts/components/Footer.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";
</script>

<template>
    <VerticalNavLayout>
        <template #navbar="{ toggleVerticalOverlayNavActive }">
            <div class="d-flex h-100 align-center">
                <IconBtn
                    class="ms-n3 d-lg-none"
                    @click="toggleVerticalOverlayNavActive(true)"
                >
                    <VIcon icon="bx-menu" />
                </IconBtn>

                <div
                    class="d-flex align-center cursor-pointer"
                    style="user-select: none"
                >
                    <IconBtn>
                        <VIcon icon="bx-search" />
                    </IconBtn>

                    <span class="d-none d-md-flex align-center text-disabled">
                        <span class="me-3">Search</span>
                        <span class="meta-key">&#8984;K</span>
                    </span>
                </div>

                <VSpacer />

                <UserProfile />
            </div>
        </template>

        <template #vertical-nav-content>
            <VerticalNavLink
                :item="{
                    title: 'Dashboard',
                    icon: 'bx-home',
                    to: '/dashboard',
                }"
            />

            <VerticalNavSectionTitle
                :item="{
                    heading: 'MASTER DATA',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Data Poliklinik',
                    icon: 'bx-buildings',
                    to: '/polyclinics',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Data Dokter',
                    icon: 'bx-user-pin',
                    to: '/doctors',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Data Pasien',
                    icon: 'bx-user',
                    to: '/patients',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Data Obat',
                    icon: 'bx-capsule',
                    to: '/medicines',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Data Treatment',
                    icon: 'bx-face',
                    to: '/treatments',
                }"
            />

            <VerticalNavSectionTitle
                :item="{
                    heading: 'LAINNYA',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Rekam Medis',
                    icon: 'bx-book',
                    to: '/medical-records',
                }"
            />

            <VerticalNavLink
                :item="{
                    title: 'Laporan',
                    icon: 'bx-file',
                    to: '/reports',
                }"
            />
        </template>

        <slot />

        <template #footer>
            <Footer />
        </template>
    </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
    border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
    border-radius: 6px;
    block-size: 1.5625rem;
    line-height: 1.3125rem;
    padding-block: 0.125rem;
    padding-inline: 0.25rem;
}
</style>
