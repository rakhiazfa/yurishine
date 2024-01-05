<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import Pagination from "@/components/Pagination.vue";
import { reactive } from "vue";
import { formatDate } from "@/helpers/date";

const formFilter = reactive({
    keyword: "",
});

const deleteMedicine = (id) => {
    ElMessageBox.confirm(
        "Apakah anda yakin ingin menghapus data ini?",
        "Warning",
        {
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            type: "warning",
        }
    )
        .then(() => {
            router.delete(`/medical-records/${id}`, {
                onSuccess: () => {
                    ElMessage({
                        type: "success",
                        message: "Berhasil menghapus data.",
                    });
                },
                preserveScroll: (page) => Object.keys(page.props.errors).length,
            });
        })
        .catch(() => {});
};

const changeFilterColumn = () => {
    formFilter.keyword = null;
};

const search = () => {
    router.get(
        "/medical-records",
        {
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["medicalRecords"],
        }
    );
};

defineProps({ medicalRecords: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Rekam Medis" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Rekam Medis</h1>
                <Link href="/medical-records/create">
                    <el-button size="small">Tambah Data</el-button>
                </Link>
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

            <el-table :data="medicalRecords.data" class="w-auto" border stripe>
                <el-table-column type="index" label="No" width="50px" />
                <el-table-column label="Pasien" min-width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/patients/${scope.row.patient?.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ scope.row.patient?.name ?? "-" }}
                        </Link>
                    </template>
                </el-table-column>
                <el-table-column label="Dokter" min-width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/doctors/${scope.row.doctor?.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ scope.row.doctor?.name ?? "-" }}
                        </Link>
                    </template>
                </el-table-column>
                <el-table-column label="Poliklinik" min-width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/polyclinics/${scope.row.polyclinic?.id}`"
                            class="text-blue-500 hover:underline"
                        >
                            {{ scope.row.polyclinic?.name ?? "-" }}
                        </Link>
                    </template>
                </el-table-column>
                <el-table-column label="Tanggal Pemeriksaan" min-width="180px">
                    <template #default="scope">
                        <p>{{ formatDate(scope.row.inspection_date) }}</p>
                    </template>
                </el-table-column>
                <el-table-column label="#" width="225px">
                    <template #default="scope">
                        <div class="flex justify-center items-center gap-3">
                            <Link :href="`/medical-records/${scope.row.id}`">
                                <el-button size="small">Detail</el-button>
                            </Link>
                            <Link
                                :href="`/medical-records/${scope.row.id}/edit`"
                            >
                                <el-button size="small">Edit</el-button>
                            </Link>
                            <el-button
                                size="small"
                                @click="deleteMedicine(scope.row.id)"
                            >
                                Delete
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <div class="mt-5">
                <Pagination :links="medicalRecords.links" />
            </div>
        </el-card>
    </div>
</template>
