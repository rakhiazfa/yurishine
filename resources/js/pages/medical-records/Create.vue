<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";
import TextEditor from "@/components/TextEditor.vue";
import currency from "@/helpers/currency";

const page = usePage();

const multipleTableRef = ref();
const form = useForm({
    patient_id: null,
    doctor_id: null,
    polyclinic_id: computed(() => page.props.auth.polyclinic?.id),
    description: "",
    treatments: [],
});

const handleSelectionChange = (items) => {
    form.treatments = items.map((item) => item.id);
};

const handleSubmit = () => {
    form.post("/medical-records", {
        onSuccess: () => {
            ElMessage({
                type: "success",
                message: "Berhasil menambahkan data.",
            });
        },
    });
};

defineProps({ patients: Array, doctors: Array, treatments: Array });
defineOptions({ layout: Layout });
</script>
<template>
    <Head title="Tambah Rekam Medis" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Tambah Rekam Medis</h1>
                <Link href="/medical-records">
                    <el-button size="small">Kembali</el-button>
                </Link>
            </div>

            <el-form
                :model="form"
                @submit.prevent="handleSubmit"
                label-position="left"
                label-width="200"
            >
                <el-form-item label="Pasien" :error="form.errors.patient_id">
                    <el-select
                        v-model="form.patient_id"
                        class="w-full"
                        filterable
                        clearable
                    >
                        <el-option
                            v-for="patient in patients"
                            :key="patient.id"
                            :value="patient.id"
                            :label="`${patient.registrasion_number} - ${patient.name}`"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="Dokter" :error="form.errors.doctor_id">
                    <el-select
                        v-model="form.doctor_id"
                        class="w-full"
                        filterable
                        clearable
                    >
                        <el-option
                            v-for="doctor in doctors"
                            :key="doctor.id"
                            :value="doctor.id"
                            :label="`${doctor.name}`"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item
                    label="Keterangan"
                    :error="form.errors.description"
                >
                    <TextEditor v-model="form.description" />
                </el-form-item>
                <el-form-item
                    label="Treatment Yang Diberikan"
                    :error="form.errors.treatments"
                >
                    <el-table
                        ref="multipleTableRef"
                        :data="treatments"
                        class="w-auto"
                        @selection-change="handleSelectionChange"
                        border
                        stripe
                    >
                        <el-table-column type="selection" width="55" />
                        <el-table-column
                            prop="name"
                            label="Nama"
                            width="180px"
                        />
                        <el-table-column label="Harga" width="150px">
                            <template #default="scope">
                                <p>{{ currency.format(scope.row.price) }}</p>
                            </template>
                        </el-table-column>
                    </el-table>
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
