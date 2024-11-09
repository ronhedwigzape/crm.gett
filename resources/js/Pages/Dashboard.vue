<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Deferred data="transactions">
                        <template #fallback>
                            <div class="card">
                                <Toolbar class="mb-6">
                                    <template #start>
                                        <Toast/>
                                        <Button label="New" icon="pi pi-plus" class="mr-2" :disabled="!selectedTransactions || !selectedTransactions.length"/>
                                        <Button label="Delete" icon="pi pi-trash" severity="danger" outlined  :disabled="!selectedTransactions || !selectedTransactions.length" />
                                    </template>

                                    <template #end>
                                        <Toast/>
                                        <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" customUpload chooseLabel="Import" class="mr-2" auto :chooseButtonProps="{ severity: 'secondary' }" :disabled="!selectedTransactions || !selectedTransactions.length"/>
                                        <Button label="Export" icon="pi pi-upload" severity="secondary" @click="exportCSV" :disabled="!selectedTransactions || !selectedTransactions.length"/>
                                    </template>
                                </Toolbar>
                                <DataTable :value="new Array(15)">
                                    <template #header>
                                        <div class="flex flex-wrap gap-2 items-center justify-between">
                                            <h3 class="m-0 text-lg font-black">Manage Transactions</h3>
                                            <IconField>
                                                <InputIcon>
                                                    <i class="pi pi-search" />
                                                </InputIcon>
                                                <InputText v-model="filters['global'].value" placeholder="Search..." :disabled="!selectedTransactions || !selectedTransactions.length"/>
                                            </IconField>
                                        </div>
                                    </template>

                                    <Column selectionMode="multiple" style="width: 6rem" :exportable="false">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Transaction Date" sortable style="min-width: 12rem">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Client" sortable style="min-width: 12rem">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Price" sortable style="min-width: 12rem">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Service" sortable style="min-width: 12rem">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Status" sortable style="min-width: 12rem">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column header="Actions" :exportable="false" style="min-width: 12rem">
                                        <template #body>
                                            <div class="flex">
                                                <Skeleton class="mx-2"/>
                                                <Skeleton class="mx-2"/>
                                            </div>
                                        </template>
                                    </Column>

                                </DataTable>
                            </div>
                        </template>

                        <div>
                            <div class="card">
                                <Toolbar class="mb-6">
                                    <template #start>
                                        <Toast/>
                                        <Button label="New" icon="pi pi-plus" class="mr-2" @click="openNew"/>
                                        <Button label="Delete" icon="pi pi-trash" severity="danger" outlined @click="confirmDeleteSelected" :disabled="!selectedTransactions || !selectedTransactions.length" />
                                    </template>

                                    <template #end>
                                        <Toast/>
                                        <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" customUpload chooseLabel="Import" class="mr-2" auto :chooseButtonProps="{ severity: 'secondary' }" />
                                        <Button label="Export" icon="pi pi-upload" severity="secondary" @click="exportCSV"/>
                                    </template>
                                </Toolbar>

                                <DataTable
                                    ref="dt"
                                    v-model:selection="selectedTransactions"
                                    :value="transactions"
                                    dataKey="id"
                                    :paginator="true"
                                    :alwaysShowPaginator="true"
                                    :rows="10"
                                    :rowHover="true"
                                    :filters="filters"
                                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                    :rowsPerPageOptions="[5, 10, 25]"
                                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} transactions"
                                >
                                    <template #header>
                                        <div class="flex flex-wrap gap-2 items-center justify-between">
                                            <h3 class="m-0 text-lg font-black">Manage Transactions</h3>
                                            <IconField>
                                                <InputIcon>
                                                    <i class="pi pi-search" />
                                                </InputIcon>
                                                <InputText v-model="filters['global'].value" placeholder="Search..." />
                                            </IconField>
                                        </div>
                                    </template>

                                    <Column selectionMode="multiple" style="width: 6rem" :exportable="false"></Column>
                                    <Column field="transaction_date" header="Transaction Date" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            {{ slotProps.data.transaction_date }}
                                        </template>
                                    </Column>
                                    <Column field="client.last_name" header="Client" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            {{ slotProps.data.client.last_name + ', ' + slotProps.data.client.first_name }}
                                        </template>
                                    </Column>
                                    <Column field="service_detail.fee" header="Price" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            {{ formatCurrency(slotProps.data.service_detail.fee)}}
                                        </template>
                                    </Column>
                                    <Column field="service.name" header="Service" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            {{ slotProps.data.service.name }}
                                        </template>
                                    </Column>
                                    <Column field="status.name" header="Status" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            <Tag :value="slotProps.data.status.name" :severity="getStatusLabel(slotProps.data.status.name)" />
                                        </template>
                                    </Column>
                                    <Column header="Actions" :exportable="false" style="min-width: 12rem">
                                        <template #body="slotProps">
                                            <Toast/>
                                            <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data)" />
                                            <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>

                            <Dialog v-model:visible="transactionDialog" :style="{ width: '450px' }" header="Transaction Detail" :modal="true">
                                <div class="flex flex-col gap-6">
                                    <div>
                                        <label for="code" class="block font-bold mb-3">Name</label>
                                        <InputText id="code" v-model.trim="transaction.code" required="true" autofocus :invalid="submitted && !transaction.code" fluid />
                                        <small v-if="submitted && !transaction.code" class="text-red-500">Name is required.</small>
                                    </div>
                                    <div>
                                        <label for="description" class="block font-bold mb-3">Description</label>
                                        <Textarea id="description" v-model="transaction.description" required="true" rows="3" cols="20" fluid />
                                    </div>
                                    <div>
                                        <label for="status" class="block font-bold mb-3">Status</label>
                                        <Select id="status" v-model="transaction.status.name" :options="statuses" optionLabel="label" placeholder="Select a Status" fluid></Select>
                                    </div>

                                    <div>
                                        <span class="block font-bold mb-4">Category</span>
                                        <div class="grid grid-cols-12 gap-4">
                                            <div class="flex items-center gap-2 col-span-6">
                                                <RadioButton id="category1" v-model="transaction.category" name="category" value="Accessories" />
                                                <label for="category1">Accessories</label>
                                            </div>
                                            <div class="flex items-center gap-2 col-span-6">
                                                <RadioButton id="category2" v-model="transaction.category" name="category" value="Clothing" />
                                                <label for="category2">Clothing</label>
                                            </div>
                                            <div class="flex items-center gap-2 col-span-6">
                                                <RadioButton id="category3" v-model="transaction.category" name="category" value="Electronics" />
                                                <label for="category3">Electronics</label>
                                            </div>
                                            <div class="flex items-center gap-2 col-span-6">
                                                <RadioButton id="category4" v-model="transaction.category" name="category" value="Fitness" />
                                                <label for="category4">Fitness</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-6">
                                            <label for="price" class="block font-bold mb-3">Price</label>
                                            <InputNumber id="price" v-model="transaction.price" mode="currency" currency="USD" locale="en-US" fluid />
                                        </div>
                                        <div class="col-span-6">
                                            <label for="quantity" class="block font-bold mb-3">Quantity</label>
                                            <InputNumber id="quantity" v-model="transaction.quantity" integeronly fluid />
                                        </div>
                                    </div>
                                </div>

                                <template #footer>
                                    <Toast/>
                                    <Button label="Cancel" icon="pi pi-times" text @click="hideDialog" />
                                    <Button label="Save" icon="pi pi-check" @click="saveProduct" />
                                </template>
                            </Dialog>

                            <Dialog v-model:visible="deleteTransactionDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                                <div class="flex items-center gap-4">
                                    <i class="pi pi-exclamation-triangle !text-3xl" />
                                    <span v-if="transaction">Are you sure you want to delete <b>{{ transaction.name }}</b>?</span>
                                </div>
                                <template #footer>
                                    <Toast/>
                                    <Button label="No" icon="pi pi-times" text @click="deleteTransactionDialog = false" />
                                    <Button label="Yes" icon="pi pi-check" @click="deleteProduct" />
                                </template>
                            </Dialog>

                            <Dialog v-model:visible="deleteTransactionsDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                                <div class="flex items-center gap-4">
                                    <i class="pi pi-exclamation-triangle !text-3xl" />
                                    <span v-if="transaction">Are you sure you want to delete the selected transactions?</span>
                                </div>
                                <template #footer>
                                    <Toast/>
                                    <Button label="No" icon="pi pi-times" text @click="deleteTransactionsDialog = false" />
                                    <Button label="Yes" icon="pi pi-check" text @click="deleteSelectedProducts" />
                                </template>
                            </Dialog>
                        </div>
                    </Deferred>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import {ref, onMounted, watch} from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Deferred } from '@inertiajs/vue3';
import Skeleton from 'primevue/skeleton';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Button from "primevue/button";
import InputNumber from 'primevue/inputnumber';
import RadioButton from 'primevue/radiobutton';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Toolbar from 'primevue/toolbar';
import FileUpload from 'primevue/fileupload';
import Tag from 'primevue/tag';

const props = defineProps({
    transactions: Array
});

const toast = useToast();
const dt = ref();
const transactions = ref();
const transactionDialog = ref(false);
const deleteTransactionDialog = ref(false);
const deleteTransactionsDialog = ref(false);
const transaction = ref({});
const selectedTransactions = ref();
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);
const statuses = ref([
    {label: 'Confirmed', value: 'Confirmed'},
    {label: 'Pending', value: 'Pending'},
    {label: 'Cancelled', value: 'Cancelled'}
]);

const getSortField = (service) => {
    switch (service.service_type) {
        case 'flight_ticket':
        case 'tour_package':
        case 'hotel_booking':
            return 'service_detail.fee';
        case 'travel_insurance':
            return 'service_detail.fee';
        case 'tourist_visa':
            return 'service_detail.fee';
        case 'transport_services':
            return 'service_detail.fee';
        default:
            return null;
    }
};


watch(
    () => props.transactions,
    (newTransactions, oldTransactions) => {
        transactions.value = newTransactions;
        console.log(newTransactions)
    },
    { deep: true }
);

watch(
    () => filters.value,
    (newFilters, oldFilters) => {
        console.log(newFilters.global.value.value)
    },
    { deep: true }
)
const handleClientName = (client) => {
    return `${client.first_name} ${client.last_name}`
}

const formatCurrency = (value) => {
    if (value !== undefined && value !== null) {
        return new Intl.NumberFormat("en-US", { style: "currency", currency: "PHP",}).format(value);
    }
    return 'Invalid value';
};

const openNew = () => {
    transaction.value = {};
    submitted.value = false;
    transactionDialog.value = true;
};
const hideDialog = () => {
    transactionDialog.value = false;
    submitted.value = false;
};
const saveProduct = () => {
    submitted.value = true;

    if (transaction?.value.code?.trim()) {
        if (transaction.value.id) {
            transaction.value.status.name = transaction.value.status.name.value ? transaction.value.status.name.value : transaction.value.status.name;
            transactions.value[findIndexById(transaction.value.id)] = transaction.value;
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
        }
        else {
            transaction.value.id = createId();
            transaction.value.image = 'transaction-placeholder.svg';
            transaction.value.status.name = transaction.value.status.name ? transaction.value.status.name.value : 'Confirmed';
            transactions.value.push(transaction.value);
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
        }

        transactionDialog.value = false;
        transaction.value = {};
    }
};
const editProduct = (prod) => {
    transaction.value = {...prod};
    transactionDialog.value = true;
};
const confirmDeleteProduct = (prod) => {
    transaction.value = prod;
    deleteTransactionDialog.value = true;
};
const deleteProduct = () => {
    transactions.value = transactions.value.filter(val => val.id !== transaction.value.id);
    deleteTransactionDialog.value = false;
    transaction.value = {};
    toast.add({severity:'success', summary: 'Successful', detail: 'Product Deleted', life: 3000});
};
const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < transactions.value.length; i++) {
        if (transactions.value[i].id === id) {
            index = i;
            break;
        }
    }

    return index;
};
const createId = () => {
    let id = '';
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for ( var i = 0; i < 5; i++ ) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return id;
}
const exportCSV = () => {
    dt.value.exportCSV();
};
const confirmDeleteSelected = () => {
    deleteTransactionsDialog.value = true;
};
const deleteSelectedProducts = () => {
    transactions.value = transactions.value.filter(val => !selectedTransactions.value.includes(val));
    deleteTransactionsDialog.value = false;
    selectedTransactions.value = null;
    toast.add({severity:'success', summary: 'Successful', detail: 'Products Deleted', life: 3000});
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'Confirmed':
            return 'success';

        case 'Pending':
            return 'warn';

        case 'Cancelled':
            return 'danger';

        default:
            return null;
    }
};

</script>
