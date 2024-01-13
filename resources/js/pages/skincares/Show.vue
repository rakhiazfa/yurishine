<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ skincare: Object });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Skincare" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Skincare</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <el-descriptions class="margin-top" :column="1" border>
                <el-descriptions-item label-class-name="w-[200px]">
                    <template #label> Nama Skincare </template>
                    {{ skincare?.name ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Deskripsi </template>
                    {{ skincare?.description ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Harga </template>
                    {{ skincare?.price ?? "-" }}
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
    </div>
</template>
