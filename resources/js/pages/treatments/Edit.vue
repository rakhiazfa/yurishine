<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";

const props = defineProps({ treatment: Object });

const form = useForm({
    name: props.treatment?.name,
    description: props.treatment?.description,
    price: props.treatment?.price,
});

const handleSubmit = () => {
    form.put(`/treatments/${props.treatment.id}`, {
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
    <Head title="Edit Data Treatment" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Edit Data Treatment</h1>
                <Link href="/treatments">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Nama Treatment" :error="form.errors.name">
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
