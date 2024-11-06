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
                                <DataTable :value="new Array(15)">
                                    <Column field="code" header="#">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column field="client" header="Client">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column field="service" header="Service">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                    <Column field="quantity" header="Quantity">
                                        <template #body>
                                            <Skeleton/>
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>
                        </template>

                        <div>
                            <div class="card">
                                <Toolbar class="mb-6">
                                    <template #start>
                                        <Button label="New" icon="pi pi-plus" class="mr-2" @click="openNew"/>
                                        <Button label="Delete" icon="pi pi-trash" severity="danger" outlined @click="confirmDeleteSelected" :disabled="!selectedTransactions || !selectedTransactions.length" />
                                    </template>

                                    <template #end>
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
                                    :lazy="true"
                                    :rowHover="true"
                                    :filters="filters"
                                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                    :rowsPerPageOptions="[5, 10, 25]"
                                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} transactions"
                                >
                                    <template #header>
                                        <div class="flex flex-wrap gap-2 items-center justify-between">
                                            <h4 class="m-0 ">Manage Transactions</h4>
                                            <IconField>
                                                <InputIcon>
                                                    <i class="pi pi-search" />
                                                </InputIcon>
                                                <InputText v-model="filters['global'].value" placeholder="Search..." />
                                            </IconField>
                                        </div>
                                    </template>

                                    <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                                    <Column field="code" header="#" sortable style="min-width: 12rem"></Column>
                                    <Column field="name" header="Name" sortable style="min-width: 16rem"></Column>
                                    <Column header="Image">
                                        <template #body="slotProps">
                                            <img :src="`https://primefaces.org/cdn/primevue/images/transaction/${slotProps.data.image}`" :alt="slotProps.data.image" class="rounded" style="width: 64px" />
                                        </template>
                                    </Column>
                                    <Column field="price" header="Price" sortable style="min-width: 8rem">
                                        <template #body="slotProps">
                                            {{ formatCurrency(slotProps) }}
                                        </template>
                                    </Column>
                                    <Column field="category" header="Category" sortable style="min-width: 10rem"></Column>
                                    <Column field="rating" header="Reviews" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            <Rating :modelValue="slotProps.data.rating" :readonly="true" />
                                        </template>
                                    </Column>
                                    <Column field="inventoryStatus" header="Status" sortable style="min-width: 12rem">
                                        <template #body="slotProps">
                                            <Tag :value="slotProps.data.inventoryStatus" :severity="getStatusLabel(slotProps.data.inventoryStatus)" />
                                        </template>
                                    </Column>
                                    <Column :exportable="false" style="min-width: 12rem">
                                        <template #body="slotProps">
                                            <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data)" />
                                            <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>

                            <Dialog v-model:visible="productDialog" :style="{ width: '450px' }" header="Product Details" :modal="true">
                                <div class="flex flex-col gap-6">
                                    <img v-if="transaction.image" :src="`https://primefaces.org/cdn/primevue/images/transaction/${transaction.image}`" :alt="transaction.image" class="block m-auto pb-4" />
                                    <div>
                                        <label for="name" class="block font-bold mb-3">Name</label>
                                        <InputText id="name" v-model.trim="transaction.name" required="true" autofocus :invalid="submitted && !transaction.name" fluid />
                                        <small v-if="submitted && !transaction.name" class="text-red-500">Name is required.</small>
                                    </div>
                                    <div>
                                        <label for="description" class="block font-bold mb-3">Description</label>
                                        <Textarea id="description" v-model="transaction.description" required="true" rows="3" cols="20" fluid />
                                    </div>
                                    <div>
                                        <label for="inventoryStatus" class="block font-bold mb-3">Inventory Status</label>
                                        <Select id="inventoryStatus" v-model="transaction.inventoryStatus" :options="statuses" optionLabel="label" placeholder="Select a Status" fluid></Select>
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
                                    <Button label="Cancel" icon="pi pi-times" text @click="hideDialog" />
                                    <Button label="Save" icon="pi pi-check" @click="saveProduct" />
                                </template>
                            </Dialog>

                            <Dialog v-model:visible="deleteProductDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                                <div class="flex items-center gap-4">
                                    <i class="pi pi-exclamation-triangle !text-3xl" />
                                    <span v-if="transaction"
                                    >Are you sure you want to delete <b>{{ transaction.name }}</b
                                    >?</span
                                    >
                                </div>
                                <template #footer>
                                    <Button label="No" icon="pi pi-times" text @click="deleteProductDialog = false" />
                                    <Button label="Yes" icon="pi pi-check" @click="deleteProduct" />
                                </template>
                            </Dialog>

                            <Dialog v-model:visible="deleteProductsDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                                <div class="flex items-center gap-4">
                                    <i class="pi pi-exclamation-triangle !text-3xl" />
                                    <span v-if="transaction">Are you sure you want to delete the selected transactions?</span>
                                </div>
                                <template #footer>
                                    <Button label="No" icon="pi pi-times" text @click="deleteProductsDialog = false" />
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

const props = defineProps({
    transactions: Array
});

watch(
    () => props.transactions,
    (newTransactions, oldTransactions) => {
        transactions.value = newTransactions;
    },
    { deep: true }
);

const toast = useToast();
const dt = ref();
const transactions = ref();
const productDialog = ref(false);
const deleteProductDialog = ref(false);
const deleteProductsDialog = ref(false);
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

const formatCurrency = (value) => {
    if(value)
        return value.toLocaleString('en-US', {style: 'currency', currency: 'PHP'});
    return;
};
const openNew = () => {
    transaction.value = {};
    submitted.value = false;
    productDialog.value = true;
};
const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};
const saveProduct = () => {
    submitted.value = true;

    if (transaction?.value.transaction_date?.trim()) {
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

        productDialog.value = false;
        transaction.value = {};
    }
};
const editProduct = (prod) => {
    transaction.value = {...prod};
    productDialog.value = true;
};
const confirmDeleteProduct = (prod) => {
    transaction.value = prod;
    deleteProductDialog.value = true;
};
const deleteProduct = () => {
    transactions.value = transactions.value.filter(val => val.id !== transaction.value.id);
    deleteProductDialog.value = false;
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
    deleteProductsDialog.value = true;
};
const deleteSelectedProducts = () => {
    transactions.value = transactions.value.filter(val => !selectedTransactions.value.includes(val));
    deleteProductsDialog.value = false;
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
