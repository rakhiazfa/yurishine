<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const form = useForm({
    name: "",
    specialist: "",
    address: "",
    phone: "",
    email: "",
    password: "",
});

const handleSubmit = () => {
    form.post("/doctors", {
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
    <Head title="Tambah Data Dokter" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Tambah Data Dokter</h1>
                <Link href="/doctors">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Nama" :error="form.errors.name">
                    <el-input v-model="form.name" />
                </el-form-item>
                <el-form-item label="Spesialis" :error="form.errors.specialist">
                    <el-input v-model="form.specialist" />
                </el-form-item>
                <el-form-item label="Alamat" :error="form.errors.address">
                    <el-input v-model="form.address" type="textarea" />
                </el-form-item>
                <el-form-item label="Nomor Telepon" :error="form.errors.phone">
                    <el-input v-model="form.phone" />
                </el-form-item>
                <el-form-item label="Email" :error="form.errors.email">
                    <el-input v-model="form.email" />
                </el-form-item>
                <el-form-item label="Kata Sandi" :error="form.errors.password">
                    <el-input
                        v-model="form.password"
                        type="password"
                        show-password
                    />
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
