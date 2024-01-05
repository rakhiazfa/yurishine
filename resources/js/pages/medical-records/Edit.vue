<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";
import TextEditor from "@/components/TextEditor.vue";
import currency from "@/helpers/currency";

const props = defineProps({
    medicalRecord: Object,
    patients: Array,
    doctors: Array,
    treatments: Array,
});

const multipleTableRef = ref();
const form = useForm({
    patient_id: props.medicalRecord?.patient_id,
    doctor_id: props.medicalRecord?.doctor_id,
    polyclinic_id: props.medicalRecord?.polyclinic_id,
    description: props.medicalRecord?.description,
    treatments: props.medicalRecord?.treatments?.map(
        (treatment) => treatment.id
    ),
});

const handleSubmit = () => {
    form.put(`/medical-records/${props.medicalRecord.id}`, {
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
    <Head title="Edit Rekam Medis" />
    <div>
        <el-card>
            <div class="flex justify-between items-center mb-5">
                <h1 class="font-semibold">Edit Rekam Medis</h1>
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
                    <el-select
                        v-model="form.treatments"
                        class="w-full"
                        multiple
                        filterable
                        clearable
                    >
                        <el-option
                            v-for="treatment in treatments"
                            :key="treatment.id"
                            :value="treatment.id"
                            :label="`${treatment.name} - ${currency.format(
                                treatment.price
                            )}`"
                        />
                    </el-select>
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
