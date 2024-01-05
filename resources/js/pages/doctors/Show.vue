<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ doctor: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Dokter" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Dokter</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <el-descriptions class="margin-top" :column="1" border>
                <el-descriptions-item label-class-name="w-[200px]">
                    <template #label> Nama </template>
                    {{ doctor?.name ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Spesialis </template>
                    {{ doctor?.specialist ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Alamat </template>
                    {{ doctor?.address ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Nomor Telepon </template>
                    {{ doctor?.phone ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Email </template>
                    {{ doctor?.user?.email ?? "-" }}
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
    </div>
</template>
