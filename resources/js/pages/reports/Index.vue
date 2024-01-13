<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import Pagination from "@/components/Pagination.vue";
import { reactive } from "vue";
import { formatDate } from "@/helpers/date";
import currency from "@/helpers/currency";

const formFilter = reactive({
    keyword: "",
});

const changeFilterColumn = () => {
    formFilter.keyword = null;
};

const search = () => {
    router.get(
        "/reports",
        {
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["reports"],
        }
    );
};

defineProps({ reports: Object });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Laporan" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Laporan</h1>
            </div>

            <el-form
                :inline="true"
                :model="formFilter"
                @submit.prevent="search"
            >
                <el-form-item>
                    <div class="flex space-x-2">
                        <el-input
                            v-model="formFilter.keyword"
                            placeholder="Masukan kata kunci"
                            class="w-220px"
                            clearable
                        />
                        <el-button @click="search" native-type="submit">
                            Cari
                        </el-button>
                    </div>
                </el-form-item>
            </el-form>

            <el-table :data="reports.data" class="w-auto" border stripe>
                <el-table-column type="expand">
                    <template #default="props">
                        <div class="p-5">
                            <el-descriptions
                                direction="vertical"
                                :column="1"
                                border
                                class="mb-5"
                            >
                                <el-descriptions-item
                                    label="Menggunakan Membership?"
                                >
                                    <el-tag
                                        :type="
                                            props.row?.use_membership
                                                ? ''
                                                : 'danger'
                                        "
                                        >{{
                                            props.row?.use_membership
                                                ? "Ya"
                                                : "Tidak"
                                        }}</el-tag
                                    >
                                </el-descriptions-item>
                                <el-descriptions-item label="Keterangan">
                                    <div
                                        class="ck-editor-result"
                                        v-html="props.row?.description"
                                    ></div>
                                </el-descriptions-item>
                            </el-descriptions>

                            <div class="flex items-start gap-5">
                                <el-descriptions
                                    direction="vertical"
                                    :column="1"
                                    border
                                    class="mb-5"
                                >
                                    <el-descriptions-item
                                        label="Resep / Skincare"
                                    >
                                        <el-table
                                            :data="props.row.skincares"
                                            class="w-max"
                                            border
                                            stripe
                                        >
                                            <el-table-column
                                                prop="name"
                                                label="Nama Skincare"
                                                width="250px"
                                            />
                                        </el-table>
                                    </el-descriptions-item>
                                </el-descriptions>
                                <el-descriptions
                                    direction="vertical"
                                    :column="1"
                                    border
                                    class="mb-5"
                                >
                                    <el-descriptions-item label="Treatment">
                                        <el-table
                                            :data="props.row.treatments"
                                            class="w-max"
                                            border
                                            stripe
                                        >
                                            <el-table-column
                                                prop="name"
                                                label="Nama"
                                                width="250px"
                                            />
                                        </el-table>
                                    </el-descriptions-item>
                                </el-descriptions>
                            </div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Nama Pasien" width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/patients/${scope.row.patient_id}`"
                            class="text-blue-500 hover:underline"
                            >{{ scope.row.patient_name ?? "-" }}</Link
                        >
                    </template>
                </el-table-column>
                <el-table-column
                    prop="patient_address"
                    label="Alamat Pasien"
                    min-width="350px"
                />
                <el-table-column
                    prop="patient_phone"
                    label="Nomor Telepon Pasien"
                    width="180px"
                />
                <el-table-column label="Dokter Yang Menangani" width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/doctors/${scope.row.doctor_id}`"
                            class="text-blue-500 hover:underline"
                            >{{ scope.row.doctor_name ?? "-" }}</Link
                        >
                    </template>
                </el-table-column>
                <el-table-column label="Tanggal Pemeriksaan" width="180px">
                    <template #default="scope">
                        <p>{{ formatDate(scope.row.inspection_date) }}</p>
                    </template>
                </el-table-column>
            </el-table>
            <div class="mt-5">
                <Pagination :links="reports.links" />
            </div>
        </el-card>
    </div>
</template>
