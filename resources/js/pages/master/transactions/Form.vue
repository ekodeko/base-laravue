<template>
  <Head :title="isEdit ? 'Edit Transaction' : 'Create Transaction'" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="max-w-lg mx-auto p-6 shadow rounded">
        <h1 class="text-xl font-bold mb-4">
          {{ isEdit ? 'Edit Transaction' : 'Create Transaction' }}
        </h1>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-sm font-medium">Date</label>
            <input type="date" v-model="form.date" class="w-full border rounded p-2" required />
            <div v-if="form.errors.date" class="text-red-500 text-sm">{{ form.errors.date }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Type</label>
            <select v-model="form.type" class="w-full border rounded p-2" required>
              <option value="">-- Select Type --</option>
              <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
            </select>
            <div v-if="form.errors.type" class="text-red-500 text-sm">{{ form.errors.type }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Amount</label>
            <input type="number" v-model="form.amount" class="w-full border rounded p-2" required step="0.01" min="0" />
            <div v-if="form.errors.amount" class="text-red-500 text-sm">{{ form.errors.amount }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Description</label>
            <textarea v-model="form.description" class="w-full border rounded p-2" rows="3"></textarea>
            <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Account</label>
            <select v-model="form.account_id" class="w-full border rounded p-2" required>
              <option value="">-- Select Account --</option>
              <option v-for="acc in accounts" :key="acc.id" :value="acc.id">
                {{ acc.name }}
              </option>
            </select>
            <div v-if="form.errors.account_id" class="text-red-500 text-sm">{{ form.errors.account_id }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Category</label>
            <select v-model="form.category_id" class="w-full border rounded p-2" required>
              <option value="">-- Select Category --</option>
              <option v-for="cat in filteredCategories" :key="cat.id" :value="cat.id">
                {{ cat.name }}
              </option>
            </select>
            <div v-if="form.errors.category_id" class="text-red-500 text-sm">{{ form.errors.category_id }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Contact</label>
            <select v-model="form.contact_id" class="w-full border rounded p-2" required>
              <option value="">-- Select Contact --</option>
              <option v-for="con in contacts" :key="con.id" :value="con.id">
                {{ con.name }}
              </option>
            </select>
            <div v-if="form.errors.contact_id" class="text-red-500 text-sm">{{ form.errors.contact_id }}</div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
              {{ isEdit ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  transaction: Object,
  accounts: Array,
  categories: Array,
  contacts: Array,
  types: Array
})

const form = useForm({
  date: props.transaction?.date || new Date().toISOString().split('T')[0],
  type: props.transaction?.type || '',
  description: props.transaction?.description || '',
  amount: props.transaction?.amount || '',
  account_id: props.transaction?.account_id || '',
  category_id: props.transaction?.category_id || '',
  contact_id: props.transaction?.contact_id || ''
})

const isEdit = computed(() => !!props.transaction)

// Filter categories based on selected type
const filteredCategories = computed(() => {
  if (!form.type || !props.categories) return []
  return props.categories.filter(cat => cat.type === form.type)
})

const submit = () => {
  if (isEdit.value) {
    form.put(`/master/transactions/${props.transaction.id}`)
  } else {
    form.post('/master/transactions')
  }
}

const breadcrumbs = [
  {
    title: 'Transaction',
    href: '/master/transactions',
  },
  {
    title: isEdit.value ? 'Edit' : 'Add',
    href: '',
  },
];
</script>
