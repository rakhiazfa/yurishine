<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const props = defineProps({ polyclinic: Object });

const form = useForm({
    name: props.polyclinic?.name,
    address: props.polyclinic?.address,
    email: props.polyclinic?.user?.email,
    password: "",
});

const handleSubmit = () => {
    form.put(`/polyclinics/${props.polyclinic.id}`, {
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
    <Head title="Edit Data Poliklinik" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Edit Data Poliklinik</h1>
                <Link href="/polyclinics">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Nama Poliklinik" :error="form.errors.name">
                    <el-input v-model="form.name" />
                </el-form-item>
                <el-form-item label="Alamat" :error="form.errors.address">
                    <el-input v-model="form.address" type="textarea" />
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
