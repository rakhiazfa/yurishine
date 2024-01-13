<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import Layout from "@/layouts/Default.vue";
import TextEditor from "@/components/TextEditor.vue";
import currency from "@/helpers/currency";

const page = usePage();

const props = defineProps({
    patients: Array,
    doctors: Array,
    treatments: Array,
    skincares: Array,
});

const multipleTableRef = ref();
const form = useForm({
    patient_id: null,
    doctor_id: null,
    polyclinic_id: computed(() => page.props.auth.polyclinic?.id),
    description: "",
    treatments: [],
    skincares: [],
    use_membership: false,
});
const selectedPatient = ref(null);

const handleChangePatient = (patient_id) => {
    selectedPatient.value = props.patients.find(
        (patient) => patient.id === patient_id
    );
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
                        @change="handleChangePatient"
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
                <el-form-item
                    label="Resep / Skincare"
                    :error="form.errors.treatments"
                >
                    <el-select
                        v-model="form.skincares"
                        class="w-full"
                        multiple
                        filterable
                        clearable
                    >
                        <el-option
                            v-for="skincare in skincares"
                            :key="skincare.id"
                            :value="skincare.id"
                            :label="`${skincare.name} - ${currency.format(
                                skincare.price
                            )} ( ${skincare.stock ?? 0} Unit )`"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item
                    v-if="selectedPatient?.membership_count > 0"
                    label="Gunakan Membership"
                    :error="form.errors.use_membership"
                >
                    <el-switch v-model="form.use_membership" />
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
