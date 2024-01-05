<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const form = useForm({
    name: "",
    age: "",
    gender: "",
    skin_type: "",
    address: "",
    phone: "",
});

const handleSubmit = () => {
    form.post("/patients", {
        onSuccess: () => {
            ElMessage({
                type: "success",
                message: "Berhasil menambahkan data.",
            });
        },
    });
};

defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Tambah Data Pasien" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Tambah Data Pasien</h1>
                <Link href="/patients">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Nomor Induk">
                    <el-tag type="info">Auto Generate</el-tag>
                </el-form-item>
                <el-form-item label="Nama" :error="form.errors.name">
                    <el-input v-model="form.name" />
                </el-form-item>
                <el-form-item label="Umur" :error="form.errors.age">
                    <el-input-number v-model="form.age" />
                </el-form-item>
                <el-form-item label="Jenis Kelamin" :error="form.errors.gender">
                    <el-select v-model="form.gender" filterable clearable>
                        <el-option value="Pria" label="Pria" />
                        <el-option value="Wanita" label="Wanita" />
                    </el-select>
                </el-form-item>
                <el-form-item
                    label="Jenis Kulit"
                    :error="form.errors.skin_type"
                >
                    <el-select v-model="form.skin_type" filterable clearable>
                        <el-option value="Normal" label="Normal" />
                        <el-option value="Oily" label="Oily" />
                        <el-option value="Dry" label="Dry" />
                        <el-option value="Acne" label="Acne" />
                        <el-option value="Kombinasi" label="Kombinasi" />
                    </el-select>
                </el-form-item>
                <el-form-item label="Alamat" :error="form.errors.address">
                    <el-input v-model="form.address" type="textarea" />
                </el-form-item>
                <el-form-item label="Nomor Telepon" :error="form.errors.phone">
                    <el-input v-model="form.phone" />
                </el-form-item>
                <div class="flex justify-end">
                    <el-button size="small" @click="handleSubmit">
                        Simpan
                    </el-button>
                </div>
            </el-form>
        </el-card>
    </div>
</template>
