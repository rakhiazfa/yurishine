<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ patient: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Pasien" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Pasien</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <el-descriptions class="margin-top" :column="1" border>
                <el-descriptions-item label-class-name="w-[200px]">
                    <template #label> Nama </template>
                    {{ patient?.name ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Umur </template>
                    {{ patient?.age ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Jenis Kelamin </template>
                    <el-tag type="info">{{ patient?.gender ?? "-" }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Jenis Kulit </template>
                    <el-tag type="info">{{ patient?.skin_type ?? "-" }}</el-tag>
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Alamat </template>
                    {{ patient?.address ?? "-" }}
                </el-descriptions-item>
                <el-descriptions-item>
                    <template #label> Nomor Telepon </template>
                    {{ patient?.phone ?? "-" }}
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
    </div>
</template>
