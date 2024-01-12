<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import Pagination from "@/components/Pagination.vue";
import { reactive } from "vue";

const formFilter = reactive({
    column: "",
    keyword: "",
});

const deleteDoctor = (id) => {
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
            router.delete(`/doctors/${id}`, {
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
        "/doctors",
        {
            column: formFilter.column,
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["doctors"],
        }
    );
};

defineProps({ doctors: Object });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Data Dokter" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Data Dokter</h1>
                <Link href="/doctors/create">
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
                            <el-option value="nip" label="NIP" />
                            <el-option value="address" label="Alamat" />
                            <el-option value="phone" label="Nomor Telepon" />
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

            <el-table :data="doctors.data" class="w-auto" border stripe>
                <el-table-column type="index" label="No" width="50px" />
                <el-table-column label="Nama" width="180px">
                    <template #default="scope">
                        <Link
                            :href="`/doctors/${scope.row.id}`"
                            class="text-blue-500 hover:underline"
                            >{{ scope.row.name ?? "-" }}</Link
                        >
                    </template>
                </el-table-column>
                <el-table-column prop="nip" label="NIP" width="180px" />
                <el-table-column label="Nomor Telepon" width="200px">
                    <template #default="scope">
                        <p>{{ scope.row.phone ?? "-" }}</p>
                    </template>
                </el-table-column>
                <el-table-column label="Email" width="200px">
                    <template #default="scope">
                        <p>{{ scope.row.user?.email }}</p>
                    </template>
                </el-table-column>
                <el-table-column label="#" width="250px">
                    <template #default="scope">
                        <div class="flex justify-center items-center gap-3">
                            <Link :href="`/doctors/${scope.row.id}`">
                                <el-button size="small">Detail</el-button>
                            </Link>
                            <Link :href="`/doctors/${scope.row.id}/edit`">
                                <el-button size="small">Edit</el-button>
                            </Link>
                            <el-button
                                size="small"
                                @click="deleteDoctor(scope.row.id)"
                            >
                                Delete
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <div class="mt-5">
                <Pagination :links="doctors.links" />
            </div>
        </el-card>
    </div>
</template>
