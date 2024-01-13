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
                                <el-descriptions-item label="Keterangan">
                                    <div
                                        class="ck-editor-result"
                                        v-html="props.row?.description"
                                    ></div>
                                </el-descriptions-item>
                            </el-descriptions>

                            <h2 class="text-sm font-semibold mb-3">
                                Treatment
                            </h2>
                            <el-table
                                :data="props.row.treatments"
                                class="w-max"
                                border
                                stripe
                            >
                                <el-table-column
                                    prop="name"
                                    label="Nama"
                                    width="180px"
                                />
                                <el-table-column label="Harga" width="150px">
                                    <template #default="scope">
                                        <p>
                                            {{
                                                currency.format(scope.row.price)
                                            }}
                                        </p>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="patient_name"
                    label="Nama Pasien"
                    width="180px"
                />
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
                <el-table-column
                    prop="doctor_name"
                    label="Nama Dokter"
                    width="180px"
                />
                <el-table-column label="Name Poliklinik" width="180px">
                    <template #default="scope">
                        <p>{{ scope.row?.polyclinic_name ?? "-" }}</p>
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
