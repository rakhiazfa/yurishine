<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const props = defineProps({ doctor: Object });

const form = useForm({
    name: props.doctor?.name,
    nip: props.doctor?.nip,
    address: props.doctor?.address,
    phone: props.doctor?.phone,
    email: props.doctor?.user?.email,
    password: "",
});

const handleSubmit = () => {
    form.put(`/doctors/${props.doctor.id}`, {
        onSuccess: () => {
            ElMessage({
                type: "success",
                message: "Berhasil memperbarui data.",
            });
        },
    });
};

defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Edit Data Dokter" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Edit Data Dokter</h1>
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
                <el-form-item label="NIP" :error="form.errors.nip">
                    <el-input v-model="form.nip" />
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
                    <el-text class="mx-1" size="small">
                        Isi jika ingin mengubah kata sandi.
                    </el-text>
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
