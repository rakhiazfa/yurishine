<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ polyclinic: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Poliklinik" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Poliklinik</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <el-descriptions class="margin-top" :column="1" border>
                <el-descriptions-item label-class-name="w-[200px]">
                    <template #label> Nama Poliklinik </template>
                    {{ polyclinic?.name ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Alamat </template>
                    {{ polyclinic?.address ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Email </template>
                    {{ polyclinic?.user?.email ?? "-" }}
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
    </div>
</template>
