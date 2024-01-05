<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const props = defineProps({ medicine: Object });

const form = useForm({
    name: props.medicine?.name,
    description: props.medicine?.description,
    price: props.medicine?.price,
});

const handleSubmit = () => {
    form.put(`/medicines/${props.medicine.id}`, {
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
    <Head title="Edit Data Obat" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Edit Data Obat</h1>
                <Link href="/medicines">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Nama Obat" :error="form.errors.name">
                    <el-input v-model="form.name" />
                </el-form-item>
                <el-form-item
                    label="Deskripsi"
                    :error="form.errors.description"
                >
                    <el-input v-model="form.description" type="textarea" />
                </el-form-item>
                <el-form-item label="Harga" :error="form.errors.price">
                    <el-input
                        v-model="form.price"
                        :formatter="
                            (value) =>
                                `Rp. ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="(value) => value.replace(/\Rp.\s?|(,*)/g, '')"
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
