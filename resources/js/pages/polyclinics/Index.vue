<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import { reactive } from "vue";

const formFilter = reactive({
    column: "",
    keyword: "",
});

const deletePolyclinic = (id) => {
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
            router.delete(`/polyclinics/${id}`, {
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
        "/polyclinics",
        {
            column: formFilter.column,
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["polyclinics"],
        }
    );
};

defineProps({ polyclinics: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Data Poliklinik" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Data Poliklinik</h1>
                <Link href="/polyclinics/create">
                    <el-button size="small">Tambah Data</el-button>
                </Link>
            </div>

            <el-form
                :inline="true"
                :model="formFilter"
                @submit.prevent="search"
            >
                <el-form-item>
                    <template #label>
                        <el-select
                            v-model="formFilter.column"
                            @change="changeFilterColumn"
                            placeholder="Cari berdasarkan kolom"
                            filterable
                            clearable
                        >
                            <el-option value="" label="Semua" />
                            <el-option value="name" label="Nama" />
                            <el-option value="address" label="Alamat" />
                            <el-option value="email" label="Email" />
                        </el-select>
                    </template>
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

            <el-table :data="polyclinics" class="w-auto" border stripe>
                <el-table-column type="index" label="No" width="50px" />
                <el-table-column prop="name" label="Nama" width="180px" />
                <el-table-column
                    prop="address"
                    label="Alamat"
                    min-width="350px"
                />
                <el-table-column label="Email" width="200px">
                    <template #default="scope">
                        <p>{{ scope.row.user?.email }}</p>
                    </template>
                </el-table-column>
                <el-table-column label="#" width="150px">
                    <template #default="scope">
                        <div class="flex justify-center items-center gap-3">
                            <Link :href="`/polyclinics/${scope.row.id}/edit`">
                                <el-button size="small">Edit</el-button>
                            </Link>
                            <el-button
                                size="small"
                                @click="deletePolyclinic(scope.row.id)"
                            >
                                Delete
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
</template>
