<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import Layout from "@/layouts/Default.vue";
import { reactive } from "vue";

const formFilter = reactive({
    column: "",
    keyword: "",
});

const deletePatient = (id) => {
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
            router.delete(`/patients/${id}`, {
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
        "/patients",
        {
            column: formFilter.column,
            keyword: formFilter.keyword,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["patients"],
        }
    );
};

defineProps({ patients: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Data Pasien" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Data Pasien</h1>
                <Link href="/patients/create">
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
                            <el-option
                                value="registrasion_number"
                                label="Nomor Induk"
                            />
                            <el-option value="name" label="Nama" />
                            <el-option value="age" label="Umur" />
                            <el-option value="gender" label="Jenis Kelamin" />
                            <el-option value="skin_type" label="Jenis Kulit" />
                            <el-option value="address" label="Alamat" />
                            <el-option value="phone" label="Nomor Telepon" />
                        </el-select>
                    </template>
                    <div class="flex space-x-2">
                        <el-input-number
                            v-if="formFilter.column === 'age'"
                            v-model="formFilter.keyword"
                            class="w-220px"
                            clearable
                        />
                        <el-select
                            v-else-if="formFilter.column === 'gender'"
                            v-model="formFilter.keyword"
                            placeholder="Pilih jenis kelamin"
                            filterable
                            clearable
                        >
                            <el-option value="Pria" label="Pria" />
                            <el-option value="Wanita" label="Wanita" />
                        </el-select>
                        <el-select
                            v-else-if="formFilter.column === 'skin_type'"
                            v-model="formFilter.keyword"
                            placeholder="Pilih jenis kulit"
                            filterable
                            clearable
                        >
                            <el-option value="Normal" label="Normal" />
                            <el-option value="Oily" label="Oily" />
                            <el-option value="Dry" label="Dry" />
                            <el-option value="Acne" label="Acne" />
                            <el-option value="Kombinasi" label="Kombinasi" />
                        </el-select>
                        <el-input
                            v-else
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

            <el-table :data="patients" class="w-auto" border stripe>
                <el-table-column type="index" label="No" width="50px" />
                <el-table-column
                    prop="registrasion_number"
                    label="Nomor Induk"
                    width="200px"
                />
                <el-table-column prop="name" label="Nama" width="180px" />
                <el-table-column prop="age" label="Umur" width="75px" />
                <el-table-column
                    prop="gender"
                    label="Jenis Kelamin"
                    width="100px"
                />
                <el-table-column
                    prop="skin_type"
                    label="Jenis Kulit"
                    width="100px"
                />
                <el-table-column
                    prop="address"
                    label="Alamat"
                    min-width="350px"
                />
                <el-table-column label="Nomor Telepon" width="200px">
                    <template #default="scope">
                        <p>{{ scope.row.phone ?? "-" }}</p>
                    </template>
                </el-table-column>
                <el-table-column label="#" width="225px">
                    <template #default="scope">
                        <div class="flex justify-center items-center gap-3">
                            <Link :href="`/patients/${scope.row.id}`">
                                <el-button size="small">Detail</el-button>
                            </Link>
                            <Link :href="`/patients/${scope.row.id}/edit`">
                                <el-button size="small">Edit</el-button>
                            </Link>
                            <el-button
                                size="small"
                                @click="deletePatient(scope.row.id)"
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
