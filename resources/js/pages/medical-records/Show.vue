<script setup>
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import Layout from "@/layouts/Default.vue";
import { formatDate } from "@/helpers/date";

let urlPrevious = usePage().props.urlPrevious;

defineProps({ medicalRecord: Object });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Detail Rekam Medis" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Detail Rekam Medis</h1>
                <el-button size="small" @click="router.visit(urlPrevious)">
                    Kembali
                </el-button>
            </div>

            <div class="mb-5">
                <h2 class="text-sm font-semibold mb-3 ml-1">Pasien</h2>
                <el-descriptions class="margin-top" :column="1" border>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Nomor Induk</div>
                        </template>
                        {{ medicalRecord?.patient?.registrasion_number ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Nama</div>
                        </template>
                        {{ medicalRecord?.patient?.name ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Nomor Telepon</div>
                        </template>
                        {{ medicalRecord?.patient?.phone ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Alamat</div>
                        </template>
                        {{ medicalRecord?.patient?.address ?? "-" }}
                    </el-descriptions-item>
                </el-descriptions>
            </div>

            <div class="mb-10">
                <h2 class="text-sm font-semibold mb-3 ml-1">Dokter</h2>
                <el-descriptions class="margin-top" :column="1" border>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">NIP</div>
                        </template>
                        {{ medicalRecord?.doctor?.nip ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Nama</div>
                        </template>
                        {{ medicalRecord?.doctor?.name ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Nomor Telepon</div>
                        </template>
                        {{ medicalRecord?.doctor?.phone ?? "-" }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="cell-item">Alamat</div>
                        </template>
                        {{ medicalRecord?.doctor?.address ?? "-" }}
                    </el-descriptions-item>
                </el-descriptions>
            </div>

            <el-descriptions direction="vertical" :column="1" border>
                <el-descriptions-item label="Keterangan">
                    <div
                        class="ck-editor-result"
                        v-html="medicalRecord?.description"
                    ></div>
                </el-descriptions-item>
                <el-descriptions-item label="Treatment Yang Diberikan">
                    <div class="flex flex-wrap items-center gap-3">
                        <Link
                            v-for="treatment in medicalRecord?.treatments"
                            :key="treatment.id"
                            :href="`/treatments/${treatment.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ treatment?.name ?? "-" }}
                        </Link>
                    </div>
                </el-descriptions-item>
                <el-descriptions-item label="Resep / Skincare">
                    <div class="flex flex-wrap items-center gap-3">
                        <Link
                            v-for="skincare in medicalRecord?.skincares"
                            :key="skincare.id"
                            :href="`/skincares/${skincare.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ skincare?.name ?? "-" }}
                        </Link>
                    </div>
                </el-descriptions-item>
                <el-descriptions-item label="Tanggal Pemeriksaan">
                    {{ formatDate(medicalRecord?.inspection_date) }}
                </el-descriptions-item>
            </el-descriptions>
        </el-card>
    </div>
</template>
